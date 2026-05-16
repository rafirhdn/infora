<?php

namespace App\Http\Controllers\Api\manajemenAkademik\Guru;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = Siswa::with([
            'kelas.jurusan',
            'akun'
        ]);

        if ($request->filled('id_kelas')) {
            $query->where('id_kelas', $request->id_kelas);
        }

        $siswa = $query
            ->orderBy('nama')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $siswa
        ]);
    }

    public function show(Siswa $siswa)
    {
        return response()->json([
            'success' => true,
            'data' => $siswa->load([
                'kelas.jurusan',
                'nilai',
                'pengajuanTugas'
            ])
        ]);
    }
}