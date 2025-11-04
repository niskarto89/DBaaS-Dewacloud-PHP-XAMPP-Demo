<?php
require 'db.php';
$id_pelanggan = $_POST['id_pelanggan'] ?? null;
$jumlah = $_POST['jumlah'] ?? null;
if ($id_pelanggan && $jumlah !== null) {
  $stmt = db()->prepare('INSERT INTO transaksi(id_pelanggan, jumlah) VALUES(?,?)');
  $stmt->execute([$id_pelanggan, $jumlah]);
}
header('Location: transactions.php');
