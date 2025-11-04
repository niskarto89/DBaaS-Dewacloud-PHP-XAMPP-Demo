<?php
require 'db.php';
$id = $_POST['id'] ?? null;
$nama = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');

if ($id) {
  $sql = 'UPDATE pelanggan SET nama=?, email=? WHERE id=?';
  $params = [$nama, $email, $id];
} else {
  $sql = 'INSERT INTO pelanggan(nama,email) VALUES(?,?)';
  $params = [$nama, $email];
}
$stmt = db()->prepare($sql); $stmt->execute($params);
header('Location: customers.php');
