<script setup lang="ts">
  // Layout halaman
  definePageMeta({
    layout: 'authentication'
  })

  // Mengubah icon mata pada kata sandi baru
  const showNewPassword = ref(false)
  // Mengubah icon mata pada kata sandi ulang
  const showNewPasswordAgain = ref(false)
</script>

<template>
  <form
    class="w-screen h-screen font-sans bg-surface-canvas flex items-center justify-center">
    <div class="flex flex-col gap-6">
      <!-- Title -->
      <div class="flex flex-col text-center">
        <span class="text-2xl tracking-tight font-medium text-ink-base-dark">
          Perbarui Kata Sandi!
        </span>
        <span
          class="max-w-sm leading-snug tracking-tight text-base font-normal text-ink-muted-dark">
          Buat kata sandi baru yang mudah diingat.
        </span>
      </div>

      <div class="flex flex-col gap-4">
        <!-- Input Box -->
        <div class="relative w-sm">
          <input
            class="w-full px-3.5 py-1.5 tracking-tight outline-none border-2 border-line-faint rounded-sm text-ink-base-dark placeholder:text-ink-muted-dark hover:bg-canvas-hover hover:border-woodsmoke-950 focus:border-flamingo-500 focus:bg-surface-canvas transition-all duration-150 ease-in"
            :type="showNewPassword ? 'text' : 'password'"
            placeholder="Kata Sandi Baru" />
          <Icon
            :name="showNewPassword ? 'hugeicons:view' : 'hugeicons:view-off'"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-ink-muted-dark w-6 h-6 cursor-pointer"
            @click="showNewPassword = !showNewPassword" />
        </div>

        <!-- Input Box -->
        <div class="relative w-sm">
          <input
            class="w-full px-3.5 py-1.5 tracking-tight outline-none border-2 border-line-faint rounded-sm text-ink-base-dark placeholder:text-ink-muted-dark hover:bg-canvas-hover hover:border-woodsmoke-950 focus:border-flamingo-500 focus:bg-surface-canvas transition-all duration-150 ease-in"
            :type="showNewPasswordAgain ? 'text' : 'password'"
            placeholder="Kata Sandi Ulang" />
          <Icon
            :name="
              showNewPasswordAgain ? 'hugeicons:view' : 'hugeicons:view-off'
            "
            class="absolute right-3 top-1/2 -translate-y-1/2 text-ink-muted-dark w-6 h-6 cursor-pointer"
            @click="showNewPasswordAgain = !showNewPasswordAgain" />
        </div>

        <!-- Button -->
        <div>
          <button
            class="w-full font-medium py-2 tracking-tight rounded-sm cursor-pointer bg-woodsmoke-950 text-ink-base-light hover:bg-flamingo-500 transition-all duration-150 ease-in"
            type="submit">
            Perbarui
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
