<?php

namespace App\Http\Controllers\manajemenAkademik\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
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

        $query = Tugas::with([
            'mataPelajaran',
            'guru',
            'kelas',
            'semester'
        ])
        ->where('id_kelas', $siswa->id_kelas);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tugas = $query
            ->orderByDesc('tenggat_waktu')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $tugas
        ]);
    }

    public function show(Tugas $tuga)
    {
        return response()->json([
            'success' => true,
            'data' => $tuga->load([
                'mataPelajaran',
                'guru',
                'kelas',
                'semester'
            ])
        ]);
    }
}