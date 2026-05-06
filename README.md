#  Infora

Aplikasi berbasis **Laravel (Backend)** dan **Nuxt (Frontend)**.

---

## Tech Stack

### Backend

* PHP

### Frontend

* Node
* Nuxt
* Vue
* Tailwind CSS

---

## Structure Project

```
root/
│
├── backend/   # Laravel
    ├── app/
        ├── Http/
            ├── Controllers/
                ├── Api/ # Backend API
                ├── manajemenAbsensi/
                ├── manajemenAkademik/
                ├── manajemenEkstrakurikuler/
                ├── manajemenSurat/
                ├── manajemenBimbinganKonseling/
                ├── autentikasi/
└── frontend/  # Nuxt
    ├── app/
        ├── pages/ # Frontend Interface
            ├── manajemen-absensi/
            ├── manajemen-akademik/
            ├── manajemen-ekstrakurikuler/
            ├── manajemen-surat/
            ├── manajemen-bimbingan-konseling/
            ├── autentikasi/
```

---

## Instalasi & Setup

### 1. Clone Repository

```bash
git clone https://github.com/rafirhdn/infora.git
cd infora
```

---

## Backend (Laravel)

Masuk ke folder backend:

```bash
cd backend
```

### Install Laravel dependency

```bash
composer install
```

### Install Node dependency

```bash
npm install
```

### Jalankan migrasi

```bash
php artisan migrate
```

### Jalankan server

```bash
php artisan serve
```

Backend berjalan di:

```
http://127.0.0.1:8000
```

---

## Frontend (Nuxt)

Buka terminal baru, lalu:

```bash
cd frontend
```

### Install dependency

```bash
npm install
```

### Jalankan development server

```bash
npm run dev
```

Frontend berjalan di:

```
http://localhost:3000
```

---
