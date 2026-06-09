# E-Learning Platform

Platform pembelajaran online berbasis web yang dibangun dengan Laravel 11. Mendukung tiga peran pengguna: **Siswa**, **Guru**, dan **Admin** — masing-masing dengan dashboard dan fitur tersendiri.

**Live Demo:** https://webdevelearning-production.up.railway.app

---

## Fitur Utama

### Siswa
- Jelajahi dan daftar ke kelas/materi yang tersedia
- Akses sub-materi berupa teks dan file PDF
- Ikuti kuis dan lihat hasil nilai
- Pantau progress belajar per kelas
- Log aktivitas belajar otomatis (waktu mulai & selesai per sub-materi)

### Guru
- Buat dan kelola kelas (materi & sub-materi)
- Upload konten: teks, PDF, dan video
- Buat soal kuis pilihan ganda
- Dashboard analitik per kelas: progress siswa, rata-rata nilai, waktu belajar

### Admin
- Kelola data siswa, guru, dan materi
- Verifikasi akun guru baru
- Buat akun guru langsung dari panel admin

---

## Tech Stack

| Layer | Teknologi |
|-------|-----------|
| Backend | PHP 8.2, Laravel 11 |
| Auth | Laravel Breeze |
| Frontend | Blade, Tailwind CSS 3, Alpine.js |
| Build Tool | Vite |
| Database | MySQL |

---

## Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL

### Langkah-langkah

```bash
# 1. Clone repo
git clone https://github.com/Jovfrinn/WebDev_Elearning.git
cd WebDev_Elearning

# 2. Install dependensi PHP
composer install

# 3. Install dependensi Node
npm install

# 4. Salin dan konfigurasi .env
cp .env.example .env
php artisan key:generate
```

Edit file `.env` dan sesuaikan koneksi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=elearning
DB_USERNAME=root
DB_PASSWORD=
```

```bash
# 5. Jalankan migrasi dan seeder
php artisan migrate --seed

# 6. Jalankan aplikasi
npm run serve
```

Aplikasi akan berjalan di `http://localhost:8000`

---

## Akun Default (Seeder)

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@gmail.com | password |
| Guru | teacher@gmail.com | password |

Akun siswa dapat didaftarkan melalui halaman register.

---

## Struktur Peran

| Role ID | Peran |
|---------|-------|
| 1 | Siswa |
| 2 | Guru |
| 3 | Admin |

---

## Lisensi

MIT License
