<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<h1 align="center">🦷 Monitoring Pasien Gigi</h1>

<p align="center">
  Sistem informasi berbasis web untuk memonitor pemeriksaan gigi pasien di klinik gigi secara efisien dan terorganisir.
</p>

---

## 📋 Deskripsi

**Monitoring Pasien Gigi** adalah aplikasi berbasis Laravel yang dirancang untuk membantu klinik gigi dalam mengelola data pasien, pencatatan pemeriksaan gigi, kondisi gigi, jadwal kunjungan, dan odontogram secara digital. Aplikasi ini mendukung tampilan yang responsif, mudah digunakan oleh staf klinik, dan membantu dalam dokumentasi serta evaluasi kondisi kesehatan gigi pasien.

---

## 🚀 Fitur Utama

- 🔐 Autentikasi dan Manajemen Pengguna
- 👩‍⚕️ Manajemen Data Pasien
- 📅 Jadwal Pemeriksaan Gigi
- 🦷 Pencatatan Kondisi Gigi (Odontogram)
- 📝 Riwayat Pemeriksaan
- 📊 Dashboard Informasi Klinik
- 📦 Ekspor/Laporan Data Pasien dan Pemeriksaan

---

## 🛠️ Teknologi yang Digunakan

- [Laravel](https://laravel.com/) 11
- [Livewire](https://laravel-livewire.com/)
- [MySQL](https://www.mysql.com/) / MariaDB
- [Bootstrap](https://getbootstrap.com/) 5
- [SweetAlert](https://sweetalert2.github.io/)
- [Alpine.js](https://alpinejs.dev/)

---

## 📦 Instalasi

```bash
# Clone proyek
git clone https://github.com/username/monitoring-pasien-gigi.git
cd monitoring-pasien-gigi

# Install dependency
composer install
npm install && npm run dev

# Copy file konfigurasi dan generate key
cp .env.example .env
php artisan key:generate

# Atur koneksi database di file .env
DB_DATABASE=nama_database
DB_USERNAME=username
DB_PASSWORD=password

# Jalankan migrasi dan seeder (opsional)
php artisan migrate --seed

# Jalankan server
php artisan serve
