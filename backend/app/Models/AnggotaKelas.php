<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaKelas extends Model
{
    protected $table = 'anggota_kelas';

    protected $primaryKey = 'id_anggota_kelas';

    public $timestamps = true;

    protected $fillable = [
        'status',
        'id_kelas',
        'id_siswa',
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

    public function siswa()
    {
        return $this->belongsTo(
            Siswa::class,
            'id_siswa',
            'id_siswa'
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