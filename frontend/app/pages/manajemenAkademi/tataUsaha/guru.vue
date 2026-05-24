<script setup>
  import { ref, onMounted, computed, watch } from 'vue'

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

  const guruList = ref([])
  const jurusanList = ref([])

  const loading = ref(false)
  const search = ref('')
  const isModalOpen = ref(false)
  const modalMode = ref('add')
  const selectedId = ref(null)

  const formData = ref({
    nama: '',
    nik: '',
    email: '',
    password: '',
    nomor: '',
    id_jurusan: ''
  })

  const fetchGuru = async () => {
    try {
      loading.value = true

      const response = await api('/guru', {
        method: 'GET'
      })

      guruList.value = response.map((item) => ({
        ...item,
        nama: item.nama,
        email: item.akun?.email || '-'
      }))
    } catch (error) {
      console.error(error)
    } finally {
      loading.value = false
    }
  }

  const fetchJurusan = async () => {
    try {
      const response = await api('/jurusan', {
        method: 'GET'
      })

      jurusanList.value = response
    } catch (error) {
      console.error(error)
    }
  }

  const filteredGuru = computed(() => {
    return guruList.value.filter((item) => {
      const keyword = search.value.toLowerCase()

      return (
        item.nama?.toLowerCase().includes(keyword) ||
        item.akun?.email?.toLowerCase().includes(keyword) ||
        item.nik?.toLowerCase().includes(keyword)
      )
    })
  })

  const resetForm = () => {
    formData.value = {
      nama: '',
      nik: '',
      email: '',
      password: '',
      nomor: '',
      id_jurusan: ''
    }
  }

  const handleOpenModal = (mode, data = null) => {
    modalMode.value = mode

    if (data) {
      selectedId.value = data.id_guru

      formData.value = {
        nama: data.nama || '',
        nik: data.nik || '',
        email: data.akun?.email || '',
        password: '',
        nomor: data.nomor || '',
        id_jurusan: data.id_jurusan || ''
      }
    } else {
      selectedId.value = null
      resetForm()
    }

    isModalOpen.value = true
  }

  const closeModal = () => {
    isModalOpen.value = false
    selectedId.value = null
    resetForm()
  }

  const handleSubmit = async () => {
    if (loading.value) return

    loading.value = true

    try {
      const payload = {
        nama: formData.value.nama,
        nik: formData.value.nik,
        email: formData.value.email,
        nomor: formData.value.nomor,
        id_jurusan: formData.value.id_jurusan
      }

      if (modalMode.value === 'add') {
        payload.password = formData.value.password

        await api('/guru', {
          method: 'POST',
          body: payload
        })
      } else {
        await api(`/guru/${selectedId.value}`, {
          method: 'PUT',
          body: payload
        })
      }

      await fetchGuru()

      closeModal()
      resetForm()
    } catch (error) {
      console.error(error)

      alert(error?.data?.message || error?.message || 'Terjadi kesalahan')
    } finally {
      loading.value = false
    }
  }

  const handleDelete = async (id) => {
    const confirmed = confirm('Yakin ingin menghapus guru ini?')

    if (!confirmed) return

    try {
      await api(`/guru/${id}`, {
        method: 'DELETE'
      })

      await fetchGuru()
    } catch (error) {
      console.error(error)

      alert(error?.data?.message || error?.message || 'Gagal menghapus data')
    }
  }

  onMounted(async () => {
    await Promise.all([fetchGuru(), fetchJurusan()])
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
          <h1 class="page-title">Data Guru</h1>

          <p class="page-subtitle">Kelola data tenaga pendidik sekolah</p>
        </div>

        <div class="header-right">
          <div class="search-bar">
            <Search :size="18" class="search-icon" />

            <input
              v-model="search"
              type="text"
              placeholder="Cari guru..."
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
            <h3>Daftar Guru</h3>

            <p class="card-subtitle">Seluruh data tenaga pendidik sekolah</p>
          </div>

          <button class="btn btn-primary" @click="handleOpenModal('add')">
            <Plus :size="18" />

            Tambah Guru
          </button>
        </div>

        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>NIK/NIP</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Jurusan / Mapel</th>
                <th>Aksi</th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="(item, index) in filteredGuru" :key="item.id_guru">
                <td>{{ index + 1 }}</td>

                <td>
                  <strong>
                    {{ item.nama }}
                  </strong>
                </td>

                <td>{{ item.nik }}</td>

                <td>
                  {{ item.email }}
                </td>

                <td>
                  {{ item.nomor || '-' }}
                </td>

                <td>
                  <div
                    v-if="item.jadwal?.length"
                    style="display: flex; flex-wrap: wrap; gap: 6px">
                    <span
                      v-for="jadwal in item.jadwal"
                      :key="jadwal.id_jadwal"
                      class="badge badge-primary">
                      {{ jadwal.mata_pelajaran?.nama || '-' }}
                    </span>
                  </div>

                  <span v-else>-</span>
                </td>

                <td>
                  <div class="action-group">
                    <button
                      class="btn-icon"
                      @click="handleOpenModal('edit', item)">
                      <Edit2 :size="16" />
                    </button>

                    <button
                      class="btn-icon text-danger"
                      @click="handleDelete(item.id_guru)">
                      <Trash2 :size="16" />
                    </button>
                  </div>
                </td>
              </tr>

              <tr v-if="!loading && filteredGuru.length === 0">
                <td colspan="7" class="empty-state">
                  Data guru tidak ditemukan
                </td>
              </tr>

              <tr v-if="loading">
                <td colspan="7" class="empty-state">Memuat data...</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>

    <!-- MODAL -->
    <div v-if="isModalOpen" class="modal-overlay" @click="closeModal">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h3 class="modal-title">
            {{ modalMode === 'add' ? 'Tambah Guru' : 'Edit Guru' }}
          </h3>

          <button class="modal-close-btn" @click="closeModal">
            <X :size="20" />
          </button>
        </div>

        <form @submit.prevent="handleSubmit">
          <div class="form-grid">
            <div class="form-group full-width">
              <label class="form-label">Nama Lengkap</label>

              <input
                v-model="formData.nama"
                type="text"
                class="form-input"
                required />
            </div>

            <div class="form-group">
              <label class="form-label">NIK / NIP</label>

              <input
                v-model="formData.nik"
                type="text"
                class="form-input"
                required />
            </div>

            <div class="form-group">
              <label class="form-label">Nomor HP</label>

              <input
                v-model="formData.nomor"
                type="text"
                class="form-input"
                required />
            </div>

            <div class="form-group">
              <label class="form-label">Email</label>

              <input
                v-model="formData.email"
                type="email"
                class="form-input"
                required />
            </div>

            <div v-if="modalMode === 'add'" class="form-group">
              <label class="form-label">Password</label>

              <input
                v-model="formData.password"
                type="password"
                class="form-input"
                required />
            </div>

            <div class="form-group full-width">
              <label class="form-label">Jurusan Pengampu</label>
              <select v-model="formData.id_jurusan" class="form-input">
                <option value="">-- Tidak Spesifik --</option>

                <option
                  v-for="jurusan in jurusanList"
                  :key="jurusan.id_jurusan"
                  :value="jurusan.id_jurusan">
                  {{ jurusan.nama }}
                </option>
              </select>
            </div>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-outline" @click="closeModal">
              Batal
            </button>

            <button type="submit" class="btn btn-primary" :disabled="loading">
              Simpan
            </button>
          </div>
        </form>
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

  /* BUTTON */

  .btn {
    display: inline-flex;
    align-items: center;
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

  /* TABLE */

  .table-container {
    overflow-x: auto;

    border: 1px solid var(--border);
    border-radius: 18px;
  }

  table {
    width: 100%;

    border-collapse: collapse;
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

    display: flex;
    align-items: center;
    justify-content: center;

    background: transparent;
  }

  .btn-icon:hover {
    background: #f1f5f9;
  }

  .text-danger {
    color: var(--danger);
  }

  .text-danger:hover {
    background: var(--danger-light);
  }

  .empty-state {
    text-align: center;

    padding: 32px;

    color: var(--text-muted);
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
    max-width: 850px;

    max-height: 90vh;
    overflow-y: auto;

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

  /* FORM */

  .form-grid {
    display: grid;

    grid-template-columns: repeat(2, 1fr);

    gap: 20px;
  }

  .form-group.full-width {
    grid-column: span 2;
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

    transition: var(--transition);
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

    .card-header {
      flex-direction: column;
      align-items: flex-start;

      gap: 16px;
    }

    .modal-content {
      padding: 24px;
    }

    .form-grid {
      grid-template-columns: 1fr;
    }

    .form-group.full-width {
      grid-column: span 1;
    }
  }
</style>
