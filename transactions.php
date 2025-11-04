<?php require 'db.php'; include 'header.php';
try {
  $tx = db()->query('SELECT t.id, p.nama AS pelanggan, t.jumlah, t.tanggal
                     FROM transaksi t JOIN pelanggan p ON t.id_pelanggan=p.id
                     ORDER BY t.id DESC')->fetchAll();
  $pel = db()->query('SELECT id,nama FROM pelanggan ORDER BY nama')->fetchAll();
} catch (Throwable $e) {
  echo "<p><strong>Gagal koneksi/query:</strong> ".htmlspecialchars($e->getMessage())."</p>";
  $tx = $pel = [];
}
?>
<h2>Transaksi</h2>
<form class="form" method="post" action="transaction_save.php" style="margin-bottom:12px">
  <div class="row">
    <label>Pelanggan
      <select name="id_pelanggan" required>
        <option value="" disabled selected>Pilih...</option>
        <?php foreach($pel as $p): ?>
          <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nama']) ?></option>
        <?php endforeach; ?>
      </select>
    </label>
    <label>Jumlah (IDR)
      <input type="number" name="jumlah" step="0.01" min="0" required />
    </label>
  </div>
  <button class="btn primary mt-12">Tambah</button>
</form>

<table class="table">
  <thead><tr><th>ID</th><th>Pelanggan</th><th>Jumlah</th><th>Tanggal</th></tr></thead>
  <tbody>
  <?php foreach($tx as $r): ?>
    <tr>
      <td><?= $r['id'] ?></td>
      <td><?= htmlspecialchars($r['pelanggan']) ?></td>
      <td><?= number_format($r['jumlah'], 2) ?></td>
      <td><?= $r['tanggal'] ?></td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php include 'footer.php'; ?>
