<?php
include('koneksi.php');

// Proses submit form
if (isset($_POST['submit'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $harga = $_POST['harga'];
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $stok = $_POST['stok'];
    $kategori = $_POST['kategori'];
    $ukuran = $_POST['ukuran'];

    // Upload gambar
    $nama_file = $_FILES['gambar']['name'];
    $tmp_file = $_FILES['gambar']['tmp_name'];
    $path = "../upload/" . basename($nama_file);

    if (move_uploaded_file($tmp_file, $path)) {
        $query = "INSERT INTO produk (nama, harga, gambar, deskripsi, stok, kategori, ukuran)
                  VALUES ('$nama', '$harga', '$nama_file', '$deskripsi', '$stok', '$kategori', '$ukuran')";
        
        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('✅ Produk berhasil ditambahkan'); window.location='dashboard_admin.php';</script>";
            exit();
        } else {
            echo "<script>alert('❌ Gagal menyimpan ke database: " . mysqli_error($koneksi) . "');</script>";
        }
    } else {
        echo "<script>alert('❌ Gagal mengupload gambar');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Form Tambah Produk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">Admin Toko Zia</a>
        <a href="dashboard_admin.php" class="btn btn-outline-light btn-sm">Kembali ke Dashboard</a>
    </div>
</nav>

<div class="container">
    <h2 class="text-center mb-4">Form Tambah Produk</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Produk</label>
            <input type="text" class="form-control" id="nama" name="nama" required autofocus>
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" required>
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar</label>
            <input type="file" class="form-control" id="gambar" name="gambar" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="2"></textarea>
        </div>

        <div class="mb-3">
            <label for="stok" class="form-label">Stok</label>
            <input type="number" class="form-control" id="stok" name="stok" required>
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select class="form-select" name="kategori" id="kategori" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="sneakers">Sneakers</option>
                <option value="converse">Converse</option>
                <option value="running">Running</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="ukuran" class="form-label">Ukuran</label>
            <input type="text" class="form-control" id="ukuran" name="ukuran" required>
        </div>

        <button type="submit" name="submit" class="btn btn-dark">Simpan Produk</button>
    </form>
</div>

</body>
</html>
