<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table = 'semester';

    protected $primaryKey = 'id_semester';

    public $timestamps = true;

    protected $fillable = [
        'nama',
        'tahun_ajaran_awal',
        'tahun_ajaran_akhir',
        'status',
        'tanggal_mulai',
        'tanggal_selesai'
    ];

    public function anggotaKelas()
    {
        return $this->hasMany(
            AnggotaKelas::class,
            'id_semester',
            'id_semester'
        );
    }

    public function jadwal()
    {
        return $this->hasMany(
            Jadwal::class,
            'id_semester',
            'id_semester'
        );
    }

    public function tugas()
    {
        return $this->hasMany(
            Tugas::class,
            'id_semester',
            'id_semester'
        );
    }

    public function nilai()
    {
        return $this->hasMany(
            Nilai::class,
            'id_semester',
            'id_semester'
        );
    }

    public function rapor()
    {
        return $this->hasMany(
            Rapor::class,
            'id_semester',
            'id_semester'
        );
    }
}