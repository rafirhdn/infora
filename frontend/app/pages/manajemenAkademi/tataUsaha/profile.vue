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
  { label: 'Profil Saya', path: 'profile', icon: User }
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
    <!-- Sidebar -->
    <Sidebar role="Admin / TU" :menus="adminMenus" />

    <!-- Main Content -->
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
  font-size: 1.8rem;
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
  margin-right: 0.5rem;
  color: var(--text-muted);
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
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);

  padding: 2rem;

  box-shadow: var(--shadow-sm);
  transition: var(--transition);
}

.card:hover {
  box-shadow: var(--shadow-md);
}

/* Profile */
.profile-wrapper {
  display: flex;
  justify-content: center;
}

.profile-card {
  width: 100%;
  max-width: 650px;
}

.profile-top {
  text-align: center;
  margin-bottom: 2rem;
}

.profile-large-avatar {
  width: 120px;
  height: 120px;

  border-radius: 50%;
  border: 4px solid var(--primary-light);
}

.profile-heading {
  margin-top: 1rem;
  color: var(--secondary);
}

.profile-id {
  margin-top: 0.4rem;
  color: var(--text-muted);
}

/* Form */
.form-group {
  margin-bottom: 1.5rem;
}

.form-label {
  display: flex;
  align-items: center;
  gap: 0.5rem;

  margin-bottom: 0.6rem;

  font-size: 0.95rem;
  font-weight: 500;

  color: var(--secondary);
}

.form-input {
  width: 100%;

  padding: 0.85rem 1rem;

  border: 1px solid var(--border);
  border-radius: var(--radius-md);

  background: #F8FAFC;

  transition: var(--transition);
}

.form-input:focus {
  outline: none;

  border-color: var(--primary);

  background: white;

  box-shadow:
    0 0 0 3px rgba(255, 106, 61, 0.1);
}

/* Buttons */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;

  border: none;
  cursor: pointer;

  padding: 0.8rem 1.4rem;

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

.full-width {
  width: 100%;
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
}

.modal-close-btn:hover {
  background: var(--bg-app);
}

.modal-description {
  color: var(--text-main);
  line-height: 1.6;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;

  margin-top: 2rem;
}

/* Animations */
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

  .profile-card {
    padding: 1.5rem;
  }

  .modal-content {
    margin: 1rem;
  }
}
</style>