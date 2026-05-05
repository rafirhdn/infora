<!-- app/layouts/school.vue -->
<template>
  <div class="flex h-screen overflow-hidden" style="background: #f5f6fa; font-family: 'DM Sans', 'Inter', system-ui, sans-serif;">

    <!-- ==================== ICON SIDEBAR ==================== -->
    <aside class="w-16 bg-white border-r border-gray-100 flex flex-col items-center py-5 gap-1 flex-shrink-0 z-20 shadow-sm">

      <!-- ── BRANDING: Logo + Badge ── -->
      <div class="flex flex-col items-center gap-1.5 mb-5 flex-shrink-0">
        <!-- Shield logo -->
        <div
          class="w-10 h-10 rounded-xl flex flex-col items-center justify-center shadow-md relative overflow-hidden"
          style="background: linear-gradient(145deg, #f5762d 0%, #e05a15 100%);"
          title="SMK Negeri 71 Jakarta"
        >
          <!-- Gloss overlay -->
          <div class="absolute inset-0 rounded-xl" style="background: linear-gradient(160deg, rgba(255,255,255,0.18) 0%, transparent 60%);"></div>
          <span class="relative text-white font-black leading-none" style="font-size: 8px; letter-spacing: -0.3px;">SMK</span>
          <span class="relative text-white font-black leading-none" style="font-size: 13px; letter-spacing: -1px; margin-top: -1px;">71</span>
        </div>
        <!-- Year badge -->
        <div
          class="text-center font-bold rounded"
          style="font-size: 7px; color: #f5762d; background: #fff3ed; border: 1px solid #fde0cc; padding: 1px 5px; letter-spacing: 0.2px;"
        >
          JKT
        </div>
      </div>

      <!-- Main Nav -->
      <nav class="flex flex-col items-center gap-1.5 flex-1">
        <div
          v-for="menu in menus"
          :key="menu.key"
          class="relative group"
        >
          <button
            @click="navigate(menu.route)"
            :class="[
              'w-10 h-10 rounded-xl flex items-center justify-center transition-all duration-150',
              activeMenu === menu.key
                ? 'text-white shadow-md nav-active'
                : 'text-gray-400 hover:bg-orange-50 nav-inactive'
            ]"
          >
            <font-awesome-icon :icon="menu.icon" class="text-base" />
          </button>
          <!-- Tooltip -->
          <div class="sidebar-tooltip">
            <span>{{ menu.label }}</span>
            <div class="sidebar-tooltip-arrow"></div>
          </div>
        </div>
      </nav>

      <!-- Bottom Nav -->
      <div class="flex flex-col items-center gap-1.5">
        <div
          v-for="menu in bottomMenus"
          :key="menu.key"
          class="relative group"
        >
          <button
            @click="navigate(menu.route)"
            class="w-10 h-10 rounded-xl flex items-center justify-center text-gray-400 transition-all nav-inactive"
          >
            <font-awesome-icon :icon="menu.icon" class="text-base" />
          </button>
          <!-- Tooltip -->
          <div class="sidebar-tooltip">
            <span>{{ menu.label }}</span>
            <div class="sidebar-tooltip-arrow"></div>
          </div>
        </div>
        <!-- Avatar -->
        <div class="w-9 h-9 rounded-full flex items-center justify-center mt-2 cursor-pointer avatar-wrap" title="Administrator">
          <font-awesome-icon :icon="['fas', 'user']" class="text-xs" style="color: #f5762d;" />
        </div>
      </div>
    </aside>

    <!-- ==================== MAIN AREA ==================== -->
    <div class="flex-1 flex flex-col overflow-hidden">

      <!-- ==================== TOPBAR ==================== -->
      <header class="bg-white border-b border-gray-100 px-6 flex items-center justify-between flex-shrink-0 shadow-sm" style="height: 60px;">

        <!-- Left: School Identity + Tabs Slot -->
        <div class="flex items-center gap-4">

          <!-- ── BRANDING: School identity inline ── -->
          <div class="flex items-center gap-2.5 flex-shrink-0">
            <!-- Mini logo -->
            <div
              class="w-8 h-8 rounded-lg flex flex-col items-center justify-center flex-shrink-0 relative overflow-hidden"
              style="background: linear-gradient(145deg, #f5762d, #e05a15); box-shadow: 0 2px 6px rgba(245,118,45,0.30);"
            >
              <div class="absolute inset-0" style="background: linear-gradient(160deg, rgba(255,255,255,0.15) 0%, transparent 60%);"></div>
              <span class="relative text-white font-black leading-none" style="font-size: 6.5px; letter-spacing: -0.2px;">SMK</span>
              <span class="relative text-white font-black leading-none" style="font-size: 11px; letter-spacing: -0.8px; margin-top: -1px;">71</span>
            </div>
            <!-- Name block -->
            <div class="flex flex-col leading-tight">
              <span class="font-bold text-gray-900" style="font-size: 12px; letter-spacing: -0.2px;">SMK Negeri 71 Jakarta</span>
              <span class="font-semibold" style="font-size: 9.5px; color: #f5762d; letter-spacing: 0.2px;">● NPSN 20104888 &nbsp;·&nbsp; Akreditasi A</span>
            </div>
          </div>

          <!-- Divider -->
          <div class="w-px bg-gray-100" style="height: 28px;"></div>

          <!-- Tabs Slot -->
          <div class="flex items-center gap-1.5">
            <slot name="topbar-tabs" />
          </div>
        </div>

        <!-- Right Controls -->
        <div class="flex items-center gap-3">

          <!-- Search Slot -->
          <slot name="topbar-search">
            <div class="relative">
              <input
                type="text"
                placeholder="Cari siswa, guru, kelas..."
                class="pl-10 pr-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:border-orange-400 w-64 placeholder-gray-400 text-gray-700"
              />
              <font-awesome-icon :icon="['fas', 'search']" class="w-4 h-4 text-gray-400 absolute left-3.5 top-2.5" />
            </div>
          </slot>

          <!-- Notifications Slot -->
          <slot name="topbar-notifications">
            <button class="relative w-9 h-9 rounded-full bg-gray-50 border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-orange-50 transition-colors">
              <font-awesome-icon :icon="['far', 'bell']" class="w-4 h-4" />
              <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
            </button>
          </slot>

          <!-- Calendar Slot -->
          <slot name="topbar-calendar">
            <button class="w-9 h-9 rounded-full bg-gray-50 border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-orange-50 transition-colors">
              <font-awesome-icon :icon="['fas', 'calendar-alt']" class="w-4 h-4" />
            </button>
          </slot>

          <div class="w-px h-6 bg-gray-200"></div>

          <!-- User Slot -->
          <slot name="topbar-user">
            <div class="flex items-center gap-2.5 cursor-pointer">
              <div class="w-9 h-9 rounded-full flex items-center justify-center avatar-wrap">
                <font-awesome-icon :icon="['fas', 'user']" class="text-sm" style="color: #f5762d;" />
              </div>
              <div class="hidden md:block">
                <p class="text-sm font-semibold text-gray-800 leading-tight">Administrator</p>
                <p class="text-xs text-gray-400 leading-tight">admin@smkn71.sch.id</p>
              </div>
            </div>
          </slot>
        </div>
      </header>

      <!-- ==================== CONTENT ==================== -->
      <div class="flex-1 overflow-hidden flex">

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto p-6 min-w-0">
          <slot />
        </div>

        <!-- Right Panel Slot (optional) -->
        <slot name="right-panel" />

      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, watch, onMounted } from 'vue'
import { useRoute, useRouter } from '#app'

const route = useRoute()
const router = useRouter()

const menus = [
  { key: 'dashboard',          label: 'Dashboard',       icon: ['fas', 'house'],             route: '/' },
  { key: 'absensi',            label: 'Absensi',          icon: ['fas', 'fingerprint'],       route: '/manajemen-absensi' },
  { key: 'akademi',            label: 'Akademi',          icon: ['fas', 'graduation-cap'],    route: '/manajemen-akademi' },
  { key: 'ekstrakulikuler',    label: 'Ekstrakulikuler',  icon: ['fas', 'futbol'],            route: '/manajemen-ekstrakurikuler' },
  { key: 'surat',              label: 'Surat',            icon: ['fas', 'envelope'],          route: '/manajemen-surat' },
  { key: 'bimbingan-konseling',label: 'BK',               icon: ['fas', 'comments'],          route: '/manajemen-bimbingan-konseling' },
]

const bottomMenus = [
  { key: 'help',     label: 'Bantuan',    icon: ['fas', 'circle-question'], route: '/bantuan' },
  { key: 'settings', label: 'Pengaturan', icon: ['fas', 'cog'],             route: '/pengaturan' },
]

const activeMenu = ref('dashboard')

const updateActiveMenu = () => {
  const path = route.path
  const found = menus.find(m => m.route === path)
  if (found) activeMenu.value = found.key
}

const navigate = (routePath: string) => {
  router.push(routePath)
}

watch(() => route.path, () => {
  updateActiveMenu()
}, { immediate: true })

onMounted(() => {
  updateActiveMenu()
})
</script>

<style scoped>
* { box-sizing: border-box; }

/* Active nav item */
.nav-active  { background: #f5762d; }
.nav-inactive:hover { background: #fff3ed; color: #f5762d; }

/* Active tab (used by pages via topbar-tabs slot) */
.tab-active  { background: #f5762d; }

/* Avatar */
.avatar-wrap { background: #fff3ed; border: 2px solid #f5762d; }

/* Sidebar tooltip */
.sidebar-tooltip {
  position: absolute;
  left: calc(100% + 12px);
  top: 50%;
  transform: translateY(-50%) translateX(-4px);
  background: #f5762d;
  color: #ffffff;
  font-size: 11px;
  font-weight: 600;
  white-space: nowrap;
  padding: 5px 10px;
  border-radius: 8px;
  pointer-events: none;
  opacity: 0;
  transition: opacity 0.15s ease, transform 0.15s ease;
  box-shadow: 0 4px 12px rgba(245, 118, 45, 0.30);
  z-index: 50;
}
.group:hover .sidebar-tooltip {
  opacity: 1;
  transform: translateY(-50%) translateX(0px);
}
.sidebar-tooltip-arrow {
  position: absolute;
  right: 100%;
  top: 50%;
  transform: translateY(-50%);
  border: 5px solid transparent;
  border-right-color: #f5762d;
}
</style>