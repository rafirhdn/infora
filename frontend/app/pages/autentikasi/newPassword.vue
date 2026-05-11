<script setup lang="ts">
  const showNewPassword = ref(false)
  const showNewPasswordAgain = ref(false)
</script>

<template>
  <form
    class="w-screen h-screen font-sans bg-canvas-bg flex items-center justify-center"
    @submit.prevent=""
  >
    <div class="flex flex-col gap-6">
      <!-- Title -->
      <div class="flex flex-col text-center">
        <span class="text-2xl font-medium text-base-dark"
          >Perbarui kata sandi akun!</span
        >
        <span
          class="max-w-sm leading-snug text-base font-normal text-muted-dark"
          >Cantumkan kata sandi baru yang mudah diingat.</span
        >
      </div>

      <div class="flex flex-col gap-4">
        <!-- Input Box -->
        <div class="relative w-sm">
          <input
            class="w-full px-3.5 py-1.5 pr-10 outline-none border border-default-border rounded-md text-base text-base-dark placeholder:text-muted-dark focus:ring-2 focus:ring-offset-2 focus:ring-flamingo-500 transition-all duration-150 ease-in"
            :type="showNewPassword ? 'text' : 'password'"
            placeholder="Masukkan kata sandi baru"
          />
          <Icon
            :name="showNewPassword ? 'hugeicons:view' : 'hugeicons:view-off'"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-muted-dark w-6 h-6 cursor-pointer"
            @click="showNewPassword = !showNewPassword"
          />
        </div>

        <!-- Input Box -->
        <div class="relative w-sm">
          <input
            class="w-full px-3.5 py-1.5 pr-10 outline-none border border-default-border rounded-md text-base text-base-dark placeholder:text-muted-dark focus:ring-2 focus:ringset-2 focus:ring-flamingo-500 transition-all duration-150 ease-in"
            :type="showNewPasswordAgain ? 'text' : 'password'"
            placeholder="Masukkan kata sandi ulang"
          />
          <Icon
            :name="showNewPasswordAgain ? 'hugeicons:view' : 'hugeicons:view-off'"
            class="absolute right-3 top-1/2 -translate-y-1/2 text-muted-dark w-6 h-6 cursor-pointer"
            @click="showNewPasswordAgain = !showNewPasswordAgain"
          />
        </div>

        <!-- Button -->
        <div>
          <button
            class="w-full font-medium py-2 rounded-md cursor-pointer bg-flamingo-500 text-base-light hover:bg-flamingo-600 transition-colors duration-150 ease-in"
            type="submit"
          >
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
