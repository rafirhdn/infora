<script setup>
import { ref } from 'vue'
import { Plus, Edit2, Trash2, Filter } from 'lucide-vue-next'

definePageMeta({
  layout: 'waka'
})

const selectedMapel = ref('Pemrograman Web')

const initialKD = [
  { id: 1, kode: '3.1', judul: 'Memahami Konsep Web Server', deskripsi: 'Memahami arsitektur dasar dan cara kerja web server secara umum.', bobot: 2 },
  { id: 2, kode: '4.1', judul: 'Menyajikan Konsep Web Server', deskripsi: 'Mempresentasikan hasil pemahaman mengenai web server.', bobot: 3 },
  { id: 3, kode: '3.2', judul: 'Menerapkan HTML Dasar', deskripsi: 'Menerapkan tag-tag dasar HTML untuk struktur halaman web.', bobot: 3 },
  { id: 4, kode: '4.2', judul: 'Membuat Halaman HTML', deskripsi: 'Membuat halaman web statis menggunakan HTML dasar.', bobot: 4 },
]

const kdList = ref(initialKD)
const isModalOpen = ref(false)
const modalMode = ref('add')
const formData = ref({ kode: '', judul: '', deskripsi: '', bobot: 1 })

const handleOpenModal = (mode, data = null) => {
  modalMode.value = mode
  if (data) {
    formData.value = { ...data }
  } else {
    formData.value = { kode: '', judul: '', deskripsi: '', bobot: 1 }
  }
  isModalOpen.value = true
}

const handleSubmit = () => {
  isModalOpen.value = false
}
</script>

<template>
  <div class="dashboard-page">
    <Header 
      title="Kompetensi Dasar (KD)" 
      subtitle="Kelola standar kompetensi per mata pelajaran" 
      :profile="{ name: 'Waka Kurikulum', role: 'Waka Kurikulum' }" 
    />

    <div class="card mb-4" style="margin-bottom: 1.5rem">
      <div style="display: flex; gap: 1rem; align-items: center">
        <Filter class="text-muted" :size="20" />
        <div style="flex: 1">
          <label class="form-label" style="margin-bottom: 0.25rem">Pilih Mata Pelajaran</label>
          <select class="form-input" v-model="selectedMapel">
            <option value="Pemrograman Web">Pemrograman Web (RPL)</option>
            <option value="Desain Grafis">Desain Grafis (DKV)</option>
            <option value="Bahasa Indonesia">Bahasa Indonesia (Umum)</option>
          </select>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card-header">
        <h3>Daftar KD: {{ selectedMapel }}</h3>
        <button class="btn btn-primary" @click="handleOpenModal('add')">
          <Plus :size="18" />
          Tambah KD
        </button>
      </div>

      <div class="table-container">
        <table>
          <thead>
            <tr>
              <th>Kode</th>
              <th>Judul Kompetensi</th>
              <th>Deskripsi Singkat</th>
              <th>Bobot</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in kdList" :key="item.id">
              <td><strong>{{ item.kode }}</strong></td>
              <td>{{ item.judul }}</td>
              <td style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                {{ item.deskripsi }}
              </td>
              <td>
                <div style="display: flex; gap: 2px">
                  <span v-for="n in 5" :key="n" :style="{ color: n <= item.bobot ? 'var(--warning)' : 'var(--border)' }">★</span>
                </div>
              </td>
              <td>
                <div style="display: flex; gap: 0.5rem">
                  <button class="btn-icon" @click="handleOpenModal('edit', item)">
                    <Edit2 :size="16" />
                  </button>
                  <button class="btn-icon text-danger">
                    <Trash2 :size="16" />
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <Modal 
      :isOpen="isModalOpen" 
      @close="isModalOpen = false" 
      :title="modalMode === 'add' ? 'Tambah KD Baru' : 'Edit KD'"
    >
      <form @submit.prevent="handleSubmit">
        <div class="form-group" style="display: flex; gap: 1rem">
          <div style="flex: 1">
            <label class="form-label">Kode KD</label>
            <input type="text" class="form-input" placeholder="Misal: 3.1" v-model="formData.kode" required />
          </div>
          <div style="flex: 2">
            <label class="form-label">Bobot Penilaian (1-5)</label>
            <input type="number" min="1" max="5" class="form-input" v-model="formData.bobot" required />
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Judul Kompetensi</label>
          <input type="text" class="form-input" placeholder="Menerapkan struktur HTML dasar" v-model="formData.judul" required />
        </div>
        <div class="form-group">
          <label class="form-label">Deskripsi / Indikator Pencapaian</label>
          <textarea class="form-input" rows="3" v-model="formData.deskripsi" required></textarea>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline" @click="isModalOpen = false">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
    </Modal>
  </div>
</template>
<style>
:root {
  /* Colors - Premium Orange & White Theme */
  --primary: #FF6A3D; /* Vibrant Orange */
  --primary-hover: #E85B31;
  --primary-light: #FFF0EB; /* Sangat soft orange untuk background widget */
  
  --secondary: #2C3E50; /* Dark slate untuk teks kuat */
  --text-main: #334155; /* Slate 700 */
  --text-muted: #64748B; /* Slate 500 */
  
  --bg-app: #F8FAFC; /* Slate 50 - Sangat terang, clean */
  --bg-surface: #FFFFFF; /* Putih murni untuk card */
  
  --success: #10B981;
  --success-light: #D1FAE5;
  --warning: #F59E0B;
  --warning-light: #FEF3C7;
  --danger: #EF4444;
  --danger-light: #FEE2E2;

  --border: #E2E8F0; /* Slate 200 */

  /* Shadows */
  --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
  --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
  --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
  --shadow-orange: 0 10px 15px -3px rgba(255, 106, 61, 0.2);

  /* Radius */
  --radius-md: 10px;
  --radius-lg: 16px;
  --radius-full: 9999px;

  /* Transitions */
  --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Outfit', sans-serif;
  background-color: var(--bg-app);
  color: var(--text-main);
  -webkit-font-smoothing: antialiased;
}

/* Typography */
h1, h2, h3, h4, h5, h6 {
  color: var(--secondary);
  font-weight: 600;
}

a {
  text-decoration: none;
  color: inherit;
}

button {
  cursor: pointer;
  font-family: inherit;
  border: none;
  outline: none;
  background: none;
}

/* Layout Utilities */
.app-container {
  display: flex;
  min-height: 100vh;
}

.main-content {
  flex: 1;
  padding: 2rem;
  overflow-y: auto;
  margin-left: 260px; /* Lebar sidebar */
}

/* Card Component */
.card {
  background: var(--bg-surface);
  border-radius: var(--radius-lg);
  padding: 1.5rem;
  box-shadow: var(--shadow-sm);
  border: 1px solid var(--border);
  transition: var(--transition);
}

.card:hover {
  box-shadow: var(--shadow-md);
  transform: translateY(-2px);
}

/* Buttons */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.75rem 1.5rem;
  border-radius: var(--radius-md);
  font-weight: 500;
  transition: var(--transition);
  font-size: 0.95rem;
}

.btn-primary {
  background: var(--primary);
  color: white;
  box-shadow: var(--shadow-orange);
}

.btn-primary:hover {
  background: var(--primary-hover);
  transform: translateY(-2px);
  box-shadow: 0 15px 20px -3px rgba(255, 106, 61, 0.3);
}

.btn-outline {
  border: 1px solid var(--border);
  color: var(--text-main);
  background: var(--bg-surface);
}

.btn-outline:hover {
  border-color: var(--primary);
  color: var(--primary);
  background: var(--primary-light);
}

.btn-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0.5rem;
  border-radius: var(--radius-md);
  color: var(--text-muted);
  transition: var(--transition);
}

.btn-icon:hover {
  background: var(--bg-app);
  color: var(--primary);
}

.text-danger {
  color: var(--danger);
}
.btn-icon.text-danger:hover {
  color: var(--danger);
  background: var(--danger-light);
}

/* Table */
.table-container {
  width: 100%;
  overflow-x: auto;
  border-radius: var(--radius-lg);
  border: 1px solid var(--border);
  background: var(--bg-surface);
}

table {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
}

th {
  background: var(--bg-app);
  padding: 1rem 1.5rem;
  font-weight: 500;
  color: var(--text-muted);
  font-size: 0.875rem;
  text-transform: uppercase;
  letter-spacing: 0.05em;
  border-bottom: 1px solid var(--border);
}

td {
  padding: 1rem 1.5rem;
  border-bottom: 1px solid var(--border);
  color: var(--text-main);
  font-size: 0.95rem;
}

tr:last-child td {
  border-bottom: none;
}

tr:hover td {
  background: var(--bg-app);
}

/* Badges / Status */
.badge {
  padding: 0.25rem 0.75rem;
  border-radius: var(--radius-full);
  font-size: 0.75rem;
  font-weight: 600;
  display: inline-block;
}

.badge-success {
  background: var(--success-light);
  color: var(--success);
}

.badge-warning {
  background: var(--warning-light);
  color: var(--warning);
}

.badge-danger {
  background: var(--danger-light);
  color: var(--danger);
}

.badge-primary {
  background: var(--primary-light);
  color: var(--primary);
}

/* Header/Title */
.page-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}

.page-title {
  font-size: 1.75rem;
  color: var(--secondary);
}

.page-subtitle {
  color: var(--text-muted);
  margin-top: 0.25rem;
}

/* Form Inputs */
.form-group {
  margin-bottom: 1.5rem;
}

.form-label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 500;
  color: var(--secondary);
  font-size: 0.9rem;
}

.form-input {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 1px solid var(--border);
  border-radius: var(--radius-md);
  font-family: inherit;
  font-size: 0.95rem;
  transition: var(--transition);
  background: #F8FAFC;
}

.form-input:focus {
  outline: none;
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(255, 106, 61, 0.1);
  background: var(--bg-surface);
}

/* Animations */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}

@keyframes slideUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Grid Utilities */
.grid-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 1.5rem;
}

.mb-4 {
  margin-bottom: 2rem;
}

.section-title {
  font-size: 1.25rem;
  margin-bottom: 1rem;
  color: var(--secondary);
}

/* Stat Cards */
.stat-card {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.stat-icon-wrapper {
  flex-shrink: 0;
}

.stat-icon {
  width: 56px;
  height: 56px;
  border-radius: var(--radius-full);
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
}

.bg-primary { background-color: var(--primary); }
.bg-warning { background-color: var(--warning); }
.bg-success { background-color: var(--success); }
.bg-danger { background-color: var(--danger); }

.stat-content {
  flex: 1;
}

.stat-title {
  font-size: 0.875rem;
  color: var(--text-muted);
  font-weight: 500;
  margin-bottom: 0.25rem;
}

.stat-value-group {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.stat-value {
  font-size: 1.75rem;
  font-weight: 700;
  color: var(--secondary);
}

.stat-trend {
  display: flex;
  align-items: center;
  gap: 0.25rem;
  font-size: 0.75rem;
  font-weight: 600;
  padding: 0.2rem 0.5rem;
  border-radius: var(--radius-full);
}

.stat-trend.success {
  background: var(--success-light);
  color: var(--success);
}

/* Alert Card */
.alert-card {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 2rem;
}

.alert-card.primary {
  background: var(--primary-light);
  border-color: rgba(255, 106, 61, 0.2);
}

.alert-content {
  display: flex;
  align-items: center;
  gap: 1.5rem;
}

.alert-icon {
  color: var(--primary);
  background: white;
  padding: 0.75rem;
  border-radius: var(--radius-full);
  box-shadow: var(--shadow-sm);
}

.alert-title {
  color: var(--primary-hover);
  margin-bottom: 0.25rem;
}

.alert-desc {
  color: var(--text-main);
}

/* Dashboard Grid */
.dashboard-grid {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 1.5rem;
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1.5rem;
}

.card-header h3 {
  font-size: 1.1rem;
}

.btn-sm {
  padding: 0.5rem 1rem;
  font-size: 0.85rem;
}

/* Chart Placeholder */
.chart-placeholder {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.bar-group {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.bar-label {
  width: 60px;
  font-weight: 500;
  color: var(--text-muted);
}

.bar-wrapper {
  flex: 1;
  background: var(--bg-app);
  height: 12px;
  border-radius: var(--radius-full);
  overflow: hidden;
}

.bar {
  height: 100%;
  border-radius: var(--radius-full);
}

.fill-primary { background: var(--primary); }
.fill-warning { background: var(--warning); }
.fill-success { background: var(--success); }

.bar-value {
  width: 40px;
  text-align: right;
  font-weight: 600;
  color: var(--secondary);
}

/* Activity List */
.activity-list {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.activity-item {
  display: flex;
  gap: 1rem;
}

.activity-dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  margin-top: 5px;
  position: relative;
}

.activity-dot::after {
  content: '';
  position: absolute;
  top: 12px;
  left: 5px;
  width: 2px;
  height: 40px;
  background: var(--border);
}

.activity-item:last-child .activity-dot::after {
  display: none;
}

.activity-content p {
  margin-bottom: 0.25rem;
  line-height: 1.4;
  color: var(--text-main);
}

.activity-time {
  font-size: 0.75rem;
  color: var(--text-muted);
}

/* Responsiveness */
@media (max-width: 1024px) {
  .dashboard-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 768px) {
  .sidebar {
    transform: translateX(-100%);
    transition: var(--transition);
  }
  
  .main-content {
    margin-left: 0;
    padding: 1rem;
  }
  
  .page-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
  }
  
  .header-right {
    width: 100%;
    justify-content: space-between;
  }
  
  .search-bar {
    width: 100%;
    max-width: none;
  }
}


</style>