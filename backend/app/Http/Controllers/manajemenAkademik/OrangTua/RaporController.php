<?php

namespace App\Http\Controllers\manajemenAkademik\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Rapor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RaporController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (!$user || !$user->orangTua) {
            return response()->json([
                'success' => false,
                'message' => 'Data orang tua tidak ditemukan'
            ], 404);
        }

        $rapor = Rapor::with([
            'semester',
            'siswa.kelas.jurusan'
        ])
        ->where(
            'id_siswa',
            $user->orangTua->id_siswa
        )
        ->orderByDesc('id_semester')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $rapor
        ]);
    }

    public function show(Rapor $rapor)
    {
        return response()->json([
            'success' => true,
            'data' => $rapor->load([
                'semester',
                'siswa.kelas.jurusan'
            ])
        ]);
    }
}