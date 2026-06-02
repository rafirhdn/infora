<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KepalaSekolah extends Model
{
    protected $table = 'kepala_sekolah';

    protected $primaryKey = 'id_kepala_sekolah';

    protected $fillable = [
        'nip',
        'id_akun'
    ];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun', 'id_akun');
    }
}
