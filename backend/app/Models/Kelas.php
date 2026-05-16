<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $primaryKey = 'id_kelas';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'nama',
        'tingkat',
        'id_jurusan'
    ];

    public function jurusan()
    {
        return $this->belongsTo(
            Jurusan::class,
            'id_jurusan',
            'id_jurusan'
        );
    }

    public function siswa()
    {
        return $this->hasMany(
            Siswa::class,
            'id_kelas',
            'id_kelas'
        );
    }

    public function anggotaKelas()
    {
        return $this->hasMany(
            AnggotaKelas::class,
            'id_kelas',
            'id_kelas'
        );
    }

    public function jadwal()
    {
        return $this->hasMany(
            Jadwal::class,
            'id_kelas',
            'id_kelas'
        );
    }
}