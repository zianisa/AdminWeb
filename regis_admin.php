<?php

include('koneksi.php');

if (isset($_POST['regis'])) {
    // Ambil dan filter input
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];
    $email    = mysqli_real_escape_string($koneksi, $_POST['email']);
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $telepon  = mysqli_real_escape_string($koneksi, $_POST['telepon']);

    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah username sudah digunakan
    $query_check = "SELECT * FROM admin WHERE username = '$username'";
    $result_check = mysqli_query($koneksi, $query_check);

    if (mysqli_num_rows($result_check) > 0) {
        echo "<script>alert('Username sudah digunakan!');</script>";
    } else {
        // Insert ke tabel admin
        $query_insert = "INSERT INTO admin (username, password, email, nama, telepon)
                         VALUES ('$username', '$password_hash', '$email', '$nama', '$telepon')";

        if (mysqli_query($koneksi, $query_insert)) {
            $_SESSION['success'] = 'Registrasi berhasil! Silakan login.';
            header("Location: login_admin.php");
            exit();
        } else {
            echo "<script>alert('Gagal mendaftar: " . mysqli_error($koneksi) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link rel="stylesheet" href="../style.css" />
</head>
<body>
    <div class="container">
        <div class="Login">
            <form method="post" action="">
                <h1 style="text-align:center;">Registrasi Admin</h1>
                <hr />
                <label>Nama</label>
                <input type="text" name="nama" placeholder="Masukkan nama" required />

                <label>No Telp</label>
                <input type="text" name="telepon" placeholder="Masukkan no telp" required />

                <label>Email</label>
                <input type="email" name="email" placeholder="Masukkan email" required />

                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required />

                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required />

                <p><button type="submit" name="regis">Daftar</button></p>
            </form>
        </div>
    </div>
</body>
</html>
