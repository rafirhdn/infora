<script setup>
import { ref } from 'vue'
import {
  Calendar,
  FileText,
  Bell,
  Search,
  GraduationCap,
  LogOut,
  LayoutDashboard,
  ClipboardCheck,
  User,
  Mail,
  Phone,
  Shield,
  Save
} from 'lucide-vue-next'

definePageMeta({
  layout: false
})

const guruMenus = [
  { label: 'Dashboard', path: 'dashboard', icon: LayoutDashboard },
  { label: 'Jadwal Mengajar', path: 'jadwal', icon: Calendar },
  { label: 'Input Nilai', path: 'nilai', icon: ClipboardCheck },
  { label: 'Tugas Siswa', path: 'tugas', icon: FileText },
  { label: 'Profil Saya', path: 'profile', icon: User }
]

const showModal = ref(false)

const profile = ref({
  name: 'Budi Santoso, S.Kom',
  email: 'budi.rpl@sekolah.id',
  phone: '081234567890',
  role: 'Guru Pengajar (RPL)'
})

const saveProfile = () => {
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
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
        <div
          class="card profile-card"
        >
          <div class="profile-top">
            <img
              src="https://ui-avatars.com/api/?name=Budi+Santoso&background=FF6A3D&color=fff&size=120"
              alt="Profile"
              class="profile-image"
            />

            <h2 class="profile-fullname">
              {{ profile.name }}
            </h2>

            <p class="profile-id">
              ID: GR-2026003
            </p>
          </div>

          <div class="form-group">
            <label class="form-label">
              <Mail
                :size="16"
                style="vertical-align: middle; margin-right: 6px"
              />

              Email
            </label>

            <input
              type="email"
              class="form-input"
              v-model="profile.email"
              disabled
            />
          </div>

          <div class="form-group">
            <label class="form-label">
              <Phone
                :size="16"
                style="vertical-align: middle; margin-right: 6px"
              />

              Nomor Telepon
            </label>

            <input
              type="text"
              class="form-input"
              v-model="profile.phone"
            />
          </div>

          <div class="form-group">
            <label class="form-label">
              <Shield
                :size="16"
                style="vertical-align: middle; margin-right: 6px"
              />

              Role / Peran
            </label>

            <input
              type="text"
              class="form-input"
              v-model="profile.role"
              disabled
            />
          </div>

          <div class="form-group">
            <label class="form-label">
              Password Baru
            </label>

            <input
              type="password"
              class="form-input"
              placeholder="••••••••"
            />
          </div>

          <button
            class="btn btn-primary save-btn"
            @click="saveProfile"
          >
            <Save :size="18" />
            Simpan Perubahan
          </button>
        </div>
      </div>
    </main>

    <!-- MODAL -->
    <div
      v-if="showModal"
      class="modal-overlay"
      @click="closeModal"
    >
      <div
        class="modal-content"
        @click.stop
      >
        <div class="modal-header">
          <h3 class="modal-title">
            Profil Berhasil Disimpan
          </h3>

          <button
            class="modal-close-btn"
            @click="closeModal"
          >
            ✕
          </button>
        </div>

        <div class="modal-body">
          <p>
            Perubahan data profil berhasil diperbarui.
          </p>
        </div>

        <div class="modal-footer">
          <button
            class="btn btn-primary"
            @click="closeModal"
          >
            Tutup
          </button>
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
  -webkit-font-smoothing: antialiased;
}

a {
  text-decoration: none;
  color: inherit;
}

button {
  border: none;
  outline: none;
  background: none;
  cursor: pointer;
  font-family: inherit;
}

.app-container {
  display: flex;
  min-height: 100vh;
}

/* SIDEBAR */

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

/* MAIN */

.main-content {
  flex: 1;
  margin-left: 260px;
  padding: 2rem;
}

/* HEADER */

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
  color: var(--text-muted);
  margin-top: 0.25rem;
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
  background: transparent;
  outline: none;
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
  color: var(--secondary);
}

.profile-role {
  font-size: 0.75rem;
  color: var(--text-muted);
}

.profile-avatar {
  width: 42px;
  height: 42px;
  border-radius: 50%;
}

/* CARD */

.card {
  background: var(--bg-surface);
  border-radius: var(--radius-lg);
  padding: 2rem;
  border: 1px solid var(--border);
  box-shadow: var(--shadow-sm);
}

.profile-card {
  max-width: 650px;
  margin: auto;
}

.profile-top {
  text-align: center;
  margin-bottom: 2rem;
}

.profile-image {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  border: 4px solid var(--primary-light);
}

.profile-fullname {
  margin-top: 1rem;
  color: var(--secondary);
}

.profile-id {
  color: var(--text-muted);
  margin-top: 0.35rem;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-label {
  display: block;
  margin-bottom: 0.5rem;
  color: var(--secondary);
  font-weight: 500;
}

.form-input {
  width: 100%;
  padding: 0.9rem 1rem;
  border-radius: var(--radius-md);
  border: 1px solid var(--border);
  background: #F8FAFC;
  transition: var(--transition);
}

.form-input:focus {
  outline: none;
  border-color: var(--primary);
  background: white;
  box-shadow: 0 0 0 3px rgba(255, 106, 61, 0.1);
}

.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.85rem 1.5rem;
  border-radius: var(--radius-md);
  transition: var(--transition);
  font-weight: 500;
}

.btn-primary {
  background: var(--primary);
  color: white;
  box-shadow: var(--shadow-orange);
}

.btn-primary:hover {
  background: var(--primary-hover);
}

.save-btn {
  width: 100%;
  margin-top: 1rem;
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

/* MODAL */

.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(15, 23, 42, 0.4);
  backdrop-filter: blur(4px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 999;
  animation: fadeIn 0.3s ease;
}

.modal-content {
  width: 100%;
  max-width: 500px;
  background: white;
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
}

.modal-title {
  color: var(--secondary);
  font-size: 1.2rem;
}

.modal-close-btn {
  color: var(--text-muted);
  font-size: 1.2rem;
}

.modal-body {
  color: var(--text-main);
  line-height: 1.6;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  margin-top: 2rem;
}

/* ANIMATION */

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

/* RESPONSIVE */

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
    flex-wrap: wrap;
  }

  .search-bar {
    width: 100%;
  }

  .profile-card {
    padding: 1.5rem;
  }
}
</style>