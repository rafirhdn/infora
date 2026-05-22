<script setup lang="ts">
  definePageMeta({ layout: 'landing' })
</script>

<template>
  <div>
    <!-- Header -->
    <section
      class="max-w-6xl w-full mx-auto px-6 pt-24 pb-16 flex flex-col items-center">
      <div class="flex flex-col gap-4 max-w-xl w-full">
        <span
          class="font-mono font-black text-xs text-flamingo-500 tracking-widest uppercase">
          Tentang
        </span>
        <h1
          class="text-4xl font-medium text-ink-base-dark tracking-tight leading-tight">
          Dibuat karena sekolah butuh lebih dari sekadar spreadsheet.
        </h1>
        <p class="text-base text-ink-muted-dark leading-relaxed">
          Infora lahir dari kebutuhan nyata — pengelolaan sekolah yang masih
          manual, tersebar di banyak tempat, dan memakan waktu yang tidak perlu.
        </p>
      </div>
    </section>

    <!-- Isi -->
    <section
      class="max-w-6xl w-full mx-auto px-6 py-16 flex flex-col items-center">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-16 w-full">
        <div class="flex flex-col gap-4">
          <span
            class="font-mono font-black text-xs text-flamingo-500 tracking-widest uppercase">
            Masalah
          </span>
          <h2 class="text-xl font-medium text-ink-base-dark tracking-tight">
            Terlalu banyak alat, terlalu sedikit koordinasi.
          </h2>
          <p class="text-sm text-ink-muted-dark leading-relaxed">
            Data absensi di satu tempat, nilai di tempat lain, surat di folder
            berbeda — semuanya tidak terhubung. Guru dan staf menghabiskan waktu
            mencari data, bukan menggunakannya.
          </p>
        </div>

        <div class="flex flex-col gap-4">
          <span
            class="font-mono font-black text-xs text-flamingo-500 tracking-widest uppercase">
            Solusi
          </span>
          <h2 class="text-xl font-medium text-ink-base-dark tracking-tight">
            Satu platform yang cukup untuk semuanya.
          </h2>
          <p class="text-sm text-ink-muted-dark leading-relaxed">
            Infora menyatukan semua kebutuhan administrasi sekolah ke dalam satu
            sistem yang ringan, cepat, dan tidak memerlukan pelatihan panjang
            untuk digunakan.
          </p>
        </div>

        <div class="flex flex-col gap-4">
          <span
            class="font-mono font-black text-xs text-flamingo-500 tracking-widest uppercase">
            Prinsip
          </span>
          <h2 class="text-xl font-medium text-ink-base-dark tracking-tight">
            Sederhana bukan berarti terbatas.
          </h2>
          <p class="text-sm text-ink-muted-dark leading-relaxed">
            Setiap fitur dipertimbangkan dengan cermat — kami tidak menambahkan
            sesuatu hanya karena bisa. Yang ada di Infora adalah yang
            benar-benar dibutuhkan, tidak lebih.
          </p>
        </div>

        <div class="flex flex-col gap-4">
          <span
            class="font-mono font-black text-xs text-flamingo-500 tracking-widest uppercase">
            Tujuan
          </span>
          <h2 class="text-xl font-medium text-ink-base-dark tracking-tight">
            Lebih banyak waktu untuk hal yang penting.
          </h2>
          <p class="text-sm text-ink-muted-dark leading-relaxed">
            Ketika administrasi berjalan sendiri, guru bisa fokus mengajar,
            konselor bisa fokus mendampingi, dan staf bisa fokus melayani —
            bukan berkutat dengan dokumen.
          </p>
        </div>
      </div>
    </section>

    <div class="max-w-6xl w-full mx-auto px-6">
      <div class="border-t border-line-faint" />
    </div>

    <!-- CTA -->
    <section
      class="max-w-6xl w-full mx-auto px-6 py-16 flex flex-col items-center">
      <div class="flex flex-col gap-4 max-w-md w-full">
        <h2 class="text-2xl font-medium text-ink-base-dark tracking-tight">
          Mulai hari ini.
        </h2>
        <p class="text-sm text-ink-muted-dark leading-relaxed">
          Tidak perlu migrasi data yang rumit. Cukup masuk dan mulai.
        </p>
        <div class="flex gap-3">
          <NuxtLink to="/autentikasi/login">
            <button
              class="px-5 py-2 text-sm font-medium rounded-sm bg-flamingo-500 text-ink-base-light hover:bg-flamingo-600 transition-all duration-150">
              Masuk ke Infora
            </button>
          </NuxtLink>
          <NuxtLink to="/halamanLanding/platform">
            <button
              class="px-5 py-2 text-sm font-medium rounded-sm border border-line-faint text-ink-muted-dark hover:bg-canvas-hover hover:text-ink-base-dark transition-all duration-150">
              Lihat platform
            </button>
          </NuxtLink>
        </div>
      </div>
    </section>
  </div>
</template>
