# SIAKAD — Sistem Informasi Akademik

Sistem informasi akademik untuk Madrasah Aliyah (manajemen guru, murid, kelas, PPDB, dan operasional sekolah).

> **Fokus project:** pengembangan fitur di lingkungan **lokal**. Repository ini tidak menyertakan konfigurasi deployment, CI/CD, atau build production.

## Struktur project

```
SIAKAD/
├── backend/          # API Laravel
├── frontend/         # Aplikasi React (Vite)
├── README.md
└── .gitignore
```

## Prasyarat

- PHP 8.2+ (disarankan XAMPP: `C:\xampp\php` di PATH)
- Composer
- Node.js 18+ dan npm
- MySQL (mis. XAMPP)

## Setup backend

```bash
cd backend
copy .env.example .env    # Windows: copy .env.example .env
composer install
php artisan key:generate
php artisan migrate
php artisan serve
```

Jika `php` atau `composer` belum di PATH (mis. XAMPP):

```powershell
cd backend
copy .env.example .env
C:\xampp\php\php.exe C:\path\to\composer.phar install
C:\xampp\php\php.exe artisan key:generate
C:\xampp\php\php.exe artisan migrate
C:\xampp\php\php.exe artisan serve
```

API development: **http://127.0.0.1:8000**

## Setup frontend

```bash
cd frontend
copy .env.example .env
npm install
npm run dev
```

Isi minimal `frontend/.env`:

```env
VITE_APP_NAME=SIAKAD
VITE_API_BASE_URL=http://127.0.0.1:8000/api
```

UI development: **http://localhost:1001**

## Menjalankan lokal (ringkas)

1. Start **MySQL** (XAMPP).
2. Terminal 1 — backend: `cd backend` → `php artisan serve`
3. Terminal 2 — frontend: `cd frontend` → `npm run dev`
4. Buka http://localhost:1001

## Yang tidak di-commit

| Path | Cara mendapatkan |
|------|------------------|
| `frontend/node_modules/` | `npm install` |
| `backend/vendor/` | `composer install` |
| `backend/.env`, `frontend/.env` | Salin dari `.env.example` |
| Log & cache Laravel | Otomatis saat aplikasi jalan |

## Role

| Role | Keterangan |
|------|------------|
| admin | Akses penuh menu admin |
| kepsek | Dashboard kepala sekolah |
| guru | Panel guru |
| wali_kelas | Guru + menu wali kelas |
| siswa | Panel siswa |
| calon_siswa | Formulir PPDB |

## Dokumentasi tim

- Menu: `frontend/src/config/menu.config.js`
- Routing: `frontend/src/app/router/AppRouter.jsx`
- [frontend/README.md](./frontend/README.md)
- [backend/README.md](./backend/README.md)

## Setelah clone / unduh ZIP

```bash
cd backend
copy .env.example .env
composer install
php artisan key:generate
php artisan migrate

cd ../frontend
copy .env.example .env
npm install
```
