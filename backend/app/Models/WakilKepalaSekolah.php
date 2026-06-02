<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WakilKepalaSekolah extends Model
{
    protected $table = 'wakil_kepala_sekolah';

    protected $primaryKey = 'id_wakil_kepala_sekolah';

    protected $fillable = [
        'peran',
        'id_akun'
    ];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun', 'id_akun');
    }
}
