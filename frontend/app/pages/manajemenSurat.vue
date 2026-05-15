<!-- pages/manajemen-surat.vue -->
<script setup lang="ts">
definePageMeta({ layout: 'school' })

import { ref, computed } from 'vue'

// ── Tabs ──────────────────────────────────────────────────────────
const activeTab = ref('masuk')
const tabs = [
  { key: 'masuk',   label: 'Surat Masuk',   icon: ['fas', 'inbox'] },
  { key: 'keluar',  label: 'Surat Keluar',  icon: ['fas', 'paper-plane'] },
  { key: 'disposisi', label: 'Disposisi',   icon: ['fas', 'arrow-right-arrow-left'] },
  { key: 'arsip',   label: 'Arsip',         icon: ['fas', 'box-archive'] },
]

// ── Stats ──────────────────────────────────────────────────────────
const stats = [
  { label: 'Surat Masuk',   value: '128', icon: ['fas', 'inbox'],        sub: '+12 bulan ini',      color: '#3b82f6' },
  { label: 'Surat Keluar',  value: '94',  icon: ['fas', 'paper-plane'],  sub: '+8 bulan ini',       color: '#f5762d' },
  { label: 'Belum Diproses',value: '17',  icon: ['fas', 'clock'],        sub: '5 urgent',           color: '#ef4444' },
  { label: 'Terarsip',      value: '389', icon: ['fas', 'box-archive'],  sub: 'Sejak 2022',         color: '#10b981' },
]

// ── Jenis & Kategori ──────────────────────────────────────────────
const kategoriMasuk = [
  'Semua', 'Dinas Pendidikan', 'Orang Tua / Wali', 'Instansi Lain', 'Internal', 'Undangan', 'Pengumuman'
]
const kategoriKeluar = [
  'Semua', 'Surat Keterangan', 'Surat Tugas', 'Undangan', 'Laporan', 'Permohonan', 'Pemberitahuan'
]

// ── Surat Masuk ───────────────────────────────────────────────────
type Status = 'Belum Dibaca' | 'Dibaca' | 'Diproses' | 'Selesai' | 'Disposisi'
interface SuratMasuk {
  id: number
  noSurat: string
  perihal: string
  pengirim: string
  kategori: string
  tanggal: string
  tglTerima: string
  status: Status
  urgent: boolean
  lampiran: number
  disposisiKe: string
}

const suratMasukData = ref<SuratMasuk[]>([
  { id:1,  noSurat:'425/1234/SET.KDK/2025', perihal:'Undangan Rapat Koordinasi Kepala Sekolah Se-DKI Jakarta', pengirim:'Dinas Pendidikan DKI Jakarta',  kategori:'Dinas Pendidikan',   tanggal:'03 Mei 2025', tglTerima:'04 Mei 2025', status:'Belum Dibaca', urgent:true,  lampiran:2, disposisiKe:'' },
  { id:2,  noSurat:'001/WM/SMKN71/V/2025',  perihal:'Permohonan Izin Tidak Masuk Ananda Budi Santoso',         pengirim:'Orang Tua Budi Santoso',        kategori:'Orang Tua / Wali',   tanggal:'02 Mei 2025', tglTerima:'02 Mei 2025', status:'Diproses',     urgent:false, lampiran:0, disposisiKe:'Wali Kelas XII RPL 1' },
  { id:3,  noSurat:'B/425/DIKDAS/2025',      perihal:'Pemberitahuan Jadwal Supervisi Akademik Semester Ganjil', pengirim:'Korwil Kec. Tebet',             kategori:'Dinas Pendidikan',   tanggal:'01 Mei 2025', tglTerima:'02 Mei 2025', status:'Dibaca',       urgent:false, lampiran:1, disposisiKe:'' },
  { id:4,  noSurat:'023/PT-Maju/IV/2025',    perihal:'Penawaran Program Magang Industri Siswa SMK 2025',        pengirim:'PT Maju Bersama Digital',       kategori:'Instansi Lain',      tanggal:'28 Apr 2025', tglTerima:'30 Apr 2025', status:'Disposisi',    urgent:false, lampiran:3, disposisiKe:'Waka Humas' },
  { id:5,  noSurat:'045/OSIS/SMKN71/IV/25', perihal:'Proposal Kegiatan Pentas Seni Akhir Tahun 2025',          pengirim:'OSIS SMKN 71 Jakarta',          kategori:'Internal',           tanggal:'27 Apr 2025', tglTerima:'28 Apr 2025', status:'Selesai',      urgent:false, lampiran:1, disposisiKe:'Waka Kesiswaan' },
  { id:6,  noSurat:'112/Undangan/IV/2025',   perihal:'Undangan Seminar Nasional Pendidikan Vokasi 2025',        pengirim:'Universitas Negeri Jakarta',    kategori:'Undangan',           tanggal:'25 Apr 2025', tglTerima:'26 Apr 2025', status:'Selesai',      urgent:false, lampiran:2, disposisiKe:'' },
  { id:7,  noSurat:'002/WM/SMKN71/IV/25',   perihal:'Permohonan Izin Sakit — Dewi Anggraini Kelas X DKV 1',   pengirim:'Orang Tua Dewi Anggraini',      kategori:'Orang Tua / Wali',   tanggal:'24 Apr 2025', tglTerima:'24 Apr 2025', status:'Selesai',      urgent:false, lampiran:1, disposisiKe:'Wali Kelas X DKV 1' },
  { id:8,  noSurat:'B/300/KONI/IV/2025',     perihal:'Surat Pemanggilan Atlet Pelajar Kejuaraan Basket DKI',   pengirim:'KONI DKI Jakarta',              kategori:'Instansi Lain',      tanggal:'23 Apr 2025', tglTerima:'24 Apr 2025', status:'Belum Dibaca', urgent:true,  lampiran:1, disposisiKe:'' },
  { id:9,  noSurat:'099/DIKMEN/IV/2025',     perihal:'Edaran Pelaksanaan Ujian Kompetensi Keahlian 2025',      pengirim:'Dinas Pendidikan DKI Jakarta',  kategori:'Pengumuman',         tanggal:'22 Apr 2025', tglTerima:'23 Apr 2025', status:'Diproses',     urgent:true,  lampiran:4, disposisiKe:'Waka Kurikulum' },
  { id:10, noSurat:'031/Permohonan/IV/25',   perihal:'Permohonan Penggunaan Aula untuk Kegiatan LDKS',         pengirim:'Pramuka SMKN 71',               kategori:'Internal',           tanggal:'21 Apr 2025', tglTerima:'21 Apr 2025', status:'Selesai',      urgent:false, lampiran:0, disposisiKe:'Waka Sarpras' },
])

// ── Surat Keluar ──────────────────────────────────────────────────
interface SuratKeluar {
  id: number
  noSurat: string
  perihal: string
  tujuan: string
  kategori: string
  tanggal: string
  ttd: string
  status: 'Draft' | 'Terkirim' | 'Diterima'
  lampiran: number
}

const suratKeluarData = ref<SuratKeluar[]>([
  { id:1,  noSurat:'422/045/SMKN71/V/2025',  perihal:'Surat Keterangan Aktif Siswa — Andi Pratama',            tujuan:'Universitas Indonesia',           kategori:'Surat Keterangan', tanggal:'04 Mei 2025', ttd:'Kepala Sekolah', status:'Terkirim', lampiran:0 },
  { id:2,  noSurat:'421/044/SMKN71/V/2025',  perihal:'Surat Tugas Mengikuti Pelatihan Guru Nasional',           tujuan:'Kemendikbud RI',                  kategori:'Surat Tugas',     tanggal:'03 Mei 2025', ttd:'Kepala Sekolah', status:'Terkirim', lampiran:1 },
  { id:3,  noSurat:'423/043/SMKN71/V/2025',  perihal:'Undangan Rapat Wali Murid Semester Genap 2025',          tujuan:'Orang Tua / Wali Siswa',          kategori:'Undangan',        tanggal:'02 Mei 2025', ttd:'Kepala Sekolah', status:'Diterima', lampiran:1 },
  { id:4,  noSurat:'800/042/SMKN71/IV/2025', perihal:'Laporan Bulanan Kegiatan Sekolah Bulan April 2025',      tujuan:'Dinas Pendidikan DKI Jakarta',    kategori:'Laporan',         tanggal:'30 Apr 2025', ttd:'Kepala Sekolah', status:'Diterima', lampiran:5 },
  { id:5,  noSurat:'422/041/SMKN71/IV/2025', perihal:'Permohonan Dana BOS Tambahan Semester Ganjil 2025',      tujuan:'Dinas Pendidikan DKI Jakarta',    kategori:'Permohonan',      tanggal:'28 Apr 2025', ttd:'Kepala Sekolah', status:'Terkirim', lampiran:3 },
  { id:6,  noSurat:'005/040/SMKN71/IV/2025', perihal:'Pemberitahuan Perubahan Jadwal Ujian Akhir Semester',    tujuan:'Semua Orang Tua / Wali Siswa',   kategori:'Pemberitahuan',   tanggal:'26 Apr 2025', ttd:'Waka Kurikulum', status:'Terkirim', lampiran:1 },
  { id:7,  noSurat:'421/039/SMKN71/IV/2025', perihal:'Surat Tugas Pembimbing PKL Industri Batch II',           tujuan:'Internal',                        kategori:'Surat Tugas',     tanggal:'24 Apr 2025', ttd:'Kepala Sekolah', status:'Diterima', lampiran:0 },
  { id:8,  noSurat:'DRAFT/038/SMKN71/V/25',  perihal:'Rancangan MoU Kerjasama Industri PT Digital Nusa',       tujuan:'PT Digital Nusa Teknologi',       kategori:'Permohonan',      tanggal:'05 Mei 2025', ttd:'—',              status:'Draft',    lampiran:2 },
])

// ── Disposisi ─────────────────────────────────────────────────────
const disposisiData = computed(() =>
  suratMasukData.value.filter(s => s.disposisiKe && s.status !== 'Selesai')
)

// ── Arsip ─────────────────────────────────────────────────────────
const arsipTahun = ref('2025')
const arsipBulan = ref('Semua')
const arsipJenis = ref('Semua')

const arsipStats = [
  { tahun: '2025', masuk: 128, keluar: 94 },
  { tahun: '2024', masuk: 312, keluar: 267 },
  { tahun: '2023', masuk: 298, keluar: 245 },
  { tahun: '2022', masuk: 189, keluar: 156 },
]

const bulanList = ['Semua','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember']

// ── Filter & Search ───────────────────────────────────────────────
const filterKategoriMasuk = ref('Semua')
const filterKategoriKeluar = ref('Semua')
const searchMasuk  = ref('')
const searchKeluar = ref('')

const filteredMasuk = computed(() =>
  suratMasukData.value.filter(s => {
    const matchKat = filterKategoriMasuk.value === 'Semua' || s.kategori === filterKategoriMasuk.value
    const matchSearch = !searchMasuk.value ||
      s.perihal.toLowerCase().includes(searchMasuk.value.toLowerCase()) ||
      s.pengirim.toLowerCase().includes(searchMasuk.value.toLowerCase()) ||
      s.noSurat.toLowerCase().includes(searchMasuk.value.toLowerCase())
    return matchKat && matchSearch
  })
)

const filteredKeluar = computed(() =>
  suratKeluarData.value.filter(s => {
    const matchKat = filterKategoriKeluar.value === 'Semua' || s.kategori === filterKategoriKeluar.value
    const matchSearch = !searchKeluar.value ||
      s.perihal.toLowerCase().includes(searchKeluar.value.toLowerCase()) ||
      s.tujuan.toLowerCase().includes(searchKeluar.value.toLowerCase()) ||
      s.noSurat.toLowerCase().includes(searchKeluar.value.toLowerCase())
    return matchKat && matchSearch
  })
)

// ── Status helpers ─────────────────────────────────────────────────
const statusMasukColor: Record<Status, string> = {
  'Belum Dibaca': 'bg-red-100 text-red-600',
  'Dibaca':       'bg-yellow-100 text-yellow-700',
  'Diproses':     'bg-blue-100 text-blue-700',
  'Selesai':      'bg-emerald-100 text-emerald-700',
  'Disposisi':    'bg-purple-100 text-purple-700',
}

const statusKeluarColor: Record<string, string> = {
  'Draft':    'bg-gray-100 text-gray-500',
  'Terkirim': 'bg-blue-100 text-blue-700',
  'Diterima': 'bg-emerald-100 text-emerald-700',
}

// ── Modal buat surat ───────────────────────────────────────────────
const showBuatSurat = ref(false)
const formSurat = ref({
  jenis: 'keluar',
  noSurat: '',
  perihal: '',
  tujuan: '',
  kategori: 'Surat Keterangan',
  tanggal: new Date().toISOString().split('T')[0],
  isi: '',
  ttd: 'Kepala Sekolah',
})

// ── Detail modal ───────────────────────────────────────────────────
const selectedSurat = ref<SuratMasuk | SuratKeluar | null>(null)
const selectedJenis = ref<'masuk' | 'keluar'>('masuk')
function openSurat(s: SuratMasuk | SuratKeluar, jenis: 'masuk' | 'keluar') {
  selectedSurat.value = s
  selectedJenis.value = jenis
  // Mark as read
  if (jenis === 'masuk') {
    const sm = s as SuratMasuk
    if (sm.status === 'Belum Dibaca') sm.status = 'Dibaca'
  }
}
function closeDetail() { selectedSurat.value = null }

const unreadCount = computed(() => suratMasukData.value.filter(s => s.status === 'Belum Dibaca').length)
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
          'px-4 py-1.5 rounded-full text-sm font-medium transition-all duration-150 flex items-center gap-1.5 relative',
          activeTab === tab.key
            ? 'text-white shadow-sm tab-active'
            : 'text-gray-500 hover:bg-gray-100 hover:text-gray-700'
        ]"
      >
        <font-awesome-icon :icon="tab.icon" class="text-xs" />
        {{ tab.label }}
        <!-- Unread badge on "masuk" tab -->
        <span
          v-if="tab.key === 'masuk' && unreadCount > 0"
          class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-red-500 text-white text-[9px] font-bold flex items-center justify-center"
        >{{ unreadCount }}</span>
      </button>
    </template>

    <!-- ══ MAIN ══ -->
    <div class="space-y-5">

      <!-- Page Header -->
      <div class="flex items-end justify-between">
        <div>
          <p class="text-xs text-gray-400 font-medium uppercase tracking-widest mb-1">Manajemen</p>
          <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Surat Menyurat</h1>
        </div>
        <div class="flex items-center gap-2">
          <button class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition-colors shadow-sm">
            <font-awesome-icon :icon="['fas', 'print']" class="text-xs" />
            Cetak
          </button>
          <button
            @click="showBuatSurat = true"
            class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white shadow-sm btn-primary"
          >
            <font-awesome-icon :icon="['fas', 'plus']" class="text-xs" />
            Buat Surat
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

      <!-- ═══════════ TAB: SURAT MASUK ═══════════ -->
      <div v-if="activeTab === 'masuk'" class="space-y-4">

        <!-- Filter Bar -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-3.5 flex flex-wrap items-center gap-3">
          <div class="flex items-center gap-2 bg-gray-50 rounded-xl px-3 py-2 flex-1 min-w-52 border border-gray-200">
            <font-awesome-icon :icon="['fas', 'search']" class="text-gray-400 text-xs" />
            <input v-model="searchMasuk" type="text" placeholder="Cari perihal, pengirim, nomor surat..." class="flex-1 text-sm bg-transparent focus:outline-none text-gray-700 placeholder-gray-400" />
          </div>
          <select v-model="filterKategoriMasuk" class="text-sm border border-gray-200 rounded-xl px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none cursor-pointer">
            <option v-for="k in kategoriMasuk" :key="k">{{ k }}</option>
          </select>
          <select class="text-sm border border-gray-200 rounded-xl px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none cursor-pointer">
            <option>Semua Status</option>
            <option>Belum Dibaca</option>
            <option>Dibaca</option>
            <option>Diproses</option>
            <option>Selesai</option>
          </select>
          <button class="flex items-center gap-1.5 text-sm font-semibold px-3 py-2 rounded-xl text-white btn-primary">
            <font-awesome-icon :icon="['fas', 'filter']" class="text-xs" />
            Filter
          </button>
        </div>

        <!-- Surat Masuk Table -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
          <div class="flex items-center justify-between px-5 py-4 border-b border-gray-50">
            <div>
              <h2 class="text-sm font-bold text-gray-900">Daftar Surat Masuk</h2>
              <p class="text-xs text-gray-400">{{ filteredMasuk.length }} surat · <span class="text-red-500 font-semibold">{{ unreadCount }} belum dibaca</span></p>
            </div>
            <button class="flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-orange-500 transition-colors">
              <font-awesome-icon :icon="['fas', 'download']" />
              Export Excel
            </button>
          </div>

          <div class="divide-y divide-gray-50">
            <div
              v-for="s in filteredMasuk"
              :key="s.id"
              class="flex items-start gap-4 px-5 py-4 hover:bg-orange-50/30 transition-colors cursor-pointer group"
              :class="{ 'bg-blue-50/30': s.status === 'Belum Dibaca' }"
              @click="openSurat(s, 'masuk')"
            >
              <!-- Unread dot -->
              <div class="w-2 h-2 rounded-full mt-2 flex-shrink-0" :class="s.status === 'Belum Dibaca' ? 'bg-blue-500' : 'bg-transparent'"></div>

              <!-- Icon -->
              <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0"
                :class="s.urgent ? 'bg-red-50 border border-red-200' : 'bg-gray-50 border border-gray-200'"
              >
                <font-awesome-icon
                  :icon="s.urgent ? ['fas', 'circle-exclamation'] : ['fas', 'envelope']"
                  :class="s.urgent ? 'text-red-500' : 'text-gray-400'"
                />
              </div>

              <!-- Content -->
              <div class="flex-1 min-w-0">
                <div class="flex items-start gap-3 mb-1">
                  <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-0.5">
                      <span v-if="s.urgent" class="text-xs font-bold px-1.5 py-0.5 rounded bg-red-500 text-white leading-none">URGENT</span>
                      <p :class="['text-sm truncate', s.status === 'Belum Dibaca' ? 'font-bold text-gray-900' : 'font-semibold text-gray-700']">
                        {{ s.perihal }}
                      </p>
                    </div>
                    <div class="flex items-center gap-3 text-xs text-gray-400">
                      <span class="flex items-center gap-1">
                        <font-awesome-icon :icon="['fas', 'building']" class="text-gray-300" />
                        {{ s.pengirim }}
                      </span>
                      <span>·</span>
                      <span class="font-mono text-gray-400">{{ s.noSurat }}</span>
                    </div>
                  </div>

                  <!-- Right meta -->
                  <div class="flex flex-col items-end gap-1.5 flex-shrink-0">
                    <span :class="['text-xs font-semibold px-2 py-0.5 rounded-full', statusMasukColor[s.status]]">{{ s.status }}</span>
                    <span class="text-xs text-gray-400">{{ s.tanggal }}</span>
                  </div>
                </div>

                <!-- Sub info -->
                <div class="flex items-center gap-3 mt-1.5">
                  <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-gray-100 text-gray-500">{{ s.kategori }}</span>
                  <span v-if="s.lampiran > 0" class="flex items-center gap-1 text-xs text-gray-400">
                    <font-awesome-icon :icon="['fas', 'paperclip']" class="text-gray-300" />
                    {{ s.lampiran }} lampiran
                  </span>
                  <span v-if="s.disposisiKe" class="flex items-center gap-1 text-xs text-purple-600 font-medium">
                    <font-awesome-icon :icon="['fas', 'arrow-right']" class="text-xs" />
                    Disposisi → {{ s.disposisiKe }}
                  </span>
                </div>
              </div>

              <!-- Action on hover -->
              <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity flex-shrink-0">
                <button class="w-7 h-7 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center hover:bg-blue-100 transition-colors" title="Disposisi">
                  <font-awesome-icon :icon="['fas', 'arrow-right-arrow-left']" class="text-xs" />
                </button>
                <button class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-500 flex items-center justify-center hover:bg-emerald-100 transition-colors" title="Tandai Selesai">
                  <font-awesome-icon :icon="['fas', 'check']" class="text-xs" />
                </button>
                <button class="w-7 h-7 rounded-lg bg-gray-50 text-gray-400 flex items-center justify-center hover:bg-gray-100 transition-colors" title="Arsip">
                  <font-awesome-icon :icon="['fas', 'box-archive']" class="text-xs" />
                </button>
              </div>
            </div>
          </div>

          <!-- Pagination -->
          <div class="flex items-center justify-between px-5 py-3 border-t border-gray-50 bg-gray-50/50">
            <span class="text-xs text-gray-400">Menampilkan {{ filteredMasuk.length }} dari {{ suratMasukData.length }} surat</span>
            <div class="flex items-center gap-1">
              <button class="w-7 h-7 rounded-lg border border-gray-200 bg-white flex items-center justify-center text-gray-400 hover:border-orange-300">
                <font-awesome-icon :icon="['fas', 'chevron-left']" class="text-xs" />
              </button>
              <button class="w-7 h-7 rounded-lg text-white text-xs font-bold btn-primary">1</button>
              <button class="w-7 h-7 rounded-lg border border-gray-200 bg-white text-gray-500 text-xs font-medium hover:border-orange-300">2</button>
              <button class="w-7 h-7 rounded-lg border border-gray-200 bg-white flex items-center justify-center text-gray-400 hover:border-orange-300">
                <font-awesome-icon :icon="['fas', 'chevron-right']" class="text-xs" />
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- ═══════════ TAB: SURAT KELUAR ═══════════ -->
      <div v-if="activeTab === 'keluar'" class="space-y-4">

        <!-- Filter Bar -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-3.5 flex flex-wrap items-center gap-3">
          <div class="flex items-center gap-2 bg-gray-50 rounded-xl px-3 py-2 flex-1 min-w-52 border border-gray-200">
            <font-awesome-icon :icon="['fas', 'search']" class="text-gray-400 text-xs" />
            <input v-model="searchKeluar" type="text" placeholder="Cari perihal, tujuan, nomor surat..." class="flex-1 text-sm bg-transparent focus:outline-none text-gray-700 placeholder-gray-400" />
          </div>
          <select v-model="filterKategoriKeluar" class="text-sm border border-gray-200 rounded-xl px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none cursor-pointer">
            <option v-for="k in kategoriKeluar" :key="k">{{ k }}</option>
          </select>
          <button @click="showBuatSurat = true" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-white btn-primary shadow-sm">
            <font-awesome-icon :icon="['fas', 'plus']" class="text-xs" />
            Buat Surat Baru
          </button>
        </div>

        <!-- Surat Keluar Table -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
          <div class="flex items-center justify-between px-5 py-4 border-b border-gray-50">
            <div>
              <h2 class="text-sm font-bold text-gray-900">Daftar Surat Keluar</h2>
              <p class="text-xs text-gray-400">{{ filteredKeluar.length }} surat tercatat</p>
            </div>
          </div>

          <table class="w-full text-sm">
            <thead>
              <tr class="bg-gray-50 border-b border-gray-100">
                <th class="text-left px-5 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider w-10">#</th>
                <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">No. Surat</th>
                <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Perihal</th>
                <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tujuan</th>
                <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                <th class="text-left px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal</th>
                <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">TTD</th>
                <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                <th class="text-center px-3 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
              <tr
                v-for="s in filteredKeluar"
                :key="s.id"
                class="hover:bg-orange-50/30 transition-colors cursor-pointer"
                @click="openSurat(s, 'keluar')"
              >
                <td class="px-5 py-3 text-xs text-gray-400">{{ s.id }}</td>
                <td class="px-3 py-3 text-xs font-mono text-gray-500 max-w-[140px]">
                  <p class="truncate">{{ s.noSurat }}</p>
                </td>
                <td class="px-3 py-3 max-w-[220px]">
                  <p class="text-sm font-semibold text-gray-800 truncate">{{ s.perihal }}</p>
                </td>
                <td class="px-3 py-3 text-sm text-gray-600 max-w-[160px]">
                  <p class="truncate">{{ s.tujuan }}</p>
                </td>
                <td class="px-3 py-3">
                  <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-orange-50 text-orange-600 border border-orange-100">{{ s.kategori }}</span>
                </td>
                <td class="px-3 py-3 text-xs text-gray-500">{{ s.tanggal }}</td>
                <td class="px-3 py-3 text-center text-xs text-gray-500">{{ s.ttd }}</td>
                <td class="px-3 py-3 text-center">
                  <span :class="['text-xs font-semibold px-2 py-0.5 rounded-full', statusKeluarColor[s.status]]">{{ s.status }}</span>
                </td>
                <td class="px-3 py-3 text-center" @click.stop>
                  <div class="flex items-center justify-center gap-1">
                    <button class="w-7 h-7 rounded-lg bg-orange-50 text-orange-500 flex items-center justify-center hover:bg-orange-100 transition-colors" title="Lihat">
                      <font-awesome-icon :icon="['fas', 'eye']" class="text-xs" />
                    </button>
                    <button class="w-7 h-7 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center hover:bg-blue-100 transition-colors" title="Edit">
                      <font-awesome-icon :icon="['fas', 'pen']" class="text-xs" />
                    </button>
                    <button class="w-7 h-7 rounded-lg bg-gray-50 text-gray-400 flex items-center justify-center hover:bg-gray-100 transition-colors" title="Cetak">
                      <font-awesome-icon :icon="['fas', 'print']" class="text-xs" />
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- ═══════════ TAB: DISPOSISI ═══════════ -->
      <div v-if="activeTab === 'disposisi'" class="space-y-4">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
          <div class="px-5 py-4 border-b border-gray-50 flex items-center justify-between">
            <div>
              <h2 class="text-sm font-bold text-gray-900">Surat dalam Proses Disposisi</h2>
              <p class="text-xs text-gray-400">{{ disposisiData.length }} surat aktif menunggu tindak lanjut</p>
            </div>
          </div>

          <div class="divide-y divide-gray-50">
            <div
              v-for="s in disposisiData"
              :key="s.id"
              class="px-5 py-4 hover:bg-purple-50/20 transition-colors"
            >
              <div class="flex items-start gap-4">
                <!-- Icon -->
                <div class="w-10 h-10 rounded-xl bg-purple-50 border border-purple-100 flex items-center justify-center flex-shrink-0">
                  <font-awesome-icon :icon="['fas', 'arrow-right-arrow-left']" class="text-purple-500" />
                </div>
                <!-- Content -->
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-bold text-gray-800 mb-0.5 truncate">{{ s.perihal }}</p>
                  <p class="text-xs text-gray-500 mb-2">{{ s.pengirim }} · {{ s.noSurat }}</p>
                  <!-- Disposisi chain -->
                  <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-xs font-semibold px-2 py-1 rounded-lg bg-blue-50 text-blue-700 border border-blue-100">
                      <font-awesome-icon :icon="['fas', 'envelope']" class="mr-1" />
                      Diterima Sekolah
                    </span>
                    <font-awesome-icon :icon="['fas', 'chevron-right']" class="text-gray-300 text-xs" />
                    <span class="text-xs font-semibold px-2 py-1 rounded-lg bg-orange-50 text-orange-600 border border-orange-100">
                      <font-awesome-icon :icon="['fas', 'user-tie']" class="mr-1" />
                      Kepala Sekolah
                    </span>
                    <font-awesome-icon :icon="['fas', 'chevron-right']" class="text-gray-300 text-xs" />
                    <span class="text-xs font-semibold px-2 py-1 rounded-lg bg-purple-50 text-purple-700 border border-purple-100">
                      <font-awesome-icon :icon="['fas', 'arrow-right']" class="mr-1" />
                      {{ s.disposisiKe }}
                    </span>
                    <span class="text-xs font-medium px-2 py-1 rounded-lg bg-yellow-50 text-yellow-600 border border-yellow-100">
                      <font-awesome-icon :icon="['fas', 'clock']" class="mr-1" />
                      Menunggu Tindak Lanjut
                    </span>
                  </div>
                </div>
                <!-- Meta -->
                <div class="flex flex-col items-end gap-2 flex-shrink-0">
                  <span class="text-xs text-gray-400">{{ s.tanggal }}</span>
                  <span :class="['text-xs font-semibold px-2 py-0.5 rounded-full', s.urgent ? 'bg-red-100 text-red-600' : 'bg-gray-100 text-gray-500']">
                    {{ s.urgent ? 'URGENT' : s.kategori }}
                  </span>
                  <div class="flex gap-1">
                    <button class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 transition-colors">
                      Selesai
                    </button>
                    <button class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors">
                      Forward
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div v-if="!disposisiData.length" class="px-5 py-12 text-center">
              <font-awesome-icon :icon="['fas', 'inbox']" class="text-gray-200 text-4xl mb-3 block mx-auto" />
              <p class="text-sm text-gray-400 font-medium">Tidak ada surat dalam proses disposisi</p>
            </div>
          </div>
        </div>
      </div>

      <!-- ═══════════ TAB: ARSIP ═══════════ -->
      <div v-if="activeTab === 'arsip'" class="space-y-4">

        <!-- Arsip Stats Banner -->
        <div class="rounded-2xl overflow-hidden relative px-6 py-5" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);">
          <div class="absolute top-0 right-0 w-64 h-full opacity-5" style="background: radial-gradient(circle at right, #f5762d, transparent 70%);"></div>
          <div class="relative z-10 flex items-center justify-between">
            <div>
              <p class="text-xs font-semibold uppercase tracking-widest mb-1" style="color: rgba(255,255,255,0.4);">Total Dokumen Terarsip</p>
              <p class="text-4xl font-black text-white tracking-tight">389</p>
              <p class="text-xs mt-1 font-medium" style="color: rgba(255,255,255,0.4);">Sejak Tahun Ajaran 2022/2023</p>
            </div>
            <div class="flex items-center gap-6">
              <div v-for="y in arsipStats" :key="y.tahun" class="text-center">
                <p class="text-lg font-black" :style="{ color: y.tahun === '2025' ? '#f5762d' : 'rgba(255,255,255,0.8)' }">{{ y.masuk + y.keluar }}</p>
                <p class="text-xs font-semibold" style="color: rgba(255,255,255,0.4);">{{ y.tahun }}</p>
                <div class="flex gap-1 mt-1 justify-center">
                  <span class="text-xs px-1.5 py-0.5 rounded bg-blue-500/30 text-blue-300 font-medium">{{ y.masuk }}M</span>
                  <span class="text-xs px-1.5 py-0.5 rounded font-medium" style="background: rgba(245,118,45,0.2); color: #f5762d;">{{ y.keluar }}K</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Filter Arsip -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-5 py-3.5 flex flex-wrap items-center gap-3">
          <select v-model="arsipTahun" class="text-sm border border-gray-200 rounded-xl px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none cursor-pointer">
            <option v-for="y in arsipStats" :key="y.tahun">{{ y.tahun }}</option>
          </select>
          <select v-model="arsipBulan" class="text-sm border border-gray-200 rounded-xl px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none cursor-pointer">
            <option v-for="b in bulanList" :key="b">{{ b }}</option>
          </select>
          <select v-model="arsipJenis" class="text-sm border border-gray-200 rounded-xl px-3 py-2 bg-gray-50 text-gray-700 focus:outline-none cursor-pointer">
            <option>Semua</option>
            <option>Surat Masuk</option>
            <option>Surat Keluar</option>
          </select>
          <div class="flex-1"></div>
          <button class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 shadow-sm">
            <font-awesome-icon :icon="['fas', 'file-zipper']" class="text-gray-400" />
            Unduh Arsip
          </button>
        </div>

        <!-- Arsip per bulan grid -->
        <div class="grid grid-cols-3 xl:grid-cols-4 gap-3">
          <div
            v-for="(bln, idx) in bulanList.slice(1)"
            :key="bln"
            class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 hover:shadow-md hover:border-orange-200 transition-all cursor-pointer"
          >
            <div class="flex items-center justify-between mb-3">
              <span class="text-sm font-bold text-gray-800">{{ bln }}</span>
              <span class="text-xs font-bold text-gray-400">{{ arsipTahun }}</span>
            </div>
            <div class="space-y-1.5">
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-1.5">
                  <div class="w-2 h-2 rounded-full bg-blue-400"></div>
                  <span class="text-xs text-gray-500">Masuk</span>
                </div>
                <span class="text-xs font-bold text-gray-700">{{ [12,8,15,10,11,14,9,16,13,11,8,10][idx] || 0 }}</span>
              </div>
              <div class="flex items-center justify-between">
                <div class="flex items-center gap-1.5">
                  <div class="w-2 h-2 rounded-full" style="background: #f5762d"></div>
                  <span class="text-xs text-gray-500">Keluar</span>
                </div>
                <span class="text-xs font-bold text-gray-700">{{ [9,7,11,8,9,12,7,13,10,9,6,9][idx] || 0 }}</span>
              </div>
            </div>
            <div class="mt-2.5 pt-2.5 border-t border-gray-50">
              <div class="flex items-center justify-between">
                <span class="text-xs text-gray-400">Total</span>
                <span class="text-xs font-black" style="color: #f5762d;">
                  {{ ([12,8,15,10,11,14,9,16,13,11,8,10][idx] || 0) + ([9,7,11,8,9,12,7,13,10,9,6,9][idx] || 0) }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div><!-- end space-y-5 -->

    <!-- ══════════════════════════════════════════════
         MODAL: BUAT SURAT
    ══════════════════════════════════════════════ -->
    <Teleport to="body">
      <div
        v-if="showBuatSurat"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);"
        @click.self="showBuatSurat = false"
      >
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-xl animate-modal overflow-hidden">
          <!-- Header -->
          <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between" style="background: linear-gradient(90deg, #fff8f4, #ffffff);">
            <div>
              <h2 class="text-base font-black text-gray-900">Buat Surat Baru</h2>
              <p class="text-xs text-gray-400 mt-0.5">Isi formulir pembuatan surat di bawah ini</p>
            </div>
            <button @click="showBuatSurat = false" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 hover:bg-gray-200 transition-colors">
              <font-awesome-icon :icon="['fas', 'xmark']" />
            </button>
          </div>

          <!-- Form -->
          <div class="p-6 space-y-4 overflow-y-auto max-h-[70vh]">

            <!-- Jenis toggle -->
            <div>
              <label class="text-xs font-bold text-gray-600 uppercase tracking-wider block mb-2">Jenis Surat</label>
              <div class="flex gap-2">
                <button
                  @click="formSurat.jenis = 'keluar'"
                  :class="['flex-1 py-2.5 rounded-xl text-sm font-semibold transition-all border', formSurat.jenis === 'keluar' ? 'text-white btn-primary border-transparent' : 'bg-gray-50 text-gray-600 border-gray-200 hover:border-orange-200']"
                >
                  <font-awesome-icon :icon="['fas', 'paper-plane']" class="mr-2" />
                  Surat Keluar
                </button>
                <button
                  @click="formSurat.jenis = 'masuk'"
                  :class="['flex-1 py-2.5 rounded-xl text-sm font-semibold transition-all border', formSurat.jenis === 'masuk' ? 'text-white btn-primary border-transparent' : 'bg-gray-50 text-gray-600 border-gray-200 hover:border-orange-200']"
                >
                  <font-awesome-icon :icon="['fas', 'inbox']" class="mr-2" />
                  Input Surat Masuk
                </button>
              </div>
            </div>

            <!-- Nomor Surat -->
            <div>
              <label class="text-xs font-bold text-gray-600 uppercase tracking-wider block mb-1.5">Nomor Surat</label>
              <input
                v-model="formSurat.noSurat"
                type="text"
                :placeholder="formSurat.jenis === 'keluar' ? 'Cth: 422/001/SMKN71/V/2025' : 'Nomor surat dari pengirim'"
                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-orange-400 bg-gray-50 text-gray-700"
              />
            </div>

            <!-- Perihal -->
            <div>
              <label class="text-xs font-bold text-gray-600 uppercase tracking-wider block mb-1.5">Perihal</label>
              <input
                v-model="formSurat.perihal"
                type="text"
                placeholder="Masukkan perihal surat..."
                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-orange-400 bg-gray-50 text-gray-700"
              />
            </div>

            <!-- Tujuan / Pengirim -->
            <div>
              <label class="text-xs font-bold text-gray-600 uppercase tracking-wider block mb-1.5">
                {{ formSurat.jenis === 'keluar' ? 'Ditujukan Kepada' : 'Pengirim' }}
              </label>
              <input
                v-model="formSurat.tujuan"
                type="text"
                :placeholder="formSurat.jenis === 'keluar' ? 'Nama instansi / penerima...' : 'Nama pengirim / instansi...'"
                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-orange-400 bg-gray-50 text-gray-700"
              />
            </div>

            <!-- Kategori & Tanggal -->
            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="text-xs font-bold text-gray-600 uppercase tracking-wider block mb-1.5">Kategori</label>
                <select
                  v-model="formSurat.kategori"
                  class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-orange-400 bg-gray-50 text-gray-700 cursor-pointer"
                >
                  <option v-for="k in (formSurat.jenis === 'keluar' ? kategoriKeluar.slice(1) : kategoriMasuk.slice(1))" :key="k">{{ k }}</option>
                </select>
              </div>
              <div>
                <label class="text-xs font-bold text-gray-600 uppercase tracking-wider block mb-1.5">Tanggal</label>
                <input
                  v-model="formSurat.tanggal"
                  type="date"
                  class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-orange-400 bg-gray-50 text-gray-700"
                />
              </div>
            </div>

            <!-- TTD (keluar only) -->
            <div v-if="formSurat.jenis === 'keluar'">
              <label class="text-xs font-bold text-gray-600 uppercase tracking-wider block mb-1.5">Penanda Tangan</label>
              <select
                v-model="formSurat.ttd"
                class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-orange-400 bg-gray-50 text-gray-700 cursor-pointer"
              >
                <option>Kepala Sekolah</option>
                <option>Waka Kurikulum</option>
                <option>Waka Kesiswaan</option>
                <option>Waka Humas</option>
                <option>Waka Sarpras</option>
              </select>
            </div>

            <!-- Isi Surat -->
            <div>
              <label class="text-xs font-bold text-gray-600 uppercase tracking-wider block mb-1.5">Keterangan / Isi Singkat</label>
              <textarea
                v-model="formSurat.isi"
                rows="4"
                placeholder="Tuliskan keterangan atau isi singkat surat..."
                class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-orange-400 bg-gray-50 text-gray-700 resize-none"
              ></textarea>
            </div>

            <!-- Lampiran -->
            <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center hover:border-orange-300 transition-colors cursor-pointer hover:bg-orange-50/20">
              <font-awesome-icon :icon="['fas', 'paperclip']" class="text-gray-300 text-xl mb-2 block mx-auto" />
              <p class="text-xs font-semibold text-gray-400">Klik untuk lampirkan file</p>
              <p class="text-xs text-gray-300 mt-0.5">PDF, DOC, JPG — maks. 10MB</p>
            </div>
          </div>

          <!-- Footer -->
          <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-between bg-gray-50/50">
            <button @click="showBuatSurat = false" class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-100 transition-colors">
              Batal
            </button>
            <div class="flex gap-2">
              <button class="px-5 py-2.5 rounded-xl text-sm font-semibold text-gray-700 bg-white border border-gray-200 hover:bg-gray-100 transition-colors">
                <font-awesome-icon :icon="['fas', 'floppy-disk']" class="mr-1.5 text-gray-400" />
                Simpan Draft
              </button>
              <button class="px-5 py-2.5 rounded-xl text-sm font-semibold text-white btn-primary shadow-sm">
                <font-awesome-icon :icon="['fas', 'paper-plane']" class="mr-1.5" />
                {{ formSurat.jenis === 'keluar' ? 'Kirim Surat' : 'Simpan' }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </Teleport>

    <!-- ══════════════════════════════════════════════
         MODAL: DETAIL SURAT
    ══════════════════════════════════════════════ -->
    <Teleport to="body">
      <div
        v-if="selectedSurat"
        class="fixed inset-0 z-50 flex items-center justify-center p-4"
        style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);"
        @click.self="closeDetail"
      >
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg animate-modal overflow-hidden">
          <!-- Header -->
          <div class="px-6 py-5 flex items-start justify-between border-b border-gray-100" :class="selectedJenis === 'masuk' ? 'bg-blue-50/60' : 'bg-orange-50/60'">
            <div class="flex items-center gap-3">
              <div :class="['w-11 h-11 rounded-2xl flex items-center justify-center', selectedJenis === 'masuk' ? 'bg-blue-100' : 'bg-orange-100']">
                <font-awesome-icon :icon="selectedJenis === 'masuk' ? ['fas', 'inbox'] : ['fas', 'paper-plane']" :class="selectedJenis === 'masuk' ? 'text-blue-500 text-lg' : 'text-orange-500 text-lg'" />
              </div>
              <div>
                <p class="text-xs font-semibold uppercase tracking-wider" :class="selectedJenis === 'masuk' ? 'text-blue-500' : 'text-orange-500'">
                  {{ selectedJenis === 'masuk' ? 'Surat Masuk' : 'Surat Keluar' }}
                </p>
                <p class="text-sm font-mono font-semibold text-gray-600 mt-0.5">{{ selectedSurat.noSurat }}</p>
              </div>
            </div>
            <button @click="closeDetail" class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-400 hover:bg-gray-100 transition-colors">
              <font-awesome-icon :icon="['fas', 'xmark']" />
            </button>
          </div>

          <!-- Body -->
          <div class="p-6 space-y-4">
            <h3 class="text-base font-bold text-gray-900 leading-snug">{{ selectedSurat.perihal }}</h3>

            <div class="grid grid-cols-2 gap-3">
              <div class="bg-gray-50 rounded-2xl p-3.5">
                <p class="text-xs text-gray-400 mb-1">{{ selectedJenis === 'masuk' ? 'Pengirim' : 'Ditujukan Kepada' }}</p>
                <p class="text-sm font-bold text-gray-800">{{ (selectedSurat as SuratMasuk).pengirim ?? (selectedSurat as SuratKeluar).tujuan }}</p>
              </div>
              <div class="bg-gray-50 rounded-2xl p-3.5">
                <p class="text-xs text-gray-400 mb-1">Tanggal Surat</p>
                <p class="text-sm font-bold text-gray-800">{{ selectedSurat.tanggal }}</p>
              </div>
              <div class="bg-gray-50 rounded-2xl p-3.5">
                <p class="text-xs text-gray-400 mb-1">Kategori</p>
                <p class="text-sm font-bold text-gray-800">{{ selectedSurat.kategori }}</p>
              </div>
              <div class="bg-gray-50 rounded-2xl p-3.5">
                <p class="text-xs text-gray-400 mb-1">Status</p>
                <span :class="[
                  'text-xs font-bold px-2 py-0.5 rounded-full',
                  selectedJenis === 'masuk'
                    ? statusMasukColor[(selectedSurat as SuratMasuk).status]
                    : statusKeluarColor[(selectedSurat as SuratKeluar).status]
                ]">
                  {{ (selectedSurat as SuratMasuk).status ?? (selectedSurat as SuratKeluar).status }}
                </span>
              </div>
            </div>

            <!-- Lampiran -->
            <div v-if="(selectedSurat as SuratMasuk).lampiran > 0" class="flex items-center gap-2 bg-gray-50 rounded-2xl p-3.5">
              <font-awesome-icon :icon="['fas', 'paperclip']" class="text-gray-400" />
              <span class="text-sm text-gray-600 font-medium">{{ (selectedSurat as SuratMasuk).lampiran }} file lampiran</span>
              <button class="ml-auto text-xs font-semibold text-orange-500 hover:underline">Unduh</button>
            </div>

            <!-- Disposisi info -->
            <div v-if="(selectedSurat as SuratMasuk).disposisiKe" class="flex items-center gap-2 bg-purple-50 rounded-2xl p-3.5 border border-purple-100">
              <font-awesome-icon :icon="['fas', 'arrow-right-arrow-left']" class="text-purple-500" />
              <span class="text-sm text-purple-700 font-medium">Disposisi ke: <strong>{{ (selectedSurat as SuratMasuk).disposisiKe }}</strong></span>
            </div>
          </div>

          <!-- Footer actions -->
          <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 flex gap-2">
            <button v-if="selectedJenis === 'masuk'" class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-white btn-primary">
              <font-awesome-icon :icon="['fas', 'arrow-right-arrow-left']" class="mr-1.5" />
              Disposisi
            </button>
            <button class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-gray-700 bg-white border border-gray-200 hover:bg-gray-100 transition-colors">
              <font-awesome-icon :icon="['fas', 'print']" class="mr-1.5 text-gray-400" />
              Cetak
            </button>
            <button class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-gray-700 bg-white border border-gray-200 hover:bg-gray-100 transition-colors">
              <font-awesome-icon :icon="['fas', 'box-archive']" class="mr-1.5 text-gray-400" />
              Arsip
            </button>
          </div>
        </div>
      </div>
    </Teleport>

  </SchoolLayout>
</template>

<style scoped>
* { box-sizing: border-box; }

.btn-primary { background: #f5762d; transition: background 0.15s; }
.btn-primary:hover { background: #e05a15; }
.tab-active { background: #f5762d; }

@keyframes modal-in {
  from { opacity: 0; transform: scale(0.94) translateY(12px); }
  to   { opacity: 1; transform: scale(1) translateY(0); }
}
.animate-modal { animation: modal-in 0.2s ease; }
</style>