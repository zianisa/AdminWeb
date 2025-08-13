<?php
include('koneksi.php');

if (isset($_POST['submit'])) {
    $nama      = htmlspecialchars($_POST['nama']);
    $harga     = $_POST['harga'];
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $stok      = $_POST['stok'];
    $kategori  = $_POST['kategori'];
    $ukuran    = $_POST['ukuran'];

    // Upload gambar
    $nama_file = $_FILES['gambar']['name'];
    $tmp_file  = $_FILES['gambar']['tmp_name'];
    $folder    = "../upload/";

    // Cek & rename file kalau namanya sama
    $ext = pathinfo($nama_file, PATHINFO_EXTENSION);
    $nama_baru = uniqid("img_") . "." . $ext;
    $path = $folder . $nama_baru;

    if (move_uploaded_file($tmp_file, $path)) {
        $query = "INSERT INTO produk (nama, harga, gambar, deskripsi, stok, kategori, ukuran)
                  VALUES ('$nama', '$harga', '$nama_baru', '$deskripsi', '$stok', '$kategori', '$ukuran')";

        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('✅ Produk berhasil ditambahkan'); window.location='dashboard_admin.php';</script>";
            exit();
        } else {
            echo "<script>alert('❌ Gagal menyimpan ke database: " . mysqli_error($koneksi) . "');</script>";
        }
    } else {
        echo "<script>alert('❌ Upload gambar gagal. Cek folder upload/ dan permission-nya.');</script>";
    }
}
?>
