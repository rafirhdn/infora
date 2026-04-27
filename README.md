#  Infora

Aplikasi berbasis **Laravel (Backend)** dan **Nuxt (Frontend)**.

---

## Tech Stack

### Backend

* PHP

### Frontend

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
└── frontend/  # Nuxt
    ├── app/
        ├── pages/ # Frontend Interface
            ├── manajemen-absensi/
            ├── manajemen-akademik/
            ├── manajemen-ekstrakurikuler/
            ├── manajemen-surat/
            ├── manajemen-bimbingan-konseling/
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

### Install dependency

```bash
composer install
```

### Copy file environment

```bash
cp .env.example .env
```

### Generate application key

```bash
php artisan key:generate
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

### Copy file environment

```bash
cp .env.example .env
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
