<?php

namespace App\Http\Controllers\Api\manajemenAkademik\Guru;

use App\Http\Controllers\Controller;
use App\Models\PengajuanTugas;
use Illuminate\Http\Request;

class PengajuanTugasController extends Controller
{
    public function index(Request $request)
    {
        $query = PengajuanTugas::with([
            'tugas',
            'siswa'
        ]);

        if ($request->filled('id_tugas')) {
            $query->where('id_tugas', $request->id_tugas);
        }

        $pengajuan = $query
            ->orderByDesc('diajukan')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $pengajuan
        ]);
    }

    public function show(PengajuanTugas $pengajuanTugas)
    {
        return response()->json([
            'success' => true,
            'data' => $pengajuanTugas->load([
                'tugas',
                'siswa'
            ])
        ]);
    }

    public function update(Request $request, PengajuanTugas $pengajuanTugas)
    {
        $validated = $request->validate([
            'nilai' => 'nullable|numeric|min:0|max:100'
        ]);

        $pengajuanTugas->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Nilai pengajuan tugas berhasil diupdate',
            'data' => $pengajuanTugas->fresh()
        ]);
    }
}