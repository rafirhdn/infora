<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\autentikasi\AuthController;

use App\Http\Controllers\manajemenAkademik\Admin\JurusanController;
use App\Http\Controllers\manajemenAkademik\Admin\SemesterController;
use App\Http\Controllers\manajemenAkademik\Admin\KelasController;
use App\Http\Controllers\manajemenAkademik\Admin\SiswaController;
use App\Http\Controllers\manajemenAkademik\Admin\GuruController;
use App\Http\Controllers\manajemenAkademik\Admin\OrangTuaController;
use App\Http\Controllers\manajemenAkademik\Admin\MataPelajaranController;
use App\Http\Controllers\manajemenAkademik\Admin\KompetensiController;
use App\Http\Controllers\manajemenAkademik\Admin\JadwalController;
use App\Http\Controllers\manajemenAkademik\Admin\AnggotaKelasController;

use App\Http\Controllers\manajemenAkademik\Guru\JadwalController as GuruJadwalController;
use App\Http\Controllers\manajemenAkademik\Guru\TugasController as GuruTugasController;
use App\Http\Controllers\manajemenAkademik\Guru\PengajuanTugasController as GuruPengajuanTugasController;
use App\Http\Controllers\manajemenAkademik\Guru\NilaiController as GuruNilaiController;
use App\Http\Controllers\manajemenAkademik\Guru\SiswaController as GuruSiswaController;
use App\Http\Controllers\manajemenAkademik\Guru\RaporController as GuruRaporController;

use App\Http\Controllers\manajemenAkademik\Siswa\JadwalController as SiswaJadwalController;
use App\Http\Controllers\manajemenAkademik\Siswa\TugasController as SiswaTugasController;
use App\Http\Controllers\manajemenAkademik\Siswa\PengajuanTugasController as SiswaPengajuanTugasController;
use App\Http\Controllers\manajemenAkademik\Siswa\NilaiController as SiswaNilaiController;
use App\Http\Controllers\manajemenAkademik\Siswa\RaporController as SiswaRaporController;

use App\Http\Controllers\manajemenAkademik\OrangTua\NilaiController as OrangTuaNilaiController;
use App\Http\Controllers\manajemenAkademik\OrangTua\RaporController as OrangTuaRaporController;
use App\Http\Controllers\manajemenAkademik\OrangTua\JadwalController as OrangTuaJadwalController;

use App\Http\Controllers\manajemenAkademik\Waka\JadwalController as WakaJadwalController;
use App\Http\Controllers\manajemenAkademik\Waka\NilaiController as WakaNilaiController;
use App\Http\Controllers\manajemenAkademik\Waka\RaporController as WakaRaporController;
use App\Http\Controllers\manajemenAkademik\Waka\MataPelajaranController as WakaMataPelajaranController;
use App\Http\Controllers\manajemenAkademik\Waka\KompetensiController as WakaKompetensiController;
use App\Http\Controllers\manajemenAkademik\Waka\MonitoringController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware([
    'force.json',
    'auth:sanctum'
])->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::prefix('admin')
        ->middleware('role:tata_usaha')
        ->group(function () {

            Route::apiResource('jurusan', JurusanController::class);
            Route::apiResource('semester', SemesterController::class);
            Route::apiResource('kelas', KelasController::class);
            Route::apiResource('siswa', SiswaController::class);
            Route::apiResource('guru', GuruController::class);
            Route::apiResource('orang-tua', OrangTuaController::class);
            Route::apiResource('mata-pelajaran', MataPelajaranController::class);
            Route::apiResource('kompetensi', KompetensiController::class);
            Route::apiResource('jadwal', JadwalController::class);
            Route::apiResource('anggota-kelas', AnggotaKelasController::class);

        });

    Route::prefix('guru')
        ->middleware('role:guru_produktif,wali_kelas')
        ->group(function () {

            Route::get('jadwal', [GuruJadwalController::class, 'index']);

            Route::apiResource('tugas', GuruTugasController::class);

            Route::apiResource(
                'pengajuan-tugas',
                GuruPengajuanTugasController::class
            );

            Route::apiResource(
                'nilai',
                GuruNilaiController::class
            )->middleware('semester.active');

            Route::get(
                'siswa',
                [GuruSiswaController::class, 'index']
            );

            Route::get(
                'rapor',
                [GuruRaporController::class, 'index']
            );

        });

    Route::prefix('siswa')
        ->middleware('role:siswa')
        ->group(function () {

            Route::get(
                'jadwal',
                [SiswaJadwalController::class, 'index']
            );

            Route::get(
                'tugas',
                [SiswaTugasController::class, 'index']
            );

            Route::get(
                'tugas/{tugas}',
                [SiswaTugasController::class, 'show']
            );

            Route::apiResource(
                'pengajuan-tugas',
                SiswaPengajuanTugasController::class
            );

            Route::get(
                'nilai',
                [SiswaNilaiController::class, 'index']
            );

            Route::get(
                'rapor',
                [SiswaRaporController::class, 'index']
            );

        });

    Route::prefix('orang-tua')
        ->middleware('role:orang_tua')
        ->group(function () {

            Route::get(
                'nilai',
                [OrangTuaNilaiController::class, 'index']
            );

            Route::get(
                'rapor',
                [OrangTuaRaporController::class, 'index']
            );

            Route::get(
                'jadwal',
                [OrangTuaJadwalController::class, 'index']
            );

        });

    Route::prefix('waka')
        ->middleware('role:wakil_kepala_sekolah')
        ->group(function () {

            Route::apiResource(
                'jadwal',
                WakaJadwalController::class
            );

            Route::apiResource(
                'mata-pelajaran',
                WakaMataPelajaranController::class
            );

            Route::apiResource(
                'kompetensi',
                WakaKompetensiController::class
            );

            Route::get(
                'nilai',
                [WakaNilaiController::class, 'index']
            );

            Route::get(
                'nilai/{nilai}',
                [WakaNilaiController::class, 'show']
            );

            Route::get(
                'rapor',
                [WakaRaporController::class, 'index']
            );

            Route::get(
                'rapor/{rapor}',
                [WakaRaporController::class, 'show']
            );

            Route::put(
                'rapor/{rapor}',
                [WakaRaporController::class, 'update']
            );

            Route::get(
                'monitoring/dashboard',
                [MonitoringController::class, 'dashboard']
            );

            Route::get(
                'monitoring/statistik-nilai',
                [MonitoringController::class, 'statistikNilai']
            );

            Route::get(
                'monitoring/rapor-belum-lengkap',
                [MonitoringController::class, 'raporBelumLengkap']
            );

        });

});