<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function kelas()
    {
        return $this->hasMany(
            Kelas::class,
            'id_jurusan',
            'id_jurusan'
        );
    }

    public function guru()
    {
        return $this->hasMany(
            Guru::class,
            'id_jurusan',
            'id_jurusan'
        );
    }

    public function mataPelajaran()
    {
        return $this->hasMany(
            MataPelajaran::class,
            'id_jurusan',
            'id_jurusan'
        );
    }
}