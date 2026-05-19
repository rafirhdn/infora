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
   DATA KELAS
========================= */
const initialKelas = [
  { id: 1, nama: 'X RPL A', jurusan: 'RPL', tingkat: 10, jumlahSiswa: 32 },
  { id: 2, nama: 'XI DKV B', jurusan: 'DKV', tingkat: 11, jumlahSiswa: 34 },
  { id: 3, nama: 'XII Animasi C', jurusan: 'Animasi', tingkat: 12, jumlahSiswa: 36 },
]

const kelasList = ref(initialKelas)

const isModalOpen = ref(false)
const modalMode = ref('add')

const formData = ref({
  nama: '',
  jurusan: 'RPL',
  tingkat: 10
})

/* =========================
   ASSIGN SISWA MODAL
========================= */
const isAssignModalOpen = ref(false)
const selectedKelas = ref(null)

/* =========================
   METHODS
========================= */
const handleOpenModal = (mode, data = null) => {
  modalMode.value = mode

  if (data) {
    formData.value = {
      nama: data.nama,
      jurusan: data.jurusan,
      tingkat: data.tingkat
    }
  } else {
    formData.value = {
      nama: '',
      jurusan: 'RPL',
      tingkat: 10
    }
  }

  isModalOpen.value = true
}

const handleOpenAssignModal = (kelas) => {
  selectedKelas.value = kelas
  isAssignModalOpen.value = true
}

const closeModal = () => {
  isModalOpen.value = false
}

const closeAssignModal = () => {
  isAssignModalOpen.value = false
}

const handleSubmit = () => {
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

    <!-- Main -->
    <main class="main-content">
      <!-- HEADER -->
      <header class="top-header">
        <div class="header-left">
          <h1 class="page-title">Data Kelas</h1>

          <p class="page-subtitle">
            Kelola data kelas dan pembagian siswa
          </p>
        </div>

        <div class="header-right">
          <!-- Search -->
          <div class="search-bar">
            <Search :size="18" class="search-icon" />

            <input
              type="text"
              placeholder="Search anything..."
              class="search-input"
            />
          </div>

          <!-- Notification -->
          <button class="notification-btn">
            <Bell :size="20" />

            <span class="notification-dot"></span>
          </button>

          <!-- Profile -->
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

      <!-- CARD -->
      <div class="card">
        <div class="card-header">
          <h3>Daftar Kelas</h3>

          <button
            class="btn btn-primary"
            @click="handleOpenModal('add')"
          >
            <Plus :size="18" />
            Tambah Kelas
          </button>
        </div>

        <!-- TABLE -->
        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Kelas</th>
                <th>Jurusan</th>
                <th>Tingkat</th>
                <th>Jumlah Siswa</th>
                <th>Aksi</th>
              </tr>
            </thead>

            <tbody>
              <tr
                v-for="(item, index) in kelasList"
                :key="item.id"
              >
                <td>{{ index + 1 }}</td>

                <td>
                  <strong>{{ item.nama }}</strong>
                </td>

                <td>
                  <span class="badge badge-primary">
                    {{ item.jurusan }}
                  </span>
                </td>

                <td>
                  Kelas {{ item.tingkat }}
                </td>

                <td>
                  {{ item.jumlahSiswa }} Siswa
                </td>

                <td>
                  <div class="action-group">
                    <!-- Assign -->
                    <button
                      class="btn-icon"
                      title="Assign Siswa"
                      @click="handleOpenAssignModal(item)"
                    >
                      <Users :size="16" />
                    </button>

                    <!-- Edit -->
                    <button
                      class="btn-icon"
                      @click="handleOpenModal('edit', item)"
                    >
                      <Edit2 :size="16" />
                    </button>

                    <!-- Delete -->
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

    <!-- =========================
         MODAL TAMBAH / EDIT
    ========================== -->
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
                ? 'Tambah Kelas Baru'
                : 'Edit Kelas'
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
            <!-- Tingkat -->
            <div class="form-group">
              <label class="form-label">
                Tingkat
              </label>

              <select
                class="form-input"
                v-model="formData.tingkat"
              >
                <option :value="10">
                  Kelas 10 (X)
                </option>

                <option :value="11">
                  Kelas 11 (XI)
                </option>

                <option :value="12">
                  Kelas 12 (XII)
                </option>
              </select>
            </div>

            <!-- Jurusan -->
            <div class="form-group">
              <label class="form-label">
                Jurusan
              </label>

              <select
                class="form-input"
                v-model="formData.jurusan"
              >
                <option value="RPL">
                  RPL
                </option>

                <option value="DKV">
                  DKV
                </option>

                <option value="Animasi">
                  Animasi
                </option>
              </select>
            </div>

            <!-- Nama -->
            <div class="form-group">
              <label class="form-label">
                Nama / Grup Kelas
              </label>

              <input
                type="text"
                class="form-input"
                placeholder="Contoh: A / B / 1 / 2"
                v-model="formData.nama"
                required
              />
            </div>

            <!-- Footer -->
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

    <!-- =========================
         MODAL ASSIGN SISWA
    ========================== -->
    <div
      v-if="isAssignModalOpen"
      class="modal-overlay"
      @click="closeAssignModal"
    >
      <div
        class="modal-content"
        @click.stop
      >
        <div class="modal-header">
          <h3 class="modal-title">
            Assign Siswa ke
            {{ selectedKelas?.nama }}
          </h3>

          <button
            class="modal-close-btn"
            @click="closeAssignModal"
          >
            <X :size="20" />
          </button>
        </div>

        <div class="modal-body">
          <p class="assign-desc">
            Fitur pemilihan siswa dan assign massal
            akan ditambahkan di sini.
          </p>

          <div class="modal-footer">
            <button
              class="btn btn-outline"
              @click="closeAssignModal"
            >
              Tutup
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
  font-weight: 700;
}

.page-subtitle {
  margin-top: 0.3rem;
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

  background: var(--bg-surface);
  border: 1px solid var(--border);

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

  border-radius: var(--radius-lg);

  padding: 1.5rem;

  border: 1px solid var(--border);

  box-shadow: var(--shadow-sm);
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
  border: 1px solid var(--border);
  background: white;
}

.btn-outline:hover {
  border-color: var(--primary);
  color: var(--primary);
}

.btn-icon {
  width: 38px;
  height: 38px;

  display: flex;
  align-items: center;
  justify-content: center;

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

tr:last-child td {
  border-bottom: none;
}

tr:hover td {
  background: #FCFCFD;
}

/* Badge */
.badge {
  display: inline-block;

  padding: 0.3rem 0.8rem;

  border-radius: var(--radius-full);

  font-size: 0.75rem;
  font-weight: 600;
}

.badge-primary {
  background: var(--primary-light);
  color: var(--primary);
}

.action-group {
  display: flex;
  gap: 0.5rem;
}

/* Form */
.form-group {
  margin-bottom: 1.2rem;
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

  outline: none;
}

.form-input:focus {
  border-color: var(--primary);
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
  font-weight: 600;
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

.assign-desc {
  color: var(--text-muted);
  line-height: 1.7;
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

  .card-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 1rem;
  }
}
</style>