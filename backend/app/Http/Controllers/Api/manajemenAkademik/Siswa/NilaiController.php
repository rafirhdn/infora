<?php

namespace App\Http\Controllers\Api\manajemenAkademik\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
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

        $query = Nilai::with([
            'mataPelajaran',
            'kompetensi',
            'semester'
        ])
        ->where('id_siswa', $user->siswa->id_siswa);

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
                'semester'
            ])
        ]);
    }
}