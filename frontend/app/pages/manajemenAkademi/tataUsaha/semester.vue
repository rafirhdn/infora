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
    Power,
    Trash2,
    X,
    LogOut
  } from 'lucide-vue-next'

  definePageMeta({
    layout: false
  })

  const search = ref('')

  const api = useApi()

  const semesterList = ref([])

  const isModalOpen = ref(false)

  const formData = ref({
    nama: '',
    mulai: '',
    selesai: ''
  })

  const fetchSemester = async () => {
    try {
      const response = await api('/manajemen-akademik/admin/semester')

      semesterList.value = response.map((item) => ({
        id: item.id_semester,
        nama: item.nama,
        mulai: item.tanggal_mulai,
        selesai: item.tanggal_selesai,
        status: item.status === 'aktif' ? 'Aktif' : 'Non-aktif'
      }))
    } catch (error) {
      console.error('Gagal mengambil data semester:', error)
    }
  }

  onMounted(() => {
    fetchSemester()
  })

  const filteredSemester = computed(() => {
    return semesterList.value.filter((item) =>
      item.nama.toLowerCase().includes(search.value.toLowerCase())
    )
  })

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

  const handleSubmit = async () => {
    try {
      const namaSplit = formData.value.nama.split(' ')

      const tahun = namaSplit[0]

      const tahunSplit = tahun.split('/')

      await api('/manajemen-akademik/admin/semester', {
        method: 'POST',

        body: {
          nama: formData.value.nama,

          tahun_ajaran_awal: tahunSplit[0],

          tahun_ajaran_akhir: tahunSplit[1],

          tanggal_mulai: formData.value.mulai,

          tanggal_selesai: formData.value.selesai,

          status: 'nonaktif'
        }
      })

      await fetchSemester()

      formData.value = {
        nama: '',
        mulai: '',
        selesai: ''
      }

      isModalOpen.value = false
    } catch (error) {
      console.error('Gagal menambah semester:', error)
    }
  }

  const handleSetAktif = async (id) => {
    try {
      await api(`/manajemen-akademik/admin/semester/${id}`, {
        method: 'PUT',

        body: {
          status: 'aktif'
        }
      })

      await fetchSemester()
    } catch (error) {
      console.error('Gagal mengaktifkan semester:', error)
    }
  }

  const handleDelete = async (id) => {
    const confirmDelete = confirm('Yakin ingin menghapus semester ini?')

    if (!confirmDelete) return

    try {
      await api(`/manajemen-akademik/admin/semester/${id}`, {
        method: 'DELETE'
      })

      alert('Semester berhasil dihapus')

      await fetchSemester()
    } catch (error) {
      console.error('Gagal menghapus semester:', error)

      if (error?.data?.message) {
        alert(error.data.message)
      } else {
        alert('Terjadi kesalahan saat menghapus semester')
      }
    }
  }
  const closeModal = () => {
    isModalOpen.value = false
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
          <h1 class="page-title">Data Semester</h1>

          <p class="page-subtitle">Kelola tahun ajaran dan semester aktif</p>
        </div>

        <div class="header-right">
          <div class="search-bar">
            <Search :size="18" class="search-icon" />

            <input
              type="text"
              placeholder="cari semester..."
              class="search-input"
              v-model="search" />
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

      <!-- CONTENT -->
      <div class="card">
        <div class="card-header">
          <h3>Daftar Semester</h3>

          <button class="btn btn-primary" @click="isModalOpen = true">
            <Plus :size="18" />
            Tambah Semester
          </button>
        </div>

        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Semester</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>

            <tbody>
              <tr v-for="(item, index) in filteredSemester" :key="item.id">
                <td>{{ index + 1 }}</td>

                <td>
                  <strong>{{ item.nama }}</strong>
                </td>

                <td>{{ item.mulai }}</td>

                <td>{{ item.selesai }}</td>

                <td>
                  <span
                    :class="[
                      'badge',
                      item.status === 'Aktif'
                        ? 'badge-success'
                        : 'badge-warning'
                    ]">
                    {{ item.status }}
                  </span>
                </td>

                <td>
                  <div class="action-group">
                    <button
                      :class="[
                        'btn',
                        'btn-sm',
                        item.status === 'Aktif' ? 'btn-outline' : 'btn-primary'
                      ]"
                      @click="handleSetAktif(item.id)"
                      :disabled="item.status === 'Aktif'">
                      <Power :size="14" />

                      {{
                        item.status === 'Aktif' ? 'Sedang Aktif' : 'Aktifkan'
                      }}
                    </button>

                    <button
                      class="btn-icon text-danger"
                      @click="handleDelete(item.id)">
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
    <div v-if="isModalOpen" class="modal-overlay" @click="closeModal">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h3 class="modal-title">Tambah Semester Baru</h3>

          <button class="modal-close-btn" @click="closeModal">
            <X :size="20" />
          </button>
        </div>

        <div class="modal-body">
          <form @submit.prevent="handleSubmit">
            <div class="form-group">
              <label class="form-label">Nama Semester</label>

              <input
                type="text"
                class="form-input"
                placeholder="Contoh: 2026/2027 Ganjil"
                v-model="formData.nama"
                required />
            </div>

            <div class="form-group">
              <label class="form-label">Tanggal Mulai</label>

              <input
                type="date"
                class="form-input"
                v-model="formData.mulai"
                required />
            </div>

            <div class="form-group">
              <label class="form-label">Tanggal Selesai</label>

              <input
                type="date"
                class="form-input"
                v-model="formData.selesai"
                required />
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-outline" @click="closeModal">
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

  body {
    overflow-x: hidden;
  }

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    min-width: 0;
  }

  body {
    background: var(--bg-app);
    font-family: sans-serif;
    color: var(--text-main);
  }

  /* LAYOUT */

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

    width: calc(100% - 260px);
    overflow-x: hidden;
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
    align-items: center;

    margin-bottom: 24px;
  }

  /* BUTTON */

  .btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;

    border: none;

    cursor: pointer;

    padding: 12px 18px;

    border-radius: 12px;

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

  .badge-success {
    background: var(--success-light);

    color: var(--success);
  }

  .badge-warning {
    background: var(--warning-light);

    color: var(--warning);
  }

  /* ACTION */

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

    margin-bottom: 28px;

    padding-bottom: 20px;

    border-bottom: 1px solid var(--border);
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

  .modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;

    margin-top: 32px;
  }

  .form-group {
    margin-bottom: 16px;
  }

  .form-label {
    display: block;

    margin-bottom: 8px;

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
  }
</style>
