<script setup lang="ts">
  // Layout
  definePageMeta({
    layout: 'authentication'
  })
</script>

<template>
  <form
    class="w-screen h-screen font-sans bg-canvas-bg flex items-center justify-center"
    @submit.prevent="">
    <div class="flex flex-col gap-6">
      <!-- Title -->
      <div class="flex flex-col text-center">
        <span class="text-2xl font-medium text-base-dark">
          Lupa kata sandi akun?
        </span>
        <span
          class="max-w-sm leading-snug text-base font-normal text-muted-dark">
          Cantumkan alamat email dan dapatkan kode OTP.
        </span>
      </div>

      <div class="flex flex-col gap-4">
        <!-- Input Box -->
        <div>
          <input
            class="w-sm px-3.5 py-1.5 outline-none border border-default-border cursor rounded-md text-base text-base-dark placeholder:text-muted-dark focus:ring-2 focus:ring-offset-2 focus:ring-flamingo-500 transition-all duration-150 ease-in"
            type="email"
            placeholder="Masukkan email" />
        </div>

        <!-- Button -->
        <div>
          <button
            class="w-full font-medium py-2 rounded-md cursor-pointer bg-flamingo-500 text-base-light hover:bg-flamingo-600 transition-colors duration-150 ease-in"
            type="submit">
            Kirim
          </button>
        </div>
      </div>

      <!-- Link -->
      <div class="text-center">
        <span class="text-base font-normal text-muted-dark">
          Ingat password anda?
          <NuxtLink
            class="font-medium text-base-dark hover:underline underline-offset-2 transition-all duration-150 ease-in"
            to="/autentikasi/login">
            Kembali
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
