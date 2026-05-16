<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $primaryKey = 'id_siswa';

    public $timestamps = true;

    protected $fillable = [
        'nis',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'nomor',
        'id_kelas',
        'id_akun'
    ];

    public function akun()
    {
        return $this->belongsTo(
            Akun::class,
            'id_akun',
            'id_akun'
        );
    }

    public function kelas()
    {
        return $this->belongsTo(
            Kelas::class,
            'id_kelas',
            'id_kelas'
        );
    }

    public function anggotaKelas()
    {
        return $this->hasMany(
            AnggotaKelas::class,
            'id_siswa',
            'id_siswa'
        );
    }

    public function nilai()
    {
        return $this->hasMany(
            Nilai::class,
            'id_siswa',
            'id_siswa'
        );
    }

    public function rapor()
    {
        return $this->hasMany(
            Rapor::class,
            'id_siswa',
            'id_siswa'
        );
    }

    public function pengajuanTugas()
    {
        return $this->hasMany(
            PengajuanTugas::class,
            'id_siswa',
            'id_siswa'
        );
    }

    public function orangTua()
    {
        return $this->hasMany(
            OrangTua::class,
            'id_siswa',
            'id_siswa'
        );
    }
}