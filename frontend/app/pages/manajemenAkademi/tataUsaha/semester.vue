<script setup>
import { ref } from 'vue'
import {
  LayoutDashboard,
  BookOpen,
  Building2,
  Calendar,
  Users,
  GraduationCap,
  ClipboardList,
  User,
  Bell,
  Search,
  Plus,
  Power,
  Trash2,
  X
} from 'lucide-vue-next'

definePageMeta({
  layout: 'admin'
})

/* =========================
   SIDEBAR MENU
========================= */
const adminMenus = [
  { label: 'Dashboard', path: 'dashboard', icon: LayoutDashboard },
  { label: 'Jurusan', path: 'jurusan', icon: Building2 },
  { label: 'Kelas', path: 'kelas', icon: BookOpen },
  { label: 'Semester', path: 'semester', icon: Calendar },
  { label: 'Guru', path: 'guru', icon: Users },
  { label: 'Siswa', path: 'siswa', icon: GraduationCap },
  { label: 'Jadwal', path: 'jadwal', icon: ClipboardList },
  { label: 'Profil Saya', path: 'profile', icon: User },
]

/* =========================
   DATA
========================= */
const initialSemester = [
  {
    id: 1,
    nama: '2025/2026 Ganjil',
    mulai: '2025-07-15',
    selesai: '2025-12-15',
    status: 'Non-aktif'
  },
  {
    id: 2,
    nama: '2025/2026 Genap',
    mulai: '2026-01-10',
    selesai: '2026-06-20',
    status: 'Non-aktif'
  },
  {
    id: 3,
    nama: '2026/2027 Ganjil',
    mulai: '2026-07-15',
    selesai: '2026-12-15',
    status: 'Aktif'
  },
]

const semesterList = ref(initialSemester)

const isModalOpen = ref(false)

const formData = ref({
  nama: '',
  mulai: '',
  selesai: ''
})

/* =========================
   ACTIONS
========================= */
const handleSetAktif = (id) => {
  semesterList.value = semesterList.value.map(item => ({
    ...item,
    status: item.id === id ? 'Aktif' : 'Non-aktif'
  }))
}

const handleSubmit = () => {
  const newSemester = {
    id: Date.now(),
    nama: formData.value.nama,
    mulai: formData.value.mulai,
    selesai: formData.value.selesai,
    status: 'Non-aktif'
  }

  semesterList.value.push(newSemester)

  formData.value = {
    nama: '',
    mulai: '',
    selesai: ''
  }

  isModalOpen.value = false
}

const closeModal = () => {
  isModalOpen.value = false
}
</script>

<template>
  <div class="app-container">
    <!-- Sidebar -->
    <Sidebar
      role="Admin / TU"
      :menus="adminMenus"
    />

    <!-- Main Content -->
    <main class="main-content">
      <!-- HEADER -->
      <header class="top-header">
        <div class="header-left">
          <h1 class="page-title">Data Semester</h1>

          <p class="page-subtitle">
            Kelola tahun ajaran dan semester aktif
          </p>
        </div>

        <div class="header-right">
          <div class="search-bar">
            <Search :size="18" class="search-icon" />

            <input
              type="text"
              placeholder="Search anything..."
              class="search-input"
            />
          </div>

          <button class="notification-btn">
            <Bell :size="20" />

            <span class="notification-dot"></span>
          </button>

          <div class="profile-menu">
            <div class="profile-info">
              <span class="profile-name">
                Admin Utama
              </span>

              <span class="profile-role">
                Admin / TU
              </span>
            </div>

            <img
              src="https://ui-avatars.com/api/?name=Admin+Utama&background=FF6A3D&color=fff"
              alt="Profile"
              class="profile-avatar"
            />
          </div>
        </div>
      </header>

      <!-- CONTENT -->
      <div class="card">
        <div class="card-header">
          <h3>Daftar Semester</h3>

          <button
            class="btn btn-primary"
            @click="isModalOpen = true"
          >
            <Plus :size="18" />
            Tambah Semester
          </button>
        </div>

        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Semester</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>

            <tbody>
              <tr
                v-for="(item, index) in semesterList"
                :key="item.id"
              >
                <td>{{ index + 1 }}</td>

                <td>
                  <strong>{{ item.nama }}</strong>
                </td>

                <td>{{ item.mulai }}</td>

                <td>{{ item.selesai }}</td>

                <td>
                  <span
                    :class="[
                      'badge',
                      item.status === 'Aktif'
                        ? 'badge-success'
                        : 'badge-warning'
                    ]"
                  >
                    {{ item.status }}
                  </span>
                </td>

                <td>
                  <div class="action-group">
                    <button
                      :class="[
                        'btn',
                        'btn-sm',
                        item.status === 'Aktif'
                          ? 'btn-outline'
                          : 'btn-primary'
                      ]"
                      @click="handleSetAktif(item.id)"
                      :disabled="item.status === 'Aktif'"
                    >
                      <Power :size="14" />

                      {{
                        item.status === 'Aktif'
                          ? 'Sedang Aktif'
                          : 'Aktifkan'
                      }}
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
    </main>

    <!-- MODAL -->
    <div
      v-if="isModalOpen"
      class="modal-overlay"
      @click="closeModal"
    >
      <div
        class="modal-content"
        @click.stop
      >
        <div class="modal-header">
          <h3 class="modal-title">
            Tambah Semester Baru
          </h3>

          <button
            class="modal-close-btn"
            @click="closeModal"
          >
            <X :size="20" />
          </button>
        </div>

        <div class="modal-body">
          <form @submit.prevent="handleSubmit">
            <div class="form-group">
              <label class="form-label">
                Nama Semester
              </label>

              <input
                type="text"
                class="form-input"
                placeholder="Contoh: 2026/2027 Ganjil"
                v-model="formData.nama"
                required
              />
            </div>

            <div class="form-group">
              <label class="form-label">
                Tanggal Mulai
              </label>

              <input
                type="date"
                class="form-input"
                v-model="formData.mulai"
                required
              />
            </div>

            <div class="form-group">
              <label class="form-label">
                Tanggal Selesai
              </label>

              <input
                type="date"
                class="form-input"
                v-model="formData.selesai"
                required
              />
            </div>

            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-outline"
                @click="closeModal"
              >
                Batal
              </button>

              <button
                type="submit"
                class="btn btn-primary"
              >
                Simpan
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
:root {
  --primary: #FF6A3D;
  --primary-hover: #E85B31;
  --primary-light: #FFF0EB;

  --secondary: #2C3E50;
  --text-main: #334155;
  --text-muted: #64748B;

  --bg-app: #F8FAFC;
  --bg-surface: #FFFFFF;

  --success: #10B981;
  --success-light: #D1FAE5;

  --warning: #F59E0B;
  --warning-light: #FEF3C7;

  --danger: #EF4444;
  --danger-light: #FEE2E2;

  --border: #E2E8F0;

  --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);

  --shadow-md:
    0 4px 6px -1px rgb(0 0 0 / 0.1),
    0 2px 4px -2px rgb(0 0 0 / 0.1);

  --shadow-lg:
    0 10px 15px -3px rgb(0 0 0 / 0.1),
    0 4px 6px -4px rgb(0 0 0 / 0.1);

  --shadow-orange:
    0 10px 15px -3px rgba(255, 106, 61, 0.2);

  --radius-md: 10px;
  --radius-lg: 16px;
  --radius-full: 9999px;

  --transition:
    all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Outfit', sans-serif;
  background: var(--bg-app);
  color: var(--text-main);
}

/* Layout */
.app-container {
  display: flex;
  min-height: 100vh;
}

.main-content {
  flex: 1;
  padding: 2rem;
  margin-left: 260px;
}

/* Header */
.top-header {
  display: flex;
  justify-content: space-between;
  align-items: center;

  margin-bottom: 2rem;
  padding-bottom: 1.5rem;

  border-bottom: 1px solid var(--border);
}

.header-right {
  display: flex;
  align-items: center;
  gap: 1.5rem;
}

.page-title {
  font-size: 2rem;
  color: var(--secondary);
}

.page-subtitle {
  margin-top: 0.25rem;
  color: var(--text-muted);
}

.search-bar {
  display: flex;
  align-items: center;

  width: 300px;

  background: var(--bg-surface);

  border: 1px solid var(--border);
  border-radius: var(--radius-full);

  padding: 0.5rem 1rem;
}

.search-icon {
  color: var(--text-muted);
  margin-right: 0.5rem;
}

.search-input {
  width: 100%;
  border: none;
  outline: none;
  background: transparent;
}

.notification-btn {
  position: relative;

  width: 42px;
  height: 42px;

  border-radius: 50%;

  border: 1px solid var(--border);
  background: var(--bg-surface);

  display: flex;
  align-items: center;
  justify-content: center;
}

.notification-dot {
  position: absolute;
  top: 9px;
  right: 10px;

  width: 8px;
  height: 8px;

  border-radius: 50%;

  background: var(--danger);
}

.profile-menu {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.profile-info {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

.profile-name {
  font-weight: 600;
}

.profile-role {
  font-size: 0.8rem;
  color: var(--text-muted);
}

.profile-avatar {
  width: 42px;
  height: 42px;
  border-radius: 50%;
}

/* Card */
.card {
  background: var(--bg-surface);

  border: 1px solid var(--border);
  border-radius: var(--radius-lg);

  padding: 1.5rem;

  box-shadow: var(--shadow-sm);

  transition: var(--transition);
}

.card:hover {
  box-shadow: var(--shadow-md);
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;

  margin-bottom: 1.5rem;
}

/* Table */
.table-container {
  overflow-x: auto;

  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
}

table {
  width: 100%;
  border-collapse: collapse;
}

th {
  background: var(--bg-app);

  padding: 1rem 1.5rem;

  text-align: left;

  color: var(--text-muted);

  font-size: 0.85rem;
  font-weight: 600;
  text-transform: uppercase;

  border-bottom: 1px solid var(--border);
}

td {
  padding: 1rem 1.5rem;
  border-bottom: 1px solid var(--border);
}

tr:last-child td {
  border-bottom: none;
}

tr:hover td {
  background: var(--bg-app);
}

/* Buttons */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;

  border: none;
  cursor: pointer;

  padding: 0.75rem 1.2rem;

  border-radius: var(--radius-md);

  font-weight: 500;

  transition: var(--transition);
}

.btn-primary {
  background: var(--primary);
  color: white;

  box-shadow: var(--shadow-orange);
}

.btn-primary:hover {
  background: var(--primary-hover);
}

.btn-outline {
  background: white;

  border: 1px solid var(--border);
}

.btn-outline:hover {
  border-color: var(--primary);
  color: var(--primary);
}

.btn-sm {
  padding: 0.5rem 1rem;
  font-size: 0.85rem;
}

.btn-icon {
  display: inline-flex;
  align-items: center;
  justify-content: center;

  padding: 0.5rem;

  border-radius: var(--radius-md);

  transition: var(--transition);
}

.btn-icon:hover {
  background: var(--bg-app);
}

.text-danger {
  color: var(--danger);
}

.action-group {
  display: flex;
  gap: 0.5rem;
}

/* Badge */
.badge {
  display: inline-block;

  padding: 0.3rem 0.8rem;

  border-radius: var(--radius-full);

  font-size: 0.75rem;
  font-weight: 600;
}

.badge-success {
  background: var(--success-light);
  color: var(--success);
}

.badge-warning {
  background: var(--warning-light);
  color: var(--warning);
}

/* Form */
.form-group {
  margin-bottom: 1.25rem;
}

.form-label {
  display: block;

  margin-bottom: 0.5rem;

  font-weight: 500;
}

.form-input {
  width: 100%;

  padding: 0.75rem 1rem;

  border: 1px solid var(--border);
  border-radius: var(--radius-md);

  background: #F8FAFC;

  font-family: inherit;
}

.form-input:focus {
  outline: none;
  border-color: var(--primary);

  background: white;

  box-shadow: 0 0 0 3px rgba(255, 106, 61, 0.1);
}

/* Modal */
.modal-overlay {
  position: fixed;
  inset: 0;

  background: rgba(15, 23, 42, 0.4);
  backdrop-filter: blur(4px);

  display: flex;
  align-items: center;
  justify-content: center;

  z-index: 1000;

  animation: fadeIn 0.3s ease;
}

.modal-content {
  width: 100%;
  max-width: 500px;

  background: var(--bg-surface);

  border-radius: var(--radius-lg);

  padding: 2rem;

  box-shadow: var(--shadow-lg);

  animation: slideUp 0.3s ease;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;

  margin-bottom: 1.5rem;
  padding-bottom: 1rem;

  border-bottom: 1px solid var(--border);
}

.modal-title {
  font-size: 1.25rem;
  color: var(--secondary);
}

.modal-close-btn {
  padding: 0.3rem;

  border-radius: var(--radius-md);

  transition: var(--transition);
}

.modal-close-btn:hover {
  background: var(--bg-app);
  color: var(--danger);
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;

  margin-top: 2rem;
}

/* Animation */
@keyframes fadeIn {
  from {
    opacity: 0;
  }

  to {
    opacity: 1;
  }
}

@keyframes slideUp {
  from {
    opacity: 0;
    transform: translateY(20px);
  }

  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Responsive */
@media (max-width: 768px) {
  .main-content {
    margin-left: 0;
    padding: 1rem;
  }

  .top-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
  }

  .header-right {
    width: 100%;
    flex-wrap: wrap;
  }

  .search-bar {
    width: 100%;
  }
}
</style>