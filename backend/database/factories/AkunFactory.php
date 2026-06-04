<?php

namespace Database\Factories;

use App\Models\Akun;
use Illuminate\Database\Eloquent\Factories\Factory;

class AkunFactory extends Factory
{
    protected $model = Akun::class;

    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'kata_sandi' => 'password', // akan di-hash otomatis oleh cast
            'nomor' => fake()->phoneNumber(),
            'profil' => null,
            'peran' => 'siswa',
        ];
    }

    public function tataUsaha()
    {
        return $this->state(fn () => ['peran' => 'tata_usaha']);
    }

    public function guru()
    {
        return $this->state(fn () => ['peran' => 'guru']);
    }

    public function waliKelas()
    {
        return $this->state(fn () => ['peran' => 'wali_kelas']);
    }

    public function siswa()
    {
        return $this->state(fn () => ['peran' => 'siswa']);
    }

    public function orangTua()
    {
        return $this->state(fn () => ['peran' => 'orang_tua']);
    }

    public function kepalaSekolah()
    {
        return $this->state(fn () => ['peran' => 'kepala_sekolah']);
    }

    public function wakilKepalaSekolah()
    {
        return $this->state(fn () => ['peran' => 'wakil_kepala_sekolah']);
    }
}
