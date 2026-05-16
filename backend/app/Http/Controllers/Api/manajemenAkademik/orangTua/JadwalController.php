<?php

namespace App\Http\Controllers\manajemenAkademik\OrangTua;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
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

        $query = Jadwal::with([
            'kelas.jurusan',
            'mataPelajaran',
            'guru',
            'semester'
        ])
        ->whereHas('kelas.siswa', function ($q) use ($orangTua) {
            $q->where('id_siswa', $orangTua->id_siswa);
        });

        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }

        if ($request->filled('id_semester')) {
            $query->where(
                'id_semester',
                $request->id_semester
            );
        }

        $jadwal = $query
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $jadwal
        ]);
    }
}