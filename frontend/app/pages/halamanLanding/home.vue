<script setup lang="ts">
  definePageMeta({
    layout: 'landing'
  })
</script>

<template>
  <div>
    <!-- Hero Section -->
    <section class="max-w-6xl w-full mx-auto pt-24 pb-20 px-6 flex flex-col items-center justify-center text-center">
      <div class="flex flex-col gap-4 items-center text-center">
        <div class="flex flex-col gap-2 items-center text-center">
          <h1 class="text-4xl font-black text-ink-base-dark leading-10 tracking-tight">
            Platform untuk mengelola sistem sekolah
            <br />
            secara digital dan terpadu
          </h1>
          <p class="text-lg text-ink-muted-dark leading-relaxed max-w-xl">
            Dibuat dengan tujuan untuk digitalisasi sistem di era global.
          </p>
        </div>
        <div class="flex flex-row items-center gap-3 mt-2">
          <NuxtLink to="/autentikasi/login">
            <button class="font-medium py-2 px-6 tracking-tight rounded-sm cursor-pointer bg-flamingo-500 text-ink-base-light hover:bg-flamingo-600 transition-all duration-150 ease-in-out">
              Mulai Sekarang
            </button>
          </NuxtLink>
          <NuxtLink to="/halamanLanding/platform">
            <button class="px-5 py-2 text-sm cursor-progress font-medium rounded-sm border border-line-faint text-ink-muted-dark hover:bg-canvas-hover hover:text-ink-base-dark transition-all duration-150">
              Lihat Sistem
            </button>
          </NuxtLink>
        </div>
      </div>
    </section>

    <!-- Fitur -->
    <section class="max-w-6xl w-full mx-auto px-6 py-20 flex flex-col items-center">
      <div class="flex flex-col gap-3 mb-12 w-full">
        <span class="font-mono font-black text-xs text-flamingo-500 tracking-widest uppercase">
          Platform
        </span>
        <h2 class="text-3xl font-medium text-ink-base-dark tracking-tight">
          Dirancang untuk keseharian sekolah.
        </h2>
        <p class="text-base text-ink-muted-dark max-w-lg">
          Setiap modul dibuat fokus — tidak berlebihan, tidak kurang.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-px bg-line-faint border border-line-faint rounded-sm overflow-hidden w-full">
        <div class="flex flex-col gap-3 p-6 bg-surface-canvas hover:bg-canvas-hover transition-colors duration-150">
          <Icon name="hugeicons:fire" class="w-5 h-5 text-flamingo-500" />
          <div class="flex flex-col gap-1">
            <span class="text-sm font-medium text-ink-base-dark">Manajemen Absensi</span>
            <p class="text-sm text-ink-muted-dark leading-relaxed">
              Rekap kehadiran harian secara otomatis. Tidak perlu kertas, tidak perlu repot.
            </p>
          </div>
        </div>

        <div class="flex flex-col gap-3 p-6 bg-surface-canvas hover:bg-canvas-hover transition-colors duration-150">
          <Icon name="hugeicons:mortarboard-02" class="w-5 h-5 text-flamingo-500" />
          <div class="flex flex-col gap-1">
            <span class="text-sm font-medium text-ink-base-dark">Manajemen Akademi</span>
            <p class="text-sm text-ink-muted-dark leading-relaxed">
              Nilai, jadwal, dan kurikulum tersusun rapi dalam satu tampilan yang bersih.
            </p>
          </div>
        </div>

        <div class="flex flex-col gap-3 p-6 bg-surface-canvas hover:bg-canvas-hover transition-colors duration-150">
          <Icon name="hugeicons:atom-02" class="w-5 h-5 text-flamingo-500" />
          <div class="flex flex-col gap-1">
            <span class="text-sm font-medium text-ink-base-dark">Manajemen Ekstrakurikuler</span>
            <p class="text-sm text-ink-muted-dark leading-relaxed">
              Kelola kegiatan dan jadwal ekskul tanpa tumpang tindih dan tanpa kebingungan.
            </p>
          </div>
        </div>

        <div class="flex flex-col gap-3 p-6 bg-surface-canvas hover:bg-canvas-hover transition-colors duration-150">
          <Icon name="hugeicons:mail-02" class="w-5 h-5 text-flamingo-500" />
          <div class="flex flex-col gap-1">
            <span class="text-sm font-medium text-ink-base-dark">Manajemen Surat</span>
            <p class="text-sm text-ink-muted-dark leading-relaxed">
              Arsip surat masuk dan keluar yang terstruktur — mudah dicari, mudah dilacak.
            </p>
          </div>
        </div>

        <div class="flex flex-col gap-3 p-6 bg-surface-canvas hover:bg-canvas-hover transition-colors duration-150 md:col-span-2">
          <Icon name="hugeicons:conversation" class="w-5 h-5 text-flamingo-500" />
          <div class="flex flex-col gap-1">
            <span class="text-sm font-medium text-ink-base-dark">Bimbingan Konseling</span>
            <p class="text-sm text-ink-muted-dark leading-relaxed">
              Catatan sesi konseling yang privat dan terorganisir. Setiap siswa mendapat perhatian yang layak.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="max-w-6xl w-full mx-auto px-6 py-20 flex flex-col items-center">
      <div class="flex flex-col gap-4 max-w-lg w-full">
        <span class="font-mono font-black text-xs text-flamingo-500 tracking-widest uppercase">
          Mulai
        </span>
        <h2 class="text-3xl font-medium text-ink-base-dark tracking-tight">
          Siap mengelola sekolah dengan lebih baik?
        </h2>
        <p class="text-base text-ink-muted-dark leading-relaxed">
          Masuk sekarang dan rasakan perbedaannya — tidak perlu setup yang rumit.
        </p>
        <div class="mt-2">
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
