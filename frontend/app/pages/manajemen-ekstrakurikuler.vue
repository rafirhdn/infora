<!-- pages/manajemen-ekstrakurikuler.vue -->
<script setup lang="ts">
definePageMeta({ layout: 'school' })

import { ref, computed } from 'vue'

// ── Tabs ──────────────────────────────────────────────────────────
const activeTab = ref('daftar')
const tabs = [
  { key: 'daftar',    label: 'Daftar Ekskul',    icon: ['fas', 'list'] },
  { key: 'peserta',   label: 'Peserta',           icon: ['fas', 'users'] },
  { key: 'jadwal',    label: 'Jadwal Latihan',    icon: ['fas', 'calendar-week'] },
  { key: 'prestasi',  label: 'Prestasi',          icon: ['fas', 'trophy'] },
]

// ── Stats ──────────────────────────────────────────────────────────
const stats = [
  { label: 'Total Ekskul',      value: '14',   icon: ['fas', 'futbol'],       sub: '3 kategori aktif',      color: '#f5762d' },
  { label: 'Total Peserta',     value: '487',  icon: ['fas', 'users'],        sub: '+24 bulan ini',          color: '#3b82f6' },
  { label: 'Pembina Aktif',     value: '18',   icon: ['fas', 'user-tie'],     sub: '2 pembina baru',         color: '#10b981' },
  { label: 'Prestasi Diraih',   value: '31',   icon: ['fas', 'medal'],        sub: '8 tingkat nasional',     color: '#f59e0b' },
]

// ── Data Ekskul ───────────────────────────────────────────────────
type EkskulStatus = 'Aktif' | 'Tidak Aktif'
interface Ekskul {
  id: number
  nama: string
  kategori: string
  pembina: string
  peserta: number
  kapasitas: number
  jadwal: string
  ruang: string
  status: EkskulStatus
  prestasi: number
  icon: string[]
  color: string
}

const ekskulData = ref<Ekskul[]>([
  { id:1,  nama:'Paskibra',            kategori:'Bela Negara', pembina:'Kol. Hendra S.',  peserta:45, kapasitas:50, jadwal:'Sabtu 07.00', ruang:'Lapangan Utama',  status:'Aktif',       prestasi:5, icon:['fas','flag'],            color:'#ef4444' },
  { id:2,  nama:'Pramuka',             kategori:'Bela Negara', pembina:'Ibu Rina H.',     peserta:62, kapasitas:80, jadwal:'Jumat 14.00',  ruang:'Aula Sekolah',    status:'Aktif',       prestasi:8, icon:['fas','compass'],         color:'#84cc16' },
  { id:3,  nama:'PMR',                  kategori:'Sosial',      pembina:'Ibu Sari W.',     peserta:38, kapasitas:40, jadwal:'Rabu 14.30',   ruang:'Ruang PMR',       status:'Aktif',       prestasi:3, icon:['fas','heart-pulse'],     color:'#f43f5e' },
  { id:4,  nama:'Basket',              kategori:'Olahraga',    pembina:'Bpk. Dimas R.',   peserta:28, kapasitas:30, jadwal:'Selasa 15.00', ruang:'Lapangan Basket', status:'Aktif',       prestasi:4, icon:['fas','basketball'],      color:'#f97316' },
  { id:5,  nama:'Futsal',              kategori:'Olahraga',    pembina:'Bpk. Agus P.',    peserta:30, kapasitas:30, jadwal:'Kamis 15.00',  ruang:'Lapangan Futsal', status:'Aktif',       prestasi:6, icon:['fas','futbol'],          color:'#22c55e' },
  { id:6,  nama:'Badminton',           kategori:'Olahraga',    pembina:'Ibu Dewi A.',     peserta:24, kapasitas:30, jadwal:'Senin 14.30',  ruang:'GOR',             status:'Aktif',       prestasi:2, icon:['fas','circle'],          color:'#a855f7' },
  { id:7,  nama:'Rohis',               kategori:'Keagamaan',   pembina:'Bpk. Budi W.',    peserta:55, kapasitas:60, jadwal:'Jumat 11.30',  ruang:'Musholla',        status:'Aktif',       prestasi:1, icon:['fas','mosque'],          color:'#0ea5e9' },
  { id:8,  nama:'Paduan Suara',        kategori:'Seni',        pembina:'Ibu Sari M.',     peserta:32, kapasitas:40, jadwal:'Rabu 15.00',   ruang:'Ruang Musik',     status:'Aktif',       prestasi:3, icon:['fas','music'],           color:'#ec4899' },
  { id:9,  nama:'Teater',              kategori:'Seni',        pembina:'Bpk. Hendra S.',  peserta:20, kapasitas:25, jadwal:'Sabtu 09.00',  ruang:'Aula',            status:'Aktif',       prestasi:2, icon:['fas','masks-theater'],   color:'#f59e0b' },
  { id:10, nama:'English Club',        kategori:'Akademik',    pembina:'Ibu Rina H.',     peserta:35, kapasitas:40, jadwal:'Selasa 14.00', ruang:'R. 201',          status:'Aktif',       prestasi:4, icon:['fas','language'],        color:'#3b82f6' },
  { id:11, nama:'Robotika',            kategori:'Akademik',    pembina:'Bpk. Dimas R.',   peserta:22, kapasitas:25, jadwal:'Kamis 14.00',  ruang:'Lab. K1',         status:'Aktif',       prestasi:7, icon:['fas','robot'],           color:'#6366f1' },
  { id:12, nama:'Jurnalistik',         kategori:'Akademik',    pembina:'Ibu Dewi A.',     peserta:18, kapasitas:25, jadwal:'Senin 15.00',  ruang:'R. 202',          status:'Aktif',       prestasi:1, icon:['fas','newspaper'],       color:'#64748b' },
  { id:13, nama:'Karate',              kategori:'Olahraga',    pembina:'Bpk. Agus P.',    peserta:26, kapasitas:30, jadwal:'Sabtu 07.30',  ruang:'GOR',             status:'Aktif',       prestasi:5, icon:['fas','hand-fist'],       color:'#dc2626' },
  { id:14, nama:'Tari Tradisional',    kategori:'Seni',        pembina:'Ibu Sari W.',     peserta:24, kapasitas:30, jadwal:'Rabu 14.00',   ruang:'Aula',            status:'Tidak Aktif', prestasi:0, icon:['fas','person-dancing'],  color:'#d946ef' },
])

const filterKategori = ref('Semua')
const searchEkskul   = ref('')
const viewMode       = ref<'grid' | 'list'>('grid')

const kategoriList = ['Semua', 'Olahraga', 'Seni', 'Akademik', 'Bela Negara', 'Sosial', 'Keagamaan']

const filteredEkskul = computed(() => {
  return ekskulData.value.filter(e => {
    const matchKat = filterKategori.value === 'Semua' || e.kategori === filterKategori.value
    const matchSearch = !searchEkskul.value || e.nama.toLowerCase().includes(searchEkskul.value.toLowerCase())
    return matchKat && matchSearch
  })
})

const kategoriColor: Record<string, string> = {
  'Olahraga':    'bg-green-100 text-green-700',
  'Seni':        'bg-pink-100 text-pink-700',
  'Akademik':    'bg-blue-100 text-blue-700',
  'Bela Negara': 'bg-red-100 text-red-700',
  'Sosial':      'bg-rose-100 text-rose-700',
  'Keagamaan':   'bg-cyan-100 text-cyan-700',
}

// ── Peserta ───────────────────────────────────────────────────────
const filterEkskulPeserta = ref('Pramuka')
const searchPeserta = ref('')

const pesertaData = ref([
  { no:1,  nis:'0045', nama:'Andi Pratama',      kelas:'XII RPL 1',    ekskul:'Pramuka',   jabatan:'Ketua',       bergabung:'Jul 2023', hadir:95 },
  { no:2,  nis:'0046', nama:'Bella Safitri',      kelas:'XI DKV 2',     ekskul:'Pramuka',   jabatan:'Wakil Ketua', bergabung:'Jul 2023', hadir:90 },
  { no:3,  nis:'0047', nama:'Candra Wijaya',       kelas:'XII RPL 2',    ekskul:'Pramuka',   jabatan:'Sekretaris',  bergabung:'Jul 2023', hadir:98 },
  { no:4,  nis:'0048', nama:'Dewi Anggraini',      kelas:'X DKV 1',      ekskul:'Pramuka',   jabatan:'Anggota',     bergabung:'Agt 2024', hadir:85 },
  { no:5,  nis:'0049', nama:'Eko Firmansyah',      kelas:'X RPL 2',      ekskul:'Pramuka',   jabatan:'Anggota',     bergabung:'Agt 2024', hadir:78 },
  { no:6,  nis:'0050', nama:'Fitria Handayani',    kelas:'XI Animasi 1', ekskul:'Pramuka',   jabatan:'Bendahara',   bergabung:'Jul 2023', hadir:92 },
  { no:7,  nis:'0051', nama:'Galih Santoso',        kelas:'XII DKV 1',    ekskul:'Pramuka',   jabatan:'Anggota',     bergabung:'Jul 2022', hadir:88 },
  { no:8,  nis:'0052', nama:'Hana Puspita',         kelas:'X Animasi 1',  ekskul:'Pramuka',   jabatan:'Anggota',     bergabung:'Agt 2024', hadir:80 },
])

const filteredPeserta = computed(() =>
  pesertaData.value.filter(p =>
    !searchPeserta.value ||
    p.nama.toLowerCase().includes(searchPeserta.value.toLowerCase()) ||
    p.nis.includes(searchPeserta.value)
  )
)

const jabatanColor: Record<string, string> = {
  'Ketua':       'bg-orange-100 text-orange-700',
  'Wakil Ketua': 'bg-amber-100 text-amber-700',
  'Sekretaris':  'bg-blue-100 text-blue-700',
  'Bendahara':   'bg-green-100 text-green-700',
  'Anggota':     'bg-gray-100 text-gray-600',
}

// ── Jadwal ────────────────────────────────────────────────────────
const jadwalData = [
  { hari:'Senin',   waktu:'14.30 – 16.00', ekskul:'Badminton',       pembina:'Ibu Dewi A.',   ruang:'GOR',             peserta:24, warna:'bg-purple-500' },
  { hari:'Senin',   waktu:'15.00 – 16.30', ekskul:'Jurnalistik',     pembina:'Ibu Dewi A.',   ruang:'R. 202',          peserta:18, warna:'bg-slate-500' },
  { hari:'Selasa',  waktu:'14.00 – 15.30', ekskul:'English Club',    pembina:'Ibu Rina H.',   ruang:'R. 201',          peserta:35, warna:'bg-blue-500' },
  { hari:'Selasa',  waktu:'15.00 – 16.30', ekskul:'Basket',          pembina:'Bpk. Dimas R.', ruang:'Lap. Basket',     peserta:28, warna:'bg-orange-500' },
  { hari:'Rabu',    waktu:'14.00 – 15.30', ekskul:'Tari Tradisional',pembina:'Ibu Sari W.',   ruang:'Aula',            peserta:24, warna:'bg-fuchsia-500' },
  { hari:'Rabu',    waktu:'14.30 – 16.00', ekskul:'PMR',              pembina:'Ibu Sari W.',   ruang:'Ruang PMR',       peserta:38, warna:'bg-rose-500' },
  { hari:'Rabu',    waktu:'15.00 – 16.30', ekskul:'Paduan Suara',    pembina:'Ibu Sari M.',   ruang:'Ruang Musik',     peserta:32, warna:'bg-pink-500' },
  { hari:'Kamis',   waktu:'14.00 – 15.30', ekskul:'Robotika',         pembina:'Bpk. Dimas R.', ruang:'Lab. K1',         peserta:22, warna:'bg-indigo-500' },
  { hari:'Kamis',   waktu:'15.00 – 16.30', ekskul:'Futsal',           pembina:'Bpk. Agus P.',  ruang:'Lap. Futsal',     peserta:30, warna:'bg-green-500' },
  { hari:'Jumat',   waktu:'11.30 – 12.30', ekskul:'Rohis',            pembina:'Bpk. Budi W.',  ruang:'Musholla',        peserta:55, warna:'bg-sky-500' },
  { hari:'Jumat',   waktu:'14.00 – 15.30', ekskul:'Pramuka',          pembina:'Ibu Rina H.',   ruang:'Aula Sekolah',    peserta:62, warna:'bg-lime-600' },
  { hari:'Sabtu',   waktu:'07.00 – 09.00', ekskul:'Paskibra',         pembina:'Kol. Hendra S.',ruang:'Lap. Utama',      peserta:45, warna:'bg-red-500' },
  { hari:'Sabtu',   waktu:'07.30 – 09.00', ekskul:'Karate',           pembina:'Bpk. Agus P.',  ruang:'GOR',             peserta:26, warna:'bg-red-700' },
  { hari:'Sabtu',   waktu:'09.00 – 11.00', ekskul:'Teater',           pembina:'Bpk. Hendra S.',ruang:'Aula',            peserta:20, warna:'bg-yellow-500' },
]

const hariUrut = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu']
const jadwalGrouped = computed(() => {
  const g: Record<string, typeof jadwalData> = {}
  hariUrut.forEach(h => { g[h] = jadwalData.filter(j => j.hari === h) })
  return g
})

// ── Prestasi ──────────────────────────────────────────────────────
type Tingkat = 'Internasional' | 'Nasional' | 'Provinsi' | 'Kota'
interface Prestasi {
  id: number
  ekskul: string
  nama: string
  tingkat: Tingkat
  peringkat: string
  penyelenggara: string
  tanggal: string
  siswa: string[]
  icon: string[]
  color: string
}

const prestasiData = ref<Prestasi[]>([
  { id:1,  ekskul:'Robotika',    nama:'Olimpiade Robot Nasional',           tingkat:'Nasional',      peringkat:'Juara 1',  penyelenggara:'Kemendikbud',      tanggal:'Nov 2024',  siswa:['Andi P.','Candra W.'],          icon:['fas','robot'],          color:'#6366f1' },
  { id:2,  ekskul:'Pramuka',     nama:'Jambore Pramuka Nasional',           tingkat:'Nasional',      peringkat:'Juara 2',  penyelenggara:'Kwartir Nasional', tanggal:'Okt 2024',  siswa:['Bella S.','Fitria H.'],         icon:['fas','compass'],        color:'#84cc16' },
  { id:3,  ekskul:'Basket',      nama:'Turnamen Basket Antar SMK DKI',      tingkat:'Provinsi',      peringkat:'Juara 1',  penyelenggara:'Dinas Pendidikan', tanggal:'Sep 2024',  siswa:['Galih S.','Hana P.','Eko F.'], icon:['fas','basketball'],     color:'#f97316' },
  { id:4,  ekskul:'Futsal',      nama:'Piala Gubernur Futsal Remaja',       tingkat:'Provinsi',      peringkat:'Juara 3',  penyelenggara:'KONI DKI',         tanggal:'Agt 2024',  siswa:['Dewi A.','Budi S.'],           icon:['fas','futbol'],         color:'#22c55e' },
  { id:5,  ekskul:'Karate',      nama:'Kejuaraan Karate Pelajar DKI',       tingkat:'Provinsi',      peringkat:'Juara 1',  penyelenggara:'FORKI DKI',        tanggal:'Jul 2024',  siswa:['Rian M.'],                     icon:['fas','hand-fist'],      color:'#dc2626' },
  { id:6,  ekskul:'Paskibra',    nama:'Lomba Paskibra Tingkat Kota',        tingkat:'Kota',          peringkat:'Juara 2',  penyelenggara:'Pemkot Jakarta',   tanggal:'Agt 2024',  siswa:['Siti N.','Agus D.'],           icon:['fas','flag'],           color:'#ef4444' },
  { id:7,  ekskul:'English Club',nama:'Speech Contest Tingkat Nasional',    tingkat:'Nasional',      peringkat:'Juara 3',  penyelenggara:'British Council',  tanggal:'Jun 2024',  siswa:['Hana P.'],                     icon:['fas','language'],       color:'#3b82f6' },
  { id:8,  ekskul:'Paduan Suara',nama:'Festival Paduan Suara Pelajar',      tingkat:'Kota',          peringkat:'Harapan 1', penyelenggara:'Dinas Kebudayaan', tanggal:'Mei 2024', siswa:['32 Anggota'],                  icon:['fas','music'],          color:'#ec4899' },
])

const tingkatColor: Record<Tingkat, string> = {
  'Internasional': 'bg-purple-100 text-purple-700 border-purple-200',
  'Nasional':      'bg-red-100 text-red-700 border-red-200',
  'Provinsi':      'bg-blue-100 text-blue-700 border-blue-200',
  'Kota':          'bg-green-100 text-green-700 border-green-200',
}

const peringkatColor = (p: string) => {
  if (p === 'Juara 1') return 'text-amber-500'
  if (p === 'Juara 2') return 'text-gray-500'
  if (p === 'Juara 3') return 'text-orange-600'
  return 'text-blue-500'
}

// ── Modal detail ──────────────────────────────────────────────────
const selectedEkskul = ref<Ekskul | null>(null)
function openDetail(e: Ekskul) { selectedEkskul.value = e }
function closeDetail() { selectedEkskul.value = null }

function kapasitasPct(p: number, k: number) { return Math.round(p / k * 100) }
function kapasitasColor(pct: number) {
  if (pct >= 90) return '#ef4444'
  if (pct >= 70) return '#f59e0b'
  return '#10b981'
}
</script>

<template>
  <SchoolLayout>

    <!-- ══ TOPBAR TABS ══ -->
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

    <!-- ══ MAIN ══ -->
    <div class="space-y-5">

      <!-- Page Header -->
      <div class="flex items-end justify-between">
        <div>
          <p class="text-xs text-gray-400 font-medium uppercase tracking-widest mb-1">Manajemen</p>
          <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Ekstrakurikuler</h1>
        </div>
        <div class="flex items-center gap-2">
          <button class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors shadow-sm">
            <font-awesome-icon :icon="['fas', 'file-export']" class="text-xs" />
            Export
          </button>
          <button class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white shadow-sm btn-primary">
            <font-awesome-icon :icon="['fas', 'plus']" class="text-xs" />
            Tambah Ekskul
          </button>
        </div>
      </div>

      <!-- Stats -->
      <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">
        <div
          v-for="stat in stats"
          :key="stat.label"
          class="bg-white rounded-2xl p-5 shadow-sm hover:shadow-md transition-all border border-gray-100"
        >
          <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-4" :style="{ background: stat.color + '18', border: '1px solid ' + stat.color + '33' }">
            <font-awesome-icon :icon="stat.icon" class="text-base" :style="{ color: stat.color }" />
          </div>
          <p class="text-2xl font-bold text-gray-900 tracking-tight">{{ stat.value }}</p>
          <p class="text-xs text-gray-400 mt-0.5 font-medium">{{ stat.label }}</p>
          <p class="text-xs mt-1 font-semibold" :style="{ color: stat.color }">{{ stat.sub }}</p>
        </div>
      </div>

      <!-- ═══════════ TAB: DAFTAR EKSKUL ═══════════ -->
      <div v-if="activeTab === 'daftar'" class="space-y-4">

        <!-- Filter Bar -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-3.5 flex flex-wrap items-center gap-3">
          <!-- Search -->
          <div class="flex items-center gap-2 bg-gray-50 rounded-xl px-3 py-2 flex-1 min-w-48 border border-gray-200">
            <font-awesome-icon :icon="['fas', 'search']" class="text-gray-400 text-xs" />
            <input v-model="searchEkskul" type="text" placeholder="Cari nama ekskul..." class="flex-1 text-sm bg-transparent focus:outline-none text-gray-700 placeholder-gray-400" />
          </div>
          <!-- Kategori pills -->
          <div class="flex items-center gap-1.5 flex-wrap">
            <button
              v-for="k in kategoriList"
              :key="k"
              @click="filterKategori = k"
              :class="[
                'px-3 py-1.5 rounded-full text-xs font-semibold transition-all',
                filterKategori === k ? 'text-white btn-primary shadow-sm' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
              ]"
            >{{ k }}</button>
          </div>
          <!-- View toggle -->
          <div class="flex items-center gap-1 border border-gray-200 rounded-xl p-1 bg-gray-50 ml-auto">
            <button
              @click="viewMode = 'grid'"
              :class="['w-8 h-7 rounded-lg flex items-center justify-center transition-all', viewMode === 'grid' ? 'bg-white shadow-sm text-orange-500' : 'text-gray-400']"
            ><font-awesome-icon :icon="['fas', 'grip']" class="text-xs" /></button>
            <button
              @click="viewMode = 'list'"
              :class="['w-8 h-7 rounded-lg flex items-center justify-center transition-all', viewMode === 'list' ? 'bg-white shadow-sm text-orange-500' : 'text-gray-400']"
            ><font-awesome-icon :icon="['fas', 'list']" class="text-xs" /></button>
          </div>
        </div>

        <!-- GRID VIEW -->
        <div v-if="viewMode === 'grid'" class="grid grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4">
          <div
            v-for="ekskul in filteredEkskul"
            :key="ekskul.id"
            class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all cursor-pointer overflow-hidden group"
            @click="openDetail(ekskul)"
          >
            <!-- Top accent bar -->
            <div class="h-1.5 w-full" :style="{ background: ekskul.color }"></div>

            <div class="p-4">
              <!-- Header -->
              <div class="flex items-start justify-between mb-3">
                <div
                  class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0"
                  :style="{ background: ekskul.color + '18', border: '1px solid ' + ekskul.color + '33' }"
                >
                  <font-awesome-icon :icon="ekskul.icon" class="text-xl" :style="{ color: ekskul.color }" />
                </div>
                <span :class="[
                  'text-xs font-bold px-2 py-0.5 rounded-full',
                  ekskul.status === 'Aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500'
                ]">{{ ekskul.status }}</span>
              </div>

              <h3 class="text-sm font-bold text-gray-900 mb-0.5 group-hover:text-orange-600 transition-colors">{{ ekskul.nama }}</h3>
              <span :class="['text-xs font-semibold px-2 py-0.5 rounded-full', kategoriColor[ekskul.kategori] || 'bg-gray-100 text-gray-600']">
                {{ ekskul.kategori }}
              </span>

              <!-- Info rows -->
              <div class="mt-3 space-y-1.5">
                <div class="flex items-center gap-2 text-xs text-gray-500">
                  <font-awesome-icon :icon="['fas', 'user-tie']" class="w-3.5 text-gray-400" />
                  <span class="truncate">{{ ekskul.pembina }}</span>
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                  <font-awesome-icon :icon="['fas', 'clock']" class="w-3.5 text-gray-400" />
                  <span>{{ ekskul.jadwal }}</span>
                </div>
                <div class="flex items-center gap-2 text-xs text-gray-500">
                  <font-awesome-icon :icon="['fas', 'location-dot']" class="w-3.5 text-gray-400" />
                  <span class="truncate">{{ ekskul.ruang }}</span>
                </div>
              </div>

              <!-- Capacity bar -->
              <div class="mt-3">
                <div class="flex justify-between text-xs mb-1">
                  <span class="text-gray-500">Peserta</span>
                  <span class="font-bold" :style="{ color: kapasitasColor(kapasitasPct(ekskul.peserta, ekskul.kapasitas)) }">
                    {{ ekskul.peserta }}/{{ ekskul.kapasitas }}
                  </span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                  <div
                    class="h-1.5 rounded-full transition-all duration-700"
                    :style="{
                      width: kapasitasPct(ekskul.peserta, ekskul.kapasitas) + '%',
                      background: kapasitasColor(kapasitasPct(ekskul.peserta, ekskul.kapasitas))
                    }"
                  ></div>
                </div>
              </div>

              <!-- Prestasi badge -->
              <div v-if="ekskul.prestasi > 0" class="mt-3 flex items-center gap-1.5">
                <font-awesome-icon :icon="['fas', 'trophy']" class="text-amber-500 text-xs" />
                <span class="text-xs text-gray-500">{{ ekskul.prestasi }} prestasi diraih</span>
              </div>
            </div>
          </div>
        </div>

        <!-- LIST VIEW -->
        <div v-else class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
          <table class="w-full text-sm">
            <thead>
              <tr class="bg-gray-50 border-b border-gray-100">
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Ekstrakurikuler</th>
                <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Pembina</th>
                <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jadwal</th>
                <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Peserta</th>
                <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Prestasi</th>
                <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
              <tr v-for="e in filteredEkskul" :key="e.id" class="hover:bg-orange-50/30 transition-colors">
                <td class="px-5 py-3">
                  <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" :style="{ background: e.color + '18' }">
                      <font-awesome-icon :icon="e.icon" :style="{ color: e.color }" />
                    </div>
                    <span class="font-semibold text-gray-800">{{ e.nama }}</span>
                  </div>
                </td>
                <td class="px-3 py-3">
                  <span :class="['text-xs font-semibold px-2 py-0.5 rounded-full', kategoriColor[e.kategori]]">{{ e.kategori }}</span>
                </td>
                <td class="px-3 py-3 text-sm text-gray-600">{{ e.pembina }}</td>
                <td class="px-3 py-3 text-sm text-gray-600">{{ e.jadwal }}</td>
                <td class="px-3 py-3 text-center">
                  <div class="flex flex-col items-center gap-1">
                    <span class="text-sm font-bold" :style="{ color: kapasitasColor(kapasitasPct(e.peserta, e.kapasitas)) }">
                      {{ e.peserta }}<span class="text-xs font-normal text-gray-400">/{{ e.kapasitas }}</span>
                    </span>
                    <div class="w-16 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                      <div class="h-1.5 rounded-full" :style="{ width: kapasitasPct(e.peserta, e.kapasitas) + '%', background: kapasitasColor(kapasitasPct(e.peserta, e.kapasitas)) }"></div>
                    </div>
                  </div>
                </td>
                <td class="px-3 py-3 text-center">
                  <span :class="['text-xs font-bold px-2 py-0.5 rounded-full', e.status === 'Aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500']">{{ e.status }}</span>
                </td>
                <td class="px-3 py-3 text-center">
                  <div class="flex items-center justify-center gap-1">
                    <font-awesome-icon :icon="['fas', 'trophy']" class="text-amber-400 text-xs" />
                    <span class="text-sm font-semibold text-gray-700">{{ e.prestasi }}</span>
                  </div>
                </td>
                <td class="px-3 py-3 text-center">
                  <div class="flex items-center justify-center gap-1">
                    <button @click="openDetail(e)" class="w-7 h-7 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center hover:bg-orange-100 transition-colors">
                      <font-awesome-icon :icon="['fas', 'eye']" class="text-xs" />
                    </button>
                    <button class="w-7 h-7 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center hover:bg-blue-100 transition-colors">
                      <font-awesome-icon :icon="['fas', 'pen']" class="text-xs" />
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- ═══════════ TAB: PESERTA ═══════════ -->
      <div v-if="activeTab === 'peserta'" class="space-y-4">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-3.5 flex flex-wrap items-center gap-3">
          <div class="flex items-center gap-2 bg-gray-50 rounded-xl px-3 py-2 flex-1 min-w-48 border border-gray-200">
            <font-awesome-icon :icon="['fas', 'search']" class="text-gray-400 text-xs" />
            <input v-model="searchPeserta" type="text" placeholder="Cari nama / NIS..." class="flex-1 text-sm bg-transparent focus:outline-none text-gray-700 placeholder-gray-400" />
          </div>
          <select v-model="filterEkskulPeserta" class="text-sm border border-gray-200 rounded-xl px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none cursor-pointer">
            <option v-for="e in ekskulData" :key="e.id">{{ e.nama }}</option>
          </select>
          <button class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white btn-primary shadow-sm">
            <font-awesome-icon :icon="['fas', 'user-plus']" class="text-xs" />
            Daftarkan Peserta
          </button>
        </div>

        <div class="flex gap-4">
          <!-- Table -->
          <div class="flex-1 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-50">
              <div>
                <h2 class="text-sm font-bold text-gray-900">Peserta — {{ filterEkskulPeserta }}</h2>
                <p class="text-xs text-gray-400">{{ filteredPeserta.length }} anggota terdaftar</p>
              </div>
              <button class="flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-orange-500 transition-colors">
                <font-awesome-icon :icon="['fas', 'download']" />
                Unduh Daftar
              </button>
            </div>
            <table class="w-full text-sm">
              <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                  <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-10">No</th>
                  <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">NIS</th>
                  <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                  <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas</th>
                  <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Jabatan</th>
                  <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Bergabung</th>
                  <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kehadiran</th>
                  <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-50">
                <tr v-for="p in filteredPeserta" :key="p.nis" class="hover:bg-orange-50/30 transition-colors">
                  <td class="px-5 py-3 text-xs text-gray-400">{{ p.no }}</td>
                  <td class="px-3 py-3 text-xs font-mono text-gray-500">{{ p.nis }}</td>
                  <td class="px-3 py-3">
                    <div class="flex items-center gap-2.5">
                      <div class="w-7 h-7 rounded-full flex items-center justify-center flex-shrink-0 text-white text-xs font-bold" style="background: #f5762d;">
                        {{ p.nama.charAt(0) }}
                      </div>
                      <span class="text-sm font-semibold text-gray-800">{{ p.nama }}</span>
                    </div>
                  </td>
                  <td class="px-3 py-3 text-sm text-gray-600">{{ p.kelas }}</td>
                  <td class="px-3 py-3">
                    <span :class="['text-xs font-semibold px-2 py-0.5 rounded-full', jabatanColor[p.jabatan]]">{{ p.jabatan }}</span>
                  </td>
                  <td class="px-3 py-3 text-xs text-gray-500">{{ p.bergabung }}</td>
                  <td class="px-3 py-3 text-center">
                    <div class="flex flex-col items-center gap-0.5">
                      <span class="text-xs font-bold" :class="p.hadir >= 90 ? 'text-emerald-600' : p.hadir >= 75 ? 'text-amber-500' : 'text-red-500'">{{ p.hadir }}%</span>
                      <div class="w-14 bg-gray-100 rounded-full h-1.5 overflow-hidden">
                        <div class="h-1.5 rounded-full transition-all" :style="{ width: p.hadir + '%', background: p.hadir >= 90 ? '#10b981' : p.hadir >= 75 ? '#f59e0b' : '#ef4444' }"></div>
                      </div>
                    </div>
                  </td>
                  <td class="px-3 py-3 text-center">
                    <div class="flex items-center justify-center gap-1">
                      <button class="w-7 h-7 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center hover:bg-blue-100 transition-colors">
                        <font-awesome-icon :icon="['fas', 'pen']" class="text-xs" />
                      </button>
                      <button class="w-7 h-7 rounded-lg bg-red-50 text-red-400 flex items-center justify-center hover:bg-red-100 transition-colors">
                        <font-awesome-icon :icon="['fas', 'trash']" class="text-xs" />
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Sidebar Info Ekskul -->
          <div class="w-56 flex-shrink-0 space-y-3">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
              <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">Info Ekskul</h3>
              <div class="space-y-2.5 text-xs">
                <div class="flex justify-between"><span class="text-gray-500">Pembina</span><span class="font-semibold text-gray-700">Ibu Rina H.</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Jadwal</span><span class="font-semibold text-gray-700">Jumat 14.00</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Lokasi</span><span class="font-semibold text-gray-700">Aula Sekolah</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Kapasitas</span><span class="font-semibold text-gray-700">62/80</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Status</span>
                  <span class="font-bold text-emerald-600">Aktif</span>
                </div>
              </div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
              <h3 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-3">Komposisi Jabatan</h3>
              <div class="space-y-2">
                <div v-for="(label, key) in jabatanColor" :key="key" class="flex items-center gap-2">
                  <span :class="[label, 'text-xs font-semibold px-2 py-0.5 rounded-full w-24 text-center']">{{ key }}</span>
                  <span class="text-xs text-gray-500">{{ pesertaData.filter(p => p.jabatan === key).length }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ═══════════ TAB: JADWAL ═══════════ -->
      <div v-if="activeTab === 'jadwal'" class="space-y-4">
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
          <div
            v-for="hari in hariUrut"
            :key="hari"
            class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden"
          >
            <!-- Hari header -->
            <div class="px-5 py-3 border-b border-gray-50 flex items-center justify-between" style="background: linear-gradient(90deg, #fff8f4, #ffffff);">
              <h3 class="text-sm font-bold text-gray-900">{{ hari }}</h3>
              <span class="text-xs font-semibold px-2 py-0.5 rounded-full" style="background: #fff3ed; color: #f5762d; border: 1px solid #fde0cc;">
                {{ jadwalGrouped[hari]?.length || 0 }} kegiatan
              </span>
            </div>

            <div v-if="jadwalGrouped[hari]?.length" class="divide-y divide-gray-50">
              <div
                v-for="(j, i) in jadwalGrouped[hari]"
                :key="i"
                class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50/50 transition-colors"
              >
                <!-- Color dot -->
                <div class="w-2.5 h-2.5 rounded-full flex-shrink-0" :class="j.warna"></div>
                <!-- Time -->
                <span class="text-xs font-bold tabular-nums text-gray-500 w-28 flex-shrink-0">{{ j.waktu }}</span>
                <!-- Info -->
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-semibold text-gray-800 truncate">{{ j.ekskul }}</p>
                  <p class="text-xs text-gray-400 truncate">{{ j.pembina }} · {{ j.ruang }}</p>
                </div>
                <!-- Peserta badge -->
                <div class="flex items-center gap-1 flex-shrink-0">
                  <font-awesome-icon :icon="['fas', 'users']" class="text-gray-400 text-xs" />
                  <span class="text-xs font-semibold text-gray-600">{{ j.peserta }}</span>
                </div>
              </div>
            </div>

            <div v-else class="px-5 py-6 text-center text-xs text-gray-400">
              <font-awesome-icon :icon="['fas', 'calendar-xmark']" class="text-gray-200 text-2xl mb-2 block mx-auto" />
              Tidak ada kegiatan
            </div>
          </div>
        </div>
      </div>

      <!-- ═══════════ TAB: PRESTASI ═══════════ -->
      <div v-if="activeTab === 'prestasi'" class="space-y-4">

        <!-- Summary banner -->
        <div class="rounded-2xl overflow-hidden relative p-5" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);">
          <div class="absolute top-0 right-0 w-48 h-48 rounded-full opacity-10" style="background: #f5762d; transform: translate(30%, -30%);"></div>
          <div class="relative z-10 flex items-center gap-8">
            <div class="flex items-center gap-3">
              <div class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background: rgba(245,118,45,0.2); border: 1px solid rgba(245,118,45,0.4);">
                <font-awesome-icon :icon="['fas', 'trophy']" class="text-2xl text-amber-400" />
              </div>
              <div>
                <p class="text-3xl font-black text-white tracking-tight">31</p>
                <p class="text-xs text-white/50 font-medium mt-0.5">Total Prestasi 2024/2025</p>
              </div>
            </div>
            <div class="w-px h-12" style="background: rgba(255,255,255,0.1)"></div>
            <div class="flex gap-6">
              <div class="text-center">
                <p class="text-xl font-black text-white">0</p>
                <p class="text-xs font-semibold" style="color: rgba(255,255,255,0.4);">Internasional</p>
              </div>
              <div class="text-center">
                <p class="text-xl font-black" style="color: #f5762d;">8</p>
                <p class="text-xs font-semibold" style="color: rgba(255,255,255,0.4);">Nasional</p>
              </div>
              <div class="text-center">
                <p class="text-xl font-black text-blue-400">14</p>
                <p class="text-xs font-semibold" style="color: rgba(255,255,255,0.4);">Provinsi</p>
              </div>
              <div class="text-center">
                <p class="text-xl font-black text-emerald-400">9</p>
                <p class="text-xs font-semibold" style="color: rgba(255,255,255,0.4);">Kota</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Prestasi Cards -->
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-4">
          <div
            v-for="p in prestasiData"
            :key="p.id"
            class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-all overflow-hidden"
          >
            <div class="flex items-start gap-4 p-5">
              <!-- Icon -->
              <div class="w-12 h-12 rounded-2xl flex items-center justify-center flex-shrink-0" :style="{ background: p.color + '18', border: '1px solid ' + p.color + '33' }">
                <font-awesome-icon :icon="p.icon" class="text-xl" :style="{ color: p.color }" />
              </div>
              <!-- Content -->
              <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-2 mb-1">
                  <h3 class="text-sm font-bold text-gray-900 leading-snug">{{ p.nama }}</h3>
                  <span :class="['text-xs font-bold px-2 py-0.5 rounded-full border flex-shrink-0', tingkatColor[p.tingkat]]">
                    {{ p.tingkat }}
                  </span>
                </div>
                <p class="text-xs text-gray-500 mb-2">{{ p.penyelenggara }} · {{ p.tanggal }}</p>
                <!-- Peringkat -->
                <div class="flex items-center gap-2 mb-2">
                  <font-awesome-icon :icon="['fas', 'award']" :class="['text-sm', peringkatColor(p.peringkat)]" />
                  <span :class="['text-sm font-black', peringkatColor(p.peringkat)]">{{ p.peringkat }}</span>
                  <span class="text-xs text-gray-400">— {{ p.ekskul }}</span>
                </div>
                <!-- Siswa -->
                <div class="flex items-center gap-1.5 flex-wrap">
                  <font-awesome-icon :icon="['fas', 'user']" class="text-gray-400 text-xs" />
                  <span
                    v-for="s in p.siswa"
                    :key="s"
                    class="text-xs font-medium px-2 py-0.5 rounded-full bg-gray-100 text-gray-600"
                  >{{ s }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Add button -->
        <button class="w-full py-4 rounded-2xl border-2 border-dashed border-gray-200 text-sm font-semibold text-gray-400 hover:border-orange-300 hover:text-orange-500 hover:bg-orange-50/30 transition-all flex items-center justify-center gap-2">
          <font-awesome-icon :icon="['fas', 'plus']" />
          Tambah Catatan Prestasi
        </button>
      </div>

    </div><!-- end space-y-5 -->

    <!-- ══ MODAL DETAIL EKSKUL ══ -->
    <Teleport to="body">
      <div
        v-if="selectedEkskul"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);"
        @click.self="closeDetail"
      >
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden animate-modal">

          <!-- Modal Header -->
          <div class="relative overflow-hidden" style="background: linear-gradient(135deg, #1a1a2e, #0f3460);">
            <div class="absolute inset-0 opacity-20" :style="{ background: selectedEkskul.color }"></div>
            <div class="relative z-10 p-6 pb-5">
              <div class="flex items-start justify-between">
                <div class="flex items-center gap-4">
                  <div class="w-14 h-14 rounded-2xl flex items-center justify-center" :style="{ background: selectedEkskul.color + '30', border: '1px solid ' + selectedEkskul.color + '50' }">
                    <font-awesome-icon :icon="selectedEkskul.icon" class="text-2xl" :style="{ color: selectedEkskul.color }" />
                  </div>
                  <div>
                    <h2 class="text-lg font-black text-white">{{ selectedEkskul.nama }}</h2>
                    <span :class="['text-xs font-semibold px-2.5 py-0.5 rounded-full mt-1 inline-block', kategoriColor[selectedEkskul.kategori]]">
                      {{ selectedEkskul.kategori }}
                    </span>
                  </div>
                </div>
                <button @click="closeDetail" class="w-8 h-8 rounded-full flex items-center justify-center text-white/60 hover:text-white hover:bg-white/10 transition-colors">
                  <font-awesome-icon :icon="['fas', 'xmark']" />
                </button>
              </div>
            </div>
          </div>

          <!-- Modal Body -->
          <div class="p-6 space-y-4">

            <!-- Capacity -->
            <div>
              <div class="flex justify-between text-sm mb-2">
                <span class="text-gray-500 font-medium">Kapasitas Peserta</span>
                <span class="font-bold" :style="{ color: kapasitasColor(kapasitasPct(selectedEkskul.peserta, selectedEkskul.kapasitas)) }">
                  {{ selectedEkskul.peserta }} / {{ selectedEkskul.kapasitas }}
                  ({{ kapasitasPct(selectedEkskul.peserta, selectedEkskul.kapasitas) }}%)
                </span>
              </div>
              <div class="w-full bg-gray-100 rounded-full h-2.5 overflow-hidden">
                <div
                  class="h-2.5 rounded-full transition-all duration-700"
                  :style="{
                    width: kapasitasPct(selectedEkskul.peserta, selectedEkskul.kapasitas) + '%',
                    background: kapasitasColor(kapasitasPct(selectedEkskul.peserta, selectedEkskul.kapasitas))
                  }"
                ></div>
              </div>
            </div>

            <!-- Detail rows -->
            <div class="grid grid-cols-2 gap-3">
              <div class="bg-gray-50 rounded-2xl p-3.5">
                <p class="text-xs text-gray-400 mb-1">Pembina</p>
                <p class="text-sm font-bold text-gray-800">{{ selectedEkskul.pembina }}</p>
              </div>
              <div class="bg-gray-50 rounded-2xl p-3.5">
                <p class="text-xs text-gray-400 mb-1">Jadwal</p>
                <p class="text-sm font-bold text-gray-800">{{ selectedEkskul.jadwal }}</p>
              </div>
              <div class="bg-gray-50 rounded-2xl p-3.5">
                <p class="text-xs text-gray-400 mb-1">Ruang/Lokasi</p>
                <p class="text-sm font-bold text-gray-800">{{ selectedEkskul.ruang }}</p>
              </div>
              <div class="bg-gray-50 rounded-2xl p-3.5">
                <p class="text-xs text-gray-400 mb-1">Prestasi</p>
                <div class="flex items-center gap-1.5">
                  <font-awesome-icon :icon="['fas', 'trophy']" class="text-amber-500 text-sm" />
                  <p class="text-sm font-bold text-gray-800">{{ selectedEkskul.prestasi }} kali</p>
                </div>
              </div>
            </div>

            <!-- Status -->
            <div class="flex items-center justify-between bg-gray-50 rounded-2xl p-3.5">
              <span class="text-sm text-gray-500">Status Ekskul</span>
              <span :class="['text-sm font-bold px-3 py-1 rounded-full', selectedEkskul.status === 'Aktif' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600']">
                {{ selectedEkskul.status }}
              </span>
            </div>

            <!-- Action buttons -->
            <div class="flex gap-2 pt-1">
              <button class="flex-1 py-3 rounded-2xl text-sm font-bold text-white btn-primary">
                <font-awesome-icon :icon="['fas', 'users']" class="mr-2" />
                Kelola Peserta
              </button>
              <button class="flex-1 py-3 rounded-2xl text-sm font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 transition-colors">
                <font-awesome-icon :icon="['fas', 'pen']" class="mr-2" />
                Edit Data
              </button>
            </div>
          </div>
        </div>
      </div>
    </Teleport>

  </SchoolLayout>
</template>

<style scoped>
* { box-sizing: border-box; }
.tabular-nums { font-variant-numeric: tabular-nums; }

.btn-primary { background: #f5762d; transition: background 0.15s; }
.btn-primary:hover { background: #e05a15; }
.tab-active { background: #f5762d; }

@keyframes modal-in {
  from { opacity: 0; transform: scale(0.94) translateY(12px); }
  to   { opacity: 1; transform: scale(1) translateY(0); }
}
.animate-modal { animation: modal-in 0.2s ease; }
</style>