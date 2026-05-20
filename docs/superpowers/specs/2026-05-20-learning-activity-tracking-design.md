# Learning Activity Tracking & Analytics Dashboard

**Date:** 2026-05-20  
**Project:** EduVortex (Laravel LMS)  
**Status:** Approved

---

## Overview

Tambahkan sistem tracking aktivitas belajar siswa secara detail, dengan dashboard yang disesuaikan per role (siswa, guru, admin). Tujuannya adalah memberikan insight nyata tentang perilaku belajar siswa — materi apa yang dibuka, berapa lama, dan bagaimana performa quiz mereka.

---

## Arsitektur

### Tabel Baru: `learning_logs`

```sql
learning_logs
- id              (bigint, PK)
- id_user         (FK → users.id)
- id_sub_material (FK → sub_materials.id)
- id_material     (FK → materials.id) -- denormalized untuk efisiensi query
- started_at      (timestamp)
- ended_at        (timestamp, nullable)
- duration        (integer, detik, nullable)
- created_at
- updated_at
```

**Cara kerja:**
- Saat siswa membuka sub-materi → insert row baru dengan `started_at`
- Saat siswa keluar/pindah halaman → update `ended_at`, hitung `duration = ended_at - started_at`
- Jika siswa membuka ulang sub-materi yang sama → insert row baru (histori terjaga)
- Data quiz menggunakan tabel `result_quizzes` yang sudah ada

**Model baru:** `LearningLog` dengan relasi ke `User`, `SubMaterial`, `Material`

---

## Dashboard Siswa

**Route:** `/progress` — halaman standalone, di bawah middleware `auth` (bukan tab, agar URL bisa di-bookmark)

### Ringkasan Atas (semua kelas)
- Total kelas yang diikuti
- Total waktu belajar keseluruhan (akumulasi semua kelas)
- Rata-rata skor quiz

### Per Kelas yang Diikuti
- Progress bar: persentase sub-materi yang sudah dibuka (misal: 3/5 = 60%)
- Total waktu belajar di kelas tersebut
- Status quiz: belum dikerjakan / sudah + skor

### Halaman Detail per Kelas
- Daftar semua sub-materi dengan status:
  - ✓ Sudah dibuka — tampilkan total durasi & terakhir diakses
  - ✗ Belum dibuka
- Status quiz + nilai jika sudah dikerjakan

---

## Dashboard Guru

**Route:** `/teacher/analytics/{id_material}` — dapat diakses dari halaman daftar materi guru

### Ringkasan Kelas
- Total siswa bergabung
- Rata-rata progress kelas (% sub-materi dibuka)
- Rata-rata skor quiz
- Jumlah siswa yang sudah / belum mengerjakan quiz

### Tabel Progress per Siswa
Kolom:
- Nama siswa
- Progress (misal: 3/5 sub-materi)
- Total waktu belajar di kelas ini
- Status quiz + skor
- Akses terakhir (relatif, misal: "2 hari lalu")

**Filter:** sudah/belum kerjakan quiz, progress > 50% / < 50%  
**Sorting:** nama, skor, waktu belajar, progress

**Klik nama siswa** → detail lengkap: sub-materi yang dibuka, durasi per sub-materi, histori akses

---

## Dashboard Admin

**Route:** tambahan section di `/admin` yang sudah ada

### Kartu Statistik Platform
- Total siswa aktif (akses dalam 30 hari terakhir)
- Total waktu belajar seluruh platform
- Total quiz yang sudah dikerjakan
- Rata-rata skor quiz keseluruhan

### Tabel Materi Paling Aktif
Kolom: nama materi, nama guru, jumlah siswa, rata-rata progress, rata-rata skor  
Default sort: paling banyak diakses

### Tabel Siswa Paling Aktif
Kolom: nama siswa, total waktu belajar, jumlah kelas diikuti, rata-rata skor  
Berguna untuk identifikasi siswa sangat aktif atau tidak aktif sama sekali

**Filter periode:** 7 hari, 30 hari, 3 bulan, semua waktu — berlaku untuk semua section (kartu statistik, tabel materi aktif, tabel siswa aktif)

---

## Alur Data

```
Siswa buka sub-materi
    → SubMateriController@show dipanggil
    → Insert LearningLog (started_at = now())
    → Simpan log ID di session

Siswa keluar halaman (navigasi / tutup tab)
    → JavaScript beforeunload event → hit endpoint /learning-log/end
    → Update LearningLog: ended_at = now(), duration = selisih detik

Query dashboard guru:
    SELECT id_user, COUNT(DISTINCT id_sub_material) as opened,
           SUM(duration) as total_duration
    FROM learning_logs
    WHERE id_material = ? GROUP BY id_user
    JOIN dengan result_quizzes untuk data quiz
```

---

## Error Handling

- Jika `ended_at` tidak pernah diisi (browser crash / tab ditutup paksa): `duration` tetap null, baris tetap ada sebagai bukti akses
- Query dashboard menggunakan `COALESCE(SUM(duration), 0)` agar null tidak merusak kalkulasi
- Siswa yang belum pernah buka sub-materi apapun tetap muncul di tabel guru dengan progress 0%

---

## File yang Akan Dibuat/Diubah

**Baru:**
- Migration: `create_learning_logs_table`
- Model: `app/Models/LearningLog.php`
- Controller: `app/Http/Controllers/LearningLogController.php`
- Controller: `app/Http/Controllers/Teacher/AnalyticsController.php`
- Views: `resources/views/user/progress.blade.php`
- Views: `resources/views/teacher/analytics.blade.php`

**Diubah:**
- `app/Http/Controllers/SubMateriController.php` — tambah insert learning log saat show
- `resources/views/admin/admin.blade.php` — tambah section analytics
- `routes/web.php` — tambah routes baru
