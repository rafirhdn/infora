<script setup>
  import { ref, computed, onMounted } from 'vue'
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

  definePageMeta({ layout: false })

  const api = useApi()

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

  /* =========================
STATE
========================= */
  const jadwalList = ref([])
  const kelasList = ref([])
  const guruList = ref([])
  const semesterList = ref([])
  const mataPelajaranList = ref([])

  const loading = ref(false)
  const search = ref('')
  const errorMessage = ref('')

  /* =========================
MODAL
========================= */
  const isModalOpen = ref(false)
  const modalMode = ref('add')

  const defaultForm = () => ({
    id_jadwal: null,
    hari: 'senin',
    jam_mulai: '',
    jam_selesai: '',
    ruang: '',
    id_kelas: null,
    id_guru: null,
    id_semester: null,
    id_mata_pelajaran: null
  })

  const formData = ref(defaultForm())

  const resetForm = () => {
    formData.value = defaultForm()
    errorMessage.value = ''
  }

  /* =========================
FETCH DATA
========================= */
  const fetchJadwal = async () => {
    try {
      loading.value = true
      const response = await api('/jadwal')

      const raw =
        response?.data?.data?.data ||
        response?.data?.data ||
        response?.data ||
        []

      // NORMALISASI BIAR TEMPLATE GAK BINGUNG
      jadwalList.value = raw.map((item) => ({
        ...item,
        mata_pelajaran: item.mata_pelajaran || item.mataPelajaran || null,
        guru: item.guru || null,
        kelas: item.kelas || null
      }))
    } catch (err) {
      console.error(err)
    } finally {
      loading.value = false
    }
  }

  const fetchDropdown = async () => {
    try {
      const [kelas, guru, semester, mapel] = await Promise.all([
        api('/kelas'),
        api('/guru'),
        api('/semester'),
        api('/mata-pelajaran')
      ])

      kelasList.value = kelas?.data?.data || kelas?.data || kelas || []
      guruList.value = guru?.data?.data || guru?.data || guru || []
      semesterList.value =
        semester?.data?.data || semester?.data || semester || []
      mataPelajaranList.value = mapel?.data?.data || mapel?.data || mapel || []
    } catch (err) {
      console.error(err)
    }
  }

  onMounted(async () => {
    await fetchJadwal()
    await fetchDropdown()
  })

  /* =========================
SEARCH
========================= */
  const filteredJadwal = computed(() => {
    if (!search.value) return jadwalList.value

    const keyword = search.value.toLowerCase()

    return jadwalList.value.filter((item) => {
      const kelasText =
        `${item.kelas?.tingkat || ''} ${item.kelas?.jurusan?.nama || ''} ${item.kelas?.nama || ''}`.toLowerCase()

      return (
        kelasText.includes(keyword) ||
        item.mata_pelajaran?.nama ||
        item.mataPelajaran?.nama?.toLowerCase()?.includes(keyword) ||
        item.guru?.nama?.toLowerCase()?.includes(keyword) ||
        item.hari?.toLowerCase()?.includes(keyword) ||
        item.ruang?.toLowerCase()?.includes(keyword)
      )
    })
  })

  /* =========================
MODAL
========================= */
  const handleOpenModal = (mode, data = null) => {
    modalMode.value = mode
    errorMessage.value = ''

    if (data) {
      formData.value = {
        id_jadwal: data.id_jadwal,
        hari: data.hari || 'senin',
        jam_mulai: data.jam_mulai || '',
        jam_selesai: data.jam_selesai || '',
        ruang: data.ruang || '',
        id_kelas: data.id_kelas || '',
        id_guru: data.id_guru || '',
        id_semester: data.id_semester || '',
        id_mata_pelajaran: data.id_mata_pelajaran || ''
      }
    } else {
      resetForm()
    }

    isModalOpen.value = true
  }

  const closeModal = () => {
    isModalOpen.value = false
    resetForm()
  }

  /* =========================
SUBMIT
========================= */
  const handleSubmit = async () => {
    try {
      errorMessage.value = ''

      if (modalMode.value === 'add') {
        await api('/jadwal', {
          method: 'POST',
          body: formData.value
        })
      } else {
        await api(`/jadwal/${formData.value.id_jadwal}`, {
          method: 'PUT',
          body: formData.value
        })
      }

      await fetchJadwal()
      closeModal()
    } catch (err) {
      errorMessage.value =
        err?.data?.message ||
        err?.response?._data?.message ||
        'Terjadi kesalahan'
    }
  }

  /* =========================
DELETE
========================= */
  const deleteJadwal = async (id) => {
    if (!confirm('Yakin ingin menghapus jadwal ini?')) return

    try {
      await api(`/jadwal/${id}`, { method: 'DELETE' })
      await fetchJadwal()
    } catch (err) {
      console.error(err)
    }
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
      <header class="top-header">
        <div>
          <h1 class="page-title">Jadwal Pelajaran</h1>

          <p class="page-subtitle">
            Kelola jadwal mengajar dan penggunaan ruang kelas
          </p>
        </div>

        <div class="header-right">
          <div class="search-bar">
            <Search :size="18" class="search-icon" />

            <input
              v-model="search"
              type="text"
              placeholder="Cari jadwal..."
              class="search-input" />
          </div>

          <button class="notification-btn">
            <Bell :size="20" />
            <span class="notification-dot"></span>
          </button>
        </div>
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
      </header>

      <!-- CARD -->
      <div class="card">
        <div class="card-header">
          <div>
            <h3>Daftar Jadwal</h3>

            <p class="card-subtitle">
              Seluruh data jadwal pembelajaran sekolah
            </p>
          </div>

          <button class="btn btn-primary" @click="handleOpenModal('add')">
            <Plus :size="18" />
            Tambah Jadwal
          </button>
        </div>

        <div class="table-container">
          <table>
            <thead>
              <tr>
                <th>Kelas</th>
                <th>Mata Pelajaran</th>
                <th>Guru Pengajar</th>
                <th>Hari</th>
                <th>Waktu</th>
                <th>Ruang</th>
                <th>Aksi</th>
              </tr>
            </thead>

            <tbody>
              <tr v-if="loading">
                <td colspan="7" class="empty-state">Loading data...</td>
              </tr>
              <tr v-for="item in filteredJadwal" :key="item.id_jadwal">
                <td>
                  <strong>
                    {{
                      item.kelas?.tingkat +
                      ' ' +
                      item.kelas?.jurusan?.nama +
                      ' ' +
                      item.kelas?.nama
                    }}
                  </strong>
                </td>

                <td>
                  {{ item.mata_pelajaran?.nama || '-' }}
                </td>

                <td>{{ item.guru?.nama || '-' }}</td>

                <td>
                  <span class="badge badge-primary">
                    {{ item.hari }}
                  </span>
                </td>

                <td>
                  {{ item.jam_mulai || '-' }} - {{ item.jam_selesai || '-' }}
                </td>

                <td>{{ item.ruang }}</td>

                <td>
                  <div class="action-group">
                    <button
                      class="btn-icon"
                      type="button"
                      @click="handleOpenModal('edit', item)">
                      <Edit2 :size="16" />
                    </button>

                    <button
                      class="btn-icon text-danger"
                      type="button"
                      @click="deleteJadwal(item.id_jadwal)">
                      <Trash2 :size="16" />
                    </button>
                  </div>
                </td>
              </tr>

              <tr v-if="filteredJadwal.length === 0 && !loading">
                <td colspan="7" class="empty-state">Belum ada data jadwal</td>
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
            {{ modalMode === 'add' ? 'Tambah Jadwal Baru' : 'Edit Jadwal' }}
          </h3>

          <button class="modal-close-btn" type="button" @click="closeModal">
            <X :size="20" />
          </button>
        </div>

        <div class="modal-body">
          <form @submit.prevent="handleSubmit">
            <p v-if="errorMessage" class="error-message">
              {{ errorMessage }}
            </p>

            <div class="form-group-row">
              <!-- HARI -->
              <div class="form-group flex-1">
                <label for="hari" class="form-label">Hari</label>

                <select
                  id="hari"
                  name="hari"
                  class="form-input"
                  v-model="formData.hari">
                  <option value="senin">Senin</option>
                  <option value="selasa">Selasa</option>
                  <option value="rabu">Rabu</option>
                  <option value="kamis">Kamis</option>
                  <option value="jumat">Jumat</option>
                </select>
              </div>

              <!-- JAM MULAI -->
              <div class="form-group flex-1">
                <label for="jam_mulai" class="form-label">Jam Mulai</label>

                <input
                  id="jam_mulai"
                  name="jam_mulai"
                  type="time"
                  class="form-input"
                  v-model="formData.jam_mulai"
                  autocomplete="off"
                  required />
              </div>

              <!-- JAM SELESAI -->
              <div class="form-group flex-1">
                <label for="jam_selesai" class="form-label">Jam Selesai</label>

                <input
                  id="jam_selesai"
                  name="jam_selesai"
                  type="time"
                  class="form-input"
                  v-model="formData.jam_selesai"
                  autocomplete="off"
                  required />
              </div>
            </div>

            <!-- KELAS -->
            <div class="form-group">
              <label for="id_kelas" class="form-label">Kelas</label>

              <select
                id="id_kelas"
                name="id_kelas"
                class="form-input"
                v-model="formData.id_kelas"
                required>
                <option value="">Pilih Kelas</option>

                <option
                  v-for="kelas in kelasList"
                  :key="kelas.id_kelas"
                  :value="kelas.id_kelas">
                  {{
                    kelas.tingkat + ' ' + kelas.jurusan?.nama + ' ' + kelas.nama
                  }}
                </option>
              </select>
            </div>

            <!-- GURU -->
            <!-- GURU -->
            <div class="form-group">
              <label for="id_guru" class="form-label">Guru Pengajar</label>

              <select
                id="id_guru"
                name="id_guru"
                class="form-input"
                v-model="formData.id_guru"
                required>
                <option value="">Pilih Guru</option>

                <option
                  v-for="guru in guruList"
                  :key="guru.id_guru"
                  :value="guru.id_guru">
                  {{ guru.nama }}
                </option>
              </select>
            </div>

            <!-- MATA PELAJARAN -->
            <div class="form-group">
              <label for="id_mata_pelajaran" class="form-label">
                Mata Pelajaran
              </label>

              <select
                id="id_mata_pelajaran"
                class="form-input"
                v-model="formData.id_mata_pelajaran"
                required>
                <option value="">Pilih Mata Pelajaran</option>

                <option
                  v-for="mapel in mataPelajaranList"
                  :key="mapel.id_mata_pelajaran"
                  :value="mapel.id_mata_pelajaran">
                  {{ mapel.nama }}
                </option>
              </select>
            </div>

            <!-- SEMESTER -->
            <div class="form-group">
              <label for="id_semester" class="form-label">Semester</label>

              <select
                id="id_semester"
                name="id_semester"
                class="form-input"
                v-model="formData.id_semester"
                required>
                <option value="">Pilih Semester</option>

                <option
                  v-for="semester in semesterList"
                  :key="semester.id_semester"
                  :value="semester.id_semester">
                  {{ semester.nama }}
                </option>
              </select>
            </div>

            <!-- RUANG -->
            <div class="form-group">
              <label for="ruang" class="form-label">Ruang Kelas / Lab</label>

              <input
                id="ruang"
                name="ruang"
                type="text"
                class="form-input"
                placeholder="Misal: Lab Komputer 1"
                v-model="formData.ruang"
                autocomplete="off"
                required />
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

    --danger: #ef4444;
    --danger-light: #fee2e2;

    --border: #e2e8f0;

    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);

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

  .empty-state {
    text-align: center;
    padding: 32px;
    color: var(--text-muted);
  }

  .form-group {
    margin-bottom: 1rem;
  }

  .form-group-row {
    display: flex;
    gap: 1rem;
  }

  .flex-1 {
    flex: 1;
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

  .error-message {
    margin-bottom: 16px;

    padding: 12px;

    border-radius: 12px;

    background: #fee2e2;
    color: #b91c1c;
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

    z-index: 9999;
  }

  .modal-content {
    width: 100%;
    max-width: 600px;

    background: white;

    border-radius: 24px;

    padding: 32px;

    box-shadow: var(--shadow-lg);

    max-height: 90vh;
    overflow-y: auto;
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

  .modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 12px;

    margin-top: 32px;

    padding-top: 24px;

    border-top: 1px solid var(--border);
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

    .form-group-row {
      flex-direction: column;
    }
  }
</style>
