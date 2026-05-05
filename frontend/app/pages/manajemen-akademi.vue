<!-- pages/manajemen-akademi.vue -->
<script setup lang="ts">
definePageMeta({ layout: 'school' })

import { ref, computed } from 'vue'

// ── Tabs ──────────────────────────────────────────────────────────
const activeTab = ref('nilai')
const tabs = [
  { key: 'nilai',     label: 'Nilai & Rapor',    icon: ['fas', 'star-half-stroke'] },
  { key: 'jadwal',    label: 'Jadwal Pelajaran',  icon: ['fas', 'calendar-week'] },
  { key: 'mapel',     label: 'Mata Pelajaran',    icon: ['fas', 'book-open'] },
  { key: 'guru',      label: 'Data Guru',         icon: ['fas', 'chalkboard-user'] },
  { key: 'kelas',     label: 'Data Kelas',        icon: ['fas', 'school'] },
]

// ── Stats ──────────────────────────────────────────────────────────
const stats = [
  { label: 'Mata Pelajaran',  value: '42',    icon: ['fas', 'book-open'],          sub: '6 jurusan aktif',    color: '#f5762d' },
  { label: 'Total Guru',      value: '89',    icon: ['fas', 'chalkboard-user'],    sub: '12 wali kelas',      color: '#3b82f6' },
  { label: 'Total Kelas',     value: '36',    icon: ['fas', 'school'],             sub: '3 tingkat · 12/kelas', color: '#10b981' },
  { label: 'Avg Nilai Siswa', value: '78.4',  icon: ['fas', 'chart-line'],         sub: '+2.1 dari sem. lalu', color: '#8b5cf6' },
]

// ── Filter Nilai ──────────────────────────────────────────────────
const filterKelas  = ref('XII RPL 1')
const filterMapel  = ref('Semua')
const filterSemester = ref('Ganjil 2024/2025')
const searchSiswa  = ref('')
const showFormNilai = ref(false)

const kelasList = [
  'X RPL 1','X RPL 2','XI RPL 1','XI RPL 2','XII RPL 1','XII RPL 2',
  'X DKV 1','X DKV 2','XI DKV 1','XI DKV 2','XII DKV 1','XII DKV 2',
  'X Animasi 1','X Animasi 2','XI Animasi 1','XI Animasi 2','XII Animasi 1','XII Animasi 2',
]

const mapelList = ['Semua','Pemrograman Web','Basis Data','Desain Grafis','Animasi 3D','Matematika','Bahasa Indonesia','Bahasa Inggris','PKK','Informatika']

const nilaiData = ref([
  { no:1,  nis:'0067',  nama:'Andi Pratama',        uts:82, uas:85, tugas:88, praktik:90, rata:86.3, predikat:'A', hadir:95 },
  { no:2,  nis:'0068',  nama:'Bella Safitri',        uts:75, uas:78, tugas:80, praktik:82, rata:78.8, predikat:'B+', hadir:98 },
  { no:3,  nis:'0069',  nama:'Candra Wijaya',         uts:90, uas:92, tugas:95, praktik:93, rata:92.5, predikat:'A+', hadir:100 },
  { no:4,  nis:'0070',  nama:'Dewi Anggraini',        uts:68, uas:72, tugas:70, praktik:74, rata:71.0, predikat:'B-', hadir:88 },
  { no:5,  nis:'0071',  nama:'Eko Firmansyah',        uts:55, uas:60, tugas:65, praktik:62, rata:60.5, predikat:'C', hadir:79 },
  { no:6,  nis:'0072',  nama:'Fitria Handayani',      uts:88, uas:86, tugas:90, praktik:89, rata:88.3, predikat:'A', hadir:97 },
  { no:7,  nis:'0073',  nama:'Galih Santoso',          uts:72, uas:74, tugas:76, praktik:78, rata:75.0, predikat:'B', hadir:92 },
  { no:8,  nis:'0074',  nama:'Hana Puspita',           uts:84, uas:88, tugas:87, praktik:91, rata:87.5, predikat:'A', hadir:96 },
  { no:9,  nis:'0075',  nama:'Ilham Maulana',          uts:61, uas:65, tugas:68, praktik:66, rata:65.0, predikat:'C+', hadir:83 },
  { no:10, nis:'0076',  nama:'Jihan Aulia',            uts:93, uas:95, tugas:97, praktik:96, rata:95.3, predikat:'A+', hadir:100 },
])

const filteredNilai = computed(() => {
  if (!searchSiswa.value) return nilaiData.value
  return nilaiData.value.filter(s =>
    s.nama.toLowerCase().includes(searchSiswa.value.toLowerCase()) ||
    s.nis.includes(searchSiswa.value)
  )
})

function predikatColor(p: string) {
  if (p.startsWith('A')) return 'bg-emerald-100 text-emerald-700'
  if (p.startsWith('B')) return 'bg-blue-100 text-blue-700'
  if (p.startsWith('C')) return 'bg-yellow-100 text-yellow-700'
  return 'bg-red-100 text-red-600'
}

function rataColor(r: number) {
  if (r >= 85) return 'text-emerald-600 font-bold'
  if (r >= 70) return 'text-blue-600 font-semibold'
  if (r >= 60) return 'text-yellow-600 font-semibold'
  return 'text-red-500 font-semibold'
}

// ── Jadwal ─────────────────────────────────────────────────────────
const jadwalKelas = ref('XII RPL 1')
const jamList = ['07.00','08.30','10.00','11.30','13.00','14.30']
const hariList = ['Senin','Selasa','Rabu','Kamis','Jumat']

const jadwalGrid: Record<string, Record<string, { mapel: string; guru: string; ruang: string } | null>> = {
  '07.00': {
    'Senin':   { mapel: 'Pemrograman Web',  guru: 'Hendra S.',  ruang: 'Lab. K1' },
    'Selasa':  { mapel: 'Basis Data',        guru: 'Rina H.',    ruang: 'Lab. K2' },
    'Rabu':    { mapel: 'Matematika',         guru: 'Budi W.',    ruang: 'R. 301' },
    'Kamis':   { mapel: 'Bahasa Inggris',     guru: 'Sari M.',    ruang: 'R. 302' },
    'Jumat':   { mapel: 'PKK',               guru: 'Agus P.',    ruang: 'R. 303' },
  },
  '08.30': {
    'Senin':   { mapel: 'Basis Data',        guru: 'Rina H.',    ruang: 'Lab. K2' },
    'Selasa':  { mapel: 'Pemrograman Web',   guru: 'Hendra S.',  ruang: 'Lab. K1' },
    'Rabu':    { mapel: 'Bahasa Indonesia',   guru: 'Dewi A.',    ruang: 'R. 201' },
    'Kamis':   { mapel: 'Matematika',         guru: 'Budi W.',    ruang: 'R. 301' },
    'Jumat':   null,
  },
  '10.00': {
    'Senin':   { mapel: 'Matematika',         guru: 'Budi W.',    ruang: 'R. 301' },
    'Selasa':  null,
    'Rabu':    { mapel: 'Pemrograman Web',   guru: 'Hendra S.',  ruang: 'Lab. K1' },
    'Kamis':   { mapel: 'PKK',               guru: 'Agus P.',    ruang: 'R. 303' },
    'Jumat':   { mapel: 'Basis Data',        guru: 'Rina H.',    ruang: 'Lab. K2' },
  },
  '11.30': {
    'Senin':   null,
    'Selasa':  { mapel: 'Bahasa Indonesia',   guru: 'Dewi A.',    ruang: 'R. 201' },
    'Rabu':    { mapel: 'Bahasa Inggris',     guru: 'Sari M.',    ruang: 'R. 302' },
    'Kamis':   { mapel: 'Pemrograman Web',   guru: 'Hendra S.',  ruang: 'Lab. K1' },
    'Jumat':   { mapel: 'Matematika',         guru: 'Budi W.',    ruang: 'R. 301' },
  },
  '13.00': {
    'Senin':   { mapel: 'Bahasa Inggris',     guru: 'Sari M.',    ruang: 'R. 302' },
    'Selasa':  { mapel: 'PKK',               guru: 'Agus P.',    ruang: 'R. 303' },
    'Rabu':    null,
    'Kamis':   { mapel: 'Basis Data',        guru: 'Rina H.',    ruang: 'Lab. K2' },
    'Jumat':   null,
  },
  '14.30': {
    'Senin':   { mapel: 'PKK',               guru: 'Agus P.',    ruang: 'R. 303' },
    'Selasa':  { mapel: 'Bahasa Inggris',     guru: 'Sari M.',    ruang: 'R. 302' },
    'Rabu':    { mapel: 'Basis Data',        guru: 'Rina H.',    ruang: 'Lab. K2' },
    'Kamis':   null,
    'Jumat':   null,
  },
}

const mapelColors: Record<string, string> = {
  'Pemrograman Web':  'bg-orange-50 border-orange-200 text-orange-700',
  'Basis Data':        'bg-blue-50 border-blue-200 text-blue-700',
  'Matematika':         'bg-purple-50 border-purple-200 text-purple-700',
  'Bahasa Inggris':     'bg-green-50 border-green-200 text-green-700',
  'Bahasa Indonesia':   'bg-cyan-50 border-cyan-200 text-cyan-700',
  'PKK':               'bg-rose-50 border-rose-200 text-rose-700',
}

function jadwalColor(mapel: string) {
  return mapelColors[mapel] || 'bg-gray-50 border-gray-200 text-gray-600'
}

// ── Mata Pelajaran ──────────────────────────────────────────────────
const mapelData = [
  { kode:'RPL-001', nama:'Pemrograman Web',     jurusan:'RPL',     jam:6, guru:'Hendra S.',  kelas:6, kkm:75 },
  { kode:'RPL-002', nama:'Basis Data',           jurusan:'RPL',     jam:4, guru:'Rina H.',    kelas:6, kkm:75 },
  { kode:'RPL-003', nama:'Pemrograman Mobile',   jurusan:'RPL',     jam:6, guru:'Dimas R.',   kelas:4, kkm:75 },
  { kode:'DKV-001', nama:'Desain Grafis',         jurusan:'DKV',     jam:6, guru:'Sari W.',    kelas:6, kkm:75 },
  { kode:'DKV-002', nama:'Ilustrasi Digital',     jurusan:'DKV',     jam:4, guru:'Agus P.',    kelas:6, kkm:75 },
  { kode:'ANM-001', nama:'Animasi 3D',            jurusan:'Animasi', jam:6, guru:'Dimas R.',   kelas:6, kkm:75 },
  { kode:'ANM-002', nama:'Storyboard',            jurusan:'Animasi', jam:4, guru:'Budi W.',    kelas:4, kkm:75 },
  { kode:'UMM-001', nama:'Matematika',            jurusan:'Umum',    jam:4, guru:'Budi W.',    kelas:18, kkm:70 },
  { kode:'UMM-002', nama:'Bahasa Indonesia',      jurusan:'Umum',    jam:3, guru:'Dewi A.',    kelas:18, kkm:70 },
  { kode:'UMM-003', nama:'Bahasa Inggris',        jurusan:'Umum',    jam:3, guru:'Sari M.',    kelas:18, kkm:70 },
]

const jurusanColors: Record<string, string> = {
  'RPL':     'bg-orange-100 text-orange-700',
  'DKV':     'bg-blue-100 text-blue-700',
  'Animasi': 'bg-purple-100 text-purple-700',
  'Umum':    'bg-gray-100 text-gray-600',
}

// ── Data Guru ──────────────────────────────────────────────────────
const guruData = [
  { nip:'1987001', nama:'Hendra Saputra',   mapel:'Pemrograman Web',   status:'PNS',    kelas:'XII RPL 1', pendidikan:'S2 Teknik Informatika' },
  { nip:'1990002', nama:'Rina Haryanti',     mapel:'Basis Data',         status:'PNS',    kelas:'XI RPL 2',  pendidikan:'S1 Sistem Informasi' },
  { nip:'1985003', nama:'Sari Wulandari',    mapel:'Desain Grafis',       status:'PNS',    kelas:'XI DKV 1',  pendidikan:'S1 Desain Komunikasi Visual' },
  { nip:'1992004', nama:'Dimas Rahayu',      mapel:'Animasi 3D',           status:'GTT',    kelas:'XII Animasi 1', pendidikan:'S1 Desain Animasi' },
  { nip:'1988005', nama:'Budi Waluyo',       mapel:'Matematika',           status:'PNS',    kelas:'X RPL 1',   pendidikan:'S2 Matematika' },
  { nip:'1991006', nama:'Dewi Anggraeni',    mapel:'Bahasa Indonesia',     status:'PNS',    kelas:'X DKV 2',   pendidikan:'S1 Sastra Indonesia' },
  { nip:'1993007', nama:'Agus Prasetyo',     mapel:'PKK',                  status:'GTT',    kelas:'XII DKV 2', pendidikan:'S1 Manajemen' },
  { nip:'1989008', nama:'Sari Maulida',      mapel:'Bahasa Inggris',       status:'PNS',    kelas:'XI Animasi 2', pendidikan:'S1 Sastra Inggris' },
]

// ── Data Kelas ──────────────────────────────────────────────────────
const kelasData = [
  { kelas:'XII RPL 1',     wali:'Hendra S.',   siswa:32, laki:22, perempuan:10, ruang:'Lab K1' },
  { kelas:'XII RPL 2',     wali:'Rina H.',     siswa:31, laki:20, perempuan:11, ruang:'Lab K2' },
  { kelas:'XII DKV 1',     wali:'Sari W.',     siswa:34, laki:15, perempuan:19, ruang:'Lab DKV' },
  { kelas:'XII DKV 2',     wali:'Agus P.',     siswa:33, laki:14, perempuan:19, ruang:'Lab DKV' },
  { kelas:'XII Animasi 1', wali:'Dimas R.',    siswa:30, laki:18, perempuan:12, ruang:'Lab Animasi' },
  { kelas:'XI RPL 1',      wali:'Budi W.',     siswa:33, laki:21, perempuan:12, ruang:'R. 201' },
  { kelas:'XI RPL 2',      wali:'Dewi A.',     siswa:32, laki:19, perempuan:13, ruang:'R. 202' },
  { kelas:'XI DKV 1',      wali:'Sari M.',     siswa:35, laki:16, perempuan:19, ruang:'R. 203' },
  { kelas:'X RPL 1',       wali:'—',          siswa:36, laki:24, perempuan:12, ruang:'R. 101' },
  { kelas:'X DKV 1',       wali:'—',          siswa:35, laki:13, perempuan:22, ruang:'R. 102' },
]

// ── Notif panel toggle ──────────────────────────────────────────────
const showPanel = ref(true)

const rekapNilai = [
  { label: 'Nilai A (≥85)',  count: 3, color: 'bg-emerald-500', pct: 30 },
  { label: 'Nilai B (70–84)', count: 4, color: 'bg-blue-500',    pct: 40 },
  { label: 'Nilai C (60–69)', count: 2, color: 'bg-yellow-400',  pct: 20 },
  { label: 'Nilai D (<60)',   count: 1, color: 'bg-red-400',     pct: 10 },
]
</script>

<template>
  <SchoolLayout>

    <!-- ══ TOPBAR TABS SLOT ══ -->
    <template #topbar-tabs>
      <button
        v-for="tab in tabs"
        :key="tab.key"
        @click="activeTab = tab.key"
        :class="[
          'px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-150 flex items-center gap-1.5',
          activeTab === tab.key
            ? 'text-white shadow-sm tab-active'
            : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700'
        ]"
      >
        <font-awesome-icon :icon="tab.icon" class="text-xs" />
        {{ tab.label }}
      </button>
    </template>

    <!-- ══ MAIN CONTENT ══ -->
    <div class="space-y-5">

      <!-- Page Header -->
      <div class="flex items-end justify-between">
        <div>
          <p class="text-xs text-gray-400 font-medium uppercase tracking-widest mb-1">Manajemen</p>
          <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Akademi</h1>
        </div>
        <div class="flex items-center gap-2">
          <button class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors shadow-sm">
            <font-awesome-icon :icon="['fas', 'file-export']" class="text-xs" />
            Export
          </button>
          <button class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white shadow-sm btn-primary">
            <font-awesome-icon :icon="['fas', 'plus']" class="text-xs" />
            Tambah Data
          </button>
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
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" :style="{ background: stat.color + '18', border: '1px solid ' + stat.color + '33' }">
              <font-awesome-icon :icon="stat.icon" class="text-base" :style="{ color: stat.color }" />
            </div>
          </div>
          <p class="text-2xl font-bold text-gray-900 tracking-tight">{{ stat.value }}</p>
          <p class="text-xs text-gray-400 mt-0.5 font-medium">{{ stat.label }}</p>
          <p class="text-xs mt-1 font-semibold" :style="{ color: stat.color }">{{ stat.sub }}</p>
        </div>
      </div>

      <!-- ════════════════ TAB: NILAI ════════════════ -->
      <div v-if="activeTab === 'nilai'" class="space-y-4">

        <!-- Filter Bar -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-4 flex flex-wrap items-center gap-3">
          <div class="flex items-center gap-2 flex-1 min-w-48">
            <font-awesome-icon :icon="['fas', 'search']" class="text-gray-400 text-sm" />
            <input
              v-model="searchSiswa"
              type="text"
              placeholder="Cari nama / NIS siswa..."
              class="flex-1 text-sm bg-transparent focus:outline-none text-gray-700 placeholder-gray-400"
            />
          </div>
          <div class="w-px h-5 bg-gray-200"></div>
          <select v-model="filterKelas" class="text-sm border border-gray-200 rounded-xl px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none cursor-pointer">
            <optgroup label="Kelas XII">
              <option v-for="k in kelasList.filter(k=>k.startsWith('XII'))" :key="k">{{ k }}</option>
            </optgroup>
            <optgroup label="Kelas XI">
              <option v-for="k in kelasList.filter(k=>k.startsWith('XI '))" :key="k">{{ k }}</option>
            </optgroup>
            <optgroup label="Kelas X">
              <option v-for="k in kelasList.filter(k=>k.startsWith('X '))" :key="k">{{ k }}</option>
            </optgroup>
          </select>
          <select v-model="filterMapel" class="text-sm border border-gray-200 rounded-xl px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none cursor-pointer">
            <option v-for="m in mapelList" :key="m">{{ m }}</option>
          </select>
          <select v-model="filterSemester" class="text-sm border border-gray-200 rounded-xl px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none cursor-pointer">
            <option>Ganjil 2024/2025</option>
            <option>Genap 2023/2024</option>
            <option>Ganjil 2023/2024</option>
          </select>
          <button class="flex items-center gap-1.5 text-sm font-semibold px-3 py-2 rounded-xl text-white btn-primary">
            <font-awesome-icon :icon="['fas', 'filter']" class="text-xs" />
            Filter
          </button>
        </div>

        <!-- Table + Rekap Side by Side -->
        <div class="flex gap-4">

          <!-- Nilai Table -->
          <div class="flex-1 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-50">
              <div>
                <h2 class="text-sm font-bold text-gray-900">Daftar Nilai — {{ filterKelas }}</h2>
                <p class="text-xs text-gray-400">{{ filterMapel === 'Semua' ? 'Semua Mata Pelajaran' : filterMapel }} · {{ filterSemester }}</p>
              </div>
              <div class="flex items-center gap-2">
                <span class="text-xs font-semibold px-3 py-1 rounded-full" style="background: #fff3ed; color: #f5762d; border: 1px solid #fde0cc;">
                  {{ filteredNilai.length }} siswa
                </span>
                <button class="w-8 h-8 rounded-lg border border-gray-200 bg-gray-50 flex items-center justify-center text-gray-400 hover:bg-orange-50 transition-colors">
                  <font-awesome-icon :icon="['fas', 'download']" class="text-xs" />
                </button>
              </div>
            </div>

            <div class="overflow-x-auto">
              <table class="w-full text-sm">
                <thead>
                  <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-10">No</th>
                    <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">NIS</th>
                    <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                    <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">UTS</th>
                    <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">UAS</th>
                    <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tugas</th>
                    <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Praktik</th>
                    <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Rata-rata</th>
                    <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Predikat</th>
                    <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Hadir%</th>
                    <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                  <tr
                    v-for="s in filteredNilai"
                    :key="s.nis"
                    class="hover:bg-orange-50/40 transition-colors cursor-default"
                  >
                    <td class="px-5 py-3 text-xs text-gray-400 tabular-nums">{{ s.no }}</td>
                    <td class="px-3 py-3 text-xs text-gray-500 font-mono">{{ s.nis }}</td>
                    <td class="px-3 py-3">
                      <div class="flex items-center gap-2.5">
                        <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0 text-white text-xs font-bold" style="background: #f5762d;">
                          {{ s.nama.charAt(0) }}
                        </div>
                        <span class="text-sm font-semibold text-gray-800">{{ s.nama }}</span>
                      </div>
                    </td>
                    <td class="px-3 py-3 text-center text-sm tabular-nums text-gray-700">{{ s.uts }}</td>
                    <td class="px-3 py-3 text-center text-sm tabular-nums text-gray-700">{{ s.uas }}</td>
                    <td class="px-3 py-3 text-center text-sm tabular-nums text-gray-700">{{ s.tugas }}</td>
                    <td class="px-3 py-3 text-center text-sm tabular-nums text-gray-700">{{ s.praktik }}</td>
                    <td class="px-3 py-3 text-center">
                      <span :class="rataColor(s.rata)" class="tabular-nums text-sm">{{ s.rata }}</span>
                    </td>
                    <td class="px-3 py-3 text-center">
                      <span :class="['text-xs font-bold px-2 py-0.5 rounded-full', predikatColor(s.predikat)]">
                        {{ s.predikat }}
                      </span>
                    </td>
                    <td class="px-3 py-3 text-center">
                      <div class="flex flex-col items-center gap-0.5">
                        <span class="text-xs font-semibold text-gray-700">{{ s.hadir }}%</span>
                        <div class="w-12 bg-gray-100 rounded-full h-1 overflow-hidden">
                          <div class="h-1 rounded-full" :style="{ width: s.hadir + '%', background: s.hadir >= 90 ? '#10b981' : s.hadir >= 75 ? '#f59e0b' : '#ef4444' }"></div>
                        </div>
                      </div>
                    </td>
                    <td class="px-3 py-3 text-center">
                      <div class="flex items-center justify-center gap-1">
                        <button class="w-7 h-7 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center hover:bg-blue-100 transition-colors">
                          <font-awesome-icon :icon="['fas', 'pen']" class="text-xs" />
                        </button>
                        <button class="w-7 h-7 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center hover:bg-orange-100 transition-colors">
                          <font-awesome-icon :icon="['fas', 'eye']" class="text-xs" />
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Table footer -->
            <div class="flex items-center justify-between px-5 py-3 border-t border-gray-50 bg-gray-50/50">
              <span class="text-xs text-gray-400">Menampilkan {{ filteredNilai.length }} dari {{ nilaiData.length }} data</span>
              <div class="flex items-center gap-1">
                <button class="w-7 h-7 rounded-lg border border-gray-200 bg-white flex items-center justify-center text-gray-400 hover:border-orange-300 transition-colors">
                  <font-awesome-icon :icon="['fas', 'chevron-left']" class="text-xs" />
                </button>
                <button class="w-7 h-7 rounded-lg text-white text-xs font-bold btn-primary">1</button>
                <button class="w-7 h-7 rounded-lg border border-gray-200 bg-white text-gray-500 text-xs font-medium hover:border-orange-300 transition-colors">2</button>
                <button class="w-7 h-7 rounded-lg border border-gray-200 bg-white flex items-center justify-center text-gray-400 hover:border-orange-300 transition-colors">
                  <font-awesome-icon :icon="['fas', 'chevron-right']" class="text-xs" />
                </button>
              </div>
            </div>
          </div>

          <!-- Rekap Sidebar -->
          <div class="w-60 flex-shrink-0 space-y-4">

            <!-- Distribusi Nilai -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
              <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-4">Distribusi Nilai</h3>
              <div class="space-y-3">
                <div v-for="r in rekapNilai" :key="r.label">
                  <div class="flex justify-between mb-1">
                    <span class="text-xs text-gray-600 font-medium">{{ r.label }}</span>
                    <span class="text-xs font-bold text-gray-800">{{ r.count }}</span>
                  </div>
                  <div class="w-full bg-gray-100 rounded-full h-2">
                    <div :class="r.color" class="h-2 rounded-full transition-all duration-700" :style="{ width: r.pct + '%' }"></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Rata-rata Kelas -->
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
              <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">Statistik Kelas</h3>
              <div class="space-y-2.5">
                <div class="flex justify-between items-center">
                  <span class="text-xs text-gray-500">Rata-rata kelas</span>
                  <span class="text-sm font-bold text-blue-600">78.0</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="text-xs text-gray-500">Nilai tertinggi</span>
                  <span class="text-sm font-bold text-emerald-600">95.3</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="text-xs text-gray-500">Nilai terendah</span>
                  <span class="text-sm font-bold text-red-500">60.5</span>
                </div>
                <div class="flex justify-between items-center">
                  <span class="text-xs text-gray-500">Lulus KKM</span>
                  <span class="text-sm font-bold" style="color: #f5762d;">9/10</span>
                </div>
              </div>
            </div>

            <!-- Quick action -->
            <button class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-2xl text-sm font-semibold text-white shadow-sm btn-primary">
              <font-awesome-icon :icon="['fas', 'file-pdf']" />
              Cetak Rapor
            </button>
            <button class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-2xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors shadow-sm">
              <font-awesome-icon :icon="['fas', 'file-excel']" class="text-green-600" />
              Export Excel
            </button>
          </div>
        </div>
      </div>

      <!-- ════════════════ TAB: JADWAL ════════════════ -->
      <div v-if="activeTab === 'jadwal'" class="space-y-4">

        <!-- Filter -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-4 flex items-center gap-3">
          <font-awesome-icon :icon="['fas', 'school']" class="text-gray-400" />
          <span class="text-sm font-semibold text-gray-700">Kelas:</span>
          <select v-model="jadwalKelas" class="text-sm border border-gray-200 rounded-xl px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none cursor-pointer">
            <option v-for="k in kelasList" :key="k">{{ k }}</option>
          </select>
          <div class="flex-1"></div>
          <button class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white btn-primary">
            <font-awesome-icon :icon="['fas', 'plus']" class="text-xs" />
            Tambah Jadwal
          </button>
        </div>

        <!-- Grid Jadwal -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
          <div class="px-5 py-4 border-b border-gray-50">
            <h2 class="text-sm font-bold text-gray-900">Jadwal Pelajaran — {{ jadwalKelas }}</h2>
            <p class="text-xs text-gray-400">Semester Ganjil 2024/2025</p>
          </div>
          <div class="overflow-x-auto">
            <table class="w-full">
              <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                  <th class="px-4 py-3 text-xs font-semibold text-gray-500 uppercase text-left w-20">Jam</th>
                  <th v-for="hari in hariList" :key="hari" class="px-3 py-3 text-xs font-semibold text-gray-500 uppercase text-center">
                    {{ hari }}
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-50">
                <tr v-for="jam in jamList" :key="jam" class="hover:bg-gray-50/50 transition-colors">
                  <td class="px-4 py-3">
                    <span class="text-xs font-bold tabular-nums" style="color: #f5762d;">{{ jam }}</span>
                  </td>
                  <td v-for="hari in hariList" :key="hari" class="px-2 py-2 text-center">
                    <div
                      v-if="jadwalGrid[jam]?.[hari]"
                      :class="['rounded-xl px-2 py-2 text-left border cursor-default hover:shadow-sm transition-all', jadwalColor(jadwalGrid[jam][hari]!.mapel)]"
                    >
                      <p class="text-xs font-bold leading-tight truncate">{{ jadwalGrid[jam][hari]!.mapel }}</p>
                      <p class="text-xs opacity-70 truncate mt-0.5">{{ jadwalGrid[jam][hari]!.guru }}</p>
                      <p class="text-xs opacity-60 truncate">{{ jadwalGrid[jam][hari]!.ruang }}</p>
                    </div>
                    <div v-else class="h-14 rounded-xl border border-dashed border-gray-200 flex items-center justify-center">
                      <font-awesome-icon :icon="['fas', 'plus']" class="text-gray-300 text-xs" />
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Legend -->
          <div class="px-5 py-3 border-t border-gray-50 flex flex-wrap gap-3">
            <div v-for="(cls, name) in mapelColors" :key="name" :class="['flex items-center gap-1.5 text-xs font-medium px-2.5 py-1 rounded-lg border', cls]">
              <div class="w-2 h-2 rounded-sm" :class="cls.split(' ')[0].replace('bg-', 'bg-').replace('-50', '-400')"></div>
              {{ name }}
            </div>
          </div>
        </div>
      </div>

      <!-- ════════════════ TAB: MAPEL ════════════════ -->
      <div v-if="activeTab === 'mapel'">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
          <div class="flex items-center justify-between px-5 py-4 border-b border-gray-50">
            <div>
              <h2 class="text-sm font-bold text-gray-900">Daftar Mata Pelajaran</h2>
              <p class="text-xs text-gray-400">{{ mapelData.length }} mata pelajaran terdaftar</p>
            </div>
            <button class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white btn-primary shadow-sm">
              <font-awesome-icon :icon="['fas', 'plus']" class="text-xs" />
              Tambah Mapel
            </button>
          </div>
          <table class="w-full text-sm">
            <thead>
              <tr class="bg-gray-50 border-b border-gray-100">
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kode</th>
                <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Mata Pelajaran</th>
                <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jurusan</th>
                <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jam/Minggu</th>
                <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Guru Pengampu</th>
                <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jml Kelas</th>
                <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">KKM</th>
                <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
              <tr v-for="m in mapelData" :key="m.kode" class="hover:bg-orange-50/40 transition-colors">
                <td class="px-5 py-3 text-xs font-mono text-gray-500">{{ m.kode }}</td>
                <td class="px-3 py-3 text-sm font-semibold text-gray-800">{{ m.nama }}</td>
                <td class="px-3 py-3">
                  <span :class="['text-xs font-semibold px-2 py-0.5 rounded-full', jurusanColors[m.jurusan]]">{{ m.jurusan }}</span>
                </td>
                <td class="px-3 py-3 text-center text-sm text-gray-700 font-semibold">{{ m.jam }}<span class="text-xs text-gray-400 font-normal"> jp</span></td>
                <td class="px-3 py-3 text-sm text-gray-700">{{ m.guru }}</td>
                <td class="px-3 py-3 text-center text-sm text-gray-700">{{ m.kelas }}</td>
                <td class="px-3 py-3 text-center text-sm font-bold" style="color: #f5762d;">{{ m.kkm }}</td>
                <td class="px-3 py-3 text-center">
                  <div class="flex items-center justify-center gap-1">
                    <button class="w-7 h-7 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center hover:bg-blue-100">
                      <font-awesome-icon :icon="['fas', 'pen']" class="text-xs" />
                    </button>
                    <button class="w-7 h-7 rounded-lg bg-red-50 text-red-400 flex items-center justify-center hover:bg-red-100">
                      <font-awesome-icon :icon="['fas', 'trash']" class="text-xs" />
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- ════════════════ TAB: GURU ════════════════ -->
      <div v-if="activeTab === 'guru'">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
          <div class="flex items-center justify-between px-5 py-4 border-b border-gray-50">
            <div>
              <h2 class="text-sm font-bold text-gray-900">Data Tenaga Pengajar</h2>
              <p class="text-xs text-gray-400">{{ guruData.length }} guru terdaftar · Tahun Ajaran 2024/2025</p>
            </div>
            <button class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white btn-primary shadow-sm">
              <font-awesome-icon :icon="['fas', 'user-plus']" class="text-xs" />
              Tambah Guru
            </button>
          </div>
          <div class="grid grid-cols-1 xl:grid-cols-2 gap-0 divide-y xl:divide-y-0 xl:divide-x-0">
            <div
              v-for="(g, i) in guruData"
              :key="g.nip"
              class="flex items-center gap-4 px-5 py-4 hover:bg-orange-50/30 transition-colors border-b border-gray-50"
            >
              <div class="w-11 h-11 rounded-2xl flex items-center justify-center flex-shrink-0 text-white font-bold text-base" style="background: linear-gradient(135deg, #f5762d, #e05a15);">
                {{ g.nama.charAt(0) }}
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-gray-800 truncate">{{ g.nama }}</p>
                <p class="text-xs text-gray-500 truncate">{{ g.mapel }}</p>
                <p class="text-xs text-gray-400 truncate">{{ g.pendidikan }}</p>
              </div>
              <div class="flex flex-col items-end gap-1.5 flex-shrink-0">
                <span :class="[g.status === 'PNS' ? 'bg-blue-100 text-blue-700' : 'bg-amber-100 text-amber-700', 'text-xs font-bold px-2 py-0.5 rounded-full']">
                  {{ g.status }}
                </span>
                <span class="text-xs text-gray-400">Wali: {{ g.kelas }}</span>
              </div>
              <div class="flex flex-col gap-1">
                <button class="w-7 h-7 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center hover:bg-blue-100">
                  <font-awesome-icon :icon="['fas', 'pen']" class="text-xs" />
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ════════════════ TAB: KELAS ════════════════ -->
      <div v-if="activeTab === 'kelas'">
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
          <div
            v-for="k in kelasData"
            :key="k.kelas"
            class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md hover:border-orange-200 transition-all cursor-default"
          >
            <div class="flex items-start justify-between mb-4">
              <div>
                <h3 class="text-base font-bold text-gray-900">{{ k.kelas }}</h3>
                <p class="text-xs text-gray-400 mt-0.5">Wali Kelas: <span class="font-semibold text-gray-600">{{ k.wali }}</span></p>
              </div>
              <div class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl" style="background: #fff3ed; border: 1px solid #fde0cc;">
                <font-awesome-icon :icon="['fas', 'users']" style="color: #f5762d;" class="text-xs" />
                <span class="text-sm font-bold" style="color: #f5762d;">{{ k.siswa }}</span>
                <span class="text-xs text-gray-400">siswa</span>
              </div>
            </div>

            <!-- Gender bar -->
            <div class="mb-3">
              <div class="flex justify-between text-xs text-gray-500 mb-1.5">
                <span>Laki-laki: <strong class="text-blue-600">{{ k.laki }}</strong></span>
                <span>Perempuan: <strong class="text-pink-500">{{ k.perempuan }}</strong></span>
              </div>
              <div class="w-full h-2.5 rounded-full overflow-hidden bg-pink-100">
                <div class="h-2.5 rounded-full bg-blue-400 transition-all duration-700" :style="{ width: Math.round(k.laki / k.siswa * 100) + '%' }"></div>
              </div>
            </div>

            <div class="flex items-center justify-between">
              <span class="text-xs text-gray-400 flex items-center gap-1.5">
                <font-awesome-icon :icon="['fas', 'door-open']" class="text-gray-300" />
                {{ k.ruang }}
              </span>
              <div class="flex gap-1">
                <button class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-orange-50 hover:bg-orange-100 transition-colors" style="color: #f5762d;">
                  Lihat Detail
                </button>
                <button class="w-7 h-7 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center hover:bg-blue-100">
                  <font-awesome-icon :icon="['fas', 'pen']" class="text-xs" />
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div><!-- end space-y-5 -->
  </SchoolLayout>
</template>

<style scoped>
* { box-sizing: border-box; }
.tabular-nums { font-variant-numeric: tabular-nums; }

.btn-primary {
  background: #f5762d;
  transition: background 0.15s;
}
.btn-primary:hover {
  background: #e05a15;
}

.tab-active {
  background: #f5762d;
}
</style>