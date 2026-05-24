<script setup>
  import { ref, onMounted, computed } from 'vue'

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
    LogOut
  } from 'lucide-vue-next'

  definePageMeta({
    layout: false
  })

  const api = useApi()

  /* =========================
   DASHBOARD STATE
========================= */
  const dashboard = ref({
    total_jurusan: 0,
    total_kelas: 0,
    total_guru: 0,
    total_siswa: 0,
    semester_aktif: null,
    distribusi_jurusan: []
  })

  /* =========================
   FETCH DASHBOARD
========================= */
  const fetchDashboard = async () => {
    try {
      const response = await api('/dashboard')

      dashboard.value = response.data
    } catch (error) {
      console.error('ERROR DASHBOARD:', error)
    }
  }

  onMounted(() => {
    fetchDashboard()
  })

  /* =========================
   MAX BAR CHART
========================= */
  const maxSiswa = computed(() => {
    if (!dashboard.value.distribusi_jurusan.length) return 1

    return Math.max(
      ...dashboard.value.distribusi_jurusan.map(
        (jurusan) => jurusan.siswa_count
      )
    )
  })

  /* =========================
   SIDEBAR MENU
========================= */
  const adminMenus = [
    {
      label: 'Dashboard',
      path: '/manajemenAkademi/tataUsaha/dashboard',
      icon: LayoutDashboard
    },
    {
      label: 'Jurusan',
      path: '/manajemenAkademi/tataUsaha/jurusan',
      icon: Building2
    },
    {
      label: 'Kelas',
      path: '/manajemenAkademi/tataUsaha/kelas',
      icon: BookOpen
    },
    {
      label: 'Semester',
      path: '/manajemenAkademi/tataUsaha/semester',
      icon: Calendar
    },
    {
      label: 'Guru',
      path: '/manajemenAkademi/tataUsaha/guru',
      icon: Users
    },
    {
      label: 'Siswa',
      path: '/manajemenAkademi/tataUsaha/siswa',
      icon: GraduationCap
    },
    {
      label: 'Jadwal',
      path: '/manajemenAkademi/tataUsaha/jadwal',
      icon: ClipboardList
    },
    {
      label: 'Profil Saya',
      path: '/manajemenAkademi/tataUsaha/profile',
      icon: User
    }
  ]
</script>

<template>
  <div class="app-container">
    <!-- SIDEBAR -->
    <aside class="sidebar">
      <div class="sidebar-header">
        <div class="logo-box">
          <GraduationCap :size="28" />
        </div>

        <h2 class="brand-name">EduManage</h2>
      </div>

      <div class="sidebar-role-badge">
        <span class="badge badge-primary role-text">Admin / TU</span>
      </div>

      <nav class="sidebar-nav">
        <ul class="nav-list">
          <li v-for="(menu, index) in adminMenus" :key="index">
            <NuxtLink :to="menu.path" class="nav-link" active-class="active">
              <component :is="menu.icon" :size="20" />

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

    <!-- MAIN CONTENT -->
    <main class="main-content">
      <!-- HEADER -->
      <header class="top-header">
        <div>
          <h1 class="page-title">Dashboard</h1>

          <p class="page-subtitle">Selamat datang kembali, Admin</p>
        </div>

        <div class="header-right">
          <div class="search-bar">
            <Search :size="18" class="search-icon" />

            <input
              type="text"
              placeholder="Search anything..."
              class="search-input" />
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
              class="profile-avatar" />
          </div>
        </div>
      </header>

      <!-- SEMESTER -->
      <div class="card alert-card primary">
        <div class="alert-content">
          <div class="alert-icon">
            <Calendar :size="24" />
          </div>

          <div>
            <h4 class="alert-title">Semester Aktif</h4>

            <p class="alert-desc">
              Saat ini berada di semester

              <strong v-if="dashboard.semester_aktif">
                {{ dashboard.semester_aktif.nama }}
                -
                {{ dashboard.semester_aktif.status }}
              </strong>

              <span v-else>Belum ada semester aktif</span>
            </p>
          </div>
        </div>
      </div>

      <!-- STATISTIK -->
      <h2 class="section-title">Ringkasan Statistik</h2>

      <div class="grid-cards mb-4">
        <!-- JURUSAN -->
        <div class="card stat-card">
          <div class="stat-icon-wrapper">
            <div class="stat-icon bg-primary">
              <Building2 :size="24" />
            </div>
          </div>

          <div class="stat-content">
            <h3 class="stat-title">Total Jurusan</h3>

            <div class="stat-value-group">
              <span class="stat-value">
                {{ dashboard.total_jurusan }}
              </span>
            </div>
          </div>
        </div>

        <!-- KELAS -->
        <div class="card stat-card">
          <div class="stat-icon-wrapper">
            <div class="stat-icon bg-warning">
              <BookOpen :size="24" />
            </div>
          </div>

          <div class="stat-content">
            <h3 class="stat-title">Total Kelas</h3>

            <div class="stat-value-group">
              <span class="stat-value">
                {{ dashboard.total_kelas }}
              </span>
            </div>
          </div>
        </div>

        <!-- GURU -->
        <div class="card stat-card">
          <div class="stat-icon-wrapper">
            <div class="stat-icon bg-success">
              <Users :size="24" />
            </div>
          </div>

          <div class="stat-content">
            <h3 class="stat-title">Total Guru</h3>

            <div class="stat-value-group">
              <span class="stat-value">
                {{ dashboard.total_guru }}
              </span>
            </div>
          </div>
        </div>

        <!-- SISWA -->
        <div class="card stat-card">
          <div class="stat-icon-wrapper">
            <div class="stat-icon bg-danger">
              <GraduationCap :size="24" />
            </div>
          </div>

          <div class="stat-content">
            <h3 class="stat-title">Total Siswa</h3>

            <div class="stat-value-group">
              <span class="stat-value">
                {{ dashboard.total_siswa }}
              </span>
            </div>
          </div>
        </div>
      </div>

      <!-- DASHBOARD GRID -->
      <div class="dashboard-grid">
        <!-- DISTRIBUSI -->
        <div class="card">
          <div class="card-header">
            <h3>Distribusi Siswa per Jurusan</h3>

            <button class="btn btn-outline btn-sm">Lihat Detail</button>
          </div>

          <div class="chart-placeholder">
            <div
              class="bar-group"
              v-for="jurusan in dashboard.distribusi_jurusan"
              :key="jurusan.id_jurusan">
              <div class="bar-label">
                {{ jurusan.nama }}
              </div>

              <div class="bar-wrapper">
                <div
                  class="bar fill-primary"
                  :style="{
                    width: `${(jurusan.siswa_count / maxSiswa) * 100}%`
                  }"></div>
              </div>

              <div class="bar-value">
                {{ jurusan.siswa_count }}
              </div>
            </div>

            <div
              v-if="!dashboard.distribusi_jurusan.length"
              class="empty-chart">
              Belum ada data jurusan
            </div>
          </div>
        </div>

        <!-- AKTIVITAS -->
        <div class="card">
          <div class="card-header">
            <h3>Aktivitas Terbaru</h3>
          </div>

          <div class="activity-list">
            <div class="activity-item">
              <div class="activity-dot bg-primary"></div>

              <div class="activity-content">
                <p>
                  Dashboard berhasil terhubung dengan database sistem akademik
                </p>

                <span class="activity-time">Real-time data</span>
              </div>
            </div>

            <div class="activity-item">
              <div class="activity-dot bg-warning"></div>

              <div class="activity-content">
                <p>
                  Semester aktif saat ini:

                  <strong v-if="dashboard.semester_aktif">
                    {{ dashboard.semester_aktif.nama }}
                  </strong>
                </p>

                <span class="activity-time">Data semester</span>
              </div>
            </div>

            <div class="activity-item">
              <div class="activity-dot bg-success"></div>

              <div class="activity-content">
                <p>
                  Total siswa aktif:

                  <strong>
                    {{ dashboard.total_siswa }}
                  </strong>
                </p>

                <span class="activity-time">Data siswa</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<style scoped>
  :root {
    --primary: #ff6a3d;
    --primary-hover: #e85b31;
    --primary-light: #fff0eb;

    --secondary: #2c3e50;

    --text-main: #334155;
    --text-muted: #64748b;

    --bg-app: #f8fafc;
    --bg-surface: #ffffff;

    --success: #10b981;
    --success-light: #d1fae5;

    --warning: #f59e0b;
    --warning-light: #fef3c7;

    --danger: #ef4444;
    --danger-light: #fee2e2;

    --border: #e2e8f0;

    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);

    --shadow-md:
      0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);

    --shadow-lg: 0 20px 25px -5px rgb(0 0 0 / 0.15);

    --radius-md: 12px;
    --radius-lg: 24px;

    --radius-full: 9999px;

    --transition: all 0.25s ease;
  }

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  body {
    background: var(--bg-app);
    font-family: sans-serif;
    color: var(--text-main);
  }

  .app-container {
    display: flex;
    min-height: 100vh;
  }

  .sidebar {
    width: 260px;
    background: white;
    border-right: 1px solid var(--border);
    position: fixed;
    inset: 0 auto 0 0;
    display: flex;
    flex-direction: column;
  }

  .sidebar-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 24px;
  }

  .badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 999px;
    font-weight: 600;
  }

  .badge-primary {
    background: var(--primary-light);
    color: var(--primary);
  }

  .role-text {
    font-size: 12px;
  }

  .logo-box {
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--primary-light);
    color: var(--primary);
    border-radius: 12px;
  }

  .brand-name {
    font-size: 22px;
    font-weight: 700;
  }

  .sidebar-role-badge {
    padding: 0 24px 20px;
  }

  .sidebar-nav {
    flex: 1;
    padding: 0 16px;
  }

  .nav-list {
    list-style: none;
  }

  .nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    border-radius: 12px;
    color: var(--text-muted);
    text-decoration: none;
    transition: var(--transition);
  }

  .nav-link:hover {
    background: #f8fafc;
    color: var(--primary);
  }

  .nav-link.active {
    background: var(--primary);
    color: white;
  }

  .sidebar-footer {
    padding: 24px;
    border-top: 1px solid var(--border);
  }

  .btn-logout {
    width: 100%;
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    color: var(--danger);
    background: transparent;
  }

  .btn-logout:hover {
    background: var(--danger-light);
  }

  .main-content {
    flex: 1;
    margin-left: 260px;
    padding: 32px;
  }

  .top-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 32px;
  }

  .page-title {
    font-size: 32px;
    font-weight: 700;
  }

  .page-subtitle {
    margin-top: 4px;
    color: var(--text-muted);
  }

  .header-right {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .search-bar {
    width: 320px;
    display: flex;
    align-items: center;
    padding: 12px 16px;
    border: 1px solid var(--border);
    border-radius: 999px;
    background: white;
  }

  .search-input {
    width: 100%;
    border: none;
    outline: none;
    background: transparent;
  }

  .search-icon {
    margin-right: 8px;
    color: var(--text-muted);
  }

  .notification-btn {
    position: relative;
    width: 46px;
    height: 46px;
    border: 1px solid var(--border);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: white;
  }

  .notification-dot {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: red;
  }

  .profile-menu {
    display: flex;
    align-items: center;
    gap: 12px;
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
    font-size: 12px;
    color: var(--text-muted);
  }

  .profile-avatar {
    width: 46px;
    height: 46px;
    border-radius: 50%;
  }

  .card {
    background: var(--bg-surface);
    border-radius: var(--radius-lg);
    padding: 24px;
    border: 1px solid var(--border);
    box-shadow: var(--shadow-sm);
  }

  .card:hover {
    box-shadow: var(--shadow-md);
  }

  .card-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 24px;
  }

  .alert-card {
    display: flex;
    align-items: center;
    margin-bottom: 32px;
  }

  .alert-card.primary {
    background: var(--primary-light);
  }

  .alert-content {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .alert-icon {
    background: white;
    color: var(--primary);
    padding: 16px;
    border-radius: 50%;
  }

  .alert-title {
    color: var(--primary-hover);
  }

  .alert-desc {
    margin-top: 4px;
  }

  .btn {
    border: none;
    cursor: pointer;
    padding: 12px 18px;
    border-radius: 12px;
    font-weight: 500;
    transition: var(--transition);
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
    padding: 8px 14px;
    font-size: 14px;
  }

  .section-title {
    margin-bottom: 16px;
  }

  .grid-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 24px;
  }

  .mb-4 {
    margin-bottom: 32px;
  }

  .stat-card {
    display: flex;
    gap: 16px;
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
    font-size: 14px;
    color: var(--text-muted);
  }

  .stat-value-group {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .stat-value {
    font-size: 30px;
    font-weight: bold;
  }

  .dashboard-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 24px;
  }

  .chart-placeholder {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .bar-group {
    display: flex;
    align-items: center;
    gap: 16px;
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

  .activity-list {
    display: flex;
    flex-direction: column;
    gap: 24px;
  }

  .activity-item {
    display: flex;
    gap: 16px;
  }

  .activity-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin-top: 5px;
  }

  .activity-time {
    font-size: 12px;
    color: var(--text-muted);
  }

  @media (max-width: 1024px) {
    .dashboard-grid {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 768px) {
    .sidebar {
      display: none;
    }

    .main-content {
      margin-left: 0;
      padding: 20px;
    }

    .top-header {
      flex-direction: column;
      align-items: flex-start;
      gap: 20px;
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
      gap: 16px;
    }
  }
</style>
