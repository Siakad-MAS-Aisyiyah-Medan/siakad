# Frontend SIAKAD

## Struktur

```
src/
├── app/              # Router, layouts, providers
├── config/           # app, api, menu, roles
├── services/         # apiClient, auth
├── features/         # Halaman per role/modul
├── shared/           # Komponen, utils, constants
└── main.jsx
```

## Routing

- Definisi route: `src/app/router/index.jsx`
- Dashboard per role: `src/app/router/DashboardRouter.jsx`

## Konfigurasi

| File | Fungsi |
|------|--------|
| `config/app.config.js` | Nama app, route default |
| `config/api.config.js` | Base URL API |
| `config/menu.config.js` | Menu sidebar per role |
| `config/roles.config.js` | Daftar role |

Environment: salin `.env.example` → `.env`, set `VITE_API_BASE_URL`.

## Service API

- `services/apiClient.js` — instance Axios + token
- `services/auth.service.js` — login, register, session

## Aturan membuat halaman baru

1. Buat folder di `features/{role}/{nama-halaman}/`
2. Minimal berisi:
   - `index.jsx` — halaman utama
   - `components/` — komponen khusus halaman
   - `hooks/` — state & efek
   - `services/` — panggilan API
   - `README.md` — ringkasan modul
3. Daftarkan route di `app/router/index.jsx`
4. Tambah menu di `config/menu.config.js` jika perlu sidebar

Contoh admin: `features/admin/murid/`
