CREATE DATABASE IF NOT EXISTS db_perpustakaan CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_perpustakaan;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  nama_lengkap VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS buku (
  id INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(200) NOT NULL,
  kategori VARCHAR(50) NOT NULL,
  penulis VARCHAR(100) NOT NULL,
  tahun_terbit YEAR NOT NULL,
  stok INT NOT NULL DEFAULT 0,
  sampul VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Akun default: username admin / password admin123
INSERT INTO users (username, password, nama_lengkap) VALUES
('admin', '$2b$12$8aC8a2w1Xrf9IKuii/OLLuiYOMb.w.5M.ZHmtjtKrTYYC2IvnIF1q', 'Administrator Perpustakaan');
