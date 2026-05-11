<script setup lang="ts">
  // Layout
  definePageMeta({
    layout: 'authentication'
  })

  // Mengubah icon mata pada kata sandi
  const showPassword = ref(false)
</script>

<template>
  <form
    class="w-screen h-screen font-sans bg-canvas-bg flex items-center justify-center"
    @submit.prevent="">
    <div class="flex flex-col gap-6">
      <!-- Logo -->
      <div class="flex flex-col gap-1.5 text-center">
        <div>
          <Icon name="hugeicons:yoga-ball" class="text-base-dark w-12 h-12" />
        </div>
        <!-- Title -->
        <div class="flex flex-col">
          <span class="text-2xl font-medium text-base-dark">
            Selamat datang di Infora!
          </span>
          <span
            class="max-w-sm leading-snug text-base font-normal text-muted-dark">
            Akses sistem manajemen dan lanjutkan aktivitas.
          </span>
        </div>
      </div>

      <div class="flex flex-col gap-4">
        <!-- Input Box -->
        <div>
          <input
            class="w-sm px-3.5 py-1.5 outline-none border border-default-border cursor rounded-md text-base text-base-dark placeholder:text-muted-dark focus:ring-2 focus:ring-offset-2 focus:ring-flamingo-500 transition-all duration-150 ease-in"
            type="email"
            placeholder="Masukkan email" />
        </div>

        <!-- Input Box -->
        <div class="relative w-sm">
          <input
            class="w-full px-3.5 py-1.5 pr-10 outline-none border border-default-border rounded-md text-base text-base-dark placeholder:text-muted-dark focus:ring-2 focus:ring-offset-2 focus:ring-flamingo-500 transition-all duration-150 ease-in"
            :type="showPassword ? 'text' : 'password'"
            placeholder="Masukkan kata sandi" />
          <Icon
            :name="showPassword ? 'hugeicons:view' : 'hugeicons:view-off'"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-muted-dark w-6 h-6 cursor-pointer"
            @click="showPassword = !showPassword" />
        </div>

        <!-- Button -->
        <div>
          <button
            class="w-full font-medium py-2 rounded-md cursor-pointer bg-flamingo-500 text-base-light hover:bg-flamingo-600 transition-colors duration-150 ease-in"
            type="submit">
            Masuk
          </button>
        </div>
      </div>

      <!-- Link -->
      <div class="text-center">
        <span class="text-base font-normal text-muted-dark">
          Lupa password anda?
          <NuxtLink
            class="font-medium text-base-dark hover:underline underline-offset-2 transition-all duration-150 ease-in"
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
</template>
