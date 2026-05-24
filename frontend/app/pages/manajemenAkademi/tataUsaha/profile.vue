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
  Mail,
  Phone,
  Shield,
  Lock,
  Pencil,
  X,
  LogOut
} from 'lucide-vue-next'

definePageMeta({
  layout: false
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

/* =========================
   MODAL
========================= */
const isEditModalOpen = ref(false)

const openEditModal = () => {
  isEditModalOpen.value = true
}

const closeEditModal = () => {
  isEditModalOpen.value = false
}
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
          <li
            v-for="(menu, index) in adminMenus"
            :key="index"
          >
            <NuxtLink
              :to="menu.path"
              class="nav-link"
              active-class="active"
            >
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
          <h1 class="page-title">Profil Saya</h1>

          <p class="page-subtitle">
            Kelola informasi akun Anda
          </p>
        </div>

        <div class="header-right">
          <div class="search-bar">
            <Search :size="18" class="search-icon" />

            <input
              type="text"
              placeholder="Cari sesuatu..."
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
              class="profile-avatar"
              src="https://ui-avatars.com/api/?name=Admin+Utama&background=FF6A3D&color=fff"
              alt="Profile"
            />
          </div>
        </div>
      </header>

      <!-- PROFILE CARD -->
      <div class="profile-wrapper">
        <div class="card profile-card">
          <div class="profile-top">
            <img
              src="https://ui-avatars.com/api/?name=Admin+Utama&background=FF6A3D&color=fff&size=120"
              alt="Profile"
              class="profile-large-avatar"
            />

            <h2 class="profile-heading">
              Admin Utama
            </h2>

            <p class="profile-id">
              ID: ADM-2026001
            </p>
          </div>

          <div class="form-group">
            <label class="form-label">
              <Mail :size="16" />
              Email
            </label>

            <input
              type="email"
              class="form-input"
              value="admin@sekolah.id"
              disabled
            />
          </div>

          <div class="form-group">
            <label class="form-label">
              <Phone :size="16" />
              Nomor Telepon
            </label>

            <input
              type="text"
              class="form-input"
              value="081234567890"
            />
          </div>

          <div class="form-group">
            <label class="form-label">
              <Shield :size="16" />
              Role / Peran
            </label>

            <input
              type="text"
              class="form-input"
              value="Admin / Tata Usaha"
              disabled
            />
          </div>

          <div class="form-group">
            <label class="form-label">
              <Lock :size="16" />
              Password Baru
            </label>

            <input
              type="password"
              class="form-input"
              placeholder="••••••••"
            />
          </div>

          <button
            class="btn btn-primary full-width"
            @click="openEditModal"
          >
            <Pencil :size="18" />

            Simpan Perubahan
          </button>
        </div>
      </div>
    </main>

    <!-- MODAL -->
    <div
      v-if="isEditModalOpen"
      class="modal-overlay"
      @click="closeEditModal"
    >
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h3 class="modal-title">
            Konfirmasi Perubahan
          </h3>

          <button
            class="modal-close-btn"
            @click="closeEditModal"
          >
            <X :size="20" />
          </button>
        </div>

        <div class="modal-body">
          <p class="modal-description">
            Apakah Anda yakin ingin menyimpan perubahan profil?
          </p>

          <div class="modal-footer">
            <button
              class="btn btn-outline"
              @click="closeEditModal"
            >
              Batal
            </button>

            <button
              class="btn btn-primary"
              @click="closeEditModal"
            >
              Ya, Simpan
            </button>
          </div>
        </div>
      </div>
    </div>
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

  --danger: #ef4444;
  --danger-light: #fee2e2;

  --border: #e2e8f0;

  --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);

  --shadow-lg: 0 20px 25px -5px rgb(0 0 0 / 0.15);

  --radius-md: 12px;
  --radius-lg: 24px;

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
}

/* APP */

.app-container {
  display: flex;
  min-height: 100vh;
}

/* SIDEBAR */

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

.role-text {
  font-size: 12px;
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

/* MAIN */

.main-content {
  flex: 1;

  margin-left: 260px;

  padding: 32px;
}

/* HEADER */

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

/* CARD */

.card {
  background: white;

  border: 1px solid var(--border);
  border-radius: 24px;

  padding: 32px;

  box-shadow: var(--shadow-sm);
}

.profile-wrapper {
  display: flex;
  justify-content: center;
}

.profile-card {
  width: 100%;
  max-width: 700px;
}

.profile-top {
  text-align: center;
  margin-bottom: 32px;
}

.profile-large-avatar {
  width: 120px;
  height: 120px;

  border-radius: 50%;

  border: 4px solid var(--primary-light);
}

.profile-heading {
  margin-top: 16px;

  font-size: 28px;
  font-weight: 700;
}

.profile-id {
  margin-top: 6px;

  color: var(--text-muted);
}

/* FORM */

.form-group {
  margin-bottom: 20px;
}

.form-label {
  display: flex;
  align-items: center;
  gap: 8px;

  margin-bottom: 8px;

  font-size: 14px;
  font-weight: 600;
}

.form-input {
  width: 100%;

  padding: 14px 16px;

  border: 1px solid var(--border);
  border-radius: 14px;

  background: #f8fafc;

  outline: none;

  transition: var(--transition);
}

.form-input:focus {
  border-color: var(--primary);

  background: white;

  box-shadow: 0 0 0 4px rgba(255, 106, 61, 0.1);
}

/* BUTTON */

.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 8px;

  padding: 12px 18px;

  border: none;
  border-radius: 12px;

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

.full-width {
  width: 100%;
}

/* MODAL */

.modal-overlay {
  position: fixed;
  inset: 0;

  background: rgba(15, 23, 42, 0.55);

  backdrop-filter: blur(4px);

  display: flex;
  align-items: center;
  justify-content: center;

  padding: 24px;

  z-index: 999;
}

.modal-content {
  width: 100%;
  max-width: 500px;

  background: white;

  border-radius: 24px;

  padding: 32px;

  box-shadow: var(--shadow-lg);
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;

  margin-bottom: 24px;
}

.modal-title {
  font-size: 24px;
  font-weight: 700;
}

.modal-close-btn {
  width: 42px;
  height: 42px;

  border: none;
  border-radius: 12px;

  cursor: pointer;

  display: flex;
  align-items: center;
  justify-content: center;

  background: transparent;
}

.modal-close-btn:hover {
  background: #f1f5f9;
}

.modal-description {
  color: var(--text-main);
  line-height: 1.6;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 12px;

  margin-top: 32px;
}

/* BADGE */

.badge {
  display: inline-block;

  padding: 6px 12px;

  border-radius: 999px;

  font-size: 12px;
  font-weight: 600;
}

.badge-primary {
  background: var(--primary-light);

  color: var(--primary);
}

/* RESPONSIVE */

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

  .modal-content {
    padding: 24px;
  }
}
</style>