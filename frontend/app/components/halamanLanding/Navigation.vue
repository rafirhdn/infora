<template>
  <div
    class="sticky top-0 z-50 mx-auto border-b border-line-faint w-full h-18 bg-surface-canvas flex flex-row items-center justify-between">
    <div
      class="flex flex-row items-center justify-between gap-4 max-w-6xl w-full mx-auto">
      <!-- Logo -->
      <div class="flex flex-row items-center gap-2 text-ink-base-dark">
        <Icon name="hugeicons:yoga-ball" class="w-8 h-8" />
        <span class="font-mono font-bold tracking-tight text-2xl">INFORA</span>
      </div>

      <!-- Links -->
      <div class="flex flex-row items-center justify-center gap-4">
        <NuxtLink
          to="/halamanLanding/home"
          class="flex items-center px-4 py-2 rounded-sm text-base text-ink-muted-dark hover:text-ink-base-dark hover:bg-canvas-hover transition-all duration-150 ease-in-out">
          Beranda
        </NuxtLink>

        <NuxtLink
          to="/halamanLanding/management"
          class="flex items-center px-4 py-2 rounded-sm text-base text-ink-muted-dark hover:text-ink-base-dark hover:bg-canvas-hover transition-all duration-150 ease-in-out">
          Sistem Manajemen
        </NuxtLink>

        <NuxtLink
          to="/halamanLanding/about"
          class="flex items-center px-4 py-2 rounded-sm text-base text-ink-muted-dark hover:text-ink-base-dark hover:bg-canvas-hover transition-all duration-150 ease-in-out">
          Tentang
        </NuxtLink>
      </div>

      <NuxtLink
        to="/autentikasi/login"
        class="font-medium py-2 px-6 tracking-tight rounded-sm cursor-pointer bg-flamingo-500 text-ink-base-light hover:bg-flamingo-600 transition-all duration-150 ease-in-out">
        Masuk
      </NuxtLink>
    </div>
  </div>
</template>
