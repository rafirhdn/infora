<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'tugas';

    protected $primaryKey = 'id_tugas';

    public $timestamps = true;

    protected $fillable = [
        'judul',
        'deskripsi',
        'tenggat_waktu',
        'status',
        'berkas',
        'id_mata_pelajaran',
        'id_kelas',
        'id_guru',
        'id_semester'
    ];

    public function mataPelajaran()
    {
        return $this->belongsTo(
            MataPelajaran::class,
            'id_mata_pelajaran',
            'id_mata_pelajaran'
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

    public function pengajuanTugas()
    {
        return $this->hasMany(
            PengajuanTugas::class,
            'id_tugas',
            'id_tugas'
        );
    }
}