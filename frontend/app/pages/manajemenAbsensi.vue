<!-- app/pages/manajemen-absensi.vue -->
<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue'

definePageMeta({
  layout: 'school'
})

// State
const selectedKelas = ref('XII RPL 1')
const selectedDate = ref(new Date().toISOString().slice(0, 10))
const activeTab = ref('rekap')
const searchQuery = ref('')

// Data
const kelasList = ref([
  'X RPL 1', 'X RPL 2', 'XI RPL 1', 'XI RPL 2', 'XII RPL 1', 'XII RPL 2',
  'X DKV 1', 'X DKV 2', 'XI DKV 1', 'XI DKV 2', 'XII DKV 1', 'XII DKV 2',
  'X Animasi 1', 'X Animasi 2', 'XI Animasi 1', 'XI Animasi 2', 'XII Animasi 1', 'XII Animasi 2',
])

const siswaList = ref([
  { no: 1, nis: '2401001', nama: 'Ade Firmansyah', status: 'hadir', jam: '06:52', ket: '' },
  { no: 2, nis: '2401002', nama: 'Bella Anggraini', status: 'hadir', jam: '07:05', ket: '' },
  { no: 3, nis: '2401003', nama: 'Cahyo Pratama', status: 'izin', jam: '-', ket: 'Keperluan keluarga' },
  { no: 4, nis: '2401004', nama: 'Dina Rahayu', status: 'hadir', jam: '06:58', ket: '' },
  { no: 5, nis: '2401005', nama: 'Eko Setiawan', status: 'sakit', jam: '-', ket: 'Surat dokter' },
  { no: 6, nis: '2401006', nama: 'Fitri Nuraini', status: 'hadir', jam: '07:10', ket: '' },
  { no: 7, nis: '2401007', nama: 'Gilang Permana', status: 'alpha', jam: '-', ket: '' },
  { no: 8, nis: '2401008', nama: 'Hana Kusumawati', status: 'hadir', jam: '07:01', ket: '' },
  { no: 9, nis: '2401009', nama: 'Ilham Maulana', status: 'hadir', jam: '06:55', ket: '' },
  { no: 10, nis: '2401010', nama: 'Joko Susilo', status: 'terlambat', jam: '07:32', ket: 'Telat 32 menit' },
])

// Filtered siswa based on search
const filteredSiswa = computed(() => {
  if (!searchQuery.value) return siswaList.value
  const query = searchQuery.value.toLowerCase()
  return siswaList.value.filter(s => 
    s.nama.toLowerCase().includes(query) || 
    s.nis.includes(query)
  )
})

// Stats computed
const stats = computed(() => {
  const total = siswaList.value.length
  const hadir = siswaList.value.filter(s => s.status === 'hadir').length
  const izin = siswaList.value.filter(s => s.status === 'izin').length
  const sakit = siswaList.value.filter(s => s.status === 'sakit').length
  const alpha = siswaList.value.filter(s => s.status === 'alpha').length
  
  return [
    { label: 'Hadir', value: hadir, total: total, color: '#22c55e', bg: '#f0fdf4', border: '#bbf7d0', pct: ((hadir/total)*100).toFixed(1) },
    { label: 'Izin', value: izin, total: total, color: '#3b82f6', bg: '#eff6ff', border: '#bfdbfe', pct: ((izin/total)*100).toFixed(1) },
    { label: 'Sakit', value: sakit, total: total, color: '#f59e0b', bg: '#fffbeb', border: '#fde68a', pct: ((sakit/total)*100).toFixed(1) },
    { label: 'Alpha', value: alpha, total: total, color: '#ef4444', bg: '#fef2f2', border: '#fecaca', pct: ((alpha/total)*100).toFixed(1) },
  ]
})

const tabs = ref([
  { key: 'rekap', label: 'Rekap Harian', icon: 'chart-line' },
  { key: 'input', label: 'Input Absensi', icon: 'pen' },
  { key: 'laporan', label: 'Laporan Bulanan', icon: 'file-alt' },
  { key: 'terlambat', label: 'Keterlambatan', icon: 'clock' },
])

const weeklyTrend = ref([
  { day: 'Sen', hadir: 34, alpha: 2, total: 36 },
  { day: 'Sel', hadir: 33, alpha: 3, total: 36 },
  { day: 'Rab', hadir: 35, alpha: 1, total: 36 },
  { day: 'Kam', hadir: 31, alpha: 5, total: 36 },
  { day: 'Jum', hadir: 36, alpha: 0, total: 36 },
])

const statusColor = ref<Record<string, string>>({
  hadir: 'bg-green-100 text-green-700',
  izin: 'bg-blue-100 text-blue-700',
  sakit: 'bg-yellow-100 text-yellow-700',
  alpha: 'bg-red-100 text-red-700',
  terlambat: 'bg-orange-100 text-orange-700',
})

const statusLabel = ref<Record<string, string>>({
  hadir: 'Hadir',
  izin: 'Izin',
  sakit: 'Sakit',
  alpha: 'Alpha',
  terlambat: 'Terlambat'
})

const today = computed(() => {
  return new Date().toLocaleDateString('id-ID', { 
    weekday: 'long', 
    year: 'numeric', 
    month: 'long', 
    day: 'numeric' 
  })
})

// Methods
const inputAbsensi = () => {
  console.log('Input absensi clicked')
}

const exportData = () => {
  console.log('Export data clicked')
}

const editSiswa = (siswa: any) => {
  console.log('Edit siswa:', siswa)
}

const deleteSiswa = (siswa: any) => {
  console.log('Delete siswa:', siswa)
}

// Watch for changes
watch([selectedKelas, selectedDate], () => {
  console.log('Fetching data for:', selectedKelas.value, selectedDate.value)
})

onMounted(() => {
  console.log('Page mounted')
})
</script>

<template>
  <div class="abs-page">
    <div class="page-content">
      <!-- Header Actions -->
      <div class="page-header">
        <div class="filters">
          <div class="filter-item">
            <font-awesome-icon :icon="['fas', 'school']" />
            <select v-model="selectedKelas" class="filter-select">
              <option 
                v-for="(k, index) in kelasList" 
                :key="index" 
                :value="k"
              >
                {{ k }}
              </option>
            </select>
          </div>
          
          <div class="filter-item">
            <font-awesome-icon :icon="['fas', 'calendar-alt']" />
            <input 
              type="date" 
              v-model="selectedDate" 
              class="filter-input" 
            />
          </div>
        </div>
        
        <div class="actions">
          <button class="btn-primary" @click="inputAbsensi">
            <font-awesome-icon :icon="['fas', 'plus']" />
            Input Absensi
          </button>
          <button class="btn-secondary" @click="exportData">
            <font-awesome-icon :icon="['fas', 'download']" />
            Export
          </button>
        </div>
      </div>

      <!-- Tabs -->
      <div class="tabs-wrapper">
        <button
          v-for="(tab, index) in tabs"
          :key="index"
          @click="activeTab = tab.key"
          :class="['tab-button', { 'tab-button--active': activeTab === tab.key }]"
        >
          <font-awesome-icon :icon="['fas', tab.icon]" />
          {{ tab.label }}
        </button>
      </div>

      <!-- Content Grid -->
      <div class="content-grid">
        <!-- Main Content Area -->
        <div class="main-area">
          <!-- Statistics Cards -->
          <div class="stats-grid">
            <div
              v-for="(stat, index) in stats"
              :key="index"
              class="stat-card"
              :style="{ borderColor: stat.border, backgroundColor: stat.bg }"
            >
              <div class="stat-header">
                <span class="stat-label" :style="{ color: stat.color }">
                  {{ stat.label }}
                </span>
                <span class="stat-percentage" :style="{ color: stat.color }">
                  {{ stat.pct }}%
                </span>
              </div>
              <div class="stat-value" :style="{ color: stat.color }">
                {{ stat.value }}
              </div>
              <div class="stat-total">
                dari {{ stat.total }} siswa
              </div>
              <div class="stat-bar">
                <div 
                  class="stat-bar-fill" 
                  :style="{ 
                    width: `${stat.pct}%`, 
                    backgroundColor: stat.color 
                  }"
                ></div>
              </div>
            </div>
          </div>

          <!-- Attendance Table -->
          <div class="card">
            <div class="card-header">
              <div>
                <h3 class="card-title">
                  Daftar Absensi — {{ selectedKelas }}
                </h3>
                <p class="card-subtitle">{{ today }}</p>
              </div>
              <div class="search-box">
                <font-awesome-icon :icon="['fas', 'search']" />
                <input
                  type="text"
                  v-model="searchQuery"
                  placeholder="Cari siswa..."
                  class="search-input"
                />
              </div>
            </div>
            
            <div class="table-container">
              <table class="data-table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Status</th>
                    <th>Jam Masuk</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <tr 
                    v-for="(siswa, index) in filteredSiswa" 
                    :key="siswa.nis"
                  >
                    <td class="text-muted">{{ index + 1 }}</td>
                    <td class="nis-cell">{{ siswa.nis }}</td>
                    <td class="nama-cell">{{ siswa.nama }}</td>
                    <td>
                      <span 
                        :class="['status-badge', statusColor[siswa.status]]"
                      >
                        {{ statusLabel[siswa.status] }}
                      </span>
                    </td>
                    <td>{{ siswa.jam }}</td>
                    <td class="text-muted">{{ siswa.ket || '—' }}</td>
                    <td>
                      <div class="action-buttons">
                        <button 
                          class="action-btn edit-btn" 
                          @click="editSiswa(siswa)"
                        >
                          <font-awesome-icon :icon="['fas', 'edit']" />
                        </button>
                        <button 
                          class="action-btn delete-btn" 
                          @click="deleteSiswa(siswa)"
                        >
                          <font-awesome-icon :icon="['fas', 'trash']" />
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- Sidebar Area -->
        <div class="sidebar-area">
          <!-- Weekly Trend Chart -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Tren Kehadiran Minggu Ini</h3>
            </div>
            <div class="chart-container">
              <div 
                v-for="(day, index) in weeklyTrend" 
                :key="index" 
                class="chart-column"
              >
                <div class="chart-bars">
                  <div 
                    class="chart-bar alpha-bar" 
                    :style="{ 
                      height: `${(day.alpha / day.total) * 100}px` 
                    }"
                  ></div>
                  <div 
                    class="chart-bar hadir-bar" 
                    :style="{ 
                      height: `${(day.hadir / day.total) * 80}px` 
                    }"
                  ></div>
                </div>
                <span class="chart-label">{{ day.day }}</span>
              </div>
            </div>
            <div class="chart-legend">
              <div class="legend-item">
                <div class="legend-color hadir-color"></div>
                <span>Hadir</span>
              </div>
              <div class="legend-item">
                <div class="legend-color alpha-color"></div>
                <span>Alpha</span>
              </div>
            </div>
          </div>

          <!-- Quick Info -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Informasi Cepat</h3>
            </div>
            <div class="info-list">
              <div class="info-item">
                <font-awesome-icon :icon="['fas', 'clock']" class="info-icon clock-icon" />
                <div>
                  <div class="info-label">Batas Masuk</div>
                  <div class="info-value">07.00 WIB</div>
                </div>
              </div>
              <div class="info-item">
                <font-awesome-icon :icon="['fas', 'user-check']" class="info-icon user-icon" />
                <div>
                  <div class="info-label">Wali Kelas</div>
                  <div class="info-value">Ibu Rina Hartati, S.Kom</div>
                </div>
              </div>
              <div class="info-item">
                <font-awesome-icon :icon="['fas', 'users']" class="info-icon users-icon" />
                <div>
                  <div class="info-label">Total Siswa</div>
                  <div class="info-value">36 siswa</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.abs-page {
  min-height: 100vh;
  background: #f8fafc;
}

.page-content {
  padding: 24px;
}

.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  flex-wrap: wrap;
  gap: 16px;
}

.filters {
  display: flex;
  gap: 12px;
}

.filter-item {
  display: flex;
  align-items: center;
  gap: 8px;
  background: white;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  padding: 8px 14px;
  color: #64748b;
}

.filter-select,
.filter-input {
  border: none;
  background: transparent;
  outline: none;
  font-size: 13px;
  font-weight: 500;
  color: #334155;
}

.actions {
  display: flex;
  gap: 12px;
}

.btn-primary,
.btn-secondary {
  padding: 8px 16px;
  border-radius: 10px;
  font-size: 12px;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 8px;
  cursor: pointer;
  transition: all 0.2s;
}

.btn-primary {
  background: #f5762d;
  color: white;
  border: none;
}

.btn-primary:hover {
  background: #e06820;
  transform: translateY(-1px);
}

.btn-secondary {
  background: white;
  color: #475569;
  border: 1px solid #e2e8f0;
}

.btn-secondary:hover {
  border-color: #f5762d;
  color: #f5762d;
}

.tabs-wrapper {
  display: flex;
  gap: 8px;
  margin-bottom: 24px;
  background: white;
  padding: 6px;
  border-radius: 14px;
  border: 1px solid #e2e8f0;
}

.tab-button {
  padding: 8px 20px;
  border-radius: 10px;
  font-size: 13px;
  font-weight: 600;
  background: transparent;
  border: none;
  color: #64748b;
  cursor: pointer;
  transition: all 0.2s;
  display: flex;
  align-items: center;
  gap: 8px;
}

.tab-button:hover {
  background: #f1f5f9;
  color: #f5762d;
}

.tab-button--active {
  background: #f5762d;
  color: white;
}

.content-grid {
  display: grid;
  grid-template-columns: 1fr 320px;
  gap: 24px;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 16px;
  margin-bottom: 24px;
}

.stat-card {
  border-radius: 16px;
  border: 1px solid;
  padding: 16px;
  transition: all 0.2s;
}

.stat-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.stat-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 12px;
}

.stat-label {
  font-size: 12px;
  font-weight: 700;
}

.stat-percentage {
  font-size: 11px;
  font-weight: 700;
  padding: 2px 8px;
  border-radius: 20px;
  background: rgba(255, 255, 255, 0.5);
}

.stat-value {
  font-size: 28px;
  font-weight: 800;
  line-height: 1;
}

.stat-total {
  font-size: 11px;
  color: #94a3b8;
  margin-top: 4px;
}

.stat-bar {
  height: 4px;
  background: rgba(0, 0, 0, 0.08);
  border-radius: 2px;
  margin-top: 12px;
  overflow: hidden;
}

.stat-bar-fill {
  height: 100%;
  border-radius: 2px;
  transition: width 0.5s ease;
}

.card {
  background: white;
  border-radius: 16px;
  border: 1px solid #e2e8f0;
  overflow: hidden;
  margin-bottom: 24px;
}

.card-header {
  padding: 16px 20px;
  border-bottom: 1px solid #f1f5f9;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 12px;
}

.card-title {
  font-size: 14px;
  font-weight: 700;
  color: #1e293b;
  margin: 0;
}

.card-subtitle {
  font-size: 11px;
  color: #94a3b8;
  margin: 4px 0 0;
}

.search-box {
  display: flex;
  align-items: center;
  gap: 8px;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  padding: 6px 12px;
  color: #94a3b8;
}

.search-input {
  border: none;
  background: transparent;
  outline: none;
  font-size: 12px;
  width: 160px;
}

.table-container {
  overflow-x: auto;
}

.data-table {
  width: 100%;
  border-collapse: collapse;
}

.data-table th {
  text-align: left;
  padding: 12px 16px;
  background: #f8fafc;
  font-size: 11px;
  font-weight: 700;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.data-table td {
  padding: 12px 16px;
  border-bottom: 1px solid #f1f5f9;
  font-size: 13px;
}

.data-table tr:hover {
  background: #f8fafc;
}

.text-muted {
  color: #94a3b8;
}

.nis-cell {
  font-family: monospace;
  font-size: 12px;
  color: #64748b;
}

.nama-cell {
  font-weight: 600;
  color: #1e293b;
}

.status-badge {
  font-size: 11px;
  font-weight: 600;
  padding: 4px 10px;
  border-radius: 20px;
  display: inline-block;
}

.bg-green-100 { background: #dcfce7; }
.bg-blue-100 { background: #dbeafe; }
.bg-yellow-100 { background: #fef3c7; }
.bg-red-100 { background: #fee2e2; }
.bg-orange-100 { background: #ffedd5; }
.text-green-700 { color: #166534; }
.text-blue-700 { color: #1e40af; }
.text-yellow-700 { color: #92400e; }
.text-red-700 { color: #991b1b; }
.text-orange-700 { color: #9a3412; }

.action-buttons {
  display: flex;
  gap: 8px;
}

.action-btn {
  width: 28px;
  height: 28px;
  border-radius: 6px;
  border: 1px solid #e2e8f0;
  background: white;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s;
  color: #64748b;
}

.edit-btn:hover {
  background: #fff3ed;
  color: #f5762d;
  border-color: #fde0cc;
}

.delete-btn:hover {
  background: #fef2f2;
  color: #ef4444;
  border-color: #fecaca;
}

.chart-container {
  display: flex;
  justify-content: space-around;
  align-items: flex-end;
  padding: 20px;
  height: 180px;
}

.chart-column {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 8px;
  flex: 1;
}

.chart-bars {
  display: flex;
  gap: 4px;
  align-items: flex-end;
  height: 100px;
}

.chart-bar {
  width: 20px;
  border-radius: 4px;
  transition: height 0.5s ease;
}

.hadir-bar {
  background: #22c55e;
}

.alpha-bar {
  background: #ef4444;
}

.chart-label {
  font-size: 11px;
  font-weight: 600;
  color: #64748b;
}

.chart-legend {
  display: flex;
  justify-content: center;
  gap: 16px;
  padding: 12px;
  border-top: 1px solid #f1f5f9;
}

.legend-item {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 11px;
  color: #64748b;
}

.legend-color {
  width: 10px;
  height: 10px;
  border-radius: 2px;
}

.hadir-color {
  background: #22c55e;
}

.alpha-color {
  background: #ef4444;
}

.info-list {
  padding: 16px;
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.info-item {
  display: flex;
  align-items: center;
  gap: 12px;
}

.info-icon {
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 10px;
  font-size: 14px;
}

.clock-icon {
  background: #fff3ed;
  color: #f5762d;
}

.user-icon {
  background: #dcfce7;
  color: #22c55e;
}

.users-icon {
  background: #dbeafe;
  color: #3b82f6;
}

.info-label {
  font-size: 10px;
  font-weight: 600;
  color: #94a3b8;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.info-value {
  font-size: 13px;
  font-weight: 600;
  color: #1e293b;
  margin-top: 2px;
}

@media (max-width: 1024px) {
  .content-grid {
    grid-template-columns: 1fr;
  }
  
  .stats-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 768px) {
  .page-header {
    flex-direction: column;
    align-items: stretch;
  }
  
  .stats-grid {
    grid-template-columns: 1fr;
  }
  
  .tabs-wrapper {
    overflow-x: auto;
  }
  
  .tab-button {
    white-space: nowrap;
  }
}
</style>