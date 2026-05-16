<?php

namespace App\Http\Controllers\manajemenAkademik\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user || !$user->orangTua) {
            return response()->json([
                'success' => false,
                'message' => 'Data orang tua tidak ditemukan'
            ], 404);
        }

        $orangTua = $user->orangTua;

        $query = Nilai::with([
            'mataPelajaran',
            'kompetensi',
            'semester',
            'siswa.kelas'
        ])
        ->where('id_siswa', $orangTua->id_siswa);

        if ($request->filled('id_semester')) {
            $query->where(
                'id_semester',
                $request->id_semester
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
                'mataPelajaran',
                'kompetensi',
                'semester',
                'siswa.kelas.jurusan'
            ])
        ]);
    }
}