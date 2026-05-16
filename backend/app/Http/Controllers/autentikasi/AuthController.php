<?php

namespace App\Http\Controllers\autentikasi;

use App\Http\Controllers\Controller;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'kata_sandi' => 'required|string'
        ]);

        $akun = Akun::where('email', $validated['email'])
            ->first();

        if (
            !$akun ||
            !Hash::check(
                $validated['kata_sandi'],
                $akun->kata_sandi
            )
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau kata sandi salah'
            ], 401);
        }

        $token = $akun->createToken('auth_token')
            ->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token' => $token,
            'data' => [
                'id_akun' => $akun->id_akun,
                'nama' => $akun->nama,
                'email' => $akun->email,
                'peran' => $akun->peran,
                'profil' => $akun->profil
            ]
        ]);
    }

    public function me(Request $request)
    {
        return response()->json([
            'success' => true,
            'data' => $request->user()
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()
            ->currentAccessToken()
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }
}