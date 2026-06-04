<script setup lang="ts">
  definePageMeta({
    layout: 'landing'
  })
</script>

<template>
  <div>
    <!-- Hero Section -->
    <section
      class="relative max-w-6xl w-full mx-auto pt-28 pb-24 px-6 flex flex-col items-center justify-center text-center overflow-hidden">
      <!-- Gradient blob background -->
      <div class="absolute inset-0 -z-10 pointer-events-none">
        <div
          class="absolute top-0 left-1/2 -translate-x-1/2 w-150 h-100 bg-flamingo-500/10 rounded-full blur-3xl"></div>
        <div
          class="absolute top-12 left-1/4 w-75 h-62 bg-flamingo-400/8 rounded-full blur-2xl"></div>
      </div>

      <!-- Icon kiri atas -->
      <div
        class="absolute left-16 top-20 w-12 h-12 rounded-full bg-flamingo-500 flex items-center justify-center">
        <Icon name="hugeicons:fire" class="w-5 h-5 text-white" />
      </div>

      <!-- Icon kiri tengah -->
      <div
        class="absolute left-28 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full border border-line-faint bg-surface-canvas flex items-center justify-center">
        <Icon
          name="hugeicons:mortarboard-02"
          class="w-5 h-5 text-ink-muted-dark" />
      </div>

      <!-- Icon kiri bawah -->
      <div
        class="absolute left-10 bottom-20 w-12 h-12 rounded-full border border-line-faint bg-surface-canvas flex items-center justify-center">
        <Icon name="hugeicons:mail-02" class="w-5 h-5 text-ink-muted-dark" />
      </div>

      <!-- Icon kanan atas -->
      <div
        class="absolute right-16 top-20 w-12 h-12 rounded-full border border-line-faint bg-surface-canvas flex items-center justify-center">
        <Icon name="hugeicons:atom-02" class="w-5 h-5 text-ink-muted-dark" />
      </div>

      <!-- Icon kanan tengah -->
      <div
        class="absolute right-28 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-flamingo-500 flex items-center justify-center">
        <Icon name="hugeicons:conversation" class="w-5 h-5 text-white" />
      </div>

      <!-- Konten utama -->
      <div class="flex flex-col gap-5 bg-surface-canvas items-center text-center max-w-2xl">
        <div class="flex flex-col gap-3 items-center">
          <h1
            class="text-5xl font-black text-ink-base-dark leading-tight tracking-tight">
            Platform untuk mengelola sistem sekolah secara digital dan terpadu
          </h1>
          <p class="text-lg text-ink-muted-dark leading-relaxed max-w-lg">
            Dibuat dengan tujuan untuk digitalisasi sistem di era global.
          </p>
        </div>
        <div class="flex flex-row items-center gap-3 mt-1">
          <NuxtLink to="/autentikasi/login">
            <button
              class="font-medium py-1.5 px-6 tracking-tight rounded-sm cursor-pointer bg-flamingo-500 text-ink-base-light hover:bg-flamingo-600 transition-all duration-150 ease-in-out">
              Mulai Sekarang
            </button>
          </NuxtLink>
        </div>
      </div>
    </section>

    <!-- Fitur Visual -->
    <section class="w-full bg-flamingo-500">
      <div
        class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-white/20">
        <!-- Fitur 1: Layer stack -->
        <div class="flex flex-col gap-8 p-10">
          <svg
            viewBox="0 0 200 160"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            class="w-full max-w-52 mx-auto">
            <path
              d="M20 120 L100 145 L180 120 L100 95 Z"
              stroke="white"
              stroke-opacity="0.2"
              stroke-width="1"
              fill="white"
              fill-opacity="0.03" />
            <path
              d="M20 105 L100 130 L180 105 L100 80 Z"
              stroke="white"
              stroke-opacity="0.3"
              stroke-width="1"
              fill="white"
              fill-opacity="0.04" />
            <path
              d="M20 90 L100 115 L180 90 L100 65 Z"
              stroke="white"
              stroke-opacity="0.4"
              stroke-width="1"
              fill="white"
              fill-opacity="0.05" />
            <path
              d="M20 75 L100 100 L180 75 L100 50 Z"
              stroke="white"
              stroke-opacity="0.55"
              stroke-width="1"
              fill="white"
              fill-opacity="0.06" />
            <path
              d="M20 60 L100 85 L180 60 L100 35 Z"
              stroke="white"
              stroke-opacity="0.75"
              stroke-width="1.5"
              fill="white"
              fill-opacity="0.08" />
            <path
              d="M20 60 L20 75 L100 100 L100 85 Z"
              stroke="white"
              stroke-opacity="0.4"
              stroke-width="1"
              fill="white"
              fill-opacity="0.04" />
            <path
              d="M180 60 L180 75 L100 100 L100 85 Z"
              stroke="white"
              stroke-opacity="0.25"
              stroke-width="1"
              fill="white"
              fill-opacity="0.025" />
            <circle
              cx="100"
              cy="60"
              r="12"
              stroke="white"
              stroke-opacity="0.6"
              stroke-width="1.5"
              fill="white"
              fill-opacity="0.08" />
            <circle
              cx="100"
              cy="60"
              r="6"
              stroke="white"
              stroke-opacity="0.8"
              stroke-width="1"
              fill="white"
              fill-opacity="0.15" />
          </svg>
          <div class="flex flex-col gap-2">
            <span class="text-base font-semibold text-white">
              Presensi otomatis
            </span>
            <p class="text-sm text-white/65 leading-relaxed">
              Rekap kehadiran harian tersusun rapi berlapis — dari siswa, kelas,
              hingga laporan sekolah.
            </p>
          </div>
        </div>

        <!-- Fitur 2: Kubus di-stack -->
        <div class="flex flex-col gap-8 p-10">
          <svg
            viewBox="0 0 200 160"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            class="w-full max-w-52 mx-auto">
            <!-- Kubus bawah -->
            <path
              d="M55 105 L100 120 L145 105 L100 90 Z"
              stroke="white"
              stroke-opacity="0.7"
              stroke-width="1.5"
              fill="white"
              fill-opacity="0.07" />
            <path
              d="M55 105 L55 128 L100 143 L100 120 Z"
              stroke="white"
              stroke-opacity="0.45"
              stroke-width="1.5"
              fill="white"
              fill-opacity="0.04" />
            <path
              d="M145 105 L145 128 L100 143 L100 120 Z"
              stroke="white"
              stroke-opacity="0.25"
              stroke-width="1.5"
              fill="white"
              fill-opacity="0.025" />

            <!-- Kubus tengah -->
            <path
              d="M60 72 L100 85 L140 72 L100 59 Z"
              stroke="white"
              stroke-opacity="0.75"
              stroke-width="1.5"
              fill="white"
              fill-opacity="0.08" />
            <path
              d="M60 72 L60 93 L100 106 L100 85 Z"
              stroke="white"
              stroke-opacity="0.48"
              stroke-width="1.5"
              fill="white"
              fill-opacity="0.05" />
            <path
              d="M140 72 L140 93 L100 106 L100 85 Z"
              stroke="white"
              stroke-opacity="0.28"
              stroke-width="1.5"
              fill="white"
              fill-opacity="0.03" />

            <!-- Kubus atas -->
            <path
              d="M65 41 L100 53 L135 41 L100 29 Z"
              stroke="white"
              stroke-opacity="0.85"
              stroke-width="1.5"
              fill="white"
              fill-opacity="0.1" />
            <path
              d="M65 41 L65 60 L100 72 L100 53 Z"
              stroke="white"
              stroke-opacity="0.5"
              stroke-width="1.5"
              fill="white"
              fill-opacity="0.06" />
            <path
              d="M135 41 L135 60 L100 72 L100 53 Z"
              stroke="white"
              stroke-opacity="0.3"
              stroke-width="1.5"
              fill="white"
              fill-opacity="0.035" />
          </svg>
          <div class="flex flex-col gap-2">
            <span class="text-base font-semibold text-white">
              Sistem yang terintegrasi
            </span>
            <p class="text-sm text-white/65 leading-relaxed">
              Setiap fitur berdiri sendiri namun saling terhubung — akademi,
              ekskul, surat, dan konseling.
            </p>
          </div>
        </div>

        <!-- Fitur 3: Card ke belakang -->
        <div class="flex flex-col gap-8 p-10">
          <svg
            viewBox="0 0 200 160"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
            class="w-full max-w-52 mx-auto">
            <!-- Card paling belakang -->
            <rect
              x="65"
              y="18"
              width="100"
              height="72"
              rx="5"
              stroke="white"
              stroke-opacity="0.15"
              stroke-width="1"
              fill="white"
              fill-opacity="0.02" />
            <!-- Card belakang 4 -->
            <rect
              x="58"
              y="26"
              width="100"
              height="72"
              rx="5"
              stroke="white"
              stroke-opacity="0.22"
              stroke-width="1"
              fill="white"
              fill-opacity="0.03" />
            <!-- Card belakang 3 -->
            <rect
              x="51"
              y="34"
              width="100"
              height="72"
              rx="5"
              stroke="white"
              stroke-opacity="0.3"
              stroke-width="1"
              fill="white"
              fill-opacity="0.04" />
            <!-- Card belakang 2 -->
            <rect
              x="44"
              y="42"
              width="100"
              height="72"
              rx="5"
              stroke="white"
              stroke-opacity="0.42"
              stroke-width="1"
              fill="white"
              fill-opacity="0.05" />
            <!-- Card belakang 1 -->
            <rect
              x="37"
              y="50"
              width="100"
              height="72"
              rx="5"
              stroke="white"
              stroke-opacity="0.55"
              stroke-width="1.2"
              fill="white"
              fill-opacity="0.06" />
            <!-- Card depan -->
            <rect
              x="30"
              y="58"
              width="100"
              height="72"
              rx="5"
              stroke="white"
              stroke-opacity="0.8"
              stroke-width="1.5"
              fill="white"
              fill-opacity="0.09" />
            <!-- Isi card depan -->
            <line
              x1="42"
              y1="76"
              x2="100"
              y2="76"
              stroke="white"
              stroke-opacity="0.5"
              stroke-width="1.2"
              stroke-linecap="round" />
            <line
              x1="42"
              y1="88"
              x2="118"
              y2="88"
              stroke="white"
              stroke-opacity="0.3"
              stroke-width="1"
              stroke-linecap="round" />
            <line
              x1="42"
              y1="99"
              x2="110"
              y2="99"
              stroke="white"
              stroke-opacity="0.25"
              stroke-width="1"
              stroke-linecap="round" />
            <line
              x1="42"
              y1="110"
              x2="95"
              y2="110"
              stroke="white"
              stroke-opacity="0.2"
              stroke-width="1"
              stroke-linecap="round" />
          </svg>
          <div class="flex flex-col gap-2">
            <span class="text-base font-semibold text-white">
              Arsip terstruktur
            </span>
            <p class="text-sm text-white/65 leading-relaxed">
              Semua data tersimpan rapi dan mudah ditemukan — tidak ada yang
              tercecer atau hilang.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Fitur -->
    <section
      class="max-w-6xl w-full mx-auto px-6 py-20 flex flex-col bg-surface-canvas items-center">
      <div class="flex flex-col gap-3 mb-12 w-full items-center text-center">
        <h2 class="text-3xl font-medium text-ink-base-dark tracking-tight">
          Dirancang untuk keseharian sekolah.
        </h2>
        <p class="text-base text-ink-muted-dark max-w-lg">
          Satu platform, semua yang dibutuhkan dari manajemen presensi hingga
          konseling.
        </p>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full mb-4">
        <div
          class="flex flex-col justify-between gap-8 p-6 border border-line-faint rounded-sm group cursor-pointer hover:bg-canvas-hover transition-colors duration-150">
          <Icon name="hugeicons:fire" class="w-8 h-8 text-flamingo-500" />
          <div class="flex flex-col gap-1.5">
            <span class="text-base font-semibold text-ink-base-dark">
              Manajemen Absensi
            </span>
            <p class="text-sm text-ink-muted-dark leading-relaxed">
              Rekap kehadiran harian otomatis. Tanpa kertas, tanpa repot.
            </p>
          </div>
        </div>

        <div
          class="flex flex-col justify-between gap-8 p-6 border border-line-faint rounded-sm group cursor-pointer hover:bg-canvas-hover transition-colors duration-150">
          <Icon
            name="hugeicons:mortarboard-02"
            class="w-8 h-8 text-flamingo-500" />
          <div class="flex flex-col gap-1.5">
            <span class="text-base font-semibold text-ink-base-dark">
              Manajemen Akademi
            </span>
            <p class="text-sm text-ink-muted-dark leading-relaxed">
              Nilai, jadwal, dan kurikulum tersusun rapi dalam satu tampilan.
            </p>
          </div>
        </div>

        <div
          class="flex flex-col justify-between gap-8 p-6 border border-line-faint rounded-sm group cursor-pointer hover:bg-canvas-hover transition-colors duration-150">
          <Icon name="hugeicons:atom-02" class="w-8 h-8 text-flamingo-500" />
          <div class="flex flex-col gap-1.5">
            <span class="text-base font-semibold text-ink-base-dark">
              Manajemen Ekstrakurikuler
            </span>
            <p class="text-sm text-ink-muted-dark leading-relaxed">
              Jadwal ekskul tanpa tumpang tindih dan tanpa kebingungan.
            </p>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
        <div
          class="flex flex-col justify-between gap-8 p-6 border border-line-faint rounded-sm group cursor-pointer hover:bg-canvas-hover transition-colors duration-150">
          <Icon name="hugeicons:mail-02" class="w-8 h-8 text-flamingo-500" />
          <div class="flex flex-col gap-1.5">
            <span class="text-base font-semibold text-ink-base-dark">
              Manajemen Surat
            </span>
            <p class="text-sm text-ink-muted-dark leading-relaxed">
              Arsip surat masuk dan keluar yang terstruktur — mudah dicari,
              mudah dilacak.
            </p>
          </div>
        </div>

        <div
          class="flex flex-col justify-between gap-8 p-6 border border-line-faint rounded-sm group cursor-pointer hover:bg-canvas-hover transition-colors duration-150">
          <Icon
            name="hugeicons:conversation"
            class="w-8 h-8 text-flamingo-500" />
          <div class="flex flex-col gap-1.5">
            <span class="text-base font-semibold text-ink-base-dark">
              Bimbingan Konseling
            </span>
            <p class="text-sm text-ink-muted-dark leading-relaxed">
              Catatan sesi konseling yang privat dan terorganisir untuk setiap
              siswa.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA -->
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
