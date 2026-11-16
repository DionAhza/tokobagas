-- Import lewat phpMyAdmin (tab Import) atau: mysql -u root < toko_db.sql
CREATE DATABASE IF NOT EXISTS toko_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE toko_db;

CREATE TABLE IF NOT EXISTS users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL  -- hasil password_hash() butuh 255 karakter
);

CREATE TABLE IF NOT EXISTS product (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(150) NOT NULL,
    deskripsi TEXT,
    harga INT UNSIGNED NOT NULL DEFAULT 0,
    gambar VARCHAR(255) DEFAULT NULL
);

-- Data contoh (hanya terisi jika tabel product masih kosong). Ubah lewat dashboard.
INSERT INTO product (nama, deskripsi, harga, gambar)
SELECT * FROM (
    SELECT 'iPhone' AS nama, 'Smartphone iPhone dengan kamera tajam dan performa lancar untuk kerja maupun hiburan.' AS deskripsi, 12999000 AS harga, 'iphone.jpg' AS gambar
    UNION ALL SELECT 'Samsung Galaxy', 'Layar cerah, baterai awet, cocok untuk dipakai seharian.', 8499000, 'samsung.jpg'
    UNION ALL SELECT 'Xiaomi', 'Pilihan hemat dengan fitur lengkap untuk kebutuhan harian.', 3299000, 'xiaomi.jpg'
) AS contoh
WHERE NOT EXISTS (SELECT 1 FROM product);
