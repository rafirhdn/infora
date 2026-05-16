<?php

namespace App\Http\Controllers\manajemenAkademik\Waka;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Jadwal;
use App\Models\Nilai;
use App\Models\Rapor;

class MonitoringController extends Controller
{
    public function dashboard()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'total_siswa' => Siswa::count(),
                'total_guru' => Guru::count(),
                'total_kelas' => Kelas::count(),
                'total_jadwal' => Jadwal::count(),
                'total_nilai' => Nilai::count(),
                'total_rapor' => Rapor::count()
            ]
        ]);
    }

    public function statistikNilai()
    {
        $rataRata = Nilai::avg('nilai_akhir');

        return response()->json([
            'success' => true,
            'data' => [
                'rata_rata_nilai' => round($rataRata, 2)
            ]
        ]);
    }

    public function raporBelumLengkap()
    {
        $rapor = Rapor::with([
            'siswa.kelas',
            'semester'
        ])
        ->where('status', 'belum_lengkap')
        ->get();

        return response()->json([
            'success' => true,
            'data' => $rapor
        ]);
    }
}