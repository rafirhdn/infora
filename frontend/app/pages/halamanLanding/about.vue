<script setup lang="ts">
  definePageMeta({ layout: 'landing' })
</script>

<template>
  <div class="font-['DM_Sans',sans-serif]">
    <!-- Header dengan floating icons di dalam section -->
    <section
      class="relative max-w-6xl w-full mx-auto px-6 pt-28 pb-20 overflow-hidden">
      <!-- Floating icons (acak di sekeliling) -->
      <!-- Kiri atas -->
      <div
        class="absolute top-4 left-0 w-12 h-12 rounded-full bg-flamingo-500 flex items-center justify-center shadow-lg rotate-12">
        <Icon name="hugeicons:fire" class="w-5 h-5 text-white" />
      </div>
      <!-- Kiri tengah -->
      <div
        class="absolute top-1/3 left-2 w-10 h-10 rounded-full border border-line-faint bg-surface-canvas flex items-center justify-center shadow-sm">
        <Icon
          name="hugeicons:mortarboard-02"
          class="w-4 h-4 text-ink-muted-dark" />
      </div>
      <!-- Kiri bawah -->
      <div
        class="absolute bottom-8 left-6 w-11 h-11 rounded-full bg-flamingo-500/20 flex items-center justify-center -rotate-6">
        <Icon name="hugeicons:mail-02" class="w-4 h-4 text-flamingo-500" />
      </div>

      <!-- Kanan atas -->
      <div
        class="absolute top-2 right-0 w-12 h-12 rounded-full border border-line-faint bg-surface-canvas flex items-center justify-center shadow-sm">
        <Icon name="hugeicons:atom-02" class="w-5 h-5 text-ink-muted-dark" />
      </div>
      <!-- Kanan tengah -->
      <div
        class="absolute top-1/2 right-4 w-11 h-11 rounded-full bg-flamingo-500 flex items-center justify-center shadow-lg rotate-45">
        <Icon name="hugeicons:conversation" class="w-4 h-4 text-white" />
      </div>
      <!-- Kanan bawah -->
      <div
        class="absolute bottom-12 right-1 w-10 h-10 rounded-full border border-flamingo-500/40 bg-white/80 flex items-center justify-center">
        <Icon
          name="hugeicons:yoga-ball"
          class="w-3.5 h-3.5 text-flamingo-500" />
      </div>

      <!-- Ikon tambahan acak di pojok lain -->
      <div
        class="absolute top-16 left-20 w-8 h-8 rounded-full bg-flamingo-500/10 flex items-center justify-center">
        <Icon name="hugeicons:chart-01" class="w-3 h-3 text-flamingo-500" />
      </div>
      <div
        class="absolute bottom-20 right-16 w-9 h-9 rounded-full bg-flamingo-500/30 flex items-center justify-center">
        <Icon
          name="hugeicons:database-01"
          class="w-3.5 h-3.5 text-flamingo-500" />
      </div>

      <!-- Konten teks (tetap di kiri, tidak di tengah) -->
      <div class="flex flex-col gap-6 max-w-2xl mx-auto text-center">
        <div class="flex items-center gap-3 justify-center">
          <span class="w-8 h-px bg-flamingo-500" />
        </div>
        <h1
          class="text-5xl font-black text-ink-base-dark tracking-tight leading-[1.1]">
          Dibuat karena sekolah butuh lebih dari sekadar
          <em class="not-italic text-flamingo-500">spreadsheet.</em>
        </h1>
        <p
          class="text-base text-ink-muted-dark leading-relaxed max-w-lg mx-auto">
          Infora lahir dari kebutuhan nyata — pengelolaan sekolah yang masih
          manual, tersebar di banyak tempat, dan memakan waktu yang tidak perlu.
        </p>
      </div>
    </section>

    <!-- Divider visual -->
    <div class="max-w-6xl mx-auto px-6">
      <div
        class="h-px w-full bg-linear-to-r from-flamingo-500 via-flamingo-300 to-transparent" />
    </div>

    <!-- Grid konten utama -->
    <section class="max-w-6xl w-full mx-auto px-6 py-20">
      <div
        class="grid grid-cols-1 md:grid-cols-2 gap-px bg-line-faint border border-line-faint rounded-sm overflow-hidden">
        <!-- Masalah -->
        <div
          class="relative flex flex-col gap-5 p-10 bg-surface-canvas group hover:bg-canvas-hover transition-colors duration-200">
          <div
            class="absolute top-0 left-0 w-1 h-full bg-flamingo-500 opacity-0 group-hover:opacity-100 transition-opacity duration-200" />
          <div class="flex items-center gap-3">
            <div
              class="w-8 h-8 rounded-full border border-flamingo-500/30 flex items-center justify-center">
              <span class="text-xs font-black text-flamingo-500">01</span>
            </div>
            <span
              class="font-sans text-[16px] font-bold text-flamingo-500 tracking-widest uppercase">
              Masalah
            </span>
          </div>
          <h2
            class="text-xl font-bold text-ink-base-dark tracking-tight leading-snug">
            Terlalu banyak alat,
            <br />
            terlalu sedikit koordinasi.
          </h2>
          <p class="text-sm text-ink-muted-dark leading-relaxed">
            Data absensi di satu tempat, nilai di tempat lain, surat di folder
            berbeda — semuanya tidak terhubung. Guru dan staf menghabiskan waktu
            mencari data, bukan menggunakannya.
          </p>
        </div>

        <!-- Solusi -->
        <div
          class="relative flex flex-col gap-5 p-10 bg-surface-canvas group hover:bg-canvas-hover transition-colors duration-200">
          <div
            class="absolute top-0 left-0 w-1 h-full bg-flamingo-500 opacity-0 group-hover:opacity-100 transition-opacity duration-200" />
          <div class="flex items-center gap-3">
            <div
              class="w-8 h-8 rounded-full border border-flamingo-500/30 flex items-center justify-center">
              <span class="text-xs font-black text-flamingo-500">02</span>
            </div>
            <span
              class="font-sans text-[16px] font-bold text-flamingo-500 tracking-widest uppercase">
              Solusi
            </span>
          </div>
          <h2
            class="text-xl font-bold text-ink-base-dark tracking-tight leading-snug">
            Satu platform yang cukup
            <br />
            untuk semuanya.
          </h2>
          <p class="text-sm text-ink-muted-dark leading-relaxed">
            Infora menyatukan semua kebutuhan administrasi sekolah ke dalam satu
            sistem yang ringan, cepat, dan tidak memerlukan pelatihan panjang
            untuk digunakan.
          </p>
        </div>

        <!-- Prinsip -->
        <div
          class="relative flex flex-col gap-5 p-10 bg-surface-canvas group hover:bg-canvas-hover transition-colors duration-200">
          <div
            class="absolute top-0 left-0 w-1 h-full bg-flamingo-500 opacity-0 group-hover:opacity-100 transition-opacity duration-200" />
          <div class="flex items-center gap-3">
            <div
              class="w-8 h-8 rounded-full border border-flamingo-500/30 flex items-center justify-center">
              <span class="text-xs font-black text-flamingo-500">03</span>
            </div>
            <span
              class="font-sans text-[16px] font-bold text-flamingo-500 tracking-widest uppercase">
              Prinsip
            </span>
          </div>
          <h2
            class="text-xl font-bold text-ink-base-dark tracking-tight leading-snug">
            Sederhana bukan
            <br />
            berarti terbatas.
          </h2>
          <p class="text-sm text-ink-muted-dark leading-relaxed">
            Setiap fitur dipertimbangkan dengan cermat — kami tidak menambahkan
            sesuatu hanya karena bisa. Yang ada di Infora adalah yang
            benar-benar dibutuhkan, tidak lebih.
          </p>
        </div>

        <!-- Tujuan -->
        <div
          class="relative flex flex-col gap-5 p-10 bg-surface-canvas group hover:bg-canvas-hover transition-colors duration-200">
          <div
            class="absolute top-0 left-0 w-1 h-full bg-flamingo-500 opacity-0 group-hover:opacity-100 transition-opacity duration-200" />
          <div class="flex items-center gap-3">
            <div
              class="w-8 h-8 rounded-full border border-flamingo-500/30 flex items-center justify-center">
              <span class="text-xs font-black text-flamingo-500">04</span>
            </div>
            <span
              class="font-sans text-[16px] font-bold text-flamingo-500 tracking-widest uppercase">
              Tujuan
            </span>
          </div>
          <h2
            class="text-xl font-bold text-ink-base-dark tracking-tight leading-snug">
            Lebih banyak waktu
            <br />
            untuk hal yang penting.
          </h2>
          <p class="text-sm text-ink-muted-dark leading-relaxed">
            Ketika administrasi berjalan sendiri, guru bisa fokus mengajar,
            konselor bisa fokus mendampingi, dan staf bisa fokus melayani —
            bukan berkutat dengan dokumen.
          </p>
        </div>
      </div>
    </section>

    <!-- Statement besar (tanpa label filosofi) -->
    <section class="max-w-6xl mx-auto px-6 py-16">
      <div
        class="bg-flamingo-500 rounded-sm px-12 py-14 flex flex-col items-center justify-between gap-8">
        <p
          class="text-3xl text-center font-black text-white leading-tight max-w-md">
          "Ketika sistem bekerja dengan baik, manusianya bisa bekerja lebih
          baik."
        </p>
      </div>
    </section>

    <!-- CTA (sama persis dengan halaman home) -->
    <section class="w-full bg-surface-canvas">
      <div
        class="relative max-w-6xl w-full mx-auto px-6 py-24 flex flex-col items-center text-center overflow-hidden">
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
