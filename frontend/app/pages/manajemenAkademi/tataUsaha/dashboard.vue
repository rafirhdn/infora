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
  TrendingUp,
  Bell,
  Search,
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
   MODAL
========================= */
const isSemesterModalOpen = ref(false)

const openSemesterModal = () => {
  isSemesterModalOpen.value = true
}

const closeSemesterModal = () => {
  isSemesterModalOpen.value = false
}
</script>

<template>
  <div class="app-container">
    <!-- Sidebar -->
    <Sidebar role="Admin / TU" :menus="adminMenus" />

    <!-- Main Content -->
    <main class="main-content">
      <!-- HEADER -->
      <header class="top-header">
        <div class="header-left">
          <h1 class="page-title">Dashboard</h1>
          <p class="page-subtitle">
            Selamat datang kembali, Admin
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
              <span class="profile-name">Admin Utama</span>
              <span class="profile-role">Admin / TU</span>
            </div>

            <img
              src="https://ui-avatars.com/api/?name=Admin+Utama&background=FF6A3D&color=fff"
              alt="Profile"
              class="profile-avatar"
            />
          </div>
        </div>
      </header>

      <!-- Alert Semester -->
      <div class="card alert-card primary">
        <div class="alert-content">
          <div class="alert-icon">
            <Calendar :size="24" />
          </div>

          <div>
            <h4 class="alert-title">Semester Aktif</h4>
            <p class="alert-desc">
              Saat ini berada di semester
              <strong>2026/2027 Ganjil - Aktif</strong>
            </p>
          </div>
        </div>

        <button class="btn btn-outline" @click="openSemesterModal">
          Ubah Semester
        </button>
      </div>

      <!-- Statistik -->
      <h2 class="section-title">Ringkasan Statistik</h2>

      <div class="grid-cards mb-4">
        <!-- Jurusan -->
        <div class="card stat-card">
          <div class="stat-icon-wrapper">
            <div class="stat-icon bg-primary">
              <Building2 :size="24" />
            </div>
          </div>

          <div class="stat-content">
            <h3 class="stat-title">Total Jurusan</h3>

            <div class="stat-value-group">
              <span class="stat-value">3</span>

              <span class="stat-trend success">
                <TrendingUp :size="14" />
                +1 baru
              </span>
            </div>
          </div>
        </div>

        <!-- Kelas -->
        <div class="card stat-card">
          <div class="stat-icon-wrapper">
            <div class="stat-icon bg-warning">
              <BookOpen :size="24" />
            </div>
          </div>

          <div class="stat-content">
            <h3 class="stat-title">Total Kelas</h3>

            <div class="stat-value-group">
              <span class="stat-value">18</span>
            </div>
          </div>
        </div>

        <!-- Guru -->
        <div class="card stat-card">
          <div class="stat-icon-wrapper">
            <div class="stat-icon bg-success">
              <Users :size="24" />
            </div>
          </div>

          <div class="stat-content">
            <h3 class="stat-title">Total Guru</h3>

            <div class="stat-value-group">
              <span class="stat-value">42</span>
            </div>
          </div>
        </div>

        <!-- Siswa -->
        <div class="card stat-card">
          <div class="stat-icon-wrapper">
            <div class="stat-icon bg-danger">
              <GraduationCap :size="24" />
            </div>
          </div>

          <div class="stat-content">
            <h3 class="stat-title">Total Siswa</h3>

            <div class="stat-value-group">
              <span class="stat-value">512</span>

              <span class="stat-trend success">
                <TrendingUp :size="14" />
                +12
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- Dashboard Grid -->
      <div class="dashboard-grid">
        <!-- Chart -->
        <div class="card">
          <div class="card-header">
            <h3>Distribusi Siswa per Jurusan</h3>

            <button class="btn btn-outline btn-sm">
              Lihat Detail
            </button>
          </div>

          <div class="chart-placeholder">
            <div class="bar-group">
              <div class="bar-label">RPL</div>

              <div class="bar-wrapper">
                <div class="bar fill-primary" style="width: 45%"></div>
              </div>

              <div class="bar-value">180</div>
            </div>

            <div class="bar-group">
              <div class="bar-label">DKV</div>

              <div class="bar-wrapper">
                <div class="bar fill-warning" style="width: 35%"></div>
              </div>

              <div class="bar-value">150</div>
            </div>

            <div class="bar-group">
              <div class="bar-label">Animasi</div>

              <div class="bar-wrapper">
                <div class="bar fill-success" style="width: 50%"></div>
              </div>

              <div class="bar-value">182</div>
            </div>
          </div>
        </div>

        <!-- Aktivitas -->
        <div class="card">
          <div class="card-header">
            <h3>Aktivitas Terbaru</h3>
          </div>

          <div class="activity-list">
            <div class="activity-item">
              <div class="activity-dot bg-primary"></div>

              <div class="activity-content">
                <p>
                  <strong>Admin</strong> menambahkan guru baru
                  Bpk. Budi Santoso
                </p>

                <span class="activity-time">
                  10 menit yang lalu
                </span>
              </div>
            </div>

            <div class="activity-item">
              <div class="activity-dot bg-warning"></div>

              <div class="activity-content">
                <p>
                  Semester
                  <strong>2026/2027 Ganjil</strong>
                  diaktifkan
                </p>

                <span class="activity-time">
                  2 jam yang lalu
                </span>
              </div>
            </div>

            <div class="activity-item">
              <div class="activity-dot bg-success"></div>

              <div class="activity-content">
                <p>
                  <strong>Waka Kurikulum</strong>
                  memperbarui KKM Mata Pelajaran RPL
                </p>

                <span class="activity-time">
                  1 hari yang lalu
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- MODAL -->
    <div
      v-if="isSemesterModalOpen"
      class="modal-overlay"
      @click="closeSemesterModal"
    >
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h3 class="modal-title">Ubah Semester</h3>

          <button
            class="modal-close-btn"
            @click="closeSemesterModal"
          >
            <X :size="20" />
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label class="form-label">Pilih Semester</label>

            <select class="form-input">
              <option>2026/2027 Ganjil</option>
              <option>2026/2027 Genap</option>
              <option>2025/2026 Genap</option>
            </select>
          </div>

          <div class="modal-footer">
            <button
              class="btn btn-outline"
              @click="closeSemesterModal"
            >
              Batal
            </button>

            <button
              class="btn btn-primary"
              @click="closeSemesterModal"
            >
              Simpan
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
  --success-light: #D1FAE5;

  --warning: #F59E0B;
  --warning-light: #FEF3C7;

  --danger: #EF4444;
  --danger-light: #FEE2E2;

  --border: #E2E8F0;

  --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
  --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1),
               0 2px 4px -2px rgb(0 0 0 / 0.1);

  --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1),
               0 4px 6px -4px rgb(0 0 0 / 0.1);

  --shadow-orange: 0 10px 15px -3px rgba(255, 106, 61, 0.2);

  --radius-md: 10px;
  --radius-lg: 16px;
  --radius-full: 9999px;

  --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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
  border-radius: var(--radius-lg);
  padding: 1.5rem;
  border: 1px solid var(--border);
  box-shadow: var(--shadow-sm);
}

.card:hover {
  box-shadow: var(--shadow-md);
}

/* Alert */
.alert-card {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}

.alert-card.primary {
  background: var(--primary-light);
}

.alert-content {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.alert-icon {
  background: white;
  color: var(--primary);
  padding: 1rem;
  border-radius: 50%;
}

.alert-title {
  color: var(--primary-hover);
}

.alert-desc {
  margin-top: 0.3rem;
}

/* Buttons */
.btn {
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

/* Stats */
.section-title {
  margin-bottom: 1rem;
}

.grid-cards {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 1.5rem;
}

.mb-4 {
  margin-bottom: 2rem;
}

.stat-card {
  display: flex;
  gap: 1rem;
  align-items: center;
}

.stat-icon {
  width: 56px;
  height: 56px;
  border-radius: 50%;

  display: flex;
  align-items: center;
  justify-content: center;

  color: white;
}

.bg-primary {
  background: var(--primary);
}

.bg-warning {
  background: var(--warning);
}

.bg-success {
  background: var(--success);
}

.bg-danger {
  background: var(--danger);
}

.stat-title {
  font-size: 0.9rem;
  color: var(--text-muted);
}

.stat-value-group {
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.stat-value {
  font-size: 1.8rem;
  font-weight: bold;
}

.stat-trend {
  display: flex;
  align-items: center;
  gap: 0.3rem;
  padding: 0.2rem 0.5rem;
  border-radius: 999px;
  font-size: 0.75rem;
}

.stat-trend.success {
  background: var(--success-light);
  color: var(--success);
}

/* Grid */
.dashboard-grid {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 1.5rem;
}

.card-header {
  display: flex;
  justify-content: space-between;
  margin-bottom: 1.5rem;
}

/* Chart */
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
  width: 70px;
}

.bar-wrapper {
  flex: 1;
  background: var(--bg-app);
  height: 12px;
  border-radius: 999px;
  overflow: hidden;
}

.bar {
  height: 100%;
  border-radius: 999px;
}

.fill-primary {
  background: var(--primary);
}

.fill-warning {
  background: var(--warning);
}

.fill-success {
  background: var(--success);
}

/* Activity */
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
}

.activity-time {
  font-size: 0.75rem;
  color: var(--text-muted);
}

/* Modal */
.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(15, 23, 42, 0.4);
  backdrop-filter: blur(4px);

  display: flex;
  justify-content: center;
  align-items: center;

  z-index: 1000;
}

.modal-content {
  width: 100%;
  max-width: 500px;

  background: var(--bg-surface);
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
  padding: 0.3rem;
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
}

.form-group {
  margin-bottom: 1rem;
}

.form-label {
  display: block;
  margin-bottom: 0.5rem;
}

.form-input {
  width: 100%;
  padding: 0.75rem 1rem;

  border: 1px solid var(--border);
  border-radius: var(--radius-md);

  background: #F8FAFC;
}

/* Responsive */
@media (max-width: 1024px) {
  .dashboard-grid {
    grid-template-columns: 1fr;
  }
}

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

  .alert-card {
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
  }
}
</style>