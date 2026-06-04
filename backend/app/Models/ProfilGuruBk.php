<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilGuruBK extends Model
{
  use HasFactory;

  protected $table = 'profil_guru_bk';
  protected $primaryKey = 'id_profil_guru_bk';
  public $timestamps = true;

  protected $fillable = [
    'nip',
    'id_akun',
  ];

  public function akun()
  {
    return $this->belongsTo(Akun::class, 'id_akun', 'id_akun');
  }
}
