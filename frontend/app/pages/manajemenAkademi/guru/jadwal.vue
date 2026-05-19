<script setup>
import {
  Calendar,
  Bell,
  Search,
  GraduationCap,
  LogOut,
  LayoutDashboard,
  ClipboardCheck,
  FileText,
  User,
  Clock,
  X
} from 'lucide-vue-next'

definePageMeta({
  layout: false
})
const guruMenus = [
  { label: 'Dashboard', path: 'dashboard', icon: LayoutDashboard },
  { label: 'Jadwal Mengajar', path: 'jadwal', icon: Calendar },
  { label: 'Input Nilai', path: 'nilai', icon: ClipboardCheck },
  { label: 'Tugas Siswa', path: 'tugas', icon: FileText },
  { label: 'Profil Saya', path: 'profile', icon: User },
]

const jadwalData = [
  {
    hari: 'Senin',
    jam: '07:00 - 09:15',
    kelas: 'X RPL A',
    mapel: 'Pemrograman Web',
    ruang: 'Lab Komputer 1'
  },
  {
    hari: 'Selasa',
    jam: '09:30 - 11:45',
    kelas: 'XI RPL B',
    mapel: 'Basis Data',
    ruang: 'Lab Komputer 2'
  },
  {
    hari: 'Rabu',
    jam: '07:00 - 09:15',
    kelas: 'XII RPL C',
    mapel: 'PBO',
    ruang: 'Lab Komputer 1'
  },
  {
    hari: 'Kamis',
    jam: '13:00 - 15:15',
    kelas: 'X RPL A',
    mapel: 'Pemrograman Dasar',
    ruang: 'Ruang Teori 5'
  },
  {
    hari: 'Jumat',
    jam: '08:00 - 10:00',
    kelas: 'XI RPL B',
    mapel: 'PBO',
    ruang: 'Lab Komputer 2'
  },
]

const days = [
  'Senin',
  'Selasa',
  'Rabu',
  'Kamis',
  'Jumat'
]

/* =========================
   MODAL
========================= */
const isModalOpen = ref(false)
const selectedJadwal = ref(null)

const openModal = (item) => {
  selectedJadwal.value = item
  isModalOpen.value = true
}

const closeModal = () => {
  isModalOpen.value = false
}
</script>

<template>
  <div class="app-container">
    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <div class="logo-box">
          <GraduationCap
            class="logo-icon"
            :size="28"
          />
        </div>

        <h2 class="brand-name">
          EduManage
        </h2>
      </div>

      <div class="sidebar-role-badge">
        <span
          class="badge badge-primary role-text"
        >
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

              <span>
                {{ menu.label }}
              </span>
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
            Jadwal Mengajar
          </h1>

          <p class="page-subtitle">
            Lihat jadwal mengajar Anda selama satu minggu
          </p>
        </div>

        <div class="header-right">
          <div class="search-bar">
            <Search
              :size="18"
              class="search-icon"
            />

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

      <!-- CONTENT -->
      <div class="dashboard-page">
        <!-- CARD -->
        <div class="card">
          <div class="card-header">
            <h3>Jadwal Mingguan Anda</h3>
          </div>

          <div class="table-container">
            <table>
              <thead>
                <tr>
                  <th>Hari</th>
                  <th>Waktu</th>
                  <th>Kelas</th>
                  <th>Mata Pelajaran</th>
                  <th>Ruang</th>
                  <th>Aksi</th>
                </tr>
              </thead>

              <tbody>
                <template
                  v-for="day in days"
                  :key="day"
                >
                  <!-- HEADER HARI -->
                  <tr class="day-row">
                    <td colspan="6">
                      <span
                        class="badge badge-primary"
                      >
                        {{ day }}
                      </span>
                    </td>
                  </tr>

                  <!-- DATA -->
                  <template
                    v-for="item in jadwalData.filter(j => j.hari === day)"
                    :key="item.jam"
                  >
                    <tr>
                      <td></td>

                      <td class="time-text">
                        {{ item.jam }}
                      </td>

                      <td>
                        <strong>
                          {{ item.kelas }}
                        </strong>
                      </td>

                      <td>
                        {{ item.mapel }}
                      </td>

                      <td>
                        {{ item.ruang }}
                      </td>

                      <td>
                        <button
                          class="btn btn-outline btn-sm"
                          @click="openModal(item)"
                        >
                          Detail
                        </button>
                      </td>
                    </tr>
                  </template>

                  <!-- EMPTY -->
                  <tr
                    v-if="jadwalData.filter(j => j.hari === day).length === 0"
                  >
                    <td></td>

                    <td
                      colspan="5"
                      class="empty-text"
                    >
                      Tidak ada jadwal mengajar pada hari ini.
                    </td>
                  </tr>
                </template>
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
            Detail Jadwal
          </h3>

          <button
            class="modal-close-btn"
            @click="closeModal"
          >
            <X :size="20" />
          </button>
        </div>

        <div
          v-if="selectedJadwal"
          class="modal-body"
        >
          <div class="detail-item">
            <span>Hari</span>
            <strong>{{ selectedJadwal.hari }}</strong>
          </div>

          <div class="detail-item">
            <span>Jam</span>
            <strong>{{ selectedJadwal.jam }}</strong>
          </div>

          <div class="detail-item">
            <span>Kelas</span>
            <strong>{{ selectedJadwal.kelas }}</strong>
          </div>

          <div class="detail-item">
            <span>Mata Pelajaran</span>
            <strong>{{ selectedJadwal.mapel }}</strong>
          </div>

          <div class="detail-item">
            <span>Ruang</span>
            <strong>{{ selectedJadwal.ruang }}</strong>
          </div>

          <div class="modal-footer">
            <button
              class="btn btn-outline"
              @click="closeModal"
            >
              Tutup
            </button>

            <button class="btn btn-primary">
              Edit Jadwal
            </button>
          </div>
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
  --warning: #F59E0B;
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

.page-title {
  font-size: 1.75rem;
  color: var(--secondary);
}

.page-subtitle {
  margin-top: 0.25rem;
  color: var(--text-muted);
}

.header-right {
  display: flex;
  align-items: center;
  gap: 1.5rem;
}

.search-bar {
  display: flex;
  align-items: center;

  width: 300px;

  background: white;

  border: 1px solid var(--border);
  border-radius: var(--radius-full);

  padding: 0.5rem 1rem;
}

.search-input {
  border: none;
  outline: none;
  width: 100%;
  background: transparent;
}

.search-icon {
  margin-right: 0.5rem;
  color: var(--text-muted);
}

.notification-btn {
  position: relative;

  width: 40px;
  height: 40px;

  border-radius: 50%;

  background: white;

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
  background: white;

  border-radius: var(--radius-lg);

  border: 1px solid var(--border);

  padding: 1.5rem;

  box-shadow: var(--shadow-sm);
}

.card-header {
  margin-bottom: 1.5rem;
}

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

  font-size: 0.85rem;
  color: var(--text-muted);

  border-bottom: 1px solid var(--border);
}

td {
  padding: 1rem 1.5rem;
  border-bottom: 1px solid var(--border);
}

tr:hover td {
  background: var(--bg-app);
}

.day-row td {
  background: var(--bg-app);
}

.time-text {
  font-weight: 600;
  color: var(--secondary);
}

.empty-text {
  color: var(--text-muted);
  font-style: italic;
}

/* =========================
   BUTTON
========================= */

.btn {
  padding: 0.75rem 1.25rem;

  border-radius: var(--radius-md);

  transition: var(--transition);

  border: none;

  cursor: pointer;
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

.btn-outline:hover {
  border-color: var(--primary);
  color: var(--primary);
}

.btn-sm {
  padding: 0.5rem 1rem;
  font-size: 0.85rem;
}

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
  width: 100%;
  max-width: 500px;

  background: white;

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

.modal-title {
  font-size: 1.25rem;
}

.modal-close-btn {
  padding: 0.25rem;

  border-radius: var(--radius-md);

  color: var(--text-muted);
}

.modal-close-btn:hover {
  background: var(--bg-app);
  color: var(--danger);
}

.detail-item {
  display: flex;
  justify-content: space-between;

  padding: 0.85rem 0;

  border-bottom: 1px solid var(--border);
}

.detail-item span {
  color: var(--text-muted);
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;

  margin-top: 2rem;
}

/* =========================
   RESPONSIVE
========================= */

@media (max-width: 768px) {
  .sidebar {
    transform: translateX(-100%);
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