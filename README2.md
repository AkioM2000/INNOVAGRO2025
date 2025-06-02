# Sistem Manajemen Arsip Kantor (eSima)

## Tentang Aplikasi
eSima adalah sistem manajemen arsip kantor berbasis web yang dirancang untuk memudahkan pengelolaan dan pengarsipan dokumen secara digital. Aplikasi ini memungkinkan pengguna untuk mengorganisir, menyimpan, dan mengakses dokumen dengan cara yang efisien dan terstruktur.

## Fitur Utama
1. **Manajemen Dokumen**
   - Upload dokumen digital
   - Kategorisasi dokumen
   - Pencarian dokumen
   - Download dokumen
   - Preview dokumen
   - Riwayat dokumen

2. **Manajemen Afdeling (Divisi)**
   - Penambahan afdeling baru
   - Edit informasi afdeling
   - Hapus afdeling
   - Daftar dokumen per afdeling

3. **Manajemen Kategori**
   - Pembuatan kategori dokumen
   - Pengelompokan berdasarkan afdeling
   - Edit kategori
   - Hapus kategori

4. **Manajemen Pengguna**
   - Multi-level user (Admin, Manager, User)
   - Manajemen hak akses
   - Profil pengguna
   - Reset password

5. **Fitur Pencarian & Filter**
   - Pencarian berdasarkan judul
   - Filter berdasarkan afdeling
   - Filter berdasarkan kategori
   - Filter berdasarkan tanggal
   - Filter berdasarkan pengguna

## Teknologi yang Digunakan
- Framework: Laravel 10
- Database: MySQL
- Frontend: Bootstrap 5
- JavaScript/jQuery
- Font Awesome Icons
- AJAX untuk interaksi dinamis

## Persyaratan Sistem
- PHP >= 8.2
- MySQL >= 5.7
- Composer
- Node.js & NPM
- Web Server (Apache/Nginx)

## Instalasi
1. Clone repository
```bash
git clone [repository-url]
```

2. Install dependencies
```bash
composer install
npm install
```

3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Konfigurasi database di file .env
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=office_archive_management
DB_USERNAME=root
DB_PASSWORD=
```

5. Migrasi dan seeding database
```bash
php artisan migrate --seed
```

6. Jalankan aplikasi
```bash
php artisan serve
npm run dev
```

## Struktur Database
1. **users**
   - id (primary key)
   - name
   - email
   - password
   - is_admin
   - remember_token
   - timestamps

2. **roles**
   - id (primary key)
   - name
   - timestamps

3. **role_user**
   - id (primary key)
   - user_id (foreign key)
   - role_id (foreign key)
   - timestamps

4. **afdelings**
   - id (primary key)
   - name
   - description
   - timestamps

5. **categories**
   - id (primary key)
   - name
   - description
   - afdeling_id (foreign key)
   - timestamps

6. **documents**
   - id (primary key)
   - title
   - description
   - file_path
   - file_name
   - file_type
   - file_size
   - category_id (foreign key)
   - afdeling_id (foreign key)
   - user_id (foreign key)
   - timestamps

## Penggunaan
1. **Login Sistem**
   - Email: admin@example.com
   - Password: password

2. **Manajemen Dokumen**
   - Klik menu "Dokumen"
   - Gunakan tombol "Upload Dokumen" untuk menambah dokumen baru
   - Isi form dengan informasi dokumen
   - Pilih file yang akan diupload
   - Klik "Simpan"

3. **Pencarian & Filter**
   - Gunakan kolom pencarian untuk mencari dokumen
   - Gunakan dropdown filter untuk menyaring berdasarkan:
     * Afdeling
     * Kategori
     * Pengguna
     * Tanggal

## Catatan Penting
1. Backup database secara berkala
2. Pastikan folder storage memiliki permission yang tepat
3. Batasi ukuran file yang dapat diupload
4. Gunakan strong password
5. Update sistem secara berkala

## Lisensi
Hak Cipta © 2024 eSima. Seluruh hak cipta dilindungi undang-undang. 
