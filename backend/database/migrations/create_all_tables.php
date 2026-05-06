<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('users');

        // Akun
        Schema::create('akun', function (Blueprint $table) {
            $table->bigIncrements('id_akun');
            $table->string('nama', 255);
            $table->string('email', 255)->unique();
            $table->string('kata_sandi', 255);
            $table->string('nomor', 15)->nullable();
            $table->string('profil', 255)->default('profilBawaan.jpg');
            $table->enum('peran', [
                'tata_usaha',
                'kepala_sekolah',
                'wakil_kepala_sekolah',
                'wali_kelas',
                'guru_piket',
                'guru_bimbingan_konseling',
                'guru_produktif',
                'siswa',
                'orang_tua',
                'pembina_ekstrakurikuler'
            ]);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        // Akademik
        Schema::create('jurusan', function (Blueprint $table) {
            $table->bigIncrements('id_jurusan');
            $table->string('nama', 50);
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('semester', function (Blueprint $table) {
            $table->bigIncrements('id_semester');
            $table->string('nama', 20);
            $table->year('tahun_ajaran_awal');
            $table->year('tahun_ajaran_akhir');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('kelas', function (Blueprint $table) {
            $table->bigIncrements('id_kelas');
            $table->string('nama', 30);
            $table->tinyInteger('tingkat');
            $table->unsignedBigInteger('id_jurusan');
            $table->foreign('id_jurusan')->references('id_jurusan')->on('jurusan')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('siswa', function (Blueprint $table) {
            $table->bigIncrements('id_siswa');
            $table->string('nis', 20)->unique();
            $table->string('nama', 100);
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('nomor', 15)->nullable();
            $table->unsignedBigInteger('id_kelas');
            $table->unsignedBigInteger('id_akun');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('cascade');
            $table->foreign('id_akun')->references('id_akun')->on('akun')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('guru', function (Blueprint $table) {
            $table->bigIncrements('id_guru');
            $table->string('nama', 100);
            $table->string('nik', 20)->unique();
            $table->string('email', 150)->unique();
            $table->string('nomor', 15)->nullable();
            $table->unsignedBigInteger('id_jurusan')->nullable();
            $table->unsignedBigInteger('id_akun')->nullable();
            $table->foreign('id_jurusan')->references('id_jurusan')->on('jurusan')->onDelete('set null');
            $table->foreign('id_akun')->references('id_akun')->on('akun')->onDelete('set null');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('mata_pelajaran', function (Blueprint $table) {
            $table->bigIncrements('id_mata_pelajaran');
            $table->string('nama', 100);
            $table->enum('kategori', ['umum', 'kejuruan']);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->unsignedBigInteger('id_jurusan')->nullable();
            $table->foreign('id_jurusan')->references('id_jurusan')->on('jurusan')->onDelete('set null');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('kompetensi', function (Blueprint $table) {
            $table->bigIncrements('id_kompetensi');
            $table->string('kode', 20);
            $table->string('judul', 150);
            $table->text('deskripsi')->nullable();
            $table->tinyInteger('bobot');
            $table->unsignedBigInteger('id_mata_pelajaran');
            $table->foreign('id_mata_pelajaran')->references('id_mata_pelajaran')->on('mata_pelajaran')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('orang_tua', function (Blueprint $table) {
            $table->bigIncrements('id_orang_tua');
            $table->enum('hubungan', ['ayah', 'ibu', 'wali']);
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_akun');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
            $table->foreign('id_akun')->references('id_akun')->on('akun')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('anggota_kelas', function (Blueprint $table) {
            $table->bigIncrements('id_anggota_kelas');
            $table->enum('status', ['aktif', 'pindah', 'lulus'])->default('aktif');
            $table->unsignedBigInteger('id_kelas');
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_semester');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('cascade');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
            $table->foreign('id_semester')->references('id_semester')->on('semester')->onDelete('cascade');
            $table->unique(['id_siswa', 'id_semester'], 'kunci_unik_anggota_kelas');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('jadwal', function (Blueprint $table) {
            $table->bigIncrements('id_jadwal');
            $table->enum('hari', ['senin', 'selasa', 'rabu', 'kamis', 'jumat']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->string('ruang', 30)->nullable();
            $table->unsignedBigInteger('id_kelas');
            $table->unsignedBigInteger('id_mata_pelajaran');
            $table->unsignedBigInteger('id_guru');
            $table->unsignedBigInteger('id_semester');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('cascade');
            $table->foreign('id_mata_pelajaran')->references('id_mata_pelajaran')->on('mata_pelajaran')->onDelete('cascade');
            $table->foreign('id_guru')->references('id_guru')->on('guru')->onDelete('cascade');
            $table->foreign('id_semester')->references('id_semester')->on('semester')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('tugas', function (Blueprint $table) {
            $table->bigIncrements('id_tugas');
            $table->string('judul', 150);
            $table->text('deskripsi')->nullable();
            $table->dateTime('tenggat_waktu');
            $table->enum('status', ['buka', 'tutup'])->default('buka');
            $table->string('berkas', 255)->nullable();
            $table->unsignedBigInteger('id_mata_pelajaran');
            $table->unsignedBigInteger('id_kelas');
            $table->unsignedBigInteger('id_guru');
            $table->unsignedBigInteger('id_semester');
            $table->foreign('id_mata_pelajaran')->references('id_mata_pelajaran')->on('mata_pelajaran')->onDelete('cascade');
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')->onDelete('cascade');
            $table->foreign('id_guru')->references('id_guru')->on('guru')->onDelete('cascade');
            $table->foreign('id_semester')->references('id_semester')->on('semester')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('pengajuan_tugas', function (Blueprint $table) {
            $table->bigIncrements('id_pengajuan_tugas');
            $table->string('berkas', 255);
            $table->decimal('nilai', 5, 2)->nullable();
            $table->dateTime('diajukan');
            $table->unsignedBigInteger('id_tugas');
            $table->unsignedBigInteger('id_siswa');
            $table->foreign('id_tugas')->references('id_tugas')->on('tugas')->onDelete('cascade');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('nilai', function (Blueprint $table) {
            $table->bigIncrements('id_nilai');
            $table->decimal('nilai_sikap', 5, 2)->nullable();
            $table->decimal('nilai_pengetahuan', 5, 2)->nullable();
            $table->decimal('nilai_keterampilan', 5, 2)->nullable();
            $table->decimal('nilai_akhir', 5, 2)->nullable();
            $table->string('predikat', 5)->nullable();
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_mata_pelajaran');
            $table->unsignedBigInteger('id_kompetensi');
            $table->unsignedBigInteger('id_semester');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
            $table->foreign('id_mata_pelajaran')->references('id_mata_pelajaran')->on('mata_pelajaran')->onDelete('cascade');
            $table->foreign('id_kompetensi')->references('id_kompetensi')->on('kompetensi')->onDelete('cascade');
            $table->foreign('id_semester')->references('id_semester')->on('semester')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('rapor', function (Blueprint $table) {
            $table->bigIncrements('id_rapor');
            $table->enum('status', ['lengkap', 'belum_lengkap'])->default('belum_lengkap');
            $table->string('berkas', 255)->nullable();
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_semester');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
            $table->foreign('id_semester')->references('id_semester')->on('semester')->onDelete('cascade');
            $table->unique(['id_siswa', 'id_semester'], 'kunci_unik_rapor');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        // Absensi
        Schema::create('sesi_absen', function (Blueprint $table) {
            $table->bigIncrements('id_sesi_absen');
            $table->string('kode')->unique();
            $table->string('link');
            $table->timestamp('waktu_mulai');
            $table->timestamp('waktu_selesai');
            $table->unsignedBigInteger('id_akun');
            $table->foreign('id_akun')->references('id_akun')->on('akun')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('catatan_absen', function (Blueprint $table) {
            $table->bigIncrements('id_catatan_absen');
            $table->enum('status', ['hadir', 'sakit', 'izin', 'alpha']);
            $table->timestamp('waktu_absen');
            $table->string('lintang', 100);
            $table->string('garis_bujur', 100);
            $table->string('jarak', 100)->nullable();
            $table->unsignedBigInteger('id_sesi_absen');
            $table->unsignedBigInteger('id_siswa');
            $table->foreign('id_sesi_absen')->references('id_sesi_absen')->on('sesi_absen')->onDelete('cascade');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('qr', function (Blueprint $table) {
            $table->bigIncrements('id_qr');
            $table->string('kode_qr')->unique();
            $table->text('teks_qr');
            $table->integer('ukuran')->default(300);
            $table->timestamp('waktu_kadaluarsa');
            $table->boolean('aktif')->default(true);
            $table->unsignedBigInteger('id_akun');
            $table->foreign('id_akun')->references('id_akun')->on('akun')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        // Bimbingan Konseling
        Schema::create('profil_siswa_bk', function (Blueprint $table) {
            $table->bigIncrements('id_profil_siswa_bk');
            $table->integer('total_poin')->default(0);
            $table->enum('kategori', ['ringan', 'sedang', 'berat'])->default('ringan');
            $table->unsignedBigInteger('id_akun')->nullable();
            $table->unsignedBigInteger('id_siswa')->nullable();
            $table->foreign('id_akun')->references('id_akun')->on('akun')->onDelete('cascade');
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('profil_guru_bk', function (Blueprint $table) {
            $table->bigIncrements('id_profil_guru_bk');
            $table->string('nip', 20)->nullable();
            $table->unsignedBigInteger('id_akun')->nullable();
            $table->foreign('id_akun')->references('id_akun')->on('akun')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('jenis_pelanggaran', function (Blueprint $table) {
            $table->bigIncrements('id_jenis_pelanggaran');
            $table->string('nama', 100);
            $table->integer('poin')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('pelanggaran_siswa', function (Blueprint $table) {
            $table->bigIncrements('id_pelanggaran_siswa');
            $table->dateTime('tanggal')->useCurrent();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('id_siswa');
            $table->unsignedBigInteger('id_jenis_pelanggaran')->nullable();
            $table->unsignedBigInteger('id_guru_akun')->nullable();
            $table->foreign('id_siswa')->references('id_siswa')->on('siswa')->onDelete('cascade');
            $table->foreign('id_jenis_pelanggaran')->references('id_jenis_pelanggaran')->on('jenis_pelanggaran')->onDelete('set null');
            $table->foreign('id_guru_akun')->references('id_akun')->on('akun')->onDelete('set null');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('konseling', function (Blueprint $table) {
            $table->bigIncrements('id_konseling');
            $table->enum('status', ['pending', 'disetujui', 'selesai'])->default('pending');
            $table->dateTime('tanggal_pengajuan')->useCurrent();
            $table->unsignedBigInteger('id_siswa_akun')->nullable();
            $table->unsignedBigInteger('id_guru_akun')->nullable();
            $table->foreign('id_siswa_akun')->references('id_akun')->on('akun')->onDelete('set null');
            $table->foreign('id_guru_akun')->references('id_akun')->on('akun')->onDelete('set null');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('detail_konseling', function (Blueprint $table) {
            $table->bigIncrements('id_detail_konseling');
            $table->text('hasil')->nullable();
            $table->text('solusi')->nullable();
            $table->dateTime('tanggal')->useCurrent();
            $table->unsignedBigInteger('id_konseling');
            $table->foreign('id_konseling')->references('id_konseling')->on('konseling')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('jadwal_konseling', function (Blueprint $table) {
            $table->bigIncrements('id_jadwal_konseling');
            $table->dateTime('tanggal')->nullable();
            $table->text('keterangan')->nullable();
            $table->unsignedBigInteger('id_konseling');
            $table->foreign('id_konseling')->references('id_konseling')->on('konseling')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('ruang_obrolan', function (Blueprint $table) {
            $table->bigIncrements('id_ruang_obrolan');
            $table->enum('status', ['aktif', 'selesai'])->default('aktif');
            $table->unsignedBigInteger('id_konseling');
            $table->foreign('id_konseling')->references('id_konseling')->on('konseling')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('pesan_obrolan', function (Blueprint $table) {
            $table->bigIncrements('id_pesan_obrolan');
            $table->text('pesan')->nullable();
            $table->unsignedBigInteger('id_ruang_obrolan');
            $table->unsignedBigInteger('id_pengirim');
            $table->foreign('id_ruang_obrolan')->references('id_ruang_obrolan')->on('ruang_obrolan')->onDelete('cascade');
            $table->foreign('id_pengirim')->references('id_akun')->on('akun')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('tanya_jawab', function (Blueprint $table) {
            $table->bigIncrements('id_tanya_jawab');
            $table->text('pertanyaan');
            $table->text('jawaban')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        // Ekstrakurikuler
        Schema::create('ekstrakurikuler', function (Blueprint $table) {
            $table->bigIncrements('id_ekstrakurikuler');
            $table->string('nama', 100);
            $table->text('deskripsi_singkat')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->string('gambar', 255)->nullable();
            $table->unsignedBigInteger('id_akun')->nullable();
            $table->foreign('id_akun')->references('id_akun')->on('akun')->onDelete('set null');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('galeri_ekstrakurikuler', function (Blueprint $table) {
            $table->bigIncrements('id_galeri');
            $table->string('gambar', 255);
            $table->unsignedBigInteger('id_ekstrakurikuler');
            $table->foreign('id_ekstrakurikuler')->references('id_ekstrakurikuler')->on('ekstrakurikuler')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('program_kegiatan', function (Blueprint $table) {
            $table->bigIncrements('id_program_kegiatan');
            $table->string('nama_program', 200);
            $table->unsignedBigInteger('id_ekstrakurikuler');
            $table->foreign('id_ekstrakurikuler')->references('id_ekstrakurikuler')->on('ekstrakurikuler')->onDelete('cascade');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('pendaftaran_ekstrakurikuler', function (Blueprint $table) {
            $table->bigIncrements('id_pendaftaran');
            $table->text('alasan_bergabung');
            $table->enum('status', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->unsignedBigInteger('id_akun');
            $table->unsignedBigInteger('id_ekstrakurikuler');
            $table->foreign('id_akun')->references('id_akun')->on('akun')->onDelete('cascade');
            $table->foreign('id_ekstrakurikuler')->references('id_ekstrakurikuler')->on('ekstrakurikuler')->onDelete('cascade');
            $table->unique(['id_akun', 'id_ekstrakurikuler'], 'kunci_unik_pendaftaran');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('anggota_ekstrakurikuler', function (Blueprint $table) {
            $table->bigIncrements('id_anggota_ekstrakurikuler');
            $table->timestamp('bergabung_pada')->useCurrent();
            $table->unsignedBigInteger('id_akun');
            $table->unsignedBigInteger('id_ekstrakurikuler');
            $table->unsignedBigInteger('id_pendaftaran');
            $table->foreign('id_akun')->references('id_akun')->on('akun')->onDelete('cascade');
            $table->foreign('id_ekstrakurikuler')->references('id_ekstrakurikuler')->on('ekstrakurikuler')->onDelete('cascade');
            $table->foreign('id_pendaftaran')->references('id_pendaftaran')->on('pendaftaran_ekstrakurikuler')->onDelete('cascade');
            $table->unique(['id_akun', 'id_ekstrakurikuler'], 'kunci_unik_anggota');
            $table->unique('id_pendaftaran', 'kunci_unik_pendaftaran_anggota');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        // Surat
        Schema::create('bidang', function (Blueprint $table) {
            $table->bigIncrements('id_bidang');
            $table->string('nama', 100);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('kategori_surat', function (Blueprint $table) {
            $table->bigIncrements('id_kategori_surat');
            $table->string('nama', 255);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('tujuan_surat', function (Blueprint $table) {
            $table->bigIncrements('id_tujuan_surat');
            $table->string('nama', 255);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('surat', function (Blueprint $table) {
            $table->bigIncrements('id_surat');
            $table->string('nomor_surat', 255);
            $table->string('perihal', 255);
            $table->enum('jenis', ['masuk', 'keluar'])->default('masuk');
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak', 'disetujui_wakepsek', 'menunggu_kepsek'])->default('menunggu');
            $table->enum('tujuan_type', ['general', 'khusus'])->default('general');
            $table->date('tanggal_dibuat');
            $table->string('file', 255)->nullable();
            $table->string('penandatangan', 255)->nullable();
            $table->string('jenis_ttd', 255)->nullable();
            $table->timestamp('dibaca_pada')->nullable();
            $table->text('isi_informasi')->nullable();
            $table->string('judul_pengumuman', 255)->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('nama_acara', 255)->nullable();
            $table->string('hari', 255)->nullable();
            $table->string('waktu', 255)->nullable();
            $table->date('tanggal_acara')->nullable();
            $table->text('agenda')->nullable();
            $table->string('penerima', 255)->nullable();
            $table->string('penyelenggara', 255)->nullable();
            $table->string('tempat', 255)->nullable();
            $table->string('nama_pegawai', 255)->nullable();
            $table->string('nip_pegawai', 50)->nullable();
            $table->string('mapel_lama', 255)->nullable();
            $table->string('mapel_baru', 255)->nullable();
            $table->string('sekolah_tujuan', 255)->nullable();
            $table->text('alamat_sekolah_tujuan')->nullable();
            $table->string('nomor_sk', 100)->nullable();
            $table->date('tmt')->nullable();
            $table->unsignedBigInteger('id_kategori_surat')->nullable();
            $table->unsignedBigInteger('id_tujuan_surat')->nullable();
            $table->unsignedBigInteger('id_bidang')->nullable();
            $table->unsignedBigInteger('id_akun')->nullable();
            $table->unsignedBigInteger('id_guru')->nullable();
            $table->foreign('id_kategori_surat')->references('id_kategori_surat')->on('kategori_surat')->onDelete('set null');
            $table->foreign('id_tujuan_surat')->references('id_tujuan_surat')->on('tujuan_surat')->onDelete('set null');
            $table->foreign('id_bidang')->references('id_bidang')->on('bidang')->onDelete('set null');
            $table->foreign('id_akun')->references('id_akun')->on('akun')->onDelete('set null');
            $table->foreign('id_guru')->references('id_guru')->on('guru')->onDelete('set null');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('persetujuan_surat', function (Blueprint $table) {
            $table->bigIncrements('id_persetujuan');
            $table->string('peran', 50)->nullable();
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->text('catatan')->nullable();
            $table->unsignedBigInteger('id_surat');
            $table->unsignedBigInteger('id_akun')->nullable();
            $table->foreign('id_surat')->references('id_surat')->on('surat')->onDelete('cascade');
            $table->foreign('id_akun')->references('id_akun')->on('akun')->onDelete('set null');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('riwayat_baca_surat', function (Blueprint $table) {
            $table->bigIncrements('id_riwayat_baca');
            $table->timestamp('dibaca_pada')->useCurrent();
            $table->unsignedBigInteger('id_surat');
            $table->unsignedBigInteger('id_akun');
            $table->foreign('id_surat')->references('id_surat')->on('surat')->onDelete('cascade');
            $table->foreign('id_akun')->references('id_akun')->on('akun')->onDelete('cascade');
            $table->unique(['id_surat', 'id_akun'], 'kunci_unik_baca_surat');
        });
    }

    public function down(): void
    {
        // Surat
        Schema::dropIfExists('riwayat_baca_surat');
        Schema::dropIfExists('persetujuan_surat');
        Schema::dropIfExists('surat');
        Schema::dropIfExists('tujuan_surat');
        Schema::dropIfExists('kategori_surat');
        Schema::dropIfExists('bidang');

        // Ekstrakurikuler
        Schema::dropIfExists('anggota_ekstrakurikuler');
        Schema::dropIfExists('pendaftaran_ekstrakurikuler');
        Schema::dropIfExists('program_kegiatan');
        Schema::dropIfExists('galeri_ekstrakurikuler');
        Schema::dropIfExists('ekstrakurikuler');

        // Bimbingan Konseling
        Schema::dropIfExists('tanya_jawab');
        Schema::dropIfExists('pesan_obrolan');
        Schema::dropIfExists('ruang_obrolan');
        Schema::dropIfExists('jadwal_konseling');
        Schema::dropIfExists('detail_konseling');
        Schema::dropIfExists('konseling');
        Schema::dropIfExists('pelanggaran_siswa');
        Schema::dropIfExists('jenis_pelanggaran');
        Schema::dropIfExists('profil_guru_bk');
        Schema::dropIfExists('profil_siswa_bk');

        // Absen
        Schema::dropIfExists('qr');
        Schema::dropIfExists('catatan_absen');
        Schema::dropIfExists('sesi_absen');

        // Akademik
        Schema::dropIfExists('rapor');
        Schema::dropIfExists('pengajuan_tugas');
        Schema::dropIfExists('tugas');
        Schema::dropIfExists('nilai');
        Schema::dropIfExists('jadwal');
        Schema::dropIfExists('anggota_kelas');
        Schema::dropIfExists('orang_tua');
        Schema::dropIfExists('kompetensi');
        Schema::dropIfExists('mata_pelajaran');
        Schema::dropIfExists('guru');
        Schema::dropIfExists('siswa');
        Schema::dropIfExists('kelas');
        Schema::dropIfExists('semester');
        Schema::dropIfExists('jurusan');

        // Akun
        Schema::dropIfExists('akun');
    }
};
