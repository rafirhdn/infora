<?php

namespace App\Http\Controllers\Api\manajemenAkademik\Siswa;

use App\Http\Controllers\Controller;
use App\Models\PengajuanTugas;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanTugasController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user || !$user->siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan'
            ], 404);
        }

        $pengajuan = PengajuanTugas::with([
            'tugas.mataPelajaran'
        ])
        ->where('id_siswa', $user->siswa->id_siswa)
        ->orderByDesc('diajukan')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $pengajuan
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->siswa) {
            return response()->json([
                'success' => false,
                'message' => 'Data siswa tidak ditemukan'
            ], 404);
        }

        $validated = $request->validate([
            'id_tugas' => 'required|exists:tugas,id_tugas',
            'berkas' => 'required|string|max:255'
        ]);

        $tugas = Tugas::findOrFail($validated['id_tugas']);

        if ($tugas->status === 'tutup') {
            return response()->json([
                'success' => false,
                'message' => 'Tugas sudah ditutup'
            ], 422);
        }

        $pengajuan = PengajuanTugas::create([
            'id_tugas' => $validated['id_tugas'],
            'id_siswa' => $user->siswa->id_siswa,
            'berkas' => $validated['berkas'],
            'diajukan' => now()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dikumpulkan',
            'data' => $pengajuan->load('tugas')
        ]);
    }

    public function show(PengajuanTugas $pengajuanTuga)
    {
        return response()->json([
            'success' => true,
            'data' => $pengajuanTuga->load([
                'tugas',
                'siswa'
            ])
        ]);
    }
}