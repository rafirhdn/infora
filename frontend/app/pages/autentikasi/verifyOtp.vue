<script setup lang="ts">
  // Layout halaman
  definePageMeta({
    layout: 'authentication'
  })
</script>

<template>
  <form
    class="w-screen h-screen font-sans bg-surface-canvas flex items-center justify-center">
    <div class="flex flex-col gap-6 w-full max-w-sm">
      <!-- Title -->
      <div class="flex flex-col gap-1.5 text-center">
        <span class="text-2xl tracking-tight font-medium text-ink-base-dark">
          Verifikasi Alamat Email!
        </span>
        <span
          class="max-w-sm leading-snug tracking-tight text-base font-normal text-ink-muted-dark">
          Cantumkan kode OTP yang telah dikirimkan.
        </span>
      </div>

      <div class="flex flex-col gap-4">
        <!-- Input Box -->
        <div>
          <input
            class="w-full px-3.5 py-1.5 tracking-tight outline-none border-2 border-line-faint rounded-sm text-ink-base-dark placeholder:text-ink-muted-dark hover:bg-canvas-hover hover:border-woodsmoke-950 focus:border-flamingo-500 focus:bg-surface-canvas transition-all duration-150 ease-in"
            type="text"
            placeholder="Kode OTP" />
        </div>

        <!-- Button -->
        <div>
          <button
            class="w-full font-medium py-2 tracking-tight rounded-sm cursor-pointer bg-woodsmoke-950 text-ink-base-light hover:bg-flamingo-500 transition-all duration-150 ease-in"
            type="submit">
            Verifikasi
          </button>
        </div>
      </div>

      <!-- Error -->
      <div>
        <div></div>
      </div>
    </div>
  </form>
</template>
