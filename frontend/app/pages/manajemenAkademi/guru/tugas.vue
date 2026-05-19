<script setup>
import { ref } from 'vue'
import {
  Plus,
  Edit2,
  Trash2,
  Link as LinkIcon,
  FileText,
  Calendar,
  Bell,
  Search,
  GraduationCap,
  LogOut,
  LayoutDashboard,
  ClipboardCheck,
  User,
  Clock,
  X
} from 'lucide-vue-next'

definePageMeta({
  layout: false
})

/* =========================
   SIDEBAR MENU
========================= */
const guruMenus = [
  { label: 'Dashboard', path: 'dashboard', icon: LayoutDashboard },
  { label: 'Jadwal Mengajar', path: 'jadwal', icon: Calendar },
  { label: 'Input Nilai', path: 'nilai', icon: ClipboardCheck },
  { label: 'Tugas Siswa', path: 'tugas', icon: FileText },
  { label: 'Profil Saya', path: 'profile', icon: User },
]

/* =========================
   DATA TUGAS
========================= */
const tugasList = ref([
  {
    id: 1,
    judul: 'Tugas 1: Instalasi Web Server',
    mapel: 'Pemrograman Web',
    kelas: 'X RPL A',
    deadline: '2026-04-25',
    status: 'Aktif'
  },
  {
    id: 2,
    judul: 'Praktikum Struktur HTML',
    mapel: 'Pemrograman Web',
    kelas: 'X RPL A',
    deadline: '2026-04-28',
    status: 'Aktif'
  },
  {
    id: 3,
    judul: 'Perancangan ERD',
    mapel: 'Basis Data',
    kelas: 'XI RPL B',
    deadline: '2026-04-20',
    status: 'Selesai'
  },
])

/* =========================
   MODAL
========================= */
const isModalOpen = ref(false)
const modalMode = ref('add')

const formData = ref({
  judul: '',
  mapel: 'Pemrograman Web',
  kelas: 'X RPL A',
  deadline: '',
  deskripsi: ''
})

const handleOpenModal = (mode, data = null) => {
  modalMode.value = mode

  if (data) {
    formData.value = { ...data }
  } else {
    formData.value = {
      judul: '',
      mapel: 'Pemrograman Web',
      kelas: 'X RPL A',
      deadline: '',
      deskripsi: ''
    }
  }

  isModalOpen.value = true
}

const closeModal = () => {
  isModalOpen.value = false
}

const handleSubmit = () => {
  isModalOpen.value = false
}
</script>

<template>
  <div class="app-container">
    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <div class="logo-box">
          <GraduationCap class="logo-icon" :size="28" />
        </div>

        <h2 class="brand-name">EduManage</h2>
      </div>

      <div class="sidebar-role-badge">
        <span class="badge badge-primary role-text">
          Guru
        </span>
      </div>

      <nav class="sidebar-nav">
        <ul class="nav-list">
          <li
            v-for="(menu, index) in guruMenus"
            :key="index"
            class="nav-item"
          >
            <NuxtLink
              :to="menu.path"
              class="nav-link"
              active-class="active"
            >
              <component
                :is="menu.icon"
                class="nav-icon"
                :size="20"
              />

              <span>{{ menu.label }}</span>
            </NuxtLink>
          </li>
        </ul>
      </nav>

      <div class="sidebar-footer">
        <button class="btn-logout">
          <LogOut :size="20" />
          <span>Logout</span>
        </button>
      </div>
    </aside>

    <!-- MAIN -->
    <main class="main-content">
      <!-- HEADER -->
      <header class="top-header">
        <div class="header-left">
          <h1 class="page-title">
            Manajemen Tugas Siswa
          </h1>

          <p class="page-subtitle">
            Kelola pemberian tugas dan materi pembelajaran
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
                Budi Santoso
              </span>

              <span class="profile-role">
                Guru Pengajar
              </span>
            </div>

            <img
              src="https://ui-avatars.com/api/?name=Budi+Santoso&background=FF6A3D&color=fff"
              alt="Profile"
              class="profile-avatar"
            />
          </div>
        </div>
      </header>

      <!-- PAGE -->
      <div class="dashboard-page">
        <!-- INFO CARDS -->
        <div class="grid-cards mb-4">
          <div
            class="card stat-card"
            style="border-left: 4px solid var(--primary)"
          >
            <div class="stat-icon-wrapper">
              <div
                class="stat-icon"
                style="
                  background: var(--primary-light);
                  color: var(--primary);
                "
              >
                <ClipboardCheck :size="24" />
              </div>
            </div>

            <div class="stat-content">
              <p class="stat-title">
                Total Tugas Aktif
              </p>

              <h3 class="stat-value">
                12 Tugas
              </h3>
            </div>
          </div>

          <div
            class="card stat-card"
            style="border-left: 4px solid var(--warning)"
          >
            <div class="stat-icon-wrapper">
              <div
                class="stat-icon"
                style="
                  background: var(--warning-light);
                  color: var(--warning);
                "
              >
                <Clock :size="24" />
              </div>
            </div>

            <div class="stat-content">
              <p class="stat-title">
                Deadline Minggu Ini
              </p>

              <h3 class="stat-value">
                5 Tugas
              </h3>
            </div>
          </div>

          <div
            class="card stat-card"
            style="border-left: 4px solid var(--success)"
          >
            <div class="stat-icon-wrapper">
              <div
                class="stat-icon"
                style="
                  background: var(--success-light);
                  color: var(--success);
                "
              >
                <FileText :size="24" />
              </div>
            </div>

            <div class="stat-content">
              <p class="stat-title">
                Tugas Selesai
              </p>

              <h3 class="stat-value">
                28 Tugas
              </h3>
            </div>
          </div>
        </div>

        <!-- TABLE -->
        <div class="card">
          <div class="card-header">
            <h3>Daftar Tugas Anda</h3>

            <button
              class="btn btn-primary"
              @click="handleOpenModal('add')"
            >
              <Plus :size="18" />
              Buat Tugas Baru
            </button>
          </div>

          <div class="table-container">
            <table>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Judul Tugas</th>
                  <th>Mata Pelajaran</th>
                  <th>Kelas</th>
                  <th>Deadline</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>

              <tbody>
                <tr
                  v-for="(item, index) in tugasList"
                  :key="item.id"
                >
                  <td>{{ index + 1 }}</td>

                  <td>
                    <strong>{{ item.judul }}</strong>
                  </td>

                  <td>{{ item.mapel }}</td>

                  <td>{{ item.kelas }}</td>

                  <td>{{ item.deadline }}</td>

                  <td>
                    <span
                      :class="[
                        'badge',
                        item.status === 'Aktif'
                          ? 'badge-primary'
                          : 'badge-success'
                      ]"
                    >
                      {{ item.status }}
                    </span>
                  </td>

                  <td>
                    <div class="action-group">
                      <button
                        class="btn-icon"
                        title="Lihat Pengumpulan"
                      >
                        <FileText :size="16" />
                      </button>

                      <button
                        class="btn-icon"
                        @click="
                          handleOpenModal(
                            'edit',
                            item
                          )
                        "
                      >
                        <Edit2 :size="16" />
                      </button>

                      <button
                        class="btn-icon text-danger"
                      >
                        <Trash2 :size="16" />
                      </button>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
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
            {{
              modalMode === 'add'
                ? 'Buat Tugas Baru'
                : 'Edit Tugas'
            }}
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
                Judul Tugas
              </label>

              <input
                type="text"
                class="form-input"
                v-model="formData.judul"
                required
              />
            </div>

            <div
              class="form-group"
              style="display: flex; gap: 1rem"
            >
              <div style="flex: 1">
                <label class="form-label">
                  Mata Pelajaran
                </label>

                <select
                  class="form-input"
                  v-model="formData.mapel"
                >
                  <option value="Pemrograman Web">
                    Pemrograman Web
                  </option>

                  <option value="Basis Data">
                    Basis Data
                  </option>
                </select>
              </div>

              <div style="flex: 1">
                <label class="form-label">
                  Kelas
                </label>

                <select
                  class="form-input"
                  v-model="formData.kelas"
                >
                  <option value="X RPL A">
                    X RPL A
                  </option>

                  <option value="XI RPL B">
                    XI RPL B
                  </option>

                  <option value="XII RPL C">
                    XII RPL C
                  </option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">
                Deadline
              </label>

              <input
                type="date"
                class="form-input"
                v-model="formData.deadline"
                required
              />
            </div>

            <div class="form-group">
              <label class="form-label">
                Deskripsi
              </label>

              <textarea
                rows="4"
                class="form-input"
                v-model="formData.deskripsi"
                placeholder="Tuliskan instruksi tugas..."
              ></textarea>
            </div>

            <div class="form-group">
              <label class="form-label">
                Lampiran URL / Google Drive
              </label>

              <div class="search-bar modal-search">
                <LinkIcon
                  :size="18"
                  class="search-icon"
                />

                <input
                  type="text"
                  placeholder="https://"
                  class="search-input"
                />
              </div>
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
                Simpan Tugas
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
  background-color: var(--bg-app);
  color: var(--text-main);
}

/* =========================
   LAYOUT
========================= */

.app-container {
  display: flex;
  min-height: 100vh;
}

.main-content {
  flex: 1;
  padding: 2rem;
  margin-left: 260px;
}

/* =========================
   SIDEBAR
========================= */

.sidebar {
  width: 260px;
  background: var(--bg-surface);
  border-right: 1px solid var(--border);
  height: 100vh;
  position: fixed;
  left: 0;
  top: 0;
  display: flex;
  flex-direction: column;
  z-index: 100;
}

.sidebar-header {
  padding: 1.5rem;
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.logo-box {
  width: 40px;
  height: 40px;
  background: var(--primary-light);
  color: var(--primary);
  border-radius: var(--radius-md);

  display: flex;
  align-items: center;
  justify-content: center;
}

.brand-name {
  font-size: 1.25rem;
  font-weight: 700;
}

.sidebar-role-badge {
  padding: 0 1.5rem 1rem;
}

.role-text {
  text-transform: uppercase;
  letter-spacing: 1px;
  font-size: 0.7rem;
}

.sidebar-nav {
  flex: 1;
  padding: 0 1rem;
}

.nav-list {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}

.nav-link {
  display: flex;
  align-items: center;
  gap: 0.75rem;

  padding: 0.75rem 1rem;
  border-radius: var(--radius-md);

  color: var(--text-muted);
  transition: var(--transition);
  font-weight: 500;
}

.nav-link:hover {
  background: var(--bg-app);
  color: var(--primary);
}

.nav-link.active {
  background: var(--primary);
  color: white;
  box-shadow: var(--shadow-orange);
}

.sidebar-footer {
  padding: 1.5rem;
  border-top: 1px solid var(--border);
}

.btn-logout {
  display: flex;
  align-items: center;
  gap: 0.75rem;

  width: 100%;
  padding: 0.75rem 1rem;

  border-radius: var(--radius-md);

  color: var(--danger);
  font-weight: 500;
  transition: var(--transition);
}

.btn-logout:hover {
  background: var(--danger-light);
}

/* =========================
   HEADER
========================= */

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

.search-bar {
  display: flex;
  align-items: center;

  background: var(--bg-surface);
  border: 1px solid var(--border);

  border-radius: var(--radius-full);

  padding: 0.5rem 1rem;
  width: 300px;
}

.search-icon {
  color: var(--text-muted);
  margin-right: 0.5rem;
}

.search-input {
  border: none;
  outline: none;
  background: transparent;
  width: 100%;
}

.notification-btn {
  position: relative;

  width: 40px;
  height: 40px;

  border-radius: 50%;

  background: var(--bg-surface);
  border: 1px solid var(--border);

  display: flex;
  align-items: center;
  justify-content: center;
}

.notification-dot {
  position: absolute;
  top: 8px;
  right: 10px;

  width: 8px;
  height: 8px;

  background: var(--danger);
  border-radius: 50%;
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
  font-size: 0.75rem;
  color: var(--text-muted);
}

.profile-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
}

/* =========================
   CARD
========================= */

.card {
  background: var(--bg-surface);
  border-radius: var(--radius-lg);
  padding: 1.5rem;
  border: 1px solid var(--border);
  box-shadow: var(--shadow-sm);
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;

  margin-bottom: 1.5rem;
}

/* =========================
   BUTTON
========================= */

.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;

  padding: 0.75rem 1.5rem;
  border-radius: var(--radius-md);

  border: none;
  cursor: pointer;
  transition: var(--transition);
}

.btn-primary {
  background: var(--primary);
  color: white;
}

.btn-primary:hover {
  background: var(--primary-hover);
}

.btn-outline {
  border: 1px solid var(--border);
  background: white;
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

/* =========================
   TABLE
========================= */

.table-container {
  overflow-x: auto;
  border-radius: var(--radius-lg);
  border: 1px solid var(--border);
}

table {
  width: 100%;
  border-collapse: collapse;
}

th {
  background: var(--bg-app);
  padding: 1rem;
  text-align: left;
  border-bottom: 1px solid var(--border);
}

td {
  padding: 1rem;
  border-bottom: 1px solid var(--border);
}

tr:last-child td {
  border-bottom: none;
}

tr:hover td {
  background: #fafafa;
}

/* =========================
   BADGE
========================= */

.badge {
  padding: 0.25rem 0.75rem;
  border-radius: var(--radius-full);
  font-size: 0.75rem;
  font-weight: 600;
}

.badge-primary {
  background: var(--primary-light);
  color: var(--primary);
}

.badge-success {
  background: var(--success-light);
  color: var(--success);
}

/* =========================
   STATS
========================= */

.grid-cards {
  display: grid;
  grid-template-columns:
    repeat(auto-fit, minmax(250px, 1fr));

  gap: 1.5rem;
}

.stat-card {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.stat-icon {
  width: 56px;
  height: 56px;

  border-radius: 50%;

  display: flex;
  align-items: center;
  justify-content: center;
}

.stat-title {
  color: var(--text-muted);
  margin-bottom: 0.25rem;
}

.stat-value {
  color: var(--secondary);
}

.mb-4 {
  margin-bottom: 2rem;
}

.action-group {
  display: flex;
  gap: 0.5rem;
}

/* =========================
   FORM
========================= */

.form-group {
  margin-bottom: 1.5rem;
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

  background: var(--bg-app);
}

.form-input:focus {
  outline: none;
  border-color: var(--primary);
}

.modal-search {
  width: 100%;
  border-radius: var(--radius-md);
}

/* =========================
   MODAL
========================= */

.modal-overlay {
  position: fixed;
  inset: 0;

  background: rgba(15, 23, 42, 0.4);
  backdrop-filter: blur(4px);

  display: flex;
  align-items: center;
  justify-content: center;

  z-index: 1000;
}

.modal-content {
  background: white;
  width: 100%;
  max-width: 550px;

  border-radius: var(--radius-lg);
  padding: 2rem;

  box-shadow: var(--shadow-lg);
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;

  margin-bottom: 1.5rem;
  padding-bottom: 1rem;

  border-bottom: 1px solid var(--border);
}

.modal-close-btn {
  padding: 0.25rem;
  border-radius: var(--radius-md);
}

.modal-close-btn:hover {
  background: var(--bg-app);
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;

  margin-top: 2rem;
  padding-top: 1.5rem;

  border-top: 1px solid var(--border);
}

/* =========================
   RESPONSIVE
========================= */

@media (max-width: 768px) {
  .sidebar {
    display: none;
  }

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
    flex-direction: column;
  }

  .search-bar {
    width: 100%;
  }
}
</style>