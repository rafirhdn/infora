<?php

namespace App\Http\Controllers\Api\manajemenAkademik\Guru;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TugasController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->guru) {
            return response()->json([
                'success' => false,
                'message' => 'Data guru tidak ditemukan'
            ], 404);
        }

        $query = Tugas::with([
            'mataPelajaran',
            'kelas',
            'semester'
        ])->where('id_guru', $user->guru->id_guru);

        if ($request->filled('id_kelas')) {
            $query->where('id_kelas', $request->id_kelas);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $tugas = $query
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $tugas
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'judul' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'tenggat_waktu' => 'required|date',
            'status' => 'required|in:buka,tutup',
            'berkas' => 'nullable|string|max:255',
            'id_mata_pelajaran' => 'required|exists:mata_pelajaran,id_mata_pelajaran',
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'id_semester' => 'required|exists:semester,id_semester'
        ]);

        $tugas = Tugas::create([
            ...$validated,
            'id_guru' => $user->guru->id_guru
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil ditambahkan',
            'data' => $tugas->load([
                'mataPelajaran',
                'kelas',
                'semester'
            ])
        ]);
    }

    public function show(Tugas $tugas)
    {
        return response()->json([
            'success' => true,
            'data' => $tugas->load([
                'mataPelajaran',
                'kelas',
                'semester',
                'pengajuanTugas.siswa'
            ])
        ]);
    }

    public function update(Request $request, Tugas $tugas)
    {
        $validated = $request->validate([
            'judul' => 'sometimes|required|string|max:150',
            'deskripsi' => 'nullable|string',
            'tenggat_waktu' => 'sometimes|required|date',
            'status' => 'sometimes|required|in:buka,tutup',
            'berkas' => 'nullable|string|max:255'
        ]);

        $tugas->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil diupdate',
            'data' => $tugas->fresh()
        ]);
    }

    public function destroy(Tugas $tugas)
    {
        $tugas->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tugas berhasil dihapus'
        ]);
    }
}