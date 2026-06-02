<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Akun extends Authenticatable
{
  use HasApiTokens, Notifiable;

  protected $table = 'akun';

  protected $primaryKey = 'id_akun';

  public $incrementing = true;

  protected $keyType = 'int';

  public $timestamps = true;

  protected $fillable = [
    'nama',
    'email',
    'kata_sandi',
    'nomor',
    'profil',
    'peran'
  ];

  protected $hidden = [
    'kata_sandi',
    'remember_token'
  ];

  protected $casts = [
    'created_at' => 'datetime',
    'updated_at' => 'datetime'
  ];

  public function getAuthPassword()
  {
    return $this->kata_sandi;
  }
  public function guru()
  {
    return $this->hasOne(
      Guru::class,
      'id_akun',
      'id_akun'
    );
  }

  public function siswa()
  {
    return $this->hasOne(
      Siswa::class,
      'id_akun',
      'id_akun'
    );
  }

  public function orangTua()
  {
    return $this->hasOne(
      OrangTua::class,
      'id_akun',
      'id_akun'
    );
  }

  public function tataUsaha()
  {
    return $this->hasOne(TataUsaha::class, 'id_akun', 'id_akun');
  }

  public function kepalaSekolah()
  {
    return $this->hasOne(KepalaSekolah::class, 'id_akun', 'id_akun');
  }

  public function wakilKepalaSekolah()
  {
    return $this->hasOne(WakilKepalaSekolah::class, 'id_akun', 'id_akun');
  }

  public function waliKelas()
  {
    return $this->hasMany(WaliKelas::class, 'id_akun', 'id_akun');
  }
}
