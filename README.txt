DBaaS Dewacloud — PHP (XAMPP) Demo
==================================
Web sederhana PHP + HTML + CSS yang terhubung ke MariaDB di Dewacloud (DBaaS).

Cara pakai (Windows XAMPP):
1) Ekstrak folder `dbaas-php` ke `C:\xampp\htdocs\`
2) Edit `config.php` isi kredensial dari Dewacloud
3) Pastikan Apache aktif (MySQL lokal boleh dimatikan)
4) Buka http://localhost/dbaas-php/ di browser

Fitur Tambahan:
- File **DewacloudCA.pem** (CA SSL Placeholder) sudah disertakan.
- Aktifkan SSL di `config.php`:
  ```php
  define('DB_SSL_CA', __DIR__ . '/DewacloudCA.pem');
  ```
- Untuk koneksi aman (TLS), ubah juga di `db.php`:
  ```php
  $opts[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = true;
  ```

Catatan:
- Jika paket Dewacloud mewajibkan SSL, pastikan CA valid dari provider.
- Skema DB tersedia di `schema.sql` (jalankan di server MariaDB Anda bila tabel belum ada).
