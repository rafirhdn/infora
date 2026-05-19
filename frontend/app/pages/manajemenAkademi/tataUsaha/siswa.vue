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
  Edit2,
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
   DATA SISWA
========================= */
const initialSiswa = [
  {
    id: 1,
    nis: '20231001',
    nama: 'Andi Saputra',
    kelas: 'X RPL A',
    jurusan: 'RPL',
    ttl: 'Jakarta, 12 Mei 2007',
    hp: '081211223344'
  },
  {
    id: 2,
    nis: '20231002',
    nama: 'Bunga Lestari',
    kelas: 'XI DKV B',
    jurusan: 'DKV',
    ttl: 'Bandung, 05 Agustus 2006',
    hp: '085566778899'
  },
  {
    id: 3,
    nis: '20231003',
    nama: 'Citra Kirana',
    kelas: 'XII Animasi C',
    jurusan: 'Animasi',
    ttl: 'Surabaya, 20 Februari 2005',
    hp: '081999888777'
  }
]

const siswaList = ref(initialSiswa)

const isModalOpen = ref(false)
const modalMode = ref('add')

const formData = ref({
  nis: '',
  nama: '',
  kelas: '',
  jurusan: 'RPL',
  ttl: '',
  hp: ''
})

/* =========================
   MODAL
========================= */
const handleOpenModal = (mode, data = null) => {
  modalMode.value = mode

  if (data) {
    formData.value = { ...data }
  } else {
    formData.value = {
      nis: '',
      nama: '',
      kelas: '',
      jurusan: 'RPL',
      ttl: '',
      hp: ''
    }
  }

  isModalOpen.value = true
}

const closeModal = () => {
  isModalOpen.value = false
}

const handleSubmit = () => {
  if (modalMode.value === 'add') {
    siswaList.value.push({
      id: Date.now(),
      ...formData.value
    })
  } else {
    const index = siswaList.value.findIndex(
      item => item.id === formData.value.id
    )

    if (index !== -1) {
      siswaList.value[index] = { ...formData.value }
    }
  }

  closeModal()
}

const deleteSiswa = (id) => {
  siswaList.value = siswaList.value.filter(item => item.id !== id)
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
          <h1 class="page-title">Data Siswa</h1>

          <p class="page-subtitle">
            Kelola data induk siswa
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

      <!-- CARD -->
      <div class="card">
        <div class="card-header">
          <h3>Daftar Siswa</h3>

          <button
            class="btn btn-primary"
            @click="handleOpenModal('add')"
          >
            <Plus :size="18" />
            Tambah Siswa
          </button>
        </div>

        <!-- TABLE -->
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>NIS</th>
                <th>Nama Lengkap</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Tempat / Tanggal Lahir</th>
                <th>No. HP</th>
                <th>Aksi</th>
              </tr>
            </thead>

            <tbody>
              <tr
                v-for="item in siswaList"
                :key="item.id"
              >
                <td>
                  <strong>{{ item.nis }}</strong>
                </td>

                <td>{{ item.nama }}</td>

                <td>{{ item.kelas }}</td>

                <td>
                  <span class="badge badge-primary">
                    {{ item.jurusan }}
                  </span>
                </td>

                <td>{{ item.ttl }}</td>

                <td>{{ item.hp }}</td>

                <td>
                  <div class="action-group">
                    <button
                      class="btn-icon"
                      @click="handleOpenModal('edit', item)"
                    >
                      <Edit2 :size="16" />
                    </button>

                    <button
                      class="btn-icon text-danger"
                      @click="deleteSiswa(item.id)"
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
    </main>

    <!-- MODAL -->
    <div
      v-if="isModalOpen"
      class="modal-overlay"
      @click="closeModal"
    >
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h3 class="modal-title">
            {{
              modalMode === 'add'
                ? 'Tambah Siswa Baru'
                : 'Edit Data Siswa'
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
              <label class="form-label">NIS</label>

              <input
                type="text"
                class="form-input"
                v-model="formData.nis"
                required
              />
            </div>

            <div class="form-group">
              <label class="form-label">
                Nama Lengkap
              </label>

              <input
                type="text"
                class="form-input"
                v-model="formData.nama"
                required
              />
            </div>

            <div class="form-row">
              <div class="form-group flex-1">
                <label class="form-label">
                  Jurusan
                </label>

                <select
                  class="form-input"
                  v-model="formData.jurusan"
                >
                  <option value="RPL">RPL</option>
                  <option value="DKV">DKV</option>
                  <option value="Animasi">
                    Animasi
                  </option>
                </select>
              </div>

              <div class="form-group flex-1">
                <label class="form-label">
                  Kelas
                </label>

                <input
                  type="text"
                  class="form-input"
                  placeholder="Contoh: X RPL A"
                  v-model="formData.kelas"
                  required
                />
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">
                Tempat, Tanggal Lahir
              </label>

              <input
                type="text"
                class="form-input"
                placeholder="Bandung, 12 Agustus 2006"
                v-model="formData.ttl"
                required
              />
            </div>

            <div class="form-group">
              <label class="form-label">
                Nomor HP
              </label>

              <input
                type="text"
                class="form-input"
                v-model="formData.hp"
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
  font-size: 1.9rem;
  color: var(--secondary);
}

.page-subtitle {
  margin-top: 0.35rem;
  color: var(--text-muted);
}

.search-bar {
  display: flex;
  align-items: center;

  width: 300px;

  background: var(--bg-surface);
  border: 1px solid var(--border);
  border-radius: var(--radius-full);

  padding: 0.55rem 1rem;
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
  top: 8px;
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
  border-radius: var(--radius-lg);

  padding: 1.5rem;

  border: 1px solid var(--border);

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
  border-radius: var(--radius-lg);
  border: 1px solid var(--border);
}

table {
  width: 100%;
  border-collapse: collapse;
}

th {
  background: var(--bg-app);

  padding: 1rem 1.2rem;

  text-align: left;
  font-size: 0.85rem;
  font-weight: 600;

  color: var(--text-muted);

  border-bottom: 1px solid var(--border);
}

td {
  padding: 1rem 1.2rem;
  border-bottom: 1px solid var(--border);
}

tr:last-child td {
  border-bottom: none;
}

tr:hover td {
  background: #fcfcfc;
}

/* Badge */
.badge {
  display: inline-block;

  padding: 0.35rem 0.75rem;

  border-radius: var(--radius-full);

  font-size: 0.75rem;
  font-weight: 600;
}

.badge-primary {
  background: var(--primary-light);
  color: var(--primary);
}

/* Buttons */
.btn {
  display: inline-flex;
  align-items: center;
  justify-content: center;

  gap: 0.5rem;

  padding: 0.75rem 1.2rem;

  border: none;
  cursor: pointer;

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
  background: white;
  border: 1px solid var(--border);
}

.btn-outline:hover {
  border-color: var(--primary);
  color: var(--primary);
}

.btn-icon {
  display: flex;
  align-items: center;
  justify-content: center;

  width: 36px;
  height: 36px;

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

.text-danger:hover {
  background: var(--danger-light);
  color: var(--danger);
}

.action-group {
  display: flex;
  gap: 0.5rem;
}

/* Form */
.form-group {
  margin-bottom: 1rem;
}

.form-row {
  display: flex;
  gap: 1rem;
}

.flex-1 {
  flex: 1;
}

.form-label {
  display: block;

  margin-bottom: 0.5rem;

  font-weight: 500;
}

.form-input {
  width: 100%;

  padding: 0.8rem 1rem;

  border: 1px solid var(--border);
  border-radius: var(--radius-md);

  background: #F8FAFC;

  transition: var(--transition);
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

  z-index: 999;
}

.modal-content {
  width: 100%;
  max-width: 550px;

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
  font-size: 1.2rem;
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

/* Animation */
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
@media (max-width: 1024px) {
  .main-content {
    margin-left: 0;
  }
}

@media (max-width: 768px) {
  .main-content {
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

  .card-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
  }

  .form-row {
    flex-direction: column;
  }
}
</style>