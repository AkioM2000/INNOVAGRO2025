# Office Archive Management System

Sistem Manajemen Arsip Kantor berbasis web untuk mengelola dokumen, kategori, divisi, dan pengajuan dokumen resmi seperti SPK & PPBJ dalam sebuah organisasi.

## 🚀 Fitur Utama

### 📁 Manajemen Dokumen
- Upload berbagai format dokumen (PDF, DOC, DOCX, XLS, XLSX, dll)
- Kategorisasi dokumen yang terstruktur
- Sistem pencarian dan filter yang canggih
- Preview dokumen langsung di browser
- Download dokumen dengan satu klik
- Riwayat perubahan dan versi dokumen

### 🏷️ Manajemen Kategori & Klasifikasi
- Multi-level kategori dokumen
- Kategorisasi berdasarkan divisi/afdeling
- Warna kustom untuk setiap kategori
- Filter dokumen berdasarkan kategori

### 👥 Manajemen Pengguna & Peran
- Multi-level user (Admin, Staff, User)
- Manajemen izin berbasis peran
- Aktivitas log pengguna
- Profil pengguna yang dapat disesuaikan

### 📝 Pengajuan SPK & PPBJ
- Form pengajuan SPK & PPBJ online
- Proses persetujuan multi-level
- Notifikasi email untuk setiap tahap
- Pelacakan status pengajuan
- Arsip digital dokumen yang disetujui

### 🔔 Sistem Notifikasi
- Notifikasi real-time
- Email notifikasi untuk aktivitas penting
- Pemberitahuan persetujuan dokumen
- Notifikasi jadwal retensi dokumen

### 📊 Laporan & Analitik
- Dashboard statistik dokumen
- Laporan aktivitas pengguna
- Audit trail untuk semua perubahan
- Ekspor data ke Excel/PDF

## 🛠️ Teknologi

### Backend
- PHP 8.1+
- Laravel 10.x
- MySQL 8.0+
- Redis (untuk cache dan queue)

### Frontend
- HTML5, CSS3, JavaScript
- Bootstrap 5
- jQuery
- DataTables
- Select2
- SweetAlert2

### Fitur Keamanan
- Autentikasi multi-faktor
- Enkripsi data sensitif
- Proteksi CSRF
- Rate limiting
- Audit log

## 📦 Persyaratan Sistem

### Server
- PHP 8.1 atau lebih baru
- Composer
- MySQL 5.7+ atau MariaDB 10.3+
- Web Server (Apache/Nginx)
- Ekstensi PHP yang diperlukan:
  - BCMath PHP Extension
  - Ctype PHP Extension
  - cURL PHP Extension
  - DOM PHP Extension
  - Fileinfo PHP Extension
  - JSON PHP Extension
  - Mbstring PHP Extension
  - OpenSSL PHP Extension
  - PDO PHP Extension
  - Tokenizer PHP Extension
  - XML PHP Extension

### Browser
- Google Chrome (versi terbaru)
- Mozilla Firefox (versi terbaru)
- Microsoft Edge (versi terbaru)
- Safari (versi terbaru)

## 🚀 Panduan Instalasi

1. **Clone Repository**
   ```bash
   git clone [repository-url]
   cd office-archive-management
   ```

2. **Instal Dependensi**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi Database**
   Buat database baru dan sesuaikan file `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=nama_database
   DB_USERNAME=username_database
   DB_PASSWORD=password_database
   ```

5. **Jalankan Migrasi & Seeder**
   ```bash
   php artisan migrate --seed
   ```

6. **Generate Storage Link**
   ```bash
   php artisan storage:link
   ```

7. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```

   Buka browser dan akses: `http://localhost:8000`

## 📝 Kredensial Default

- **Admin**:
  - Email: admin@example.com
  - Password: password

- **User Biasa**:
  - Email: user@example.com
  - Password: password

## 📄 Dokumentasi

Dokumentasi lengkap tersedia di [Dokumentasi Aplikasi](docs/README.md).

## 🤝 Berkontribusi

1. Fork repository ini
2. Buat branch fitur (`git checkout -b fitur/namafitur`)
3. Commit perubahan Anda (`git commit -am 'Menambahkan fitur baru'`)
4. Push ke branch (`git push origin fitur/namafitur`)
5. Buat Pull Request

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

## 📞 Kontak

- **Nama**: Mahendra
- **Email**: mahendracuandri@gmail.com
- **Telepon/WA**: 0822-8721-8274
- **Alamat**: [Alamat Lengkap]

---

<div align="center">
  <sub>Dibuat dengan ❤️ oleh Tim Pengembang</sub>
</div>

## 📜 Lisensi

Proyek ini dilisensikan di bawah [MIT License](LICENSE).

---

<div align="center">
  <sub>Dibuat dengan ❤️ oleh Tim Pengembang</sub>
</div>
