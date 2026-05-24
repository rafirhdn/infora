<script setup>
  import { ref, onMounted } from 'vue'

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
    X,
    Check,
    LogOut
  } from 'lucide-vue-next'

  definePageMeta({
    layout: false
  })

  const api = useApi()

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

  const jurusanList = ref([])
  const filteredJurusan = ref([])
  const searchQuery = ref('')
  const isLoading = ref(false)
  const isModalOpen = ref(false)
  const modalMode = ref('add')
  const selectedId = ref(null)

  const formData = ref({
    nama: '',
    deskripsi: ''
  })

  const fetchJurusan = async () => {
    try {
      isLoading.value = true

      const response = await api('/jurusan')

      const data = Array.isArray(response) ? response : response.data || []

      jurusanList.value = data.map((item) => ({
        id: item.id_jurusan,
        nama: item.nama,
        deskripsi: item.deskripsi,

        // HASIL withCount('kelas')
        jumlahKelas: item.kelas_count || 0,

        // HASIL withCount('siswa')
        jumlahSiswa: item.siswa_count || 0,

        status: item.status === 'aktif' ? 'Aktif' : 'Nonaktif'
      }))

      filteredJurusan.value = jurusanList.value
    } catch (error) {
      console.error('Gagal mengambil data jurusan:', error)
    } finally {
      isLoading.value = false
    }
  }

  const handleNonaktif = async (id) => {
    try {
      await api(`/jurusan/${id}/nonaktifkan`, {
        method: 'PATCH'
      })

      await fetchJurusan()
    } catch (error) {
      console.error('Gagal menonaktifkan jurusan:', error)
    }
  }

  const handleAktif = async (id) => {
    try {
      await api(`/jurusan/${id}/aktifkan`, {
        method: 'PATCH'
      })

      await fetchJurusan()
    } catch (error) {
      console.error('Gagal mengaktifkan jurusan:', error)
    }
  }

  const handleSearch = () => {
    const keyword = searchQuery.value.toLowerCase()

    filteredJurusan.value = jurusanList.value.filter((item) => {
      return (
        item.nama.toLowerCase().includes(keyword) ||
        item.deskripsi.toLowerCase().includes(keyword)
      )
    })
  }

  const handleOpenModal = (mode, data = null) => {
    modalMode.value = mode

    if (data) {
      selectedId.value = data.id

      formData.value = {
        nama: data.nama,
        deskripsi: data.deskripsi
      }
    } else {
      selectedId.value = null

      formData.value = {
        nama: '',
        deskripsi: ''
      }
    }

    isModalOpen.value = true
  }

  const handleCloseModal = () => {
    isModalOpen.value = false
  }

  const handleSubmit = async () => {
    try {
      const isDuplicate = jurusanList.value.some((item) => {
        if (modalMode.value === 'edit' && item.id === selectedId.value) {
          return false
        }

        return (
          item.nama.toLowerCase().trim() ===
          formData.value.nama.toLowerCase().trim()
        )
      })

      if (isDuplicate) {
        alert('Nama jurusan sudah ada!')
        return
      }

      if (modalMode.value === 'add') {
        await api('/jurusan', {
          method: 'POST',

          body: {
            nama: formData.value.nama,
            deskripsi: formData.value.deskripsi,
            status: 'aktif'
          }
        })
      } else {
        await api(`/jurusan/${selectedId.value}`, {
          method: 'PUT',

          body: {
            nama: formData.value.nama,
            deskripsi: formData.value.deskripsi
          }
        })
      }

      await fetchJurusan()

      handleCloseModal()
    } catch (error) {
      console.error('Gagal menyimpan data:', error)
    }
  }

  const handleDelete = async (id) => {
    const confirmed = confirm('Yakin ingin menghapus jurusan ini?')

    if (!confirmed) return

    try {
      await api(`/jurusan/${id}`, {
        method: 'DELETE'
      })

      await fetchJurusan()
    } catch (error) {
      console.error('Gagal menghapus data:', error)
    }
  }

  onMounted(() => {
    fetchJurusan()
  })
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

    <!-- MAIN -->
    <main class="main-content">
      <!-- HEADER -->
      <header class="top-header">
        <div>
          <h1 class="page-title">Data Jurusan</h1>

          <p class="page-subtitle">Kelola program keahlian / jurusan sekolah</p>
        </div>

        <div class="header-right">
          <div class="search-bar">
            <Search :size="18" class="search-icon" />

            <input
              v-model="searchQuery"
              type="text"
              placeholder="Cari jurusan..."
              class="search-input"
              @input="handleSearch" />
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
              alt="Profile" />
          </div>
        </div>
      </header>

      <!-- CARD -->
      <div class="card">
        <div class="card-header">
          <div>
            <h3>Daftar Jurusan</h3>

            <p class="card-subtitle">Seluruh data jurusan sekolah</p>
          </div>

          <button class="btn btn-primary" @click="handleOpenModal('add')">
            <Plus :size="18" />

            Tambah Jurusan
          </button>
        </div>

        <!-- LOADING -->
        <div v-if="isLoading" class="loading-box">Memuat data...</div>

        <!-- TABLE -->
        <div v-else class="table-container">
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Jurusan</th>
                <th>Deskripsi</th>
                <th>Jumlah Kelas</th>
                <th>Jumlah Siswa</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="(item, index) in filteredJurusan" :key="item.id">
                <td>{{ index + 1 }}</td>

                <td>
                  <strong>
                    {{ item.nama }}
                  </strong>
                </td>

                <td>
                  {{ item.deskripsi }}
                </td>

                <td>
                  {{ item.jumlahKelas }}
                </td>

                <td>
                  {{ item.jumlahSiswa }}
                </td>

                <td>
                  <span
                    :class="[
                      'badge',
                      item.status === 'Aktif' ? 'badge-success' : 'badge-danger'
                    ]">
                    {{ item.status }}
                  </span>
                </td>

                <td>
                  <div class="action-group">
                    <!-- EDIT -->
                    <button
                      class="btn-icon"
                      @click="handleOpenModal('edit', item)">
                      <Edit2 :size="16" />
                    </button>

                    <!-- NONAKTIF / AKTIF -->
                    <button
                      v-if="item.status === 'Aktif'"
                      class="btn-icon text-warning"
                      @click="handleNonaktif(item.id)">
                      <X :size="16" />
                    </button>

                    <button
                      v-else
                      class="btn-icon text-success"
                      @click="handleAktif(item.id)">
                      <Check :size="16" />
                    </button>

                    <!-- DELETE -->
                    <button
                      class="btn-icon text-danger"
                      :disabled="item.status === 'Aktif'"
                      :class="{
                        'btn-disabled': item.status === 'Aktif'
                      }"
                      @click="handleDelete(item.id)">
                      <Trash2 :size="16" />
                    </button>
                  </div>
                </td>
              </tr>

              <tr v-if="filteredJurusan.length === 0">
                <td colspan="7" class="empty-table">Data jurusan kosong</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>

    <!-- MODAL -->
    <div v-if="isModalOpen" class="modal-overlay" @click="handleCloseModal">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h3 class="modal-title">
            {{ modalMode === 'add' ? 'Tambah Jurusan Baru' : 'Edit Jurusan' }}
          </h3>

          <button class="modal-close-btn" @click="handleCloseModal">
            <X :size="20" />
          </button>
        </div>

        <div class="modal-body">
          <form @submit.prevent="handleSubmit">
            <div class="form-group">
              <label class="form-label">Nama Jurusan</label>

              <input
                v-model="formData.nama"
                type="text"
                class="form-input"
                placeholder="Contoh: RPL"
                required />
            </div>

            <div class="form-group">
              <label class="form-label">Deskripsi</label>

              <input
                v-model="formData.deskripsi"
                type="text"
                class="form-input"
                placeholder="Contoh: Rekayasa Perangkat Lunak"
                required />
            </div>

            <div class="modal-footer">
              <button
                type="button"
                class="btn btn-outline"
                @click="handleCloseModal">
                Batal
              </button>

              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
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

    --text-main: #334155;
    --text-muted: #64748b;

    --bg-app: #f8fafc;

    --success: #10b981;
    --success-light: #d1fae5;

    --danger: #ef4444;
    --danger-light: #fee2e2;

    --border: #e2e8f0;

    --shadow-sm: 0 1px 2px rgb(0 0 0 / 0.05);

    --shadow-lg: 0 20px 25px -5px rgb(0 0 0 / 0.15);

    --transition: all 0.25s ease;
  }

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  .app-container {
    display: flex;
    min-height: 100vh;
    background: var(--bg-app);
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

    text-decoration: none;

    color: var(--text-muted);

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

    border: none;
    border-radius: 12px;

    background: transparent;

    cursor: pointer;

    color: var(--danger);
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

    background: white;

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
    background: white;

    border: 1px solid var(--border);
    border-radius: 24px;

    padding: 24px;

    box-shadow: var(--shadow-sm);
  }

  .card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;

    margin-bottom: 24px;
  }

  .card-subtitle {
    margin-top: 4px;
    color: var(--text-muted);
  }

  .btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;

    padding: 12px 18px;

    border: none;
    border-radius: 12px;

    cursor: pointer;
  }

  .btn-primary {
    background: var(--primary);
    color: white;
  }

  .btn-outline {
    border: 1px solid var(--border);
    background: white;
  }

  .table-container {
    overflow-x: auto;

    border: 1px solid var(--border);
    border-radius: 18px;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  .btn-disabled {
    opacity: 0.4;
    cursor: not-allowed;
  }

  .btn-disabled:hover {
    background: transparent !important;
  }

  th {
    background: #f8fafc;

    padding: 16px;

    text-align: left;

    color: var(--text-muted);
  }

  td {
    padding: 16px;
    border-top: 1px solid var(--border);
  }

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

  .badge-success {
    background: var(--success-light);
    color: var(--success);
  }

  .badge-danger {
    background: var(--danger-light);
    color: var(--danger);
  }

  .action-group {
    display: flex;
    gap: 8px;
  }

  .btn-icon {
    width: 38px;
    height: 38px;

    border: none;
    border-radius: 10px;

    cursor: pointer;

    background: transparent;

    display: flex;
    align-items: center;
    justify-content: center;
  }

  .btn-icon:hover {
    background: #f1f5f9;
  }

  .text-danger {
    color: var(--danger);
  }

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

    margin-bottom: 28px;
  }

  .text-warning {
    color: #f59e0b;
  }

  .text-success {
    color: #10b981;
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

    background: transparent;

    cursor: pointer;

    display: flex;
    align-items: center;
    justify-content: center;
  }

  .form-group {
    margin-bottom: 20px;
  }

  .form-label {
    display: block;

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
  }

  .form-input:focus {
    border-color: var(--primary);

    background: white;

    box-shadow: 0 0 0 4px rgba(255, 106, 61, 0.1);
  }

  .modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;

    margin-top: 32px;

    padding-top: 24px;

    border-top: 1px solid var(--border);
  }

  .loading-box,
  .empty-table {
    padding: 24px;
    text-align: center;
    color: var(--text-muted);
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

    .card-header {
      flex-direction: column;
      align-items: flex-start;

      gap: 16px;
    }

    .modal-content {
      padding: 24px;
    }
  }
</style>
