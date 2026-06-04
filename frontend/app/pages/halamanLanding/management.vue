<script setup lang="ts">
  definePageMeta({ layout: 'landing' })

  const modules = [
    {
      value: 'absensi',
      icon: 'hugeicons:fire',
      number: '01',
      title: 'Manajemen Absensi',
      tag: 'Kehadiran',
      desc: 'Rekap kehadiran harian secara otomatis dan akurat.',
      detail: [
        'Pencatatan kehadiran per kelas dan per mata pelajaran.',
        'Rekap mingguan dan bulanan yang bisa diekspor.',
        'Notifikasi otomatis untuk ketidakhadiran berlebih.',
        'Riwayat absensi siswa tersimpan dan mudah dicari.'
      ]
    },
    {
      value: 'akademi',
      icon: 'hugeicons:mortarboard-02',
      number: '02',
      title: 'Manajemen Akademi',
      tag: 'Nilai & Jadwal',
      desc: 'Nilai, jadwal, dan kurikulum dalam satu tampilan bersih.',
      detail: [
        'Input dan kelola nilai per mata pelajaran.',
        'Jadwal pelajaran yang tidak tumpang tindih.',
        'Laporan akademik siswa yang siap cetak.',
        'Manajemen kurikulum per tahun ajaran.'
      ]
    },
    {
      value: 'ekstrakurikuler',
      icon: 'hugeicons:atom-02',
      number: '03',
      title: 'Manajemen Ekstrakurikuler',
      tag: 'Kegiatan',
      desc: 'Kelola ekskul tanpa kebingungan jadwal dan peserta.',
      detail: [
        'Daftar ekskul beserta pembina dan jadwalnya.',
        'Pendaftaran dan pengelolaan peserta ekskul.',
        'Absensi kegiatan ekskul yang terintegrasi.',
        'Laporan partisipasi siswa per ekskul.'
      ]
    },
    {
      value: 'surat',
      icon: 'hugeicons:mail-02',
      number: '04',
      title: 'Manajemen Surat',
      tag: 'Arsip',
      desc: 'Arsip surat masuk dan keluar yang terstruktur dan mudah dilacak.',
      detail: [
        'Pencatatan surat masuk dan keluar secara digital.',
        'Kategorisasi surat berdasarkan jenis dan tanggal.',
        'Pencarian surat yang cepat berdasarkan kata kunci.',
        'Riwayat disposisi dan tindak lanjut surat.'
      ]
    },
    {
      value: 'bimbingan-konseling',
      icon: 'hugeicons:conversation',
      number: '05',
      title: 'Bimbingan Konseling',
      tag: 'Konseling',
      desc: 'Catatan sesi konseling yang privat, terorganisir, dan mudah diakses.',
      detail: [
        'Profil konseling per siswa yang terjaga privasinya.',
        'Jadwal sesi konseling yang teratur.',
        'Catatan hasil sesi dan tindak lanjut.',
        'Laporan perkembangan siswa untuk wali kelas.'
      ]
    }
  ]
</script>

<template>
  <div>
    <!-- Header dengan teks tengah dan ikon mengelilingi -->
    <section
      class="relative max-w-6xl mx-auto px-6 pt-28 pb-20 overflow-hidden">
      <!-- Gradient blob background (opsional) -->
      <div class="absolute inset-0 -z-10 pointer-events-none">
        <div
          class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-150 h-100 bg-flamingo-500/10 rounded-full blur-3xl"></div>
      </div>

      <!-- Ikon mengelilingi (posisi absolute) -->
      <!-- Ikon kiri atas -->
      <div
        class="absolute left-0 top-10 w-12 h-12 rounded-full bg-flamingo-500 flex items-center justify-center shadow-lg">
        <Icon name="hugeicons:fire" class="w-5 h-5 text-white" />
      </div>

      <!-- Ikon kiri tengah -->
      <div
        class="absolute left-6 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full border border-line-faint bg-surface-canvas flex items-center justify-center shadow-sm">
        <Icon
          name="hugeicons:mortarboard-02"
          class="w-5 h-5 text-ink-muted-dark" />
      </div>

      <!-- Ikon kiri bawah -->
      <div
        class="absolute left-4 bottom-10 w-12 h-12 rounded-full border border-line-faint bg-surface-canvas flex items-center justify-center shadow-sm">
        <Icon name="hugeicons:mail-02" class="w-5 h-5 text-ink-muted-dark" />
      </div>

      <!-- Ikon kanan atas -->
      <div
        class="absolute right-0 top-10 w-12 h-12 rounded-full border border-line-faint bg-surface-canvas flex items-center justify-center shadow-sm">
        <Icon name="hugeicons:atom-02" class="w-5 h-5 text-ink-muted-dark" />
      </div>

      <!-- Ikon kanan tengah -->
      <div
        class="absolute right-6 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-flamingo-500 flex items-center justify-center shadow-lg">
        <Icon name="hugeicons:conversation" class="w-5 h-5 text-white" />
      </div>

      <!-- Ikon kanan bawah -->
      <div
        class="absolute right-4 bottom-10 w-12 h-12 rounded-full border border-line-faint bg-surface-canvas flex items-center justify-center shadow-sm">
        <Icon name="hugeicons:yoga-ball" class="w-5 h-5 text-ink-muted-dark" />
      </div>

      <!-- Ikon tambahan (opsional) di sudut lebih jauh -->
      <div
        class="absolute left-20 top-0 w-10 h-10 rounded-full bg-flamingo-500/20 flex items-center justify-center">
        <Icon name="hugeicons:chart-01" class="w-4 h-4 text-flamingo-500" />
      </div>
      <div
        class="absolute right-20 bottom-0 w-10 h-10 rounded-full bg-flamingo-500/20 flex items-center justify-center">
        <Icon name="hugeicons:database-01" class="w-4 h-4 text-flamingo-500" />
      </div>

      <!-- Konten teks di tengah -->
      <div class="flex flex-col items-center text-center max-w-2xl mx-auto">
        <div class="flex items-center gap-3 mb-2">
          <span class="w-8 h-px bg-flamingo-500" />
          <span class="w-8 h-px bg-flamingo-500" />
        </div>
        <h1
          class="text-5xl font-black text-ink-base-dark tracking-tight leading-[1.2]">
          Lima modul.
          <br />
          <span class="text-flamingo-500">Satu</span>
          platform.
        </h1>
        <p class="text-base text-ink-muted-dark leading-relaxed max-w-md mt-4">
          Setiap modul dirancang untuk menyelesaikan satu masalah dengan baik —
          tidak berlebihan, tidak kurang.
        </p>
      </div>
    </section>

    <!-- Divider -->
    <div class="max-w-6xl mx-auto px-6">
      <div
        class="h-px w-full bg-linear-to-r from-flamingo-500 via-flamingo-300 to-transparent" />
    </div>

    <!-- Modul List dengan icon apung (seperti di home) -->
    <section class="relative max-w-6xl mx-auto px-6 py-20 overflow-hidden">
      <!-- Gradient blob background mirip home -->
      <div class="absolute inset-0 -z-10 pointer-events-none">
        <div
          class="absolute top-0 left-1/2 -translate-x-1/2 w-150 h-100 bg-flamingo-500/10 rounded-full blur-3xl"></div>
        <div
          class="absolute top-12 left-1/4 w-75 h-62 bg-flamingo-400/8 rounded-full blur-2xl"></div>
      </div>

      <!-- Daftar modul -->
      <div
        class="flex flex-col gap-px bg-line-faint border border-line-faint rounded-sm overflow-hidden">
        <div
          v-for="mod in modules"
          :key="mod.value"
          class="relative flex flex-row gap-10 p-8 bg-surface-canvas hover:bg-canvas-hover transition-colors duration-150 group">
          <!-- Accent bar kiri saat hover -->
          <div
            class="absolute top-0 left-0 w-1 h-full bg-flamingo-500 opacity-0 group-hover:opacity-100 transition-opacity duration-200" />

          <!-- Nomor besar (background decorative) -->
          <div
            class="absolute right-8 top-1/2 -translate-y-1/2 font-black text-8xl text-ink-base-dark/4 select-none pointer-events-none leading-none">
            {{ mod.number }}
          </div>

          <!-- Kiri: info modul -->
          <div class="flex flex-col gap-4 w-64 shrink-0">
            <div class="flex items-center gap-2.5">
              <div
                class="w-8 h-8 rounded-full bg-flamingo-500/10 flex items-center justify-center group-hover:bg-flamingo-500 transition-colors duration-200">
                <Icon
                  :name="mod.icon"
                  class="w-4 h-4 text-flamingo-500 group-hover:text-white transition-colors duration-200" />
              </div>
              <span
                class="text-[14px] text-flamingo-500 font-bold tracking-widest uppercase">
                {{ mod.tag }}
              </span>
            </div>
            <span class="text-base font-bold text-ink-base-dark leading-snug">
              {{ mod.title }}
            </span>
            <p class="text-sm text-ink-muted-dark leading-relaxed">
              {{ mod.desc }}
            </p>
          </div>

          <!-- Kanan: detail fitur -->
          <div class="flex flex-col gap-3 flex-1">
            <div
              v-for="(item, i) in mod.detail"
              :key="i"
              class="flex items-start gap-3">
              <span
                class="mt-1.75 w-1.5 h-1.5 rounded-full bg-flamingo-500/40 group-hover:bg-flamingo-500 shrink-0 transition-colors duration-200" />
              <span class="text-sm text-ink-muted-dark leading-relaxed">
                {{ item }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Statement block (3 kolom) dengan gaya home -->
    <div class="max-w-6xl mx-auto px-6 pb-6">
      <div
        class="grid grid-cols-3 border border-line-faint rounded-sm overflow-hidden">
        <div class="flex flex-col gap-2 p-8 border-r border-line-faint justify-center items-center text-center">
          <span class="text-3xl font-black text-flamingo-500">5</span>
          <span class="text-sm text-ink-muted-dark">Modul terintegrasi</span>
        </div>
        <div class="flex flex-col gap-2 p-8 border-r border-line-faint justify-center items-center text-center">
          <span class="text-3xl font-black text-flamingo-500">1</span>
          <span class="text-sm text-ink-muted-dark">Platform terpadu</span>
        </div>
        <div class="flex flex-col gap-2 p-8 justify-center items-center text-center">
          <span class="text-3xl font-black text-flamingo-500">0</span>
          <span class="text-sm text-ink-muted-dark">Konfigurasi tambahan</span>
        </div>
      </div>
    </div>

    <!-- CTA (sama persis dengan home) -->
    <section class="w-full bg-surface-canvas">
      <div
        class="relative max-w-6xl w-full mx-auto px-6 py-24 flex flex-col items-center text-center overflow-hidden">
        <!-- Gradient blob -->
        <div class="absolute inset-0 -z-10 pointer-events-none">
          <div
            class="absolute top-0 right-0 w-125 h-75 bg-flamingo-500/5 rounded-full blur-3xl"></div>
          <div
            class="absolute bottom-0 left-0 w-75 h-50 bg-flamingo-600/5 rounded-full blur-2xl"></div>
        </div>

        <div class="flex flex-col gap-5 items-center max-w-xl">
          <h2
            class="text-4xl font-black text-ink-base-dark tracking-tight leading-tight">
            Siap mengelola sekolah dengan lebih baik?
          </h2>
          <p class="text-base text-ink-muted-dark leading-relaxed">
            Masuk sekarang dan rasakan perbedaannya!
          </p>
          <div class="mt-1">
            <NuxtLink to="/autentikasi/login">
              <button
                class="px-6 py-1.5 font-medium cursor-pointer rounded-sm bg-flamingo-500 text-white hover:bg-flamingo-600 transition-all duration-150">
                Masuk
              </button>
            </NuxtLink>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>
