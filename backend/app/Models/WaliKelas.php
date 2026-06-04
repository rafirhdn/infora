<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WaliKelas extends Model
{
  use HasFactory;

  protected $table = 'wali_kelas';

  protected $primaryKey = 'id_wali_kelas';

  protected $fillable = [
    'id_guru',
    'id_kelas',
    'id_semester'
  ];

  public function akun()
  {
    return $this->belongsTo(Akun::class, 'id_akun', 'id_akun');
  }

  public function kelas()
  {
    return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
  }

  public function semester()
  {
    return $this->belongsTo(Semester::class, 'id_semester', 'id_semester');
  }
}
