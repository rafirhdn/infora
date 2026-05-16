<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kompetensi extends Model
{
    protected $table = 'kompetensi';

    protected $primaryKey = 'id_kompetensi';

    public $timestamps = true;

    protected $fillable = [
        'kode',
        'judul',
        'deskripsi',
        'bobot',
        'id_mata_pelajaran'
    ];

    public function mataPelajaran()
    {
        return $this->belongsTo(
            MataPelajaran::class,
            'id_mata_pelajaran',
            'id_mata_pelajaran'
        );
    }

    public function nilai()
    {
        return $this->hasMany(
            Nilai::class,
            'id_kompetensi',
            'id_kompetensi'
        );
    }
}