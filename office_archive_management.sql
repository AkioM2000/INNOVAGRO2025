-- Create database
CREATE DATABASE IF NOT EXISTS `office_archive_management` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `office_archive_management`;

-- Create users table
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create roles table
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create role_user table
CREATE TABLE IF NOT EXISTS `role_user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_user_user_id_foreign` (`user_id`),
  KEY `role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create afdelings table
CREATE TABLE IF NOT EXISTS `afdelings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create categories table
CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text,
  `afdeling_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `categories_afdeling_id_foreign` (`afdeling_id`),
  CONSTRAINT `categories_afdeling_id_foreign` FOREIGN KEY (`afdeling_id`) REFERENCES `afdelings` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create documents table
CREATE TABLE IF NOT EXISTS `documents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `file_path` varchar(255) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_size` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `afdeling_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `documents_category_id_foreign` (`category_id`),
  KEY `documents_afdeling_id_foreign` (`afdeling_id`),
  KEY `documents_user_id_foreign` (`user_id`),
  CONSTRAINT `documents_afdeling_id_foreign` FOREIGN KEY (`afdeling_id`) REFERENCES `afdelings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `documents_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `documents_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert initial data
INSERT INTO `roles` (`name`, `created_at`, `updated_at`) VALUES
('admin', NOW(), NOW()),
('manager', NOW(), NOW()),
('user', NOW(), NOW());

INSERT INTO `users` (`name`, `email`, `password`, `is_admin`, `created_at`, `updated_at`) VALUES
('Admin User', 'admin@example.com', '$2y$12$7tcCED5/4TEtXHHYhz2TYes77EWIPSjil.AQE4NhyCW2VnoGPh8sS', 1, NOW(), NOW());

INSERT INTO `role_user` (`user_id`, `role_id`, `created_at`, `updated_at`) VALUES
(1, 1, NOW(), NOW());

INSERT INTO `afdelings` (`name`, `description`, `created_at`, `updated_at`) VALUES
('HRD', 'Divisi Sumber Daya Manusia', NOW(), NOW()),
('Finance', 'Divisi Keuangan', NOW(), NOW()),
('IT', 'Divisi Teknologi Informasi', NOW(), NOW());

INSERT INTO `categories` (`name`, `description`, `afdeling_id`, `created_at`, `updated_at`) VALUES
('Surat Masuk', 'Dokumen surat masuk', 1, NOW(), NOW()),
('Surat Keluar', 'Dokumen surat keluar', 1, NOW(), NOW()),
('Laporan Keuangan', 'Dokumen laporan keuangan', 2, NOW(), NOW()),
('Proposal', 'Dokumen proposal', 2, NOW(), NOW()),
('Manual Book', 'Dokumen panduan', 3, NOW(), NOW()),
('SOP', 'Dokumen standar operasional', 3, NOW(), NOW());
