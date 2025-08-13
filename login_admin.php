<?php

include('koneksi.php');

// Jika sudah login, langsung arahkan ke dashboard
if (isset($_SESSION['username'])) {
    header("Location: dashboard_admin.php");
    exit();
}

// Tangkap dan tampilkan pesan sukses setelah registrasi
$pesan_sukses = '';
if (isset($_SESSION['success'])) {
    $pesan_sukses = $_SESSION['success'];
    unset($_SESSION['success']);
}

// Proses login saat form disubmit
if (isset($_POST['login_admin'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    // Cek apakah username terdaftar
    $query = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);

        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username']; // Simpan username ke session
            header("Location: dashboard_admin.php");
            exit();
        } else {
            $error = "Password salah. Silakan coba lagi.";
        }
    } else {
        $error = "Username tidak ditemukan.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Toko Sepatu Zia - Login Admin</title>
    <link rel="stylesheet" href="../style.css" />
</head>
<body>
    <div class="container">
        <div class="Login">
            <form method="post" action="">
                <h1 style="text-align:center;">Login Admin</h1>
                <hr/>

                <?php if (!empty($pesan_sukses)) : ?>
                    <p style="color:green; text-align:center;"><?= $pesan_sukses ?></p>
                <?php endif; ?>

                <?php if (!empty($error)) : ?>
                    <p style="color:red; text-align:center;"><?= $error ?></p>
                <?php endif; ?>

                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username" required/>

                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required/>

                <button type="submit" name="login_admin">Login</button>

                <p style="text-align:center;">
                    <a href="regis_admin.php">Belum punya akun? Daftar</a>
                </p>
            </form>
        </div>
    </div>
</body>
</html>
