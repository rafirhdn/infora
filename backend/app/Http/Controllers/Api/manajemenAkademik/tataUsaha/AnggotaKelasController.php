<?php

namespace App\Http\Controllers\manajemenAkademik\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnggotaKelas;
use Illuminate\Http\Request;

class AnggotaKelasController extends Controller
{
    public function index(Request $request)
    {
        $query = AnggotaKelas::with([
            'siswa',
            'kelas.jurusan',
            'semester'
        ]);

        if ($request->filled('id_kelas')) {
            $query->where(
                'id_kelas',
                $request->id_kelas
            );
        }

        if ($request->filled('id_semester')) {
            $query->where(
                'id_semester',
                $request->id_semester
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        $anggotaKelas = $query
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $anggotaKelas
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_siswa' =>
                'required|exists:siswa,id_siswa',

            'id_kelas' =>
                'required|exists:kelas,id_kelas',

            'id_semester' =>
                'required|exists:semester,id_semester',

            'status' =>
                'required|in:aktif,pindah,lulus'
        ]);

        $exists = AnggotaKelas::where(
            'id_siswa',
            $validated['id_siswa']
        )
        ->where(
            'id_semester',
            $validated['id_semester']
        )
        ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' =>
                    'Siswa sudah memiliki kelas di semester ini'
            ], 422);
        }

        $anggotaKelas = AnggotaKelas::create(
            $validated
        );

        return response()->json([
            'success' => true,
            'message' =>
                'Anggota kelas berhasil ditambahkan',
            'data' =>
                $anggotaKelas->load([
                    'siswa',
                    'kelas',
                    'semester'
                ])
        ], 201);
    }

    public function show(
        AnggotaKelas $anggotaKelas
    ) {
        return response()->json([
            'success' => true,
            'data' =>
                $anggotaKelas->load([
                    'siswa',
                    'kelas.jurusan',
                    'semester'
                ])
        ]);
    }

    public function update(
        Request $request,
        AnggotaKelas $anggotaKelas
    ) {
        $validated = $request->validate([
            'id_kelas' =>
                'sometimes|required|exists:kelas,id_kelas',

            'status' =>
                'sometimes|required|in:aktif,pindah,lulus'
        ]);

        $anggotaKelas->update(
            $validated
        );

        return response()->json([
            'success' => true,
            'message' =>
                'Anggota kelas berhasil diupdate',
            'data' =>
                $anggotaKelas
                    ->fresh()
                    ->load([
                        'siswa',
                        'kelas',
                        'semester'
                    ])
        ]);
    }

    public function destroy(
        AnggotaKelas $anggotaKelas
    ) {
        $anggotaKelas->delete();

        return response()->json([
            'success' => true,
            'message' =>
                'Anggota kelas berhasil dihapus'
        ]);
    }
}