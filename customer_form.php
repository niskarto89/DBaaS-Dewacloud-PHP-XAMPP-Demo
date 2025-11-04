<?php require 'db.php'; include 'header.php';
$id = $_GET['id'] ?? null; $row = null;
if ($id) {
  $stmt = db()->prepare('SELECT * FROM pelanggan WHERE id=?');
  $stmt->execute([$id]);
  $row = $stmt->fetch();
}
?>
<h2><?= $id ? 'Edit' : 'Tambah' ?> Pelanggan</h2>
<form class="form" method="post" action="customer_save.php">
  <input type="hidden" name="id" value="<?= htmlspecialchars($row['id'] ?? '') ?>" />
  <div class="row">
    <label>Nama
      <input name="nama" required value="<?= htmlspecialchars($row['nama'] ?? '') ?>" />
    </label>
    <label>Email
      <input type="email" name="email" required value="<?= htmlspecialchars($row['email'] ?? '') ?>" />
    </label>
  </div>
  <button class="btn primary mt-12">Simpan</button>
  <a class="btn mt-12" href="customers.php">Batal</a>
</form>
<?php include 'footer.php'; ?>
