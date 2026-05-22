<script setup lang="ts">
definePageMeta({ layout: 'landing' })

const modules = [
  {
    value: 'absensi',
    icon: 'hugeicons:fire',
    title: 'Manajemen Absensi',
    tag: 'Kehadiran',
    desc: 'Rekap kehadiran harian secara otomatis dan akurat.',
    detail: [
      'Pencatatan kehadiran per kelas dan per mata pelajaran.',
      'Rekap mingguan dan bulanan yang bisa diekspor.',
      'Notifikasi otomatis untuk ketidakhadiran berlebih.',
      'Riwayat absensi siswa tersimpan dan mudah dicari.',
    ]
  },
  {
    value: 'akademi',
    icon: 'hugeicons:mortarboard-02',
    title: 'Manajemen Akademi',
    tag: 'Nilai & Jadwal',
    desc: 'Nilai, jadwal, dan kurikulum dalam satu tampilan bersih.',
    detail: [
      'Input dan kelola nilai per mata pelajaran.',
      'Jadwal pelajaran yang tidak tumpang tindih.',
      'Laporan akademik siswa yang siap cetak.',
      'Manajemen kurikulum per tahun ajaran.',
    ]
  },
  {
    value: 'ekstrakurikuler',
    icon: 'hugeicons:atom-02',
    title: 'Manajemen Ekstrakurikuler',
    tag: 'Kegiatan',
    desc: 'Kelola ekskul tanpa kebingungan jadwal dan peserta.',
    detail: [
      'Daftar ekskul beserta pembina dan jadwalnya.',
      'Pendaftaran dan pengelolaan peserta ekskul.',
      'Absensi kegiatan ekskul yang terintegrasi.',
      'Laporan partisipasi siswa per ekskul.',
    ]
  },
  {
    value: 'surat',
    icon: 'hugeicons:mail-02',
    title: 'Manajemen Surat',
    tag: 'Arsip',
    desc: 'Arsip surat masuk dan keluar yang terstruktur dan mudah dilacak.',
    detail: [
      'Pencatatan surat masuk dan keluar secara digital.',
      'Kategorisasi surat berdasarkan jenis dan tanggal.',
      'Pencarian surat yang cepat berdasarkan kata kunci.',
      'Riwayat disposisi dan tindak lanjut surat.',
    ]
  },
  {
    value: 'bimbingan-konseling',
    icon: 'hugeicons:conversation',
    title: 'Bimbingan Konseling',
    tag: 'Konseling',
    desc: 'Catatan sesi konseling yang privat, terorganisir, dan mudah diakses.',
    detail: [
      'Profil konseling per siswa yang terjaga privasinya.',
      'Jadwal sesi konseling yang teratur.',
      'Catatan hasil sesi dan tindak lanjut.',
      'Laporan perkembangan siswa untuk wali kelas.',
    ]
  },
]
</script>

<template>
  <div>
    <!-- Header -->
    <section class="max-w-5xl mx-auto px-6 pt-24 pb-16">
      <div class="flex flex-col gap-4 max-w-xl">
        <span class="font-mono text-xs text-flamingo-500 tracking-widest uppercase">Platform</span>
        <h1 class="text-4xl font-medium text-ink-base-dark tracking-tight leading-tight">
          Lima modul. Satu platform.
        </h1>
        <p class="text-base text-ink-muted-dark leading-relaxed">
          Setiap modul dirancang untuk menyelesaikan satu masalah dengan baik —
          tidak berlebihan, tidak kurang.
        </p>
      </div>
    </section>

    <!-- Modul List -->
    <section class="max-w-5xl mx-auto px-6 py-16">
      <div class="flex flex-col gap-px bg-line-faint border border-line-faint rounded-sm overflow-hidden">
        <div
          v-for="mod in modules"
          :key="mod.value"
          class="flex flex-row gap-10 p-8 bg-surface-canvas hover:bg-canvas-hover transition-colors duration-150">

          <!-- Kiri -->
          <div class="flex flex-col gap-3 w-64 shrink-0">
            <div class="flex items-center gap-2">
              <Icon :name="mod.icon" class="w-4 h-4 text-flamingo-500" />
              <span class="font-mono text-xs text-flamingo-500 tracking-widest uppercase">
                {{ mod.tag }}
              </span>
            </div>
            <span class="text-base font-medium text-ink-base-dark">{{ mod.title }}</span>
            <p class="text-sm text-ink-muted-dark leading-relaxed">{{ mod.desc }}</p>
          </div>

          <!-- Kanan -->
          <div class="flex flex-col gap-2 flex-1">
            <div
              v-for="(item, i) in mod.detail"
              :key="i"
              class="flex items-start gap-2.5">
              <span class="mt-1.5 w-1 h-1 rounded-full bg-flamingo-400 shrink-0" />
              <span class="text-sm text-ink-muted-dark leading-relaxed">{{ item }}</span>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- CTA -->
    <div class="max-w-5xl mx-auto px-6">
      <div class="border-t border-line-faint" />
    </div>
    <section class="max-w-5xl mx-auto px-6 py-16">
      <div class="flex flex-col gap-4 max-w-md">
        <h2 class="text-2xl font-medium text-ink-base-dark tracking-tight">
          Siap mencoba?
        </h2>
        <p class="text-sm text-ink-muted-dark leading-relaxed">
          Semua modul bisa diakses langsung setelah masuk — tidak perlu konfigurasi tambahan.
        </p>
        <div>
          <NuxtLink to="/autentikasi/login">
            <button class="px-5 py-2 text-sm font-medium rounded-sm bg-flamingo-500 text-ink-base-light hover:bg-flamingo-600 transition-all duration-150">
              Masuk ke Infora
            </button>
          </NuxtLink>
        </div>
      </div>
    </section>

  </div>
</template>
