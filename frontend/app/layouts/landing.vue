<template>
  <div class="min-h-screen font-sans bg-surface-canvas flex flex-col selection:bg-flamingo-400 selection:text-ink-base-light">
    <Navigation />

    <!-- Konten -->
    <main class="flex-1">
      <slot />
    </main>

    <Footer />
  </div>
</template>
