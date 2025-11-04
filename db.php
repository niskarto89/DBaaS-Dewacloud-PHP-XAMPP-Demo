<?php
require_once __DIR__.'/config.php';

function db() : PDO {
  static $pdo = null;
  if ($pdo) return $pdo;

  $dsn = 'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME.';charset=utf8mb4';
  $opts = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ];

  // Aktifkan SSL jika CA disediakan
  if (defined('DB_SSL_CA') && DB_SSL_CA) {
    // Konstanta berikut butuh PHP dengan mysqlnd dan dukungan SSL
    $opts[PDO::MYSQL_ATTR_SSL_CA] = DB_SSL_CA;
    // Jika menggunakan CA resmi, set true
    if (defined('PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT')) {
      $opts[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = false;
    }
  }

  $pdo = new PDO($dsn, DB_USER, DB_PASS, $opts);
  return $pdo;
}
