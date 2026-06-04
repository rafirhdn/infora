<?php

namespace Database\Seeders;

use App\Models\Akun;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\OrangTua;
use App\Models\TataUsaha;
use App\Models\KepalaSekolah;
use App\Models\WakilKepalaSekolah;
use App\Models\WaliKelas;
use App\Models\ProfilGuruBK;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AkunSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Buat data master minimal (jurusan, kelas, semester) jika belum ada
        if (DB::table('jurusan')->count() == 0) {
            DB::table('jurusan')->insert([
                'nama' => 'Rekayasa Perangkat Lunak',
                'deskripsi' => 'Jurusan RPL',
                'status' => 'aktif'
            ]);
        }
        $idJurusan = DB::table('jurusan')->value('id_jurusan');

        if (DB::table('kelas')->count() == 0) {
            DB::table('kelas')->insert([
                'nama' => 'X RPL 1',
                'tingkat' => 10,
                'id_jurusan' => $idJurusan
            ]);
        }
        $idKelas = DB::table('kelas')->value('id_kelas');

        if (DB::table('semester')->count() == 0) {
            DB::table('semester')->insert([
                'nama' => 'Ganjil',
                'tahun_ajaran_awal' => 2025,
                'tahun_ajaran_akhir' => 2026,
                'status' => 'aktif'
            ]);
        }
        $idSemester = DB::table('semester')->value('id_semester');

        // Helper untuk generate NIP dan NIS unik
        $nipCounter = 1;
        $nisCounter = 1;

        // Daftar nomor WhatsApp yang diberikan (urutan)
        $nomorWhatsApp = [
            '85810201605',   // 1. Tata Usaha
            '81295842139',   // 2. Guru
            '83177088229',   // 3. Wali Kelas
            '82111159144',   // 4. Siswa
            '81219649243',   // 5. Orang Tua
            '87872499147',   // 6. Kepala Sekolah
            '82113523411',   // 7. Wakil Kurikulum
            '85710572226',   // 8. Wakil Prasarana
            '85736033217',   // 9. Wakil Kesiswaan
            '81317208074',   // 10. Guru BK
            '85218275702',   // 11. Pembina Ekstrakurikuler
        ];
        $idx = 0;

        // 1. Tata Usaha
        $akun = Akun::create([
            'nama' => 'Tata Usaha',
            'email' => 'tatausaha@sekolah.com',
            'kata_sandi' => Hash::make('password'),
            'nomor' => $nomorWhatsApp[$idx++],
            'peran' => 'tata_usaha',
        ]);
        TataUsaha::create(['id_akun' => $akun->id_akun]);

        // 2. Guru
        $akun = Akun::create([
            'nama' => 'Guru',
            'email' => 'guru@sekolah.com',
            'kata_sandi' => Hash::make('password'),
            'nomor' => $nomorWhatsApp[$idx++],
            'peran' => 'guru',
        ]);
        Guru::create([
            'id_akun' => $akun->id_akun,
            'nip' => '1234567890' . str_pad($nipCounter++, 8, '0', STR_PAD_LEFT),
            'id_jurusan' => $idJurusan
        ]);

        // 3. Wali Kelas
        $akun = Akun::create([
            'nama' => 'Wali Kelas',
            'email' => 'walikelas@sekolah.com',
            'kata_sandi' => Hash::make('password'),
            'nomor' => $nomorWhatsApp[$idx++],
            'peran' => 'wali_kelas',
        ]);
        $guru = Guru::create([
            'id_akun' => $akun->id_akun,
            'nip' => '1234567890' . str_pad($nipCounter++, 8, '0', STR_PAD_LEFT),
            'id_jurusan' => $idJurusan
        ]);
        WaliKelas::create([
            'id_akun' => $akun->id_akun,
            'id_kelas' => $idKelas,
            'id_semester' => $idSemester
        ]);

        // 4. Siswa
        $akun = Akun::create([
            'nama' => 'Siswa Contoh',
            'email' => 'siswa@sekolah.com',
            'kata_sandi' => Hash::make('password'),
            'nomor' => $nomorWhatsApp[$idx++],
            'peran' => 'siswa',
        ]);
        $siswa = Siswa::create([
            'id_akun' => $akun->id_akun,
            'nis' => '9876543210' . str_pad($nisCounter++, 8, '0', STR_PAD_LEFT),
            'id_kelas' => $idKelas,
            'tempat_lahir' => 'Kota',
            'tanggal_lahir' => '2000-01-01'
        ]);

        // 5. Orang Tua
        $akun = Akun::create([
            'nama' => 'Orang Tua',
            'email' => 'orangtua@sekolah.com',
            'kata_sandi' => Hash::make('password'),
            'nomor' => $nomorWhatsApp[$idx++],
            'peran' => 'orang_tua',
        ]);
        OrangTua::create([
            'id_akun' => $akun->id_akun,
            'hubungan' => 'ayah',
            'id_siswa' => $siswa->id_siswa
        ]);

        // 6. Kepala Sekolah
        $akun = Akun::create([
            'nama' => 'Kepala Sekolah',
            'email' => 'kepsek@sekolah.com',
            'kata_sandi' => Hash::make('password'),
            'nomor' => $nomorWhatsApp[$idx++],
            'peran' => 'kepala_sekolah',
        ]);
        KepalaSekolah::create([
            'id_akun' => $akun->id_akun,
            'nip' => '1234567890' . str_pad($nipCounter++, 8, '0', STR_PAD_LEFT)
        ]);

        // 7. Wakil Kepala Sekolah - Kurikulum
        $akun = Akun::create([
            'nama' => 'Wakil Kepala Sekolah Kurikulum',
            'email' => 'wakil.kurikulum@sekolah.com',
            'kata_sandi' => Hash::make('password'),
            'nomor' => $nomorWhatsApp[$idx++],
            'peran' => 'wakil_kepala_sekolah',
        ]);
        WakilKepalaSekolah::create([
            'id_akun' => $akun->id_akun,
            'peran' => 'kurikulum'
        ]);

        // 8. Wakil Kepala Sekolah - Prasarana
        $akun = Akun::create([
            'nama' => 'Wakil Kepala Sekolah Prasarana',
            'email' => 'wakil.prasarana@sekolah.com',
            'kata_sandi' => Hash::make('password'),
            'nomor' => $nomorWhatsApp[$idx++],
            'peran' => 'wakil_kepala_sekolah',
        ]);
        WakilKepalaSekolah::create([
            'id_akun' => $akun->id_akun,
            'peran' => 'prasarana'
        ]);

        // 9. Wakil Kepala Sekolah - Kesiswaan
        $akun = Akun::create([
            'nama' => 'Wakil Kepala Sekolah Kesiswaan',
            'email' => 'wakil.kesiswaan@sekolah.com',
            'kata_sandi' => Hash::make('password'),
            'nomor' => $nomorWhatsApp[$idx++],
            'peran' => 'wakil_kepala_sekolah',
        ]);
        WakilKepalaSekolah::create([
            'id_akun' => $akun->id_akun,
            'peran' => 'kesiswaan'
        ]);

        // 10. Guru BK
        $akun = Akun::create([
            'nama' => 'Guru BK',
            'email' => 'gurubk@sekolah.com',
            'kata_sandi' => Hash::make('password'),
            'nomor' => $nomorWhatsApp[$idx++],
            'peran' => 'guru',
        ]);
        ProfilGuruBK::create([
            'id_akun' => $akun->id_akun,
            'nip' => '1234567890' . str_pad($nipCounter++, 8, '0', STR_PAD_LEFT)
        ]);

        // 11. Pembina Ekstrakurikuler (tidak ada tabel relasi khusus)
        Akun::create([
            'nama' => 'Pembina Ekstrakurikuler',
            'email' => 'pembina@sekolah.com',
            'kata_sandi' => Hash::make('password'),
            'nomor' => $nomorWhatsApp[$idx++],
            'peran' => 'pembina_ekstrakurikuler',
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
