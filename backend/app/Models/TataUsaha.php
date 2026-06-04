<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TataUsaha extends Model
{
  use HasFactory;

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
