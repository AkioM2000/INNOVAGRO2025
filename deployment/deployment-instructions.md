# Panduan Deployment Office Archive Management

## Persyaratan Server
- PHP 8.1 atau lebih baru
- Composer
- MySQL 5.7+ atau MariaDB 10.3+
- Web Server (Nginx/Apache)
- Node.js & NPM (untuk kompilasi aset)

## Langkah-langkah Deployment

### 1. Upload File ke Server
Upload semua file ke server Anda ke direktori yang diinginkan, misalnya `/var/www/office-archive`

### 2. Install Dependensi
```bash
# Masuk ke direktori project
cd /var/www/office-archive

# Install dependensi PHP
composer install --optimize-autoloader --no-dev

# Install dependensi NPM dan kompilasi aset
npm install
npm run build
```

### 3. Konfigurasi Environment
```bash
# Salin file .env.example ke .env
cp .env.example .env

# Generate APP_KEY
php artisan key:generate

# Sesuaikan konfigurasi database di .env
nano .env
```

### 4. Set Permission
```bash
# Set permission storage dan cache
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/

# Set ownership (ganti user:group sesuai pengguna server)
chown -R www-data:www-data /var/www/office-archive
```

### 5. Migrasi Database
```bash
# Jalankan migrasi dan seeder
php artisan migrate --force
php artisan db:seed --force
```

### 6. Link Storage
```bash
php artisan storage:link
```

### 7. Konfigurasi Web Server

#### Untuk Nginx:
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /var/www/office-archive/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

#### Untuk Apache:
Pastikan mod_rewrite diaktifkan dan tambahkan file `.htaccess` di folder public:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### 8. Atur Task Scheduler
Tambahkan cron job berikut:
```bash
* * * * * cd /var/www/office-archive && php artisan schedule:run >> /dev/null 2>&1
```

### 9. Optimasi Aplikasi
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Setelah Deployment
1. Buat user admin pertama melalui tinker:
   ```bash
   php artisan tinker
   ```
   ```php
   $user = new App\Models\User();
   $user->name = 'Admin';
   $user->email = 'admin@example.com';
   $user->password = Hash::make('password_anda');
   $user->save();
   $user->assignRole('admin');
   ```

2. Pastikan folder storage memiliki permission yang benar
3. Verifikasi aplikasi dapat diakses melalui browser

## Backup Rutin
Sangat disarankan untuk menyiapkan backup rutin untuk:
- File upload di `storage/app/public`
- Database MySQL/MariaDB
