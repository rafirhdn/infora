<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';

    protected $primaryKey = 'id_mata_pelajaran';

    public $timestamps = true;

    protected $fillable = [
        'nama',
        'kategori',
        'status',
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

    public function kompetensi()
    {
        return $this->hasMany(
            Kompetensi::class,
            'id_mata_pelajaran',
            'id_mata_pelajaran'
        );
    }

    public function jadwal()
    {
        return $this->hasMany(
            Jadwal::class,
            'id_mata_pelajaran',
            'id_mata_pelajaran'
        );
    }

    public function tugas()
    {
        return $this->hasMany(
            Tugas::class,
            'id_mata_pelajaran',
            'id_mata_pelajaran'
        );
    }

    public function nilai()
    {
        return $this->hasMany(
            Nilai::class,
            'id_mata_pelajaran',
            'id_mata_pelajaran'
        );
    }
}