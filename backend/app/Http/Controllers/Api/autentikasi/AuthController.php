<?php

namespace App\Http\Controllers\Api\autentikasi;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    // Login
    public function login(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email'      => 'required|email',
                'kata_sandi' => 'required|string',
            ],
            [
                'email.required'      => 'Email harus diisi!',
                'kata_sandi.required' => 'Kata sandi harus diisi!',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Login gagal!',
                'error'   => $validator->errors()->first(),
            ], 422);
        }

        $akun = Akun::where('email', $request->email)->first();

        if (!$akun || !Hash::check($request->kata_sandi, $akun->kata_sandi)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau kata sandi salah.',
            ], 421);
        }

        return response()->json([
            'success'      => true,
            'access_token' => $akun->createToken('auth_token')->plainTextToken,
            'token_type'   => 'Bearer',
            'user'         => $akun,
        ]);
    }

    // Profile
    public function profile(Request $request)
    {
        return response()->json([
            'success' => true,
            'data'    => $request->user(),
        ]);
    }

    // Logout
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil logout.',
        ]);
    }

    // === STEP 1: Verifikasi Email + Kirim OTP ===
    public function verifyEmail(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ['email' => 'required|email'],
            ['email.required' => 'Email harus diisi!']
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Verifikasi email gagal!',
                'error'   => $validator->errors()->first(),
            ], 422);
        }

        $akun = Akun::where('email', $request->email)->first();

        if (!$akun || empty($akun->nomor)) {
            return response()->json([
                'success' => false,
                'message' => 'Email tidak terdaftar atau nomor WhatsApp kosong.',
            ], 442);
        }

        // Generate & simpan OTP
        $kode = strval(rand(100000, 999999));
        Cache::put("otp_" . $request->email, $kode, now()->addMinutes(5));

        // Normalisasi nomor ke format internasional (62xxx)
        $nomor = preg_replace('/\s+/', '', $akun->nomor);
        $nomor = ltrim($nomor, '+');
        $nomor = preg_replace('/[^0-9]/', '', $nomor);

        if (str_starts_with($nomor, '0')) {
            $nomor = '62' . substr($nomor, 1);
        } elseif (!str_starts_with($nomor, '62')) {
            $nomor = '62' . $nomor;
        }

        Log::info('Mengirim OTP ke nomor (internasional): ' . $nomor . ' dengan kode: ' . $kode);

        try {
            $response = Http::withHeaders([
                'Authorization' => config('services.fonnte.token'),
            ])->post('https://api.fonnte.com/send', [
                'target'  => $nomor,
                'message' => "Kode OTP Anda: *{$kode}*\nBerlaku selama 5 menit.",
            ]);

            Log::info('Respons Fonnte: ' . $response->body());

            if (!$response->successful() || !$response->json('status')) {
                Log::error('Fonnte gagal: ' . $response->body());
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengirim kode OTP!',
                    'error'   => 'Pengiriman kode ke WhatsApp gagal, coba lagi!',
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('Fonnte Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim kode OTP!',
                'error'   => 'Gagal mengirim pesan WhatsApp karena kesalahan koneksi.',
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Kode OTP telah dikirim ke WhatsApp Anda!',
        ]);
    }

    // === STEP 2: Verifikasi Kode OTP ===
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'otp'   => 'required|string|size:6',
            ],
            [
                'email.required' => 'Email harus diisi!',
                'otp.required'   => 'Kode OTP harus diisi!',
                'otp.size'       => 'Kode OTP harus 6 digit!',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Verifikasi kode OTP gagal!',
                'error'   => $validator->errors()->first(),
            ], 422);
        }

        $cachedOtp = Cache::get("otp_" . $request->email);

        if (!$cachedOtp || $cachedOtp !== $request->otp) {
            return response()->json([
                'success' => false,
                'message' => 'Verifikasi kode OTP gagal!',
                'error'   => 'Kode OTP salah atau sudah kadaluarsa.',
            ], 422);
        }

        // OTP valid — simpan flag verified, hapus OTP
        Cache::forget("otp_" . $request->email);
        Cache::put("verified_" . $request->email, true, now()->addMinutes(10));

        return response()->json([
            'success' => true,
            'message' => 'Kode OTP berhasil diverifikasi! Silakan lanjutkan reset password.',
        ]);
    }

    // === STEP 3: Reset Password ===
    public function resetPassword(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'email'                     => 'required|email',
                'kata_sandi_baru'           => 'required|string|min:8|confirmed',
                'kata_sandi_baru_confirmation' => 'required|string',
            ],
            [
                'email.required'                        => 'Email harus diisi!',
                'kata_sandi_baru.required'              => 'Kata sandi baru harus diisi!',
                'kata_sandi_baru.min'                   => 'Kata sandi minimal 8 karakter!',
                'kata_sandi_baru.confirmed'             => 'Konfirmasi kata sandi tidak cocok!',
                'kata_sandi_baru_confirmation.required' => 'Konfirmasi kata sandi harus diisi!',
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Reset password gagal!',
                'error'   => $validator->errors()->first(),
            ], 422);
        }

        $isVerified = Cache::get("verified_" . $request->email);
        if (!$isVerified) {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melakukan verifikasi OTP. Silakan ulangi proses lupa password.',
            ], 403);
        }

        $akun = Akun::where('email', $request->email)->first();
        if (!$akun) {
            return response()->json([
                'success' => false,
                'message' => 'Akun tidak ditemukan.',
            ], 404);
        }

        $akun->kata_sandi = Hash::make($request->kata_sandi_baru);
        $akun->save();

        Cache::forget("otp_" . $request->email);
        Cache::forget("verified_" . $request->email);

        return response()->json([
            'success' => true,
            'message' => 'Kata sandi berhasil diperbarui.',
        ]);
    }
}
