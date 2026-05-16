<?php

namespace App\Http\Controllers\manajemenAkademik\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Rapor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RaporController extends Controller
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

        $rapor = Rapor::with([
            'semester',
            'siswa.kelas'
        ])
        ->where('id_siswa', $user->siswa->id_siswa)
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