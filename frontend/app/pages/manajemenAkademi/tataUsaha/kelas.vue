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
    LogOut
  } from 'lucide-vue-next'

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
    { label: 'Guru', path: '/manajemenAkademi/tataUsaha/guru', icon: Users },
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

  definePageMeta({ layout: false })

  /* =========================
   API
========================= */
  const api = useApi()
  const API_JURUSAN =
    'http://127.0.0.1:8000/api/manajemen-akademik/admin/jurusan'

  /* =========================
   STATE
========================= */
  const kelasList = ref([])
  const jurusanList = ref([])
  const isLoading = ref(false)

  const isModalOpen = ref(false)
  const isAssignModalOpen = ref(false)

  const modalMode = ref('add')
  const selectedId = ref(null)
  const selectedKelas = ref(null)

  const formData = ref({
    nama: '',
    tingkat: 10,
    id_jurusan: null
  })

  /* =========================
   FETCH KELAS
========================= */
  const fetchKelas = async () => {
    try {
      isLoading.value = true

      const res = await api('/kelas')

      kelasList.value = res.map((item) => ({
        id_kelas: item.id_kelas,
        nama: item.nama,
        tingkat: item.tingkat,
        jurusan: item.jurusan?.nama || '-',
        id_jurusan: item.id_jurusan,
        jumlahSiswa: item.siswa_count ?? 0
      }))
    } catch (err) {
      alert('Gagal mengambil data kelas')
    } finally {
      isLoading.value = false
    }
  }

  /* =========================
   FETCH JURUSAN
========================= */
  const fetchJurusan = async () => {
    try {
      const res = await api('/jurusan')

      jurusanList.value = res.map((j) => ({
        id: j.id_jurusan,
        nama: j.nama
      }))
    } catch {
      alert('Gagal mengambil jurusan')
    }
  }

  /* =========================
   MODAL
========================= */
  const closeModal = () => {
    isModalOpen.value = false
    selectedId.value = null
  }

  const closeAssignModal = () => {
    isAssignModalOpen.value = false
    selectedKelas.value = null
  }

  const handleOpenModal = (mode, data = null) => {
    modalMode.value = mode

    if (data) {
      selectedId.value = data.id_kelas
      formData.value = {
        nama: data.nama,
        tingkat: data.tingkat,
        id_jurusan: data.id_jurusan
      }
    } else {
      selectedId.value = null
      formData.value = {
        nama: '',
        tingkat: 10,
        id_jurusan: null
      }
    }

    isModalOpen.value = true
  }

  /* =========================
   SUBMIT
========================= */
  const handleSubmit = async () => {
    try {
      if (modalMode.value === 'add') {
        await api('/kelas', {
          method: 'POST',
          body: formData.value
        })
      } else {
        await api(`/kelas/${selectedId.value}`, {
          method: 'PUT',
          body: formData.value
        })
      }

      closeModal()
      await fetchKelas()
    } catch (err) {
      alert(err?.data?.message || 'Gagal simpan data')
    }
  }

  /* =========================
   DELETE
========================= */
  const handleDelete = async (item) => {
    // SAFETY GUARD FRONTEND
    if (item.jumlahSiswa && item.jumlahSiswa > 0) {
      alert(
        'Kelas tidak bisa dihapus karena masih ada siswa di dalam kelas ini'
      )
      return
    }

    const ok = confirm(`Yakin ingin menghapus kelas "${item.nama}"?`)
    if (!ok) return

    try {
      await api(`/manajemen-akademik/admin/kelas/${item.id_kelas}`, {
        method: 'DELETE'
      })

      await fetchKelas()
    } catch (err) {
      alert(err?.data?.message || 'Gagal hapus kelas')
    }
  }

  /* =========================
   ASSIGN
========================= */
  const handleOpenAssignModal = (kelas) => {
    selectedKelas.value = kelas
    isAssignModalOpen.value = true
  }

  /* =========================
   INIT
========================= */
  onMounted(() => {
    fetchKelas()
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
          <h1 class="page-title">Data Kelas</h1>

          <p class="page-subtitle">Kelola data kelas dan pembagian siswa</p>
        </div>

        <div class="header-right">
          <div class="search-bar">
            <Search :size="18" class="search-icon" />

            <input
              type="text"
              placeholder="Cari kelas..."
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
            <h3>Daftar Kelas</h3>

            <p class="card-subtitle">Seluruh data kelas sekolah</p>
          </div>

          <button class="btn btn-primary" @click="handleOpenModal('add')">
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
              <tr v-for="(item, index) in kelasList" :key="item.id_kelas">
                <td>{{ index + 1 }}</td>

                <td>
                  <strong>{{ item.nama }}</strong>
                </td>

                <td>
                  <span class="badge badge-primary">
                    {{ item.jurusan }}
                  </span>
                </td>

                <td>Kelas {{ item.tingkat }}</td>

                <td>{{ item.jumlahSiswa }} Siswa</td>

                <td>
                  <div class="action-group">
                    <!-- ASSIGN -->
                    <button
                      class="btn-icon"
                      title="Assign Siswa"
                      @click="handleOpenAssignModal(item)">
                      <Users :size="16" />
                    </button>

                    <!-- EDIT -->
                    <button
                      class="btn-icon"
                      @click="handleOpenModal('edit', item)">
                      <Edit2 :size="16" />
                    </button>

                    <!-- DELETE (FIXED + SAFE) -->
                    <button
                      class="btn-icon text-danger"
                      :disabled="item.jumlahSiswa > 0"
                      :class="{
                        'opacity-50 cursor-not-allowed': item.jumlahSiswa > 0
                      }"
                      :title="
                        item.jumlahSiswa > 0
                          ? 'Tidak bisa dihapus (masih ada siswa)'
                          : 'Hapus kelas'
                      "
                      @click="item.jumlahSiswa > 0 ? null : handleDelete(item)">
                      <Trash2 :size="16" />
                    </button>
                  </div>

                  <!-- WARNING TEXT -->
                  <span
                    v-if="item.jumlahSiswa > 0"
                    class="text-warning"
                    style="font-size: 11px">
                    Tidak bisa dihapus (masih ada siswa)
                  </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>

    <!-- MODAL TAMBAH / EDIT -->
    <div v-if="isModalOpen" class="modal-overlay" @click="closeModal">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h3 class="modal-title">
            {{ modalMode === 'add' ? 'Tambah Kelas Baru' : 'Edit Kelas' }}
          </h3>

          <button class="modal-close-btn" @click="closeModal">
            <X :size="20" />
          </button>
        </div>

        <div class="modal-body">
          <form @submit.prevent="handleSubmit">
            <div class="form-group">
              <label class="form-label">Tingkat</label>

              <select class="form-input" v-model="formData.tingkat">
                <option :value="10">Kelas 10 (X)</option>

                <option :value="11">Kelas 11 (XI)</option>

                <option :value="12">Kelas 12 (XII)</option>
              </select>
            </div>

            <div class="form-group">
              <label class="form-label">Jurusan</label>

              <select class="form-input" v-model="formData.id_jurusan">
                <option v-for="j in jurusanList" :key="j.id" :value="j.id">
                  {{ j.nama }}
                </option>
              </select>
            </div>

            <div class="form-group">
              <label class="form-label">Nama / Grup Kelas</label>

              <input
                type="text"
                class="form-input"
                placeholder="Contoh: A / B / 1 / 2"
                v-model="formData.nama"
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

    <!-- MODAL ASSIGN -->
    <div
      v-if="isAssignModalOpen"
      class="modal-overlay"
      @click="closeAssignModal">
      <div class="modal-content" @click.stop>
        <div class="modal-header">
          <h3 class="modal-title">
            Assign Siswa ke
            {{ selectedKelas?.nama }}
          </h3>

          <button class="modal-close-btn" @click="closeAssignModal">
            <X :size="20" />
          </button>
        </div>

        <div class="modal-body">
          <p class="assign-desc">
            Fitur pemilihan siswa dan assign massal akan ditambahkan di sini.
          </p>

          <div class="modal-footer">
            <button class="btn btn-outline" @click="closeAssignModal">
              Tutup
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

  .assign-desc {
    color: var(--text-muted);
    line-height: 1.7;
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
  }
</style>
