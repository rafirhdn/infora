<script setup lang="ts">
  // Page layout
  definePageMeta({
    layout: 'authentication'
  })

  // Toggle icon
  const showPassword = ref(false)

  // Dropdown feature
  const isOpen = ref<boolean>(false)
  const wrapperRef = ref<HTMLElement | null>(null)

  function toggleDropdown(): void {
    isOpen.value = !isOpen.value
  }

  function closeDropdown(): void {
    isOpen.value = false
  }

  onMounted(() => {
    document.addEventListener('click', handleOutsideClick)
  })

  onUnmounted(() => {
    document.removeEventListener('click', handleOutsideClick)
  })

  function handleOutsideClick(e: MouseEvent): void {
    if (wrapperRef.value && !wrapperRef.value.contains(e.target as Node)) {
      closeDropdown()
    }
  }

  const selected = ref<{ value: string; label: string } | null>(null)

  function selectOption(option: { value: string; label: string }): void {
    selected.value = option
    closeDropdown()
  }

  const optionIcons: Record<string, string> = {
    absensi: 'hugeicons:fire',
    akademi: 'hugeicons:mortarboard-02',
    ekstrakurikuler: 'hugeicons:atom-02',
    surat: 'hugeicons:mail-02',
    'bimbingan-konseling': 'hugeicons:teacher'
  }
</script>

<template>
  <div class="w-screen h-screen font-sans flex flex-row">
    <!-- Panel -->
    <div
      class="lg:flex w-1/2 bg-woodsmoke-950 flex-col justify-center items-start gap-10 px-40 py-20 hidden">
      <!-- Logo -->
      <div class="flex flex-row items-center gap-2 text-ink-base-light">
        <Icon
          name="hugeicons:yoga-ball"
          class="w-8 h-8" />
        <span class="font-mono font-bold tracking-tight text-2xl">
          INFORA
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
              class="w-full px-3.5 py-1.5 tracking-tight outline-none border-2 border-line-faint rounded-sm text-ink-base-dark placeholder:text-ink-muted-dark hover:bg-canvas-hover hover:border-flamingo-500 focus:border-flamingo-500 focus:bg-surface-canvas transition-all duration-150 ease-in-out"
              type="email"
              placeholder="Email" />
          </div>

          <!-- Input Password -->
          <div class="relative">
            <input
              class="w-full px-3.5 py-1.5 pr-10 tracking-tight outline-none border-2 border-line-faint rounded-sm text-base text-ink-base-dark placeholder:text-ink-muted-dark hover:bg-canvas-hover hover:border-flamingo-500 focus:border-flamingo-500 focus:bg-surface-canvas transition-all duration-150 ease-in-out"
              :type="showPassword ? 'text' : 'password'"
              placeholder="Kata Sandi" />
            <Icon
              :name="showPassword ? 'hugeicons:view' : 'hugeicons:view-off'"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-ink-muted-dark w-6 h-6 cursor-pointer"
              @click="showPassword = !showPassword" />
          </div>

          <!-- Dropdown -->
          <div class="relative" ref="wrapperRef">
            <!-- Trigger -->
            <div
              @click="toggleDropdown"
              class="relative w-full px-3.5 py-1.5 pr-10 tracking-tight outline-none border-2 border-line-faint rounded-sm text-base text-ink-base-dark hover:bg-canvas-hover hover:border-flamingo-500 transition-all duration-150 ease-in-out cursor-pointer select-none"
              :class="isOpen ? 'border-flamingo-500 bg-surface-canvas' : ''">
              <div class="flex items-center gap-2.5">
                <Icon
                  v-if="selected"
                  :name="optionIcons[selected.value] ?? ''"
                  class="w-5 h-5 text-ink-base-dark" />
                <span
                  :class="
                    selected ? 'text-ink-base-dark' : 'text-ink-muted-dark'
                  "
                  class="text-base">
                  {{ selected?.label ?? 'Manajemen' }}
                </span>
              </div>
              <Icon
                name="hugeicons:arrow-down-01"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-ink-muted-dark w-6 h-6 transition-transform duration-200"
                :class="isOpen ? 'rotate-180' : ''" />
            </div>

            <!-- List -->
            <Transition
              enter-active-class="transition ease-out duration-150"
              enter-from-class="opacity-0 translate-y-1"
              enter-to-class="opacity-100 translate-y-0"
              leave-active-class="transition ease-in-out duration-100"
              leave-from-class="opacity-100 translate-y-0"
              leave-to-class="opacity-0 translate-y-1">
              <ul
                v-if="isOpen"
                class="absolute z-50 mt-1 w-full bg-surface-canvas border-2 border-line-faint rounded-sm overflow-hidden">
                <li
                  @click="
                    selectOption({
                      value: 'absensi',
                      label: 'Manajemen Absensi'
                    })
                  "
                  class="flex items-center gap-2.5 px-3.5 py-2 text-base cursor-pointer transition-colors duration-100 hover:bg-canvas-hover hover:text-ink-base-dark"
                  :class="
                    selected?.value === 'absensi'
                      ? 'bg-canvas-hover text-ink-base-dark'
                      : 'text-ink-muted-dark'
                  ">
                  <Icon name="hugeicons:fire" class="w-5 h-5" />
                  Manajemen Absensi
                </li>
                <li
                  @click="
                    selectOption({
                      value: 'akademi',
                      label: 'Manajemen Akademi'
                    })
                  "
                  class="flex items-center gap-2.5 px-3.5 py-2 text-base cursor-pointer transition-colors duration-100 hover:bg-canvas-hover hover:text-ink-base-dark"
                  :class="
                    selected?.value === 'akademi'
                      ? 'bg-canvas-hover text-ink-base-dark'
                      : 'text-ink-muted-dark'
                  ">
                  <Icon name="hugeicons:mortarboard-02" class="w-5 h-5" />
                  Manajemen Akademi
                </li>
                <li
                  @click="
                    selectOption({
                      value: 'ekstrakurikuler',
                      label: 'Manajemen Ekstrakurikuler'
                    })
                  "
                  class="flex items-center gap-2.5 px-3.5 py-2 text-base cursor-pointer transition-colors duration-100 hover:bg-canvas-hover hover:text-ink-base-dark"
                  :class="
                    selected?.value === 'ekstrakurikuler'
                      ? 'bg-canvas-hover text-ink-base-dark'
                      : 'text-ink-muted-dark'
                  ">
                  <Icon name="hugeicons:atom-02" class="w-5 h-5" />
                  Manajemen Ekstrakurikuler
                </li>
                <li
                  @click="
                    selectOption({ value: 'surat', label: 'Manajemen Surat' })
                  "
                  class="flex items-center gap-2.5 px-3.5 py-2 text-base cursor-pointer transition-colors duration-100 hover:bg-canvas-hover hover:text-ink-base-dark"
                  :class="
                    selected?.value === 'surat'
                      ? 'bg-canvas-hover text-ink-base-dark'
                      : 'text-ink-muted-dark'
                  ">
                  <Icon name="hugeicons:mail-02" class="w-5 h-5" />
                  Manajemen Surat
                </li>
                <li
                  @click="
                    selectOption({
                      value: 'bimbingan-konseling',
                      label: 'Manajemen Bimbingan Konseling'
                    })
                  "
                  class="flex items-center gap-2.5 px-3.5 py-2 text-base cursor-pointer transition-colors duration-100 hover:bg-canvas-hover hover:text-ink-base-dark"
                  :class="
                    selected?.value === 'bimbingan-konseling'
                      ? 'bg-canvas-hover text-ink-base-dark'
                      : 'text-ink-muted-dark'
                  ">
                  <Icon name="hugeicons:teacher" class="w-5 h-5" />
                  Manajemen Bimbingan Konseling
                </li>
              </ul>
            </Transition>
          </div>

          <!-- Button -->
          <div>
            <button
              class="w-full font-medium py-2 tracking-tight rounded-sm cursor-pointer bg-flamingo-500 text-ink-base-light hover:bg-flamingo-600 transition-all duration-150 ease-in-out"
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
              class="font-medium text-ink-base-dark hover:underline underline-offset-2 transition-all duration-150 ease-in-out"
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
