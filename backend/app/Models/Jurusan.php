<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\MataPelajaran;

class Jurusan extends Model
{
    protected $table = 'jurusan';

    protected $primaryKey = 'id_jurusan';

    public $timestamps = true;

    protected $fillable = [
        'nama',
        'deskripsi',
        'status'
    ];

    /**
     * RELASI GURU
     */
    public function guru()
    {
        return $this->hasMany(
            Guru::class,
            'id_jurusan',
            'id_jurusan'
        );
    }

    /**
     * RELASI MATA PELAJARAN
     */
    public function mataPelajaran()
    {
        return $this->hasMany(
            MataPelajaran::class,
            'id_jurusan',
            'id_jurusan'
        );
    }

    /**
     * RELASI KELAS
     */
    public function kelas()
    {
        return $this->hasMany(
            Kelas::class,
            'id_jurusan',
            'id_jurusan'
        );
    }

    /**
     * RELASI SISWA
     * Mengambil semua siswa dari seluruh kelas di jurusan ini
     */
    public function siswa()
    {
        return $this->hasManyThrough(
            Siswa::class,
            Kelas::class,
            'id_jurusan', 
            'id_kelas',   
            'id_jurusan', 
            'id_kelas'    
        );
    }

    /**
     * ROUTE MODEL BINDING
     */
    public function getRouteKeyName()
    {
        return 'id_jurusan';
    }
}
