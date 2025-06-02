#!/bin/bash

# Konfigurasi
DB_USER="your_db_user"
DB_PASS="your_db_password"
DB_NAME="your_db_name"
BACKUP_DIR="/path/to/backup/folder"
PROJECT_DIR="/var/www/office-archive"
DATE=$(date +"%Y%m%d_%H%M%S")
KEEP_DAYS=30

# Buat direktori backup jika belum ada
mkdir -p "$BACKUP_DIR"

# Backup database
mysqldump -u$DB_USER -p$DB_PASS $DB_NAME | gzip > "${BACKUP_DIR}/db_backup_${DATE}.sql.gz"

# Backup file upload
cd "$PROJECT_DIR/storage/app/public"
tar -czf "${BACKUP_DIR}/uploads_backup_${DATE}.tar.gz" .

# Backup kode aplikasi (opsional)
cd "$PROJECT_DIR/.."
tar --exclude='node_modules' --exclude='vendor' --exclude='.git' -czf "${BACKUP_DIR}/code_backup_${DATE}.tar.gz" "$(basename $PROJECT_DIR)"

# Hapus backup lama (lebih dari 30 hari)
find "$BACKUP_DIR" -type f -mtime +$KEEP_DAYS -delete

# Set permission
chmod 600 "$BACKUP_DIR"/*

echo "Backup completed: $(date)" >> "${BACKUP_DIR}/backup.log"
