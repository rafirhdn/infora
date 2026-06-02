<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TataUsaha extends Model
{
    protected $table = 'tata_usaha';

    protected $primaryKey = 'id_tata_usaha';

    protected $fillable = [
        'id_akun'
    ];

    public function akun()
    {
        return $this->belongsTo(Akun::class, 'id_akun', 'id_akun');
    }
}
