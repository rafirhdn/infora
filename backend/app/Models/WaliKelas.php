<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    protected $table = 'wali_kelas';

    protected $primaryKey = 'id_wali_kelas';

    protected $fillable = [
        'id_guru',
        'id_kelas',
        'id_semester'
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id_guru');
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
