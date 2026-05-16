<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanTugas extends Model
{
    protected $table = 'pengajuan_tugas';

    protected $primaryKey = 'id_pengajuan_tugas';

    public $timestamps = true;

    protected $fillable = [
        'berkas',
        'nilai',
        'diajukan',
        'id_tugas',
        'id_siswa'
    ];

    public function tugas()
    {
        return $this->belongsTo(
            Tugas::class,
            'id_tugas',
            'id_tugas'
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
}