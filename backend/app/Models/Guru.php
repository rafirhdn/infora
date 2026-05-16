<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    protected $table = 'guru';

    protected $primaryKey = 'id_guru';

    public $timestamps = true;

    protected $fillable = [
        'nama',
        'nik',
        'email',
        'nomor',
        'id_jurusan',
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

    public function jurusan()
    {
        return $this->belongsTo(
            Jurusan::class,
            'id_jurusan',
            'id_jurusan'
        );
    }

    public function jadwal()
    {
        return $this->hasMany(
            Jadwal::class,
            'id_guru',
            'id_guru'
        );
    }

    public function tugas()
    {
        return $this->hasMany(
            Tugas::class,
            'id_guru',
            'id_guru'
        );
    }
}