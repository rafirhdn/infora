<!-- pages/index.vue -->
<script setup lang="ts">
import { ref, computed } from 'vue'

definePageMeta({ layout: false }) // index uses its own full layout

const activeMenu = ref('dashboard')
const activeTab = ref('today')
const notifOpen = ref(false)

const stats = [
  { label: 'Total Siswa', value: '1.247', icon: ['fas', 'user-graduate'], change: '+3.2%', up: true },
  { label: 'Total Guru', value: '89', icon: ['fas', 'chalkboard-user'], change: '+1.1%', up: true },
  { label: 'Kelas Aktif', value: '36', icon: ['fas', 'school'], change: '0%', up: true },
  { label: 'Kehadiran Hari Ini', value: '94.3%', icon: ['fas', 'clipboard-list'], change: '-0.5%', up: false },
]

const announcements = [
  { title: 'Ujian Akhir Semester Ganjil', date: '15 Jan 2025', tag: 'Akademik', urgent: true },
  { title: 'Pembayaran SPP Bulan Januari', date: '10 Jan 2025', tag: 'Keuangan', urgent: false },
  { title: 'Ekstrakurikuler Paskibra Dibuka', date: '08 Jan 2025', tag: 'Kegiatan', urgent: false },
  { title: 'Rapat Wali Murid Semester II', date: '20 Jan 2025', tag: 'Umum', urgent: false },
]

const scheduleToday = [
  { time: '07.00', subject: 'Pemrograman Web', class: 'XII RPL 1', room: 'Lab. Komputer 1', teacher: 'Bpk. Hendra S.' },
  { time: '08.30', subject: 'Desain Grafis', class: 'XI DKV 2', room: 'Lab. DKV', teacher: 'Ibu Sari W.' },
  { time: '10.00', subject: 'Animasi 3D', class: 'XII Animasi 1', room: 'Lab. Animasi', teacher: 'Bpk. Dimas R.' },
  { time: '11.30', subject: 'Basis Data', class: 'X RPL 2', room: 'Lab. Komputer 2', teacher: 'Ibu Rina H.' },
  { time: '13.00', subject: 'Ilustrasi Digital', class: 'XI DKV 1', room: 'Lab. DKV', teacher: 'Bpk. Agus P.' },
]

const menus = [
  { key: 'dashboard', label: 'Dashboard', icon: ['fas', 'house'], route: '/' },
  { key: 'absensi', label: 'Absensi', icon: ['fas', 'fingerprint'], route: '/manajemen-absensi' },
  { key: 'akademi', label: 'Akademi', icon: ['fas', 'graduation-cap'], route: '/manajemen-akademi' },
  { key: 'ekstrakulikuler', label: 'Ekstrakulikuler', icon: ['fas', 'futbol'], route: '/manajemen-ekstrakurikuler' },
  { key: 'surat', label: 'Surat', icon: ['fas', 'envelope'], route: '/manajemen-surat' },
  { key: 'bimbingan-konseling', label: 'BK', icon: ['fas', 'comments'], route: '/manajemen-bimbingan-konseling' },
]

const bottomMenus = [
  { key: 'help', label: 'Bantuan', icon: ['fas', 'circle-question'], route: '/bantuan' },
  { key: 'settings', label: 'Pengaturan', icon: ['fas', 'cog'], route: '/pengaturan' },
]

const quickAccess = [
  { icon: ['fas', 'fingerprint'], label: 'Input Absensi', route: '/manajemen-absensi' },
  { icon: ['fas', 'graduation-cap'], label: 'Akademi', route: '/manajemen-akademi' },
  { icon: ['fas', 'futbol'], label: 'Ekstrakulikuler', route: '/manajemen-ekstrakurikuler' },
  { icon: ['fas', 'envelope'], label: 'Buat Surat', route: '/manajemen-surat' },
  { icon: ['fas', 'comments'], label: 'BK', route: '/manajemen-bimbingan-konseling' },
  { icon: ['fas', 'cog'], label: 'Pengaturan', route: '/pengaturan' },
]

const recentActivity = [
  { icon: ['fas', 'pen-fancy'], text: 'Nilai UTS XII IPA 1 diperbarui', time: '5 mnt lalu', color: 'bg-blue-100', iconColor: 'text-blue-600' },
  { icon: ['fas', 'user-plus'], text: 'Siswa baru terdaftar: Budi Santoso', time: '20 mnt lalu', color: 'bg-green-100', iconColor: 'text-green-600' },
  { icon: ['fas', 'wallet'], text: 'SPP Desember lunas: 45 siswa', time: '1 jam lalu', color: 'act-orange', iconColor: 'act-icon-orange' },
  { icon: ['fas', 'trophy'], text: 'Juara 1 OSN Matematika Provinsi', time: '3 jam lalu', color: 'bg-red-100', iconColor: 'text-red-600' },
]

const tagColors: Record<string, string> = {
  'Akademik': 'bg-blue-100 text-blue-700',
  'Keuangan': 'bg-green-100 text-green-700',
  'Kegiatan': 'bg-purple-100 text-purple-700',
  'Umum': 'bg-gray-100 text-gray-600',
}

const attendanceWeekly = [
  { label: 'Sen', pct: 96 },
  { label: 'Sel', pct: 94 },
  { label: 'Rab', pct: 97 },
  { label: 'Kam', pct: 91 },
  { label: 'Jum', pct: 94 },
]

const latenessPerDay = [
  { day: 'Senin',  count: 18, pct: 72, color: 'bg-red-400' },
  { day: 'Selasa', count: 12, pct: 48, color: 'bg-orange-400' },
  { day: 'Rabu',   count: 9,  pct: 36, color: 'bg-yellow-400' },
  { day: 'Kamis',  count: 21, pct: 84, color: 'bg-red-500' },
  { day: 'Jumat',  count: 6,  pct: 24, color: 'bg-emerald-400' },
]

const kelasList = [
  'X RPL 1', 'X RPL 2',
  'XI RPL 1', 'XI RPL 2',
  'XII RPL 1', 'XII RPL 2',
  'X DKV 1', 'X DKV 2',
  'XI DKV 1', 'XI DKV 2',
  'XII DKV 1', 'XII DKV 2',
  'X Animasi 1', 'X Animasi 2',
  'XI Animasi 1', 'XI Animasi 2',
  'XII Animasi 1', 'XII Animasi 2',
]

const tabs = [
  { key: 'today', label: 'Hari Ini' },
  { key: 'week', label: 'Minggu Ini' },
  { key: 'month', label: 'Bulan Ini' },
  { key: 'reports', label: 'Laporan' },
]

const today = computed(() =>
  new Date().toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })
)

function navigate(menu: typeof menus[0]) {
  activeMenu.value = menu.key
  navigateTo(menu.route)
}

function quickNavigate(route: string) {
  navigateTo(route)
}
</script>

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
            @click="navigate(menu)"
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
            @click="quickNavigate(menu.route)"
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

        <!-- Left: School Identity + Tabs -->
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

          <!-- Tabs -->
          <div class="flex items-center gap-1.5">
            <button
              v-for="tab in tabs"
              :key="tab.key"
              @click="activeTab = tab.key"
              :class="[
                'px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-150',
                activeTab === tab.key
                  ? 'text-white shadow-sm tab-active'
                  : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700'
              ]"
            >{{ tab.label }}</button>
          </div>
        </div>

        <!-- Right Controls -->
        <div class="flex items-center gap-3">
          <div class="relative">
            <input
              type="text"
              placeholder="Cari siswa, guru, kelas..."
              class="pl-10 pr-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-full focus:outline-none focus:border-orange-400 w-64 placeholder-gray-400 text-gray-700"
            />
            <font-awesome-icon :icon="['fas', 'search']" class="w-4 h-4 text-gray-400 absolute left-3.5 top-2.5" />
          </div>

          <button
            @click="notifOpen = !notifOpen"
            class="relative w-9 h-9 rounded-full bg-gray-50 border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-orange-50 transition-colors"
          >
            <font-awesome-icon :icon="['far', 'bell']" class="w-4 h-4" />
            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
          </button>

          <button class="w-9 h-9 rounded-full bg-gray-50 border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-orange-50 transition-colors">
            <font-awesome-icon :icon="['fas', 'calendar-alt']" class="w-4 h-4" />
          </button>

          <div class="w-px h-6 bg-gray-200"></div>

          <div class="flex items-center gap-2.5 cursor-pointer">
            <div class="w-9 h-9 rounded-full flex items-center justify-center avatar-wrap">
              <font-awesome-icon :icon="['fas', 'user']" class="text-sm" style="color: #f5762d;" />
            </div>
            <div class="hidden md:block">
              <p class="text-sm font-semibold text-gray-800 leading-tight">Administrator</p>
              <p class="text-xs text-gray-400 leading-tight">admin@smkn71.sch.id</p>
            </div>
          </div>
        </div>
      </header>

      <!-- ==================== CONTENT ==================== -->
      <div class="flex-1 overflow-hidden flex">

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto p-6 space-y-5 min-w-0">

          <!-- Page Title -->
          <div class="flex items-end justify-between">
            <div>
              <p class="text-xs text-gray-400 font-medium uppercase tracking-widest mb-1">Selamat datang kembali</p>
              <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Dashboard Sekolah</h1>
            </div>
            <div class="flex items-center gap-2 text-white px-4 py-2 rounded-xl text-sm font-semibold shadow-sm" style="background: #f5762d;">
              <font-awesome-icon :icon="['fas', 'calendar-alt']" class="text-sm" />
              <span>Sem. Ganjil 2024/2025</span>
            </div>
          </div>

          <!-- Stats Cards -->
          <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">
            <div
              v-for="stat in stats"
              :key="stat.label"
              class="bg-white rounded-2xl p-5 shadow-sm hover:shadow-md transition-all cursor-default border border-gray-100"
            >
              <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background: #fff3ed; border: 1px solid #fde0cc;">
                  <font-awesome-icon :icon="stat.icon" class="text-base" style="color: #f5762d;" />
                </div>
                <span :class="[stat.up ? 'text-emerald-600 bg-emerald-50' : 'text-red-500 bg-red-50', 'text-xs font-bold px-2 py-0.5 rounded-full']">
                  {{ stat.change }}
                </span>
              </div>
              <p class="text-2xl font-bold text-gray-900 tracking-tight">{{ stat.value }}</p>
              <p class="text-xs text-gray-400 mt-0.5 font-medium">{{ stat.label }}</p>
            </div>
          </div>

          <!-- ── BRANDING: Identity Banner ── -->
          <div class="identity-banner rounded-2xl overflow-hidden relative" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);">
            <!-- Decorative circles -->
            <div class="identity-banner-circle-1"></div>
            <div class="identity-banner-circle-2"></div>
            <!-- Content -->
            <div class="relative z-10 flex items-center justify-between px-6 py-4">
              <!-- Left: Logo + Text -->
              <div class="flex items-center gap-4">
                <!-- Banner logo -->
                <div
                  class="w-12 h-12 rounded-xl flex flex-col items-center justify-content-center relative overflow-hidden flex-shrink-0"
                  style="background: linear-gradient(145deg, #f5762d, #e05a15); box-shadow: 0 3px 14px rgba(245,118,45,0.45); display: flex; flex-direction: column; align-items: center; justify-content: center;"
                >
                  <div class="absolute inset-0" style="background: linear-gradient(160deg, rgba(255,255,255,0.18) 0%, transparent 60%);"></div>
                  <span class="relative text-white font-black leading-none" style="font-size: 9px; letter-spacing: -0.3px;">SMK</span>
                  <span class="relative text-white font-black leading-none" style="font-size: 15px; letter-spacing: -1px; margin-top: -1px;">71</span>
                </div>
                <!-- Text block -->
                <div class="flex flex-col gap-0.5">
                  <span class="font-bold text-white leading-tight" style="font-size: 13.5px; letter-spacing: -0.2px;">
                    SMK Negeri 71 Jakarta
                  </span>
                  <span style="font-size: 10px; color: rgba(255,255,255,0.45); font-weight: 500; letter-spacing: 0.2px;">
                    Jl. Pendidikan Raya, Jakarta Selatan
                  </span>
                  <span class="font-semibold italic" style="font-size: 10px; color: #f5762d; margin-top: 2px;">
                    "Unggul dalam Prestasi, Santun dalam Budi Pekerti"
                  </span>
                </div>
              </div>

              <!-- Right: Stats + Accreditation -->
              <div class="flex items-center gap-5">
                <!-- Tahun Ajaran -->
                <div class="text-center">
                  <div class="font-black leading-tight" style="font-size: 16px; color: #f5762d; letter-spacing: -0.5px;">T.A.</div>
                  <div style="font-size: 9px; color: rgba(255,255,255,0.4); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px;">2024 / 2025</div>
                </div>
                <div style="width: 1px; height: 32px; background: rgba(255,255,255,0.1);"></div>
                <!-- Kompetensi -->
                <div class="text-center">
                  <div class="font-black leading-tight" style="font-size: 22px; color: #f5762d; letter-spacing: -1px;">3</div>
                  <div style="font-size: 9px; color: rgba(255,255,255,0.4); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px;">Komp. Keahlian</div>
                </div>
                <div style="width: 1px; height: 32px; background: rgba(255,255,255,0.1);"></div>
                <!-- Accreditation badge -->
                <div
                  class="flex flex-col items-center gap-0.5 rounded-xl px-4 py-2"
                  style="background: rgba(245,118,45,0.15); border: 1px solid rgba(245,118,45,0.35);"
                >
                  <span class="font-black" style="font-size: 22px; color: #f5762d; line-height: 1; letter-spacing: -1px;">A</span>
                  <span style="font-size: 8.5px; color: rgba(255,255,255,0.45); font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Akreditasi</span>
                </div>
              </div>
            </div>
          </div>

          <!-- Jadwal + Kehadiran -->
          <div class="grid grid-cols-1 xl:grid-cols-5 gap-4">

            <!-- Jadwal Hari Ini -->
            <div class="xl:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
              <div class="flex items-center justify-between px-5 py-4 border-b border-gray-50">
                <div>
                  <h2 class="text-sm font-bold text-gray-900">Jadwal Hari Ini</h2>
                  <p class="text-xs text-gray-400">{{ today }}</p>
                </div>
                <button class="text-xs font-semibold hover:underline flex items-center gap-1" style="color: #f5762d;">
                  Lihat Semua ...
                </button>
              </div>
              <div class="divide-y divide-gray-50">
                <div
                  v-for="(item, i) in scheduleToday"
                  :key="i"
                  class="flex items-center gap-4 px-5 py-3 transition-colors schedule-row"
                >
                  <div class="text-xs font-bold w-11 flex-shrink-0 tabular-nums" style="color: #f5762d;">{{ item.time }}</div>
                  <div class="w-0.5 h-8 rounded-full flex-shrink-0" style="background: #ffd0b3;"></div>
                  <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-800 truncate">{{ item.subject }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ item.teacher }}</p>
                  </div>
                  <div class="flex flex-col items-end gap-1 flex-shrink-0">
                    <span class="text-xs font-semibold px-2 py-0.5 rounded-lg" style="background: #fff3ed; color: #f5762d; border: 1px solid #fde0cc;">
                      {{ item.class }}
                    </span>
                    <span class="text-xs text-gray-400">{{ item.room }}</span>
                  </div>
                </div>
              </div>
            </div>

            <!-- Kehadiran Mingguan -->
            <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
              <div class="flex items-center justify-between mb-4">
                <div>
                  <h2 class="text-sm font-bold text-gray-900">Kehadiran Mingguan</h2>
                  <p class="text-xs text-gray-400">Rata-rata per hari</p>
                </div>
                <select class="text-xs border border-gray-200 bg-gray-50 rounded-lg px-2 py-1.5 text-gray-600 focus:outline-none cursor-pointer">
                  <option>Semua Kelas</option>
                  <optgroup label="RPL">
                    <option v-for="k in kelasList.filter(k => k.includes('RPL'))" :key="k">{{ k }}</option>
                  </optgroup>
                  <optgroup label="DKV">
                    <option v-for="k in kelasList.filter(k => k.includes('DKV'))" :key="k">{{ k }}</option>
                  </optgroup>
                  <optgroup label="Animasi">
                    <option v-for="k in kelasList.filter(k => k.includes('Animasi'))" :key="k">{{ k }}</option>
                  </optgroup>
                </select>
              </div>
              <div class="flex items-end gap-2 h-28 mb-3">
                <div
                  v-for="(day, i) in attendanceWeekly"
                  :key="i"
                  class="flex-1 flex flex-col items-center gap-1"
                >
                  <span class="text-xs font-bold" style="color: #f5762d;">{{ day.pct }}%</span>
                  <div class="w-full bg-gray-100 rounded-lg overflow-hidden" style="height: 80px; display:flex; flex-direction:column; justify-content:flex-end;">
                    <div
                      class="w-full rounded-lg transition-all duration-700"
                      style="background: #f5762d;"
                      :style="{ height: Math.round(day.pct / 100 * 80) + 'px', background: '#f5762d' }"
                    ></div>
                  </div>
                  <span class="text-xs text-gray-400">{{ day.label }}</span>
                </div>
              </div>
              <div class="flex items-center justify-between pt-3 border-t border-gray-50">
                <div class="flex items-center gap-3">
                  <div class="flex items-center gap-1.5">
                    <div class="w-2.5 h-2.5 rounded-sm" style="background: #f5762d;"></div>
                    <span class="text-xs text-gray-500">Hadir</span>
                  </div>
                  <div class="flex items-center gap-1.5">
                    <div class="w-2.5 h-2.5 rounded-sm bg-gray-100"></div>
                    <span class="text-xs text-gray-500">Absen</span>
                  </div>
                </div>
                <span class="text-xs text-gray-400">Rata: <span class="font-bold" style="color: #f5762d;">94.4%</span></span>
              </div>
            </div>
          </div>

          <!-- Rekap Keterlambatan + Akses Cepat -->
          <div class="grid grid-cols-1 xl:grid-cols-5 gap-4">

            <!-- Rekap Keterlambatan Kehadiran -->
            <div class="xl:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
              <div class="flex items-center justify-between mb-5">
                <div>
                  <h2 class="text-sm font-bold text-gray-900">Rekap Keterlambatan Kehadiran</h2>
                  <p class="text-xs text-gray-400">Jumlah siswa terlambat per hari minggu ini</p>
                </div>
                <div class="flex items-center gap-2">
                  <select class="text-xs border border-gray-200 bg-gray-50 rounded-lg px-2 py-1.5 text-gray-600 focus:outline-none cursor-pointer">
                    <option>Semua Kelas</option>
                    <optgroup label="RPL">
                      <option v-for="k in kelasList.filter(k => k.includes('RPL'))" :key="k">{{ k }}</option>
                    </optgroup>
                    <optgroup label="DKV">
                      <option v-for="k in kelasList.filter(k => k.includes('DKV'))" :key="k">{{ k }}</option>
                    </optgroup>
                    <optgroup label="Animasi">
                      <option v-for="k in kelasList.filter(k => k.includes('Animasi'))" :key="k">{{ k }}</option>
                    </optgroup>
                  </select>
                  <button class="w-8 h-8 rounded-lg border border-gray-200 bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-orange-50 transition-colors">
                    <font-awesome-icon :icon="['fas', 'sliders']" class="text-xs" />
                  </button>
                </div>
              </div>

              <div class="space-y-4">
                <div v-for="(item, i) in latenessPerDay" :key="i">
                  <div class="flex items-center justify-between mb-1.5">
                    <span class="text-xs font-semibold text-gray-700 w-14">{{ item.day }}</span>
                    <div class="flex-1 mx-3 bg-gray-100 rounded-full h-2.5 overflow-hidden">
                      <div
                        :class="item.color"
                        class="h-2.5 rounded-full transition-all duration-700"
                        :style="{ width: item.pct + '%' }"
                      ></div>
                    </div>
                    <div class="flex items-center gap-1.5 w-20 justify-end">
                      <span class="text-xs font-bold text-gray-800">{{ item.count }}</span>
                      <span class="text-xs text-gray-400">siswa</span>
                      <span class="text-xs font-medium px-1.5 py-0.5 rounded-md" :class="item.pct >= 60 ? 'bg-red-50 text-red-500' : item.pct >= 40 ? 'bg-orange-50 text-orange-500' : 'bg-emerald-50 text-emerald-600'">
                        {{ item.pct }}%
                      </span>
                    </div>
                  </div>
                </div>
              </div>

              <div class="flex items-center justify-between mt-5 pt-4 border-t border-gray-50">
                <div class="flex items-center gap-4">
                  <div class="flex items-center gap-1.5">
                    <div class="w-2.5 h-2.5 rounded-sm bg-red-400"></div>
                    <span class="text-xs text-gray-500">Tinggi (&gt;60%)</span>
                  </div>
                  <div class="flex items-center gap-1.5">
                    <div class="w-2.5 h-2.5 rounded-sm bg-yellow-400"></div>
                    <span class="text-xs text-gray-500">Sedang (40–60%)</span>
                  </div>
                  <div class="flex items-center gap-1.5">
                    <div class="w-2.5 h-2.5 rounded-sm bg-emerald-400"></div>
                    <span class="text-xs text-gray-500">Rendah (&lt;40%)</span>
                  </div>
                </div>
                <span class="text-xs text-gray-400">Total: <span class="font-bold" style="color: #f5762d;">{{ latenessPerDay.reduce((a, b) => a + b.count, 0) }} siswa</span></span>
              </div>
            </div>

            <!-- Akses Cepat -->
            <div class="xl:col-span-2 rounded-2xl p-5 shadow-sm" style="background: #f5762d;">
              <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold text-white">
                  <font-awesome-icon :icon="['fas', 'bolt']" class="mr-2 text-white/80" />
                  Akses Cepat
                </h2>
                <span class="text-xs" style="color: rgba(255,255,255,0.6);">
                  <font-awesome-icon :icon="['fas', 'fire']" class="mr-1" />
                  Populer
                </span>
              </div>
              <div class="grid grid-cols-3 gap-2">
                <button
                  v-for="item in quickAccess"
                  :key="item.label"
                  @click="quickNavigate(item.route)"
                  class="flex flex-col items-center gap-2 rounded-xl py-3.5 px-2 transition-all duration-150 quick-btn"
                >
                  <font-awesome-icon :icon="item.icon" class="text-white text-lg" />
                  <span class="text-white text-xs font-medium leading-tight text-center">{{ item.label }}</span>
                </button>
              </div>
            </div>
          </div>

        </div>

        <!-- ==================== RIGHT PANEL ==================== -->
        <div class="w-72 xl:w-80 bg-white border-l border-gray-100 flex-shrink-0 overflow-y-auto p-5 space-y-5">

          <!-- Pengumuman -->
          <div>
            <div class="flex items-center justify-between mb-3">
              <h2 class="text-sm font-bold text-gray-900">
                <font-awesome-icon :icon="['fas', 'bullhorn']" class="mr-2" style="color: #f5762d;" />
                Pengumuman
              </h2>
              <button class="text-xs font-semibold hover:underline" style="color: #f5762d;">
                Semua ...
              </button>
            </div>
            <div class="space-y-2.5">
              <div
                v-for="(ann, i) in announcements"
                :key="i"
                class="p-3.5 rounded-xl border border-gray-100 bg-gray-50 cursor-pointer ann-card transition-colors"
              >
                <div class="flex items-start gap-2 mb-2">
                  <font-awesome-icon
                    v-if="ann.urgent"
                    :icon="['fas', 'exclamation-circle']"
                    class="text-red-400 text-xs mt-0.5 flex-shrink-0"
                  />
                  <p class="text-xs font-semibold text-gray-800 leading-snug">{{ ann.title }}</p>
                </div>
                <div class="flex items-center gap-2">
                  <span :class="[tagColors[ann.tag], 'text-xs font-medium px-2 py-0.5 rounded-md']">{{ ann.tag }}</span>
                  <span class="text-xs text-gray-400">{{ ann.date }}</span>
                </div>
              </div>
            </div>
          </div>

          <div class="border-t border-gray-100"></div>

          <!-- Aktivitas Terkini -->
          <div>
            <div class="flex items-center justify-between mb-3">
              <h2 class="text-sm font-bold text-gray-900">
                <font-awesome-icon :icon="['fas', 'history']" class="mr-2" style="color: #f5762d;" />
                Aktivitas Terkini
              </h2>
            </div>
            <div class="space-y-3">
              <div
                v-for="(act, i) in recentActivity"
                :key="i"
                class="flex items-start gap-3"
              >
                <div
                  :class="[act.color !== 'act-orange' ? act.color : '', 'w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0']"
                  :style="act.color === 'act-orange' ? { background: '#fff3ed' } : {}"
                >
                  <font-awesome-icon
                    :icon="act.icon"
                    :class="act.iconColor !== 'act-icon-orange' ? act.iconColor : ''"
                    :style="act.iconColor === 'act-icon-orange' ? { color: '#f5762d' } : {}"
                    class="text-sm"
                  />
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-xs font-medium text-gray-700 leading-snug">{{ act.text }}</p>
                  <p class="text-xs text-gray-400 mt-0.5">
                    <font-awesome-icon :icon="['far', 'clock']" class="text-xs mr-1" />
                    {{ act.time }}
                  </p>
                </div>
                <button class="text-xs font-semibold mt-1 hover:underline whitespace-nowrap" style="color: #f5762d;">
                  Lihat →
                </button>
              </div>
            </div>
          </div>

          <div class="border-t border-gray-100"></div>

          <!-- ── BRANDING: Footer badge ── -->
          <div class="flex justify-center pb-1">
            <div
              class="flex items-center gap-2 rounded-xl px-3 py-2"
              style="background: #fff3ed; border: 1px solid #fde0cc;"
            >
              <!-- Mini logo -->
              <div
                class="w-6 h-6 rounded-md flex flex-col items-center justify-center flex-shrink-0 relative overflow-hidden"
                style="background: linear-gradient(145deg, #f5762d, #e05a15);"
              >
                <span class="relative text-white font-black leading-none" style="font-size: 5px; letter-spacing: -0.2px;">SMK</span>
                <span class="relative text-white font-black leading-none" style="font-size: 9px; letter-spacing: -0.5px; margin-top: -1px;">71</span>
              </div>
              <div class="flex flex-col leading-tight">
                <span class="font-bold" style="font-size: 9.5px; color: #f5762d;">SMKN 71 Jakarta</span>
                <span style="font-size: 8.5px; color: #c4c4c4;">SIS v2.4.1 · 2024/2025</span>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
* { box-sizing: border-box; }
.tabular-nums { font-variant-numeric: tabular-nums; }

/* Active nav item */
.nav-active  { background: #f5762d; }
.nav-inactive:hover { background: #fff3ed; color: #f5762d; }

/* Active tab */
.tab-active  { background: #f5762d; }

/* Schedule row hover */
.schedule-row:hover { background: #fff8f4; }

/* Quick access buttons */
.quick-btn { background: rgba(255,255,255,0.18); border: 1px solid rgba(255,255,255,0.28); }
.quick-btn:hover { background: rgba(255,255,255,0.30); }
.quick-btn:active { background: rgba(255,255,255,0.10); }

/* Announcement card hover */
.ann-card:hover { background: #fff8f4; border-color: #fde0cc; }

/* Avatar */
.avatar-wrap { background: #fff3ed; border: 2px solid #f5762d; }

/* ── Identity Banner decorative circles ── */
.identity-banner {
  position: relative;
}
.identity-banner-circle-1 {
  position: absolute;
  top: -24px;
  right: 80px;
  width: 140px;
  height: 140px;
  background: rgba(245, 118, 45, 0.07);
  border-radius: 50%;
  pointer-events: none;
}
.identity-banner-circle-2 {
  position: absolute;
  bottom: -36px;
  right: -12px;
  width: 110px;
  height: 110px;
  background: rgba(245, 118, 45, 0.05);
  border-radius: 50%;
  pointer-events: none;
}

/* Sidebar tooltip */
.sidebar-tooltip {
  position: absolute;
  left: calc(100% + 12px);
  top: 50%;
  transform: translateY(-50%);
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
  transform: translateY(-50%) translateX(-4px);
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