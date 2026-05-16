<?php

namespace App\Http\Controllers\manajemenAkademik\Waka;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Nilai::with([
            'siswa.kelas',
            'mataPelajaran',
            'kompetensi',
            'semester'
        ]);

        if ($request->filled('id_siswa')) {
            $query->where(
                'id_siswa',
                $request->id_siswa
            );
        }

        if ($request->filled('id_semester')) {
            $query->where(
                'id_semester',
                $request->id_semester
            );
        }

        if ($request->filled('id_mata_pelajaran')) {
            $query->where(
                'id_mata_pelajaran',
                $request->id_mata_pelajaran
            );
        }

        $nilai = $query->get();

        return response()->json([
            'success' => true,
            'data' => $nilai
        ]);
    }

    public function show(Nilai $nilai)
    {
        return response()->json([
            'success' => true,
            'data' => $nilai->load([
                'siswa.kelas.jurusan',
                'mataPelajaran',
                'kompetensi',
                'semester'
            ])
        ]);
    }
}