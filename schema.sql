-- Jalankan pada server MariaDB Dewacloud Anda
CREATE DATABASE IF NOT EXISTS praktikum_cloud;
USE praktikum_cloud;

CREATE TABLE IF NOT EXISTS pelanggan (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  tanggal_daftar TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS transaksi (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_pelanggan INT NOT NULL,
  jumlah DECIMAL(10,2) NOT NULL,
  tanggal TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_tx_pelanggan FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id)
);
