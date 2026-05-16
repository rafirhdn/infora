<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Rapor extends Model
{
    protected $table = 'rapor';

    protected $primaryKey = 'id_rapor';

    public $timestamps = true;

    protected $fillable = [
        'status',
        'berkas',
        'id_siswa',
        'id_semester'
    ];

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

    public function scopeLengkap(Builder $query): Builder
    {
        return $query->where('status', 'lengkap');
    }
}