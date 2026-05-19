<script setup>
import { ref } from 'vue'
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
  User,
  Save,
  Filter,
  Download,
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

/* =========================
   STATE
========================= */
const activeTab = ref('input')

const selectedKelas = ref('X RPL A')
const selectedMapel = ref('Pemrograman Web')
const selectedKD = ref('3.1 Memahami Konsep Web Server')

const showSaveModal = ref(false)
const showExportModal = ref(false)

const siswaList = ref([
  {
    id: 1,
    nis: '20231001',
    nama: 'Andi Saputra',
    sikap: 'B',
    pengetahuan: 85,
    keterampilan: 88
  },
  {
    id: 2,
    nis: '20231002',
    nama: 'Bunga Lestari',
    sikap: 'A',
    pengetahuan: 90,
    keterampilan: 92
  },
  {
    id: 3,
    nis: '20231003',
    nama: 'Citra Kirana',
    sikap: 'A',
    pengetahuan: 95,
    keterampilan: 96
  },
  {
    id: 4,
    nis: '20231004',
    nama: 'Doni Setiawan',
    sikap: 'C',
    pengetahuan: 70,
    keterampilan: 75
  }
])

/* =========================
   FUNCTIONS
========================= */
const hitungNilaiAkhir = (siswa) => {
  return (
    (siswa.pengetahuan + siswa.keterampilan) / 2
  ).toFixed(1)
}

const getPredikat = (nilai) => {
  if (nilai >= 90) return 'A'
  if (nilai >= 80) return 'B'
  if (nilai >= 70) return 'C'
  return 'D'
}

const simpanNilai = () => {
  showSaveModal.value = true
}

const exportNilai = () => {
  showExportModal.value = true
}
</script>

<template>
  <div class="app-container">
    <!-- =========================
         SIDEBAR
    ========================= -->
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

    <!-- =========================
         MAIN CONTENT
    ========================= -->
    <main class="main-content">
      <!-- HEADER -->
      <header class="top-header">
        <div class="header-left">
          <h1 class="page-title">
            Input Nilai Siswa
          </h1>

          <p class="page-subtitle">
            Masukkan dan kelola nilai sikap,
            pengetahuan, dan keterampilan
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

      <!-- PAGE -->
      <div class="dashboard-page">
        <!-- TABS -->
        <div class="tabs-wrapper">
          <button
            :class="[
              'btn',
              activeTab === 'input'
                ? 'btn-primary'
                : 'btn-outline'
            ]"
            @click="activeTab = 'input'"
          >
            Input Nilai per Kelas
          </button>

          <button
            :class="[
              'btn',
              activeTab === 'review'
                ? 'btn-primary'
                : 'btn-outline'
            ]"
            @click="activeTab = 'review'"
          >
            Review Nilai
          </button>
        </div>

        <!-- FILTER -->
        <div class="card mb-4">
          <div class="filter-grid">
            <div>
              <label class="form-label">
                Pilih Kelas
              </label>

              <select
                class="form-input"
                v-model="selectedKelas"
              >
                <option value="X RPL A">
                  X RPL A
                </option>

                <option value="XI RPL B">
                  XI RPL B
                </option>
              </select>
            </div>

            <div>
              <label class="form-label">
                Mata Pelajaran
              </label>

              <select
                class="form-input"
                v-model="selectedMapel"
              >
                <option value="Pemrograman Web">
                  Pemrograman Web
                </option>
              </select>
            </div>

            <div>
              <label class="form-label">
                Kompetensi Dasar (KD)
              </label>

              <select
                class="form-input"
                v-model="selectedKD"
              >
                <option
                  value="3.1 Memahami Konsep Web Server"
                >
                  3.1 Memahami Konsep Web Server
                </option>

                <option
                  value="4.1 Menyajikan Konsep Web Server"
                >
                  4.1 Menyajikan Konsep Web Server
                </option>
              </select>
            </div>

            <button
              class="btn btn-primary filter-btn"
            >
              <Filter :size="18" />
              Terapkan
            </button>
          </div>
        </div>

        <!-- INPUT TAB -->
        <div
          class="card"
          v-if="activeTab === 'input'"
        >
          <div class="card-header">
            <h3>
              Form Input:
              {{ selectedKelas }} -
              {{ selectedKD }}
            </h3>

            <button
              class="btn btn-success"
              @click="simpanNilai"
            >
              <Save :size="18" />
              Simpan Nilai
            </button>
          </div>

          <div class="table-container">
            <table>
              <thead>
                <tr>
                  <th>No</th>
                  <th>NIS</th>
                  <th>Nama Lengkap</th>
                  <th style="text-align: center">
                    Sikap
                  </th>
                  <th style="text-align: center">
                    Pengetahuan
                  </th>
                  <th style="text-align: center">
                    Keterampilan
                  </th>
                  <th style="text-align: center">
                    Nilai Akhir
                  </th>
                  <th style="text-align: center">
                    Predikat
                  </th>
                </tr>
              </thead>

              <tbody>
                <tr
                  v-for="(item, index) in siswaList"
                  :key="item.id"
                >
                  <td>{{ index + 1 }}</td>

                  <td>{{ item.nis }}</td>

                  <td>
                    <strong>
                      {{ item.nama }}
                    </strong>
                  </td>

                  <td style="width: 100px">
                    <select
                      class="form-input input-mini"
                      v-model="item.sikap"
                    >
                      <option value="A">A</option>
                      <option value="B">B</option>
                      <option value="C">C</option>
                      <option value="D">D</option>
                    </select>
                  </td>

                  <td style="width: 120px">
                    <input
                      type="number"
                      class="form-input input-mini"
                      v-model.number="
                        item.pengetahuan
                      "
                    />
                  </td>

                  <td style="width: 120px">
                    <input
                      type="number"
                      class="form-input input-mini"
                      v-model.number="
                        item.keterampilan
                      "
                    />
                  </td>

                  <td
                    class="nilai-akhir"
                    :class="
                      hitungNilaiAkhir(item) >= 75
                        ? 'text-success'
                        : 'text-danger'
                    "
                  >
                    {{ hitungNilaiAkhir(item) }}
                  </td>

                  <td style="text-align: center">
                    <span
                      :class="[
                        'badge',
                        getPredikat(
                          hitungNilaiAkhir(item)
                        ) === 'A' ||
                        getPredikat(
                          hitungNilaiAkhir(item)
                        ) === 'B'
                          ? 'badge-success'
                          : 'badge-danger'
                      ]"
                    >
                      {{
                        getPredikat(
                          hitungNilaiAkhir(item)
                        )
                      }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- REVIEW TAB -->
        <div class="card" v-else>
          <div class="card-header">
            <h3>
              Review Nilai:
              {{ selectedKelas }} -
              {{ selectedMapel }}
            </h3>

            <button
              class="btn btn-outline btn-sm"
              @click="exportNilai"
            >
              <Download :size="16" />
              Export ke Excel
            </button>
          </div>

          <div class="table-container">
            <table>
              <thead>
                <tr>
                  <th>No</th>
                  <th>NIS</th>
                  <th>Nama Lengkap</th>
                  <th>Sikap</th>
                  <th>Pengetahuan</th>
                  <th>Keterampilan</th>
                  <th>Nilai Akhir</th>
                  <th>Predikat</th>
                  <th>Status</th>
                </tr>
              </thead>

              <tbody>
                <tr
                  v-for="(item, index) in siswaList"
                  :key="item.id"
                >
                  <td>{{ index + 1 }}</td>

                  <td>{{ item.nis }}</td>

                  <td>
                    <strong>
                      {{ item.nama }}
                    </strong>
                  </td>

                  <td>{{ item.sikap }}</td>

                  <td>
                    {{ item.pengetahuan }}
                  </td>

                  <td>
                    {{ item.keterampilan }}
                  </td>

                  <td
                    class="nilai-akhir"
                    :class="
                      hitungNilaiAkhir(item) >= 75
                        ? 'text-success'
                        : 'text-danger'
                    "
                  >
                    {{ hitungNilaiAkhir(item) }}
                  </td>

                  <td>
                    <span
                      :class="[
                        'badge',
                        getPredikat(
                          hitungNilaiAkhir(item)
                        ) === 'A' ||
                        getPredikat(
                          hitungNilaiAkhir(item)
                        ) === 'B'
                          ? 'badge-success'
                          : 'badge-danger'
                      ]"
                    >
                      {{
                        getPredikat(
                          hitungNilaiAkhir(item)
                        )
                      }}
                    </span>
                  </td>

                  <td>
                    <span class="text-success">
                      Tersimpan
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </main>

    <!-- =========================
         MODAL SIMPAN
    ========================= -->
    <div
      v-if="showSaveModal"
      class="modal-overlay"
      @click="showSaveModal = false"
    >
      <div
        class="modal-content"
        @click.stop
      >
        <div class="modal-header">
          <h3 class="modal-title">
            Simpan Nilai
          </h3>

          <button
            class="modal-close-btn"
            @click="showSaveModal = false"
          >
            <X :size="20" />
          </button>
        </div>

        <div class="modal-body">
          <p>
            Nilai siswa untuk
            <strong>
              {{ selectedKelas }}
            </strong>
            berhasil disimpan.
          </p>
        </div>

        <div class="modal-footer">
          <button
            class="btn btn-primary"
            @click="showSaveModal = false"
          >
            Oke
          </button>
        </div>
      </div>
    </div>

    <!-- =========================
         MODAL EXPORT
    ========================= -->
    <div
      v-if="showExportModal"
      class="modal-overlay"
      @click="showExportModal = false"
    >
      <div
        class="modal-content"
        @click.stop
      >
        <div class="modal-header">
          <h3 class="modal-title">
            Export Nilai
          </h3>

          <button
            class="modal-close-btn"
            @click="showExportModal = false"
          >
            <X :size="20" />
          </button>
        </div>

        <div class="modal-body">
          <p>
            Data nilai berhasil diexport ke
            format Excel.
          </p>
        </div>

        <div class="modal-footer">
          <button
            class="btn btn-primary"
            @click="showExportModal = false"
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

.app-container {
  display: flex;
  min-height: 100vh;
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
  padding: 0.85rem 1rem;
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
}

.sidebar-footer {
  padding: 1.5rem;
  border-top: 1px solid var(--border);
}

.btn-logout {
  width: 100%;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.75rem 1rem;
  border-radius: var(--radius-md);
  color: var(--danger);
  transition: var(--transition);
}

.btn-logout:hover {
  background: var(--danger-light);
}

/* =========================
   MAIN
========================= */

.main-content {
  flex: 1;
  padding: 2rem;
  margin-left: 260px;
}

.top-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
  padding-bottom: 1.5rem;
  border-bottom: 1px solid var(--border);
}

.page-title {
  font-size: 1.8rem;
}

.page-subtitle {
  color: var(--text-muted);
  margin-top: 0.3rem;
}

.header-right {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.search-bar {
  width: 300px;
  display: flex;
  align-items: center;
  background: white;
  border: 1px solid var(--border);
  border-radius: var(--radius-full);
  padding: 0.65rem 1rem;
}

.search-icon {
  margin-right: 0.5rem;
  color: var(--text-muted);
}

.search-input {
  border: none;
  outline: none;
  width: 100%;
  background: transparent;
}

.notification-btn {
  position: relative;
  width: 42px;
  height: 42px;
  border-radius: 50%;
  background: white;
  border: 1px solid var(--border);
  display: flex;
  align-items: center;
  justify-content: center;
}

.notification-dot {
  position: absolute;
  top: 10px;
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
  width: 42px;
  height: 42px;
  border-radius: 50%;
}

/* =========================
   COMPONENTS
========================= */

.card {
  background: white;
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

.tabs-wrapper {
  display: flex;
  gap: 1rem;
  margin-bottom: 1.5rem;
}

.btn {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  padding: 0.8rem 1.4rem;
  border-radius: var(--radius-md);
  transition: var(--transition);
  font-weight: 500;
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

.btn-success {
  background: var(--success);
  color: white;
}

.btn-sm {
  padding: 0.6rem 1rem;
}

.badge {
  padding: 0.3rem 0.8rem;
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

.badge-danger {
  background: var(--danger-light);
  color: var(--danger);
}

.text-success {
  color: var(--success);
}

.text-danger {
  color: var(--danger);
}

/* =========================
   FORM
========================= */

.filter-grid {
  display: flex;
  gap: 1rem;
  align-items: flex-end;
  flex-wrap: wrap;
}

.filter-grid > div {
  flex: 1;
  min-width: 180px;
}

.filter-btn {
  height: 46px;
}

.form-label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 500;
}

.form-input {
  width: 100%;
  padding: 0.75rem 1rem;
  border-radius: var(--radius-md);
  border: 1px solid var(--border);
  background: #f8fafc;
}

.form-input:focus {
  outline: none;
  border-color: var(--primary);
}

.input-mini {
  padding: 0.55rem;
  text-align: center;
}

/* =========================
   TABLE
========================= */

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
  padding: 1rem;
  font-size: 0.85rem;
  text-transform: uppercase;
  color: var(--text-muted);
}

td {
  padding: 1rem;
  border-top: 1px solid var(--border);
}

tr:hover td {
  background: #fafafa;
}

.nilai-akhir {
  text-align: center;
  font-size: 1.05rem;
  font-weight: 700;
}

/* =========================
   MODAL
========================= */

.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(15, 23, 42, 0.45);
  backdrop-filter: blur(4px);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 999;
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
  margin-bottom: 1rem;
}

.modal-title {
  font-size: 1.25rem;
  font-weight: 700;
}

.modal-close-btn {
  padding: 0.3rem;
  border-radius: var(--radius-md);
}

.modal-close-btn:hover {
  background: var(--bg-app);
  color: var(--danger);
}

.modal-footer {
  margin-top: 2rem;
  display: flex;
  justify-content: flex-end;
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
    flex-wrap: wrap;
  }

  .search-bar {
    width: 100%;
  }
}

/* =========================
   ANIMATION
========================= */

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

.mb-4 {
  margin-bottom: 1.5rem;
}
</style>