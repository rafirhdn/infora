<?php

namespace App\Http\Controllers\Api\manajemenAkademik\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan'
            ], 404);
        }

        $siswa = $user->siswa;

        $query = Jadwal::with([
            'kelas.jurusan',
            'mataPelajaran',
            'guru',
            'semester'
        ])
        ->where('id_kelas', $siswa->id_kelas);

        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }

        if ($request->filled('id_semester')) {
            $query->where('id_semester', $request->id_semester);
        }

        $jadwal = $query
            ->orderByRaw("
                FIELD(
                    hari,
                    'senin',
                    'selasa',
                    'rabu',
                    'kamis',
                    'jumat'
                )
            ")
            ->orderBy('jam_mulai')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $jadwal
        ]);
    }
}