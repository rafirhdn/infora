<script setup>
import {
  Calendar,
  FileText,
  Clock,
  Bell,
  Search,
  GraduationCap,
  LogOut,
  LayoutDashboard,
  ClipboardCheck,
  User
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
        <span class="badge badge-primary role-text">Guru</span>
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
              <component :is="menu.icon" class="nav-icon" :size="20" />
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

    <!-- MAIN CONTENT -->
    <main class="main-content">
      <!-- HEADER -->
      <header class="top-header">
        <div class="header-left">
          <h1 class="page-title">Dashboard Guru</h1>
          <p class="page-subtitle">
            Selamat datang, Bpk. Budi Santoso
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
              <span class="profile-name">Budi Santoso</span>
              <span class="profile-role">Guru Pengajar</span>
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
        <h2 class="section-title">Agenda Hari Ini</h2>

        <div class="grid-cards mb-4">
          <!-- Jadwal 1 -->
          <div
            class="card stat-card"
            style="border-left: 4px solid var(--primary)"
          >
            <div class="stat-icon-wrapper">
              <div
                class="stat-icon"
                style="background: var(--bg-app); color: var(--primary)"
              >
                <Clock :size="24" />
              </div>
            </div>

            <div class="stat-content">
              <p
                class="stat-title"
                style="color: var(--primary); font-weight: 600"
              >
                07:00 - 09:15
              </p>

              <h3 style="font-size: 1.1rem; color: var(--secondary)">
                X RPL A
              </h3>

              <p
                style="font-size: 0.85rem; color: var(--text-muted)"
              >
                Pemrograman Web • Lab Komputer 1
              </p>
            </div>
          </div>

          <!-- Jadwal 2 -->
          <div
            class="card stat-card"
            style="border-left: 4px solid var(--warning)"
          >
            <div class="stat-icon-wrapper">
              <div
                class="stat-icon"
                style="background: var(--bg-app); color: var(--warning)"
              >
                <Clock :size="24" />
              </div>
            </div>

            <div class="stat-content">
              <p
                class="stat-title"
                style="color: var(--warning); font-weight: 600"
              >
                09:30 - 11:45
              </p>

              <h3 style="font-size: 1.1rem; color: var(--secondary)">
                XI RPL B
              </h3>

              <p
                style="font-size: 0.85rem; color: var(--text-muted)"
              >
                Basis Data • Lab Komputer 2
              </p>
            </div>
          </div>

          <!-- Jadwal Kosong -->
          <div
            class="card stat-card"
            style="border-left: 4px solid var(--border); opacity: 0.7"
          >
            <div class="stat-icon-wrapper">
              <div
                class="stat-icon"
                style="background: var(--bg-app); color: var(--text-muted)"
              >
                <Clock :size="24" />
              </div>
            </div>

            <div class="stat-content">
              <p
                class="stat-title"
                style="color: var(--text-muted); font-weight: 600"
              >
                12:30 - Selesai
              </p>

              <h3 style="font-size: 1.1rem; color: var(--text-muted)">
                Waktu Kosong
              </h3>

              <p
                style="font-size: 0.85rem; color: var(--text-muted)"
              >
                Persiapan materi / koreksi tugas
              </p>
            </div>
          </div>
        </div>

        <!-- GRID -->
        <div class="dashboard-grid">
          <!-- NOTIFIKASI -->
          <div class="card">
            <div class="card-header">
              <h3>Notifikasi Tugas & Penilaian</h3>

              <button class="btn btn-outline btn-sm">
                Lihat Semua
              </button>
            </div>

            <div class="activity-list">
              <div class="activity-item">
                <div class="activity-dot bg-danger"></div>

                <div class="activity-content">
                  <p>
                    <strong>X RPL A</strong>:
                    Tugas UTS Pemrograman Web menanti
                    untuk dinilai.
                  </p>

                  <span
                    class="activity-time"
                    style="color: var(--danger)"
                  >
                    Deadline nilai: Besok, 22 April
                  </span>
                </div>
              </div>

              <div class="activity-item">
                <div class="activity-dot bg-warning"></div>

                <div class="activity-content">
                  <p>
                    <strong>XI RPL B</strong>:
                    Ujian PTS Basis Data dijadwalkan
                    hari ini jam 09:30.
                  </p>

                  <span class="activity-time">
                    Hari ini
                  </span>
                </div>
              </div>

              <div class="activity-item">
                <div class="activity-dot bg-success"></div>

                <div class="activity-content">
                  <p>
                    <strong>XII RPL C</strong>:
                    100% siswa telah mengumpulkan
                    Tugas Akhir Semester.
                  </p>

                  <span class="activity-time">
                    1 jam yang lalu
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- PENGUMUMAN -->
          <div
            class="card"
            style="
              background: var(--primary);
              color: white;
              border: none;
            "
          >
            <div
              class="card-header"
              style="margin-bottom: 1rem"
            >
              <h3 style="color: white">Pengumuman</h3>

              <Bell :size="20" />
            </div>

            <div>
              <h4
                style="color: white; margin-bottom: 0.5rem"
              >
                Rapat Evaluasi Tengah Semester
              </h4>

              <p
                style="
                  font-size: 0.9rem;
                  opacity: 0.9;
                  margin-bottom: 1rem;
                  line-height: 1.5;
                "
              >
                Diberitahukan kepada seluruh dewan
                guru untuk menghadiri rapat evaluasi
                besok pukul 13.00 WIB di Ruang Guru.
              </p>

              <button
                class="btn"
                style="
                  background: white;
                  color: var(--primary);
                  width: 100%;
                "
              >
                Tandai Sudah Dibaca
              </button>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<style>
:root {
  /* Colors - Premium Orange & White Theme */
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
  -webkit-font-smoothing: antialiased;
}

h1,
h2,
h3,
h4,
h5,
h6 {
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

.app-container {
  display: flex;
  min-height: 100vh;
}

.main-content {
  flex: 1;
  padding: 2rem;
  overflow-y: auto;
  margin-left: 260px;
}

/* =========================
   SIDEBAR EXACT
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
  box-shadow: 2px 0 10px rgba(0,0,0,0.02);
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
  color: var(--secondary);
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
  overflow-y: auto;
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

.nav-icon {
  flex-shrink: 0;
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
   HEADER EXACT
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
  transition: var(--transition);
}

.search-bar:focus-within {
  border-color: var(--primary);
  box-shadow: 0 0 0 3px rgba(255, 106, 61, 0.1);
}

.search-icon {
  color: var(--text-muted);
  margin-right: 0.5rem;
}

.search-input {
  border: none;
  background: transparent;
  outline: none;
  width: 100%;
  font-family: inherit;
  font-size: 0.9rem;
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
  color: var(--text-main);
  transition: var(--transition);
}

.notification-btn:hover {
  color: var(--primary);
  border-color: var(--primary-light);
  background: var(--primary-light);
}

.notification-dot {
  position: absolute;
  top: 8px;
  right: 10px;
  width: 8px;
  height: 8px;
  background: var(--danger);
  border-radius: 50%;
  border: 2px solid var(--bg-surface);
}

.profile-menu {
  display: flex;
  align-items: center;
  gap: 1rem;
  cursor: pointer;
  padding: 0.5rem;
  border-radius: var(--radius-full);
  transition: var(--transition);
}

.profile-menu:hover {
  background: var(--bg-surface);
  box-shadow: var(--shadow-sm);
}

.profile-info {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

.profile-name {
  font-weight: 600;
  font-size: 0.9rem;
  color: var(--secondary);
}

.profile-role {
  font-size: 0.75rem;
  color: var(--text-muted);
}

.profile-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid var(--primary-light);
}

/* =========================
   GLOBAL UI
========================= */

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

.btn-sm {
  padding: 0.5rem 1rem;
  font-size: 0.85rem;
}

.badge {
  padding: 0.25rem 0.75rem;
  border-radius: var(--radius-full);
  font-size: 0.75rem;
  font-weight: 600;
  display: inline-block;
}

.badge-primary {
  background: var(--primary-light);
  color: var(--primary);
}

.page-title {
  font-size: 1.75rem;
  color: var(--secondary);
}

.page-subtitle {
  color: var(--text-muted);
  margin-top: 0.25rem;
}

/* =========================
   DASHBOARD
========================= */

.grid-cards {
  display: grid;
  grid-template-columns:
    repeat(auto-fit, minmax(240px, 1fr));
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

.bg-primary {
  background-color: var(--primary);
}

.bg-warning {
  background-color: var(--warning);
}

.bg-success {
  background-color: var(--success);
}

.bg-danger {
  background-color: var(--danger);
}

.stat-content {
  flex: 1;
}

.stat-title {
  font-size: 0.875rem;
  color: var(--text-muted);
  font-weight: 500;
  margin-bottom: 0.25rem;
}

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

/* =========================
   ANIMATION
========================= */

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

/* =========================
   RESPONSIVE
========================= */

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