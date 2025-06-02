# Panduan Update Aplikasi

## Sebelum Update
1. Backup database dan file upload
2. Pastikan tidak ada user yang sedang aktif menggunakan sistem
3. Catat perubahan versi atau update yang akan dilakukan

## Langkah-langkah Update

### 1. Masuk ke server
```bash
ssh user@your-server-ip
cd /var/www/office-archive
```

### 2. Masuk ke mode maintenance
```bash
php artisan down
```

### 3. Backup database (opsional, sangat disarankan)
```bash
php artisan backup:run
```

### 4. Update kode aplikasi
```bash
# Jika menggunakan Git
git pull origin main  # atau branch yang sesuai

# Atau jika mengupload manual
# Upload file-file baru ke server
```

### 5. Update dependensi
```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

### 6. Jalankan migrasi database
```bash
php artisan migrate --force
```

### 7. Clear cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### 8. Rebuild cache
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 9. Set permission
```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
chown -R www-data:www-data /var/www/office-archive
```

### 10. Keluar dari mode maintenance
```bash
php artisan up
```

## Setelah Update
1. Verifikasi aplikasi berjalan dengan baik
2. Periksa log untuk error:
   ```bash
   tail -f storage/logs/laravel.log
   ```
3. Beri tahu pengguna tentang update yang telah dilakukan

## Rollback (jika diperlukan)
1. Kembalikan database dari backup
2. Kembalikan file upload jika diperlukan
3. Kembalikan ke versi sebelumnya dengan Git atau dari backup kode
4. Jalankan:
   ```bash
   composer install
   php artisan migrate
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
