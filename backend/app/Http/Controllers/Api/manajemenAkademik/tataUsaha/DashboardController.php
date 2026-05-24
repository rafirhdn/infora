<?php

namespace App\Http\Controllers\Api\manajemenAkademik\tataUsaha;

use App\Http\Controllers\Controller;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Semester;

class DashboardController extends Controller
{
    public function index()
    {
        $semesterAktif = Semester::where('status', 'aktif')
            ->first();

        $jurusan = Jurusan::withCount([
            'siswa'
        ])->get();

        return response()->json([
            'success' => true,

            'data' => [

                'total_jurusan' => Jurusan::count(),

                'total_kelas' => Kelas::count(),

                'total_guru' => Guru::count(),

                'total_siswa' => Siswa::count(),

                'semester_aktif' => $semesterAktif,

                'distribusi_jurusan' => $jurusan
            ]
        ]);
    }
}