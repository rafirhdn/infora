<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    protected $table = 'jadwal';

    protected $primaryKey = 'id_jadwal';

    public $timestamps = true;

    protected $fillable = [
        'hari',
        'jam_mulai',
        'jam_selesai',
        'ruang',
        'id_kelas',
        'id_mata_pelajaran',
        'id_guru',
        'id_semester'
    ];

    public function kelas()
    {
        return $this->belongsTo(
            Kelas::class,
            'id_kelas',
            'id_kelas'
        );
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(
            MataPelajaran::class,
            'id_mata_pelajaran',
            'id_mata_pelajaran'
        );
    }

    public function guru()
    {
        return $this->belongsTo(
            Guru::class,
            'id_guru',
            'id_guru'
        );
    }

    public function semester()
    {
        return $this->belongsTo(
            Semester::class,
            'id_semester',
            'id_semester'
        );
    }
}