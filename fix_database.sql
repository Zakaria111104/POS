-- Script untuk memperbaiki struktur database
USE ci3_project;

ALTER TABLE users MODIFY COLUMN role int DEFAULT 1 COMMENT '0=Admin, 1=User';

-- Tambahkan data admin jika belum ada
INSERT INTO users (username, password, role) 
SELECT 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 0
WHERE NOT EXISTS (SELECT 1 FROM users WHERE username = 'admin');

-- Pastikan tabel penjualan dan produk ada
CREATE TABLE IF NOT EXISTS penjualan (
  id int NOT NULL AUTO_INCREMENT,
  tanggal datetime DEFAULT NULL,
  total decimal(10,2) DEFAULT NULL,
  kasir_id int DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS produk (
  id int NOT NULL AUTO_INCREMENT,
  nama varchar(100) DEFAULT NULL,
  harga decimal(10,2) DEFAULT NULL,
  stok int DEFAULT NULL,
  gambar varchar(255) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci; 