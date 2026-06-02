<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
  use SoftDeletes;

  protected $table = 'kelas';
  protected $primaryKey = 'id_kelas';

  public $incrementing = true;
  public $timestamps = true;

  protected $fillable = [
    'nama',
    'tingkat',
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

  public function siswa()
  {
    return $this->hasMany(
      Siswa::class,
      'id_kelas',
      'id_kelas'
    );
  }

  public function anggotaKelas()
  {
    return $this->hasMany(
      AnggotaKelas::class,
      'id_kelas',
      'id_kelas'
    );
  }

  public function jadwal()
  {
    return $this->hasMany(
      Jadwal::class,
      'id_kelas',
      'id_kelas'
    );
  }

  public function waliKelas()
  {
    return $this->hasMany(WaliKelas::class, 'id_kelas', 'id_kelas');
  }

  public function getRouteKeyName()
  {
    return 'id_kelas';
  }
}
