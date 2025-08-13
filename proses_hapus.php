<?php
include('koneksi.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data gambar dulu biar bisa dihapus dari folder
    $get = mysqli_query($koneksi, "SELECT gambar FROM produk WHERE id = '$id'");
    $data = mysqli_fetch_assoc($get);

    if ($data) {
        $gambar = $data['gambar'];
        $path = "../upload/" . $gambar;

        // Hapus data di database
        $delete = mysqli_query($koneksi, "DELETE FROM produk WHERE id = '$id'");

        if ($delete) {
            // Coba hapus file gambar dari folder upload
            if (file_exists($path)) {
                unlink($path);
            }
            echo "<script>alert('Produk berhasil dihapus'); window.location='dashboard_admin.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus produk'); window.location='dashboard_admin.php';</script>";
        }
    } else {
        echo "<script>alert('Data tidak ditemukan'); window.location='dashboard_admin.php';</script>";
    }
} else {
    echo "<script>alert('ID tidak valid'); window.location='dashboard_admin.php';</script>";
}
?>
