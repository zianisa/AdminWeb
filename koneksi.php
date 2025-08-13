<?php
$koneksi = mysqli_connect("localhost", "root", "", "ecommerce");

// Fungsi untuk query SELECT
function query($query) {
    global $koneksi;
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        echo "Query error: " . mysqli_error($koneksi);
        return [];
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}

// Fungsi untuk menambahkan produk
function tambah_produk($data) {
    global $koneksi;

    // Sesuaikan dengan name di form
    $nama = htmlspecialchars($data['nama_barang']);
    $harga = htmlspecialchars($data['harga']);
    $deskripsi = htmlspecialchars($data['deskripsi']);
    $stok = htmlspecialchars($data['stok']);
    $kategori = htmlspecialchars($data['kategori']);
    $ukuran = htmlspecialchars($data['size']);
    $alamat = 'alamat_default'; // Ganti kalau kamu mau pakai field alamat

    // Upload gambar
    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    // Simpan ke DB
    $query = "INSERT INTO produk (nama, kategori, gambar, deskripsi, stok, ukuran, harga, alamat)
              VALUES ('$nama', '$kategori', '$gambar', '$deskripsi', '$stok', '$ukuran', '$harga', '$alamat')";

    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        die("error: " . mysqli_error($koneksi));
    }

    return mysqli_affected_rows($koneksi);
}

// Fungsi upload file
function upload() {
    $nama_file = $_FILES['gambar']['name'];
    $ukuran_file = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmp_nama = $_FILES['gambar']['tmp_name'];

    // Cek apakah user upload file
    if ($error === 4) {
        echo "<script>alert('Pilih gambar terlebih dahulu!');</script>";
        return false;
    }

    // Cek ekstensi gambar valid
    $ekstensi_valid = ['jpg', 'jpeg', 'png'];
    $ekstensi_gambar = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

    if (!in_array($ekstensi_gambar, $ekstensi_valid)) {
        echo "<script>alert('File yang diupload bukan gambar (jpg/jpeg/png)!');</script>";
        return false;
    }

    // Rename file biar unik
    $nama_file_baru = uniqid() . '.' . $ekstensi_gambar;

    // Pindahkan ke folder upload
    if (move_uploaded_file($tmp_nama, 'upload/' . $nama_file_baru)) {
        return $nama_file_baru;
    } else {
        echo "<script>alert('Gagal mengunggah gambar!');</script>";
        return false;
    }
}
?>
