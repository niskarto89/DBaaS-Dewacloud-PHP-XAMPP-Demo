<?php require 'db.php'; include 'header.php';
try {
  $rows = db()->query("SELECT id,nama,email,tanggal_daftar FROM pelanggan ORDER BY id DESC")->fetchAll();
} catch (Throwable $e) {
  echo "<p><strong>Gagal koneksi/query:</strong> ".htmlspecialchars($e->getMessage())."</p>";
  $rows = [];
}
?>
<h2>Pelanggan</h2>
<p><a class="btn primary" href="customer_form.php">+ Tambah</a></p>
<table class="table">
  <thead><tr><th>ID</th><th>Nama</th><th>Email</th><th>Daftar</th><th>Aksi</th></tr></thead>
  <tbody>
  <?php foreach($rows as $r): ?>
    <tr>
      <td><?= htmlspecialchars($r['id']) ?></td>
      <td><?= htmlspecialchars($r['nama']) ?></td>
      <td><?= htmlspecialchars($r['email']) ?></td>
      <td><?= htmlspecialchars($r['tanggal_daftar']) ?></td>
      <td>
        <a class="btn" href="customer_form.php?id=<?= $r['id'] ?>">Edit</a>
        <form action="customer_delete.php" method="post" style="display:inline">
          <input type="hidden" name="id" value="<?= $r['id'] ?>" />
          <button class="btn danger" onclick="return confirm('Hapus data ini?')">Hapus</button>
        </form>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
<?php include 'footer.php'; ?>
