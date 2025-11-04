# DBaaS Dewacloud — PHP (XAMPP) Demo

Aplikasi web **PHP + HTML + CSS** sederhana yang terhubung ke **MariaDB di Dewacloud** (Database as a Service).
Dokumen ini menjelaskan **langkah demi langkah** dari nol hingga aplikasi berjalan di `http://localhost/dbaas-php/`.

> **Ringkas:** Ekstrak, isi kredensial di `config.php`, (opsional) aktifkan SSL, jalankan Apache XAMPP, buka browser.

---

## 1. Prasyarat

- **Akun Dewacloud** aktif dan sudah bisa membuat environment database MariaDB/MySQL.
- **XAMPP** terpasang (disarankan PHP 8.x). Pada Windows biasanya di `C:\xampp`.
- **Koneksi internet** (aplikasi lokal akan mengakses DB di Dewacloud).
- (Opsional) **DB Client** seperti DBeaver / MySQL Workbench untuk mengelola skema.

> Anda **tidak perlu** menjalankan MySQL lokal XAMPP, karena database berada di Dewacloud.

---

## 2. Siapkan Database di Dewacloud (DBaaS)

1. **Masuk ke Dashboard Dewacloud** → `Create Environment` → tab **Databases** → pilih **MariaDB/MySQL**.
2. Beri nama environment, atur resource minimal, **Create** → tunggu status **Running**.
3. Catat **kredensial** dari panel Dewacloud:
   - `Host` (misal: `mariadb-node-name.cloudlets.dewacloud.com`)
   - `Port` (default `3306`)
   - `User` (misal `webadmin` atau user yang Anda set)
   - `Password`
4. (Opsional) **Aktifkan endpoint publik** bila diperlukan.
5. (Opsional) Jika paket mewajibkan **SSL/TLS**, siapkan **CA certificate**. Paket ini menyertakan **placeholder** `DewacloudCA.pem`.
   - Jika Dewacloud menyediakan CA resmi, **ganti** file placeholder dengan CA yang valid.

---

## 3. Import Skema (Schema)

Jika tabel belum ada pada database target:

1. Buka DB client Anda dan koneksikan ke MariaDB Dewacloud menggunakan host/port/user/password di atas.
2. Jalankan file `schema.sql` yang tersedia dalam paket ini.
   - Membuat database `praktikum_cloud` dan tabel:
     - `pelanggan (id, nama, email, tanggal_daftar)`
     - `transaksi (id, id_pelanggan, jumlah, tanggal)`

> Anda dapat menyesuaikan nama database pada `schema.sql` maupun pada `config.php` nanti.

---

## 4. Pasang Aplikasi ke XAMPP (Localhost)

1. **Ekstrak** ZIP ini sehingga menghasilkan folder `dbaas-php/`.
2. Salin folder `dbaas-php/` ke:
   - Windows: `C:\xampp\htdocs\`
   - macOS (XAMPP): `Applications/XAMPP/htdocs/`
   - Linux (XAMPP): sesuai lokasi pemasangan XAMPP Anda, mis. `/opt/lampp/htdocs/`
3. Hasil akhir:
   ```
   htdocs/
   └─ dbaas-php/
      ├─ config.php
      ├─ db.php
      ├─ index.php
      ├─ customers.php
      ├─ customer_form.php
      ├─ customer_save.php
      ├─ customer_delete.php
      ├─ transactions.php
      ├─ transaction_save.php
      ├─ schema.sql
      ├─ README.md
      ├─ README.txt
      ├─ DewacloudCA.pem        # placeholder CA
      ├─ header.php
      ├─ footer.php
      └─ styles.css
   ```

---

## 5. Konfigurasi Koneksi (config.php)

Buka `dbaas-php/config.php` dan ubah sesuai kredensial Dewacloud Anda:

```php
define('DB_HOST', 'mariadb-node-name.cloudlets.dewacloud.com'); // ubah
define('DB_PORT', 3306);
define('DB_NAME', 'praktikum_cloud'); // samakan dengan DB Anda
define('DB_USER', 'webadmin');        // ubah
define('DB_PASS', 'password_dashboard'); // ubah
```

### (Opsional) Aktifkan SSL/TLS

- Paket ini menyertakan **placeholder** `DewacloudCA.pem`. Jika Dewacloud memberi **CA resmi**, ganti file ini.
- Aktifkan di `config.php`:
  ```php
  define('DB_SSL_CA', __DIR__ . '/DewacloudCA.pem');
  ```
- Di `db.php`, **verifikasi sertifikat** server:
  ```php
  $opts[PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT] = true;
  ```
  > Gunakan `true` hanya jika CA valid dan nama host cocok. Bila masih masalah koneksi, sementara set `false` lalu investigasi.

---

## 6. Jalankan XAMPP

1. Buka **XAMPP Control Panel** → **Start** `Apache`.
   - **MySQL lokal boleh OFF**, karena DB ada di Dewacloud.
2. Buka browser Anda ke:
   - `http://localhost/dbaas-php/` → akan diarahkan ke **Pelanggan**.

---

## 7. Uji Fungsional

### 7.1. Pelanggan
- Buka **Pelanggan** → klik **+ Tambah**.
- Isi **Nama** dan **Email** → **Simpan**.
- Coba **Edit**/**Hapus** data.

### 7.2. Transaksi
- Buka **Transaksi** → pilih **Pelanggan** dari dropdown → isi **Jumlah** → **Tambah**.
- Tabel menampilkan daftar transaksi terbaru dengan nama pelanggan.

> Semua operasi dijalankan **langsung** terhadap MariaDB Dewacloud.

---

## 8. Troubleshooting (Masalah Umum)

**A. `SQLSTATE[HY000] [2002]` (Connection error)**  
- Cek `DB_HOST`, `DB_PORT`, koneksi internet, dan **endpoint publik** Dewacloud.
- Firewall kampus/ISP bisa memblokir **port 3306** outbound. Tes hotspot seluler sebagai pembanding.
- Jika SSL wajib → pastikan `DB_SSL_CA` menunjuk ke CA valid.

**B. `Access denied for user`**  
- Periksa `DB_USER`/`DB_PASS` dan hak akses user di DB.
- Coba reset password dari panel Dewacloud.

**C. Lama/Macet (timeout)**  
- Periksa kualitas jaringan; uji ping/latency ke host DB.
- Kurangi beban (tab browser lain, VPN).

**D. Error saat verifikasi SSL**  
- Sementara **nonaktifkan verifikasi** (`PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT = false`) untuk memastikan faktor non-SSL bukan penyebab.  
- Ganti **placeholder CA** dengan CA resmi lalu aktifkan verifikasi `true` kembali.

---

## 9. Keamanan (Best Practices)

- **Jangan commit kredensial** ke repo publik.
- Gunakan **user khusus aplikasi** dengan hak minimal (bukan superuser).
- Rotasi password secara berkala.
- Aktifkan **SSL/TLS** dan verifikasi sertifikat bila tersedia.
- Batasi akses publik ke DB; gunakan **whitelist IP** bila dimungkinkan.

---

## 10. Kustomisasi & Produksi

- Untuk produksi, pertimbangkan **Nginx/Apache** terkonfigurasi baik dan domain HTTPS.
- Tambahkan fitur **pagination**, **validasi sisi server**, dan **CSRF protection** pada form.
- Gunakan **prepared statements** (sudah digunakan) untuk mencegah SQL Injection.
- Pisahkan environment (dev/staging/prod) dan gunakan **env vars** atau file config terpisah.

---

## 11. Changelog Paket

- Menambahkan **DewacloudCA.pem (placeholder)** ke dalam paket.
- Memperbarui `README.md` dan `README.txt` instruksi aktivasi SSL.
- Menyertakan file PHP CRUD dan `schema.sql` untuk bootstrap.

---

## 12. Kontak & Bantuan

- Jika Anda menemui kendala koneksi, sertakan:
  - Potongan `config.php` *tanpa password* (masking), pesan error lengkap.
  - Tangkapan layar panel Dewacloud (masking bagian sensitif).
- Dokumentasi tambahan disiapkan instruktur sesuai kebutuhan modul.

Selamat mencoba! 🎉
