<?php
include('koneksi.php');
zianisa
// Ambil data produk dari database
$query = "SELECT * FROM produk ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);

// Simpan data ke array
$produk = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $produk[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Admin - Toko Zia</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Nunito', sans-serif;
    }
    .table img {
      max-width: 100px;
      height: auto;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="assets/logo.png" alt="Logo" width="30" class="me-2">
      <strong>Admin</strong>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-3">
        <li class="nav-item">
          <a class="nav-link active" href="dashboard_admin.php">Dashboard</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="form_admin.php">Tambah Produk</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Main Content -->
<div class="container mt-5">
  <h2 class="text-center mb-4">Daftar Produk</h2>

  <a href="form_admin.php" class="btn btn-success btn-sm mb-3">
    <i class="fas fa-plus-circle"></i> Tambah Produk
  </a>

  <div class="table-responsive">
    <table class="table table-bordered text-center align-middle">
      <thead class="table-primary">
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Harga</th>
          <th>Gambar</th>
          <th>Deskripsi</th>
          <th>Stok</th>
          <th>Kategori</th>
          <th>Ukuran</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($produk)): ?>
          <?php $no = 1; foreach ($produk as $item): ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= htmlspecialchars($item['nama']); ?></td>
              <td>Rp <?= number_format($item['harga'], 0, ',', '.'); ?></td>
              <td>
                <img src="../upload/<?= htmlspecialchars($item['gambar']); ?>" alt="<?= htmlspecialchars($item['nama']); ?>">
              </td>
              <td><?= htmlspecialchars($item['deskripsi']); ?></td>
              <td><?= $item['stok']; ?></td>
              <td><?= htmlspecialchars($item['kategori']); ?></td>
              <td><?= htmlspecialchars($item['ukuran']); ?></td>
              <td>
  <a href="proses_edit.php?id=<?= $item['id']; ?>" class="btn btn-warning btn-sm">
  <i class="ti ti-edit"></i>
</a>

                <a href="proses_hapus.php?id=<?= $item['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus produk ini?');">
  <i class="ti ti-trash"></i>
</a>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="9">Belum ada produk yang ditambahkan.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
