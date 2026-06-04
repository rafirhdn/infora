<script setup lang="ts">
  import { ref, computed, onMounted, onUnmounted } from 'vue'
  import { useRouter } from 'nuxt/app'

  const router = useRouter()
  const dropdownOpen = ref(false)
  const dropdownRef = ref<HTMLElement | null>(null)

  const isLoggedIn = ref(false)
  const userRole = ref<string | null>(null)
  const userSubRole = ref<string | null>(null)

  onMounted(() => {
    const token = localStorage.getItem('access_token')
    const userStr = localStorage.getItem('user')
    if (token && userStr) {
      try {
        const user = JSON.parse(userStr)
        isLoggedIn.value = true
        userRole.value = user.peran
        if (user.peran === 'wakil_kepala_sekolah' && user.email) {
          const email = user.email as string
          if (email.includes('kurikulum')) userSubRole.value = 'kurikulum'
          else if (email.includes('prasarana')) userSubRole.value = 'prasarana'
          else if (email.includes('kesiswaan')) userSubRole.value = 'kesiswaan'
        }
      } catch (e) {
        console.error(e)
      }
    }
    document.addEventListener('click', handleClickOutside)
  })

  onUnmounted(() => {
    document.removeEventListener('click', handleClickOutside)
  })

  const getFolderByRole = (
    sistem: string,
    role: string,
    subRole?: string | null
  ): string | null => {
    const mapping: Record<string, Record<string, string>> = {
      manajemenAbsensi: {
        tata_usaha: 'tataUsaha',
        wali_kelas: 'waliKelas'
      },
      manajemenAkademi: {
        tata_usaha: 'tataUsaha',
        guru: 'guru',
        siswa: 'murid',
        orang_tua: 'orangTua'
      },
      manajemenEkstrakurikuler: {
        tata_usaha: 'tataUsaha',
        siswa: 'siswa'
      },
      manajemenSurat: {
        tata_usaha: 'tataUsaha',
        kepala_sekolah: 'kepalaSekolah',
        siswa: 'murid',
        wakil_kepala_sekolah: 'wakilKepalaSekolah'
      },
      manajemenBimbinganKonseling: {
        tata_usaha: 'tataUsaha',
        guru_bk: 'guruBimbinganKonseling',
        siswa: 'murid'
      }
    }

    if (
      sistem === 'manajemenAkademi' &&
      role === 'wakil_kepala_sekolah' &&
      subRole === 'kurikulum'
    ) {
      return 'wakilKepalaKurikulum'
    }

    return mapping[sistem]?.[role] || null
  }

  const systemDefinitions = [
    {
      category: 'Sistem Absensi',
      baseFolder: 'manajemenAbsensi',
      icon: 'hugeicons:fire',
      allowedRoles: ['tata_usaha', 'wali_kelas']
    },
    {
      category: 'Sistem Akademi',
      baseFolder: 'manajemenAkademi',
      icon: 'hugeicons:mortarboard-02',
      allowedRoles: [
        'tata_usaha',
        'guru',
        'siswa',
        'orang_tua',
        'wakil_kepala_sekolah'
      ]
    },
    {
      category: 'Sistem Ekstrakurikuler',
      baseFolder: 'manajemenEkstrakurikuler',
      icon: 'hugeicons:atom-02',
      allowedRoles: ['tata_usaha', 'siswa']
    },
    {
      category: 'Sistem Surat',
      baseFolder: 'manajemenSurat',
      icon: 'hugeicons:mail-02',
      allowedRoles: [
        'tata_usaha',
        'kepala_sekolah',
        'siswa',
        'wakil_kepala_sekolah'
      ]
    },
    {
      category: 'Sistem Bimbingan Konseling',
      baseFolder: 'manajemenBimbinganKonseling',
      icon: 'hugeicons:conversation',
      allowedRoles: ['tata_usaha', 'guru', 'siswa']
    }
  ]

  const accessibleSystems = computed(() => {
    const role = userRole.value
    const subRole = userSubRole.value
    if (!role) return {}

    const result: Record<
      string,
      Array<{ name: string; path: string; icon: string }>
    > = {}

    for (const sys of systemDefinitions) {
      let allowed = sys.allowedRoles.includes(role)
      if (
        !allowed &&
        role === 'wakil_kepala_sekolah' &&
        subRole === 'kurikulum' &&
        sys.category === 'Sistem Akademi'
      ) {
        allowed = true
      }
      if (allowed) {
        const folder = getFolderByRole(sys.baseFolder, role, subRole)
        if (folder) {
          const path = `/${sys.baseFolder}/${folder}/dashboard`
          const name = sys.category.replace('Sistem ', '')
          if (!result[sys.category]) {
            result[sys.category] = []
          }
          result[sys.category]!.push({ name, path, icon: sys.icon })
        }
      }
    }
    return result
  })

  const toggleDropdown = () => {
    dropdownOpen.value = !dropdownOpen.value
  }

  const handleLogout = () => {
    localStorage.removeItem('access_token')
    localStorage.removeItem('token_type')
    localStorage.removeItem('user')
    isLoggedIn.value = false
    userRole.value = null
    userSubRole.value = null
    dropdownOpen.value = false
    router.push('/autentikasi/login')
  }

  const handleClickOutside = (event: MouseEvent) => {
    if (
      dropdownRef.value &&
      !dropdownRef.value.contains(event.target as Node)
    ) {
      dropdownOpen.value = false
    }
  }
</script>

<template>
  <div
    class="sticky top-0 z-50 mx-auto w-full h-18 bg-surface-canvas flex flex-row items-center justify-between">
    <div
      class="flex flex-row items-center justify-between gap-4 max-w-6xl w-full mx-auto">

      <!-- Logo -->
      <div class="flex flex-row items-center gap-2 text-ink-base-dark">
        <Icon name="hugeicons:yoga-ball" class="w-8 h-8" />
        <span class="font-bold tracking-tight text-2xl">Infora</span>
      </div>

      <!-- Navigation -->
      <div class="flex flex-row items-center justify-center gap-4">
        <div class="flex flex-row items-center justify-center gap-2">
          <NuxtLink
            to="/halamanLanding/home"
            class="flex font-medium items-center px-4 py-1.5 rounded-sm text-base text-ink-muted-dark hover:text-ink-base-dark hover:bg-subtle-hover transition-all duration-150 ease-in-out">
            Beranda
          </NuxtLink>
          <NuxtLink
            to="/halamanLanding/management"
            class="flex font-medium items-center px-4 py-1.5 rounded-sm text-base text-ink-muted-dark hover:text-ink-base-dark hover:bg-subtle-hover transition-all duration-150 ease-in-out">
            Manajemen
          </NuxtLink>
          <NuxtLink
            to="/halamanLanding/about"
            class="flex font-medium items-center px-4 py-1.5 rounded-sm text-base text-ink-muted-dark hover:text-ink-base-dark hover:bg-subtle-hover transition-all duration-150 ease-in-out">
            Tentang
          </NuxtLink>
        </div>

        <div class="w-px h-8 bg-line-slate"></div>

        <!-- Belum login -->
        <NuxtLink
          v-if="!isLoggedIn"
          to="/autentikasi/login"
          class="font-medium py-1.5 px-6 tracking-tight rounded-sm cursor-pointer bg-flamingo-500 text-ink-base-light hover:bg-flamingo-600 transition-all duration-150 ease-in-out">
          Masuk
        </NuxtLink>

        <!-- Sudah login -->
        <div v-else class="relative" ref="dropdownRef">
          <button
            @click="toggleDropdown"
            class="flex font-medium items-center gap-1 px-4 py-1.5 rounded-sm text-base text-ink-muted-dark hover:text-ink-base-dark hover:bg-subtle-hover cursor-pointer transition-all duration-150 ease-in-out">
            Buka Manajemen
            <Icon
              :name="
                dropdownOpen
                  ? 'hugeicons:arrow-up-01'
                  : 'hugeicons:arrow-down-01'
              "
              class="w-4 h-4" />
          </button>

          <!-- Dropdown menu -->
          <div
            v-if="dropdownOpen"
            class="absolute right-0 mt-2 w-60 bg-white rounded-lg border border-line-faint shadow-md z-10 py-1 px-1 overflow-hidden">
            <template
              v-for="(items, category) in accessibleSystems"
              :key="category">
              <NuxtLink
                v-for="item in items"
                :key="item.path"
                :to="item.path"
                @click="dropdownOpen = false"
                class="flex rounded-lg items-center gap-3 px-5 py-2.5 cursor-pointer hover:bg-canvas-hover transition-all duration-150 ease-in-out group">
                <div
                  class="w-8 h-8 rounded-sm bg-flamingo-50 flex items-center justify-center shrink-0 group-hover:bg-flamingo-100 transition-all duration-150">
                  <Icon
                    :name="item.icon"
                    class="w-5 h-5 text-flamingo-500" />
                </div>
                <span class="text-sm font-medium text-ink-base-dark">
                  {{ item.name }}
                </span>
              </NuxtLink>
            </template>

            <div class="border-t border-line-faint mt-1 pt-1">
              <button
                @click="handleLogout"
                class="w-full rounded-lg flex items-center gap-3 px-5 py-2.5 cursor-pointer hover:bg-red-50 transition-all duration-150 ease-in-out group">
                <div
                  class="w-8 h-8 rounded-sm bg-red-50 flex items-center justify-center shrink-0 group-hover:bg-red-100 transition-all duration-150">
                  <Icon
                    name="hugeicons:logout-03"
                    class="w-5 h-5 text-red-500" />
                </div>
                <span class="text-sm font-medium text-red-600">Keluar</span>
              </button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</template>
