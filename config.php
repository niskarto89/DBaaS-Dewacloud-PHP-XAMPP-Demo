<?php
// Ganti sesuai kredensial dari Dewacloud Dashboard
define('DB_HOST', 'mariadb-node-name.cloudlets.dewacloud.com'); // <- ubah
define('DB_PORT', 3306);
define('DB_NAME', 'praktikum_cloud'); // <- ubah bila perlu
define('DB_USER', 'webadmin'); // <- ubah
define('DB_PASS', 'password_dashboard'); // <- ubah

// (Opsional) SSL/TLS — jika Dewacloud mewajibkan SSL
// Simpan CA (jika tersedia) di path lokal & aktifkan opsi di db.php
define('DB_SSL_CA', ''); // contoh: __DIR__ . '/DewacloudCA.pem'
