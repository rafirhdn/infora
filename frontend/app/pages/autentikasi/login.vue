<script setup lang="ts">
  // Layout halaman
  definePageMeta({
    layout: 'authentication'
  })

  // Mengubah icon mata
  const showPassword = ref(false)
</script>

<template>
  <div class="w-screen h-screen font-sans flex flex-row">
    <!-- Panel -->
    <div
      class="lg:flex w-1/2 bg-woodsmoke-950 flex-col justify-center items-start gap-10 px-40 py-20 hidden">
      <!-- Logo -->
      <div class="flex flex-row items-center gap-2">
        <Icon
          name="hugeicons:yoga-ball"
          class="text-ink-base-light w-10 h-10" />
        <span class="text-ink-base-light font-black tracking-tight text-3xl">
          Infora
        </span>
      </div>

      <!-- Tagline -->
      <div class="flex flex-col gap-2 text-left">
        <h1
          class="text-4xl font-medium text-ink-base-light leading-snug tracking-tight">
          Sistem manajemen untuk pengelolaan yang efisien
        </h1>
        <p class="text-ink-muted-light tracking-tight text-lg">
          Tersusun rapi, mudah digunakan.
        </p>
      </div>
    </div>

    <!-- Form -->
    <form
      class="w-full lg:w-1/2 bg-surface-canvas flex items-center justify-center">
      <div class="flex flex-col gap-6 w-full max-w-sm">
        <!-- Title -->
        <div class="flex flex-col gap-1.5 text-center">
          <span class="text-2xl tracking-tight font-medium text-ink-base-dark">
            Selamat Datang!
          </span>
          <span
            class="leading-snug text-base tracking-tight font-normal text-ink-muted-dark">
            Akses sistem manajemen dan lanjutkan aktivitas.
          </span>
        </div>

        <div class="flex flex-col gap-4">
          <!-- Input Box -->
          <div>
            <input
              class="w-full px-3.5 py-1.5 tracking-tight outline-none border-2 border-line-faint rounded-sm text-ink-base-dark placeholder:text-ink-muted-dark hover:bg-canvas-hover hover:border-woodsmoke-950 focus:border-flamingo-500 focus:bg-surface-canvas transition-all duration-150 ease-in"
              type="email"
              placeholder="Email" />
          </div>

          <!-- Input Box -->
          <div class="relative">
            <input
              class="w-full px-3.5 py-1.5 pr-10 tracking-tight outline-none border-2 border-line-faint rounded-sm text-base text-ink-base-dark placeholder:text-ink-muted-dark hover:bg-canvas-hover hover:border-woodsmoke-950 focus:border-flamingo-500 focus:bg-surface-canvas transition-all duration-150 ease-in"
              :type="showPassword ? 'text' : 'password'"
              placeholder="Kata Sandi" />
            <Icon
              :name="showPassword ? 'hugeicons:view' : 'hugeicons:view-off'"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-ink-muted-dark w-6 h-6 cursor-pointer"
              @click="showPassword = !showPassword" />
          </div>

          <!-- Button -->
          <div>
            <button
              class="w-full font-medium py-2 tracking-tight rounded-sm cursor-pointer bg-woodsmoke-950 text-ink-base-light hover:bg-flamingo-500 transition-all duration-150 ease-in"
              type="submit">
              Masuk
            </button>
          </div>
        </div>

        <!-- Link -->
        <div class="text-center tracking-tight">
          <span class="text-base font-normal text-ink-muted-dark">
            Lupa password anda?
            <NuxtLink
              class="font-medium text-ink-base-dark hover:underline underline-offset-2 transition-all duration-150 ease-in"
              to="/autentikasi/verifyEmail">
              Klik di sini
            </NuxtLink>
          </span>
        </div>

        <!-- Error -->
        <div>
          <div></div>
        </div>
      </div>
    </form>
  </div>
</template>
