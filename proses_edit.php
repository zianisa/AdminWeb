<?php
include('koneksi.php');

// Ambil data produk berdasarkan ID dari URL
$id = $_GET['id'];
$query = mysqli_query($koneksi, "SELECT * FROM produk WHERE id = '$id'");
$produk = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan
if (!$produk) {
    echo "Produk tidak ditemukan.";
    exit;
}

// Proses submit form edit
if (isset($_POST['submit'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $harga = $_POST['harga'];
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];
    $ukuran = $_POST['ukuran'];
    
    $gambar_lama = $produk['gambar'];
    $gambar_baru = $_FILES['gambar']['name'];
    $tmp_file = $_FILES['gambar']['tmp_name'];

    // Jika user upload gambar baru
    if (!empty($gambar_baru)) {
        $path = "../upload/" . basename($gambar_baru);
        if (move_uploaded_file($tmp_file, $path)) {
            $gambar_final = $gambar_baru;
        } else {
            echo "<script>alert('Gagal mengupload gambar');</script>";
            $gambar_final = $gambar_lama;
        }
    } else {
        $gambar_final = $gambar_lama;
    }

    // Update data
    $sql = "UPDATE produk SET 
              nama = '$nama',
              harga = '$harga',
              gambar = '$gambar_final',
              deskripsi = '$deskripsi',
              stok = '$stok',
              kategori = '$kategori',
              ukuran = '$ukuran'
            WHERE id = '$id'";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Produk berhasil diperbarui'); window.location='dashboard_admin.php';</script>";
    } else {
        echo "❌ Gagal mengupdate data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Produk</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
  <h2 class="mb-4 text-center">Edit Produk</h2>
  <form action="" method="post" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="nama" class="form-label">Nama Produk</label>
      <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($produk['nama']); ?>" required>
    </div>

    <div class="mb-3">
      <label for="harga" class="form-label">Harga</label>
      <input type="number" class="form-control" name="harga" value="<?= $produk['harga']; ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Gambar Saat Ini</label><br>
      <img src="../upload/<?= $produk['gambar']; ?>" width="100"><br>
      <label for="gambar" class="form-label mt-2">Upload Gambar Baru (opsional)</label>
      <input type="file" class="form-control" name="gambar">
    </div>

    <div class="mb-3">
      <label for="deskripsi" class="form-label">Deskripsi</label>
      <input type="text" class="form-control" name="deskripsi" value="<?= htmlspecialchars($produk['deskripsi']); ?>">
    </div>

    <div class="mb-3">
      <label for="stok" class="form-label">Stok</label>
      <input type="number" class="form-control" name="stok" value="<?= $produk['stok']; ?>" required>
    </div>

    <div class="mb-3">
      <label for="kategori" class="form-label">Kategori</label>
      <select class="form-select" name="kategori" required>
        <option value="sneakers" <?= $produk['kategori'] == 'sneakers' ? 'selected' : '' ?>>Sneakers</option>
        <option value="converse" <?= $produk['kategori'] == 'converse' ? 'selected' : '' ?>>Converse</option>
        <option value="running" <?= $produk['kategori'] == 'running' ? 'selected' : '' ?>>Running</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="ukuran" class="form-label">Ukuran</label>
      <input type="text" class="form-control" name="ukuran" value="<?= htmlspecialchars($produk['ukuran']); ?>" required>
    </div>

    <button type="submit" name="submit" class="btn btn-dark">Update</button>
    <a href="dashboard_admin.php" class="btn btn-secondary">Batal</a>
  </form>
</div>
</body>
</html>
