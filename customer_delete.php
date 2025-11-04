<?php
require 'db.php';
$id = $_POST['id'] ?? null;
if ($id) {
  $stmt = db()->prepare('DELETE FROM pelanggan WHERE id=?');
  $stmt->execute([$id]);
}
header('Location: customers.php');
