<?php
require '../../function/function.php';

if (isset($_POST["register"])) {
    // Validasi input dan sanitasi
    $nama = htmlspecialchars($_POST["nama"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $username = htmlspecialchars($_POST["username"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $jenis_akun = htmlspecialchars($_POST["jenis_akun"]);

    // Validasi panjang password
    if (strlen($password) < 8) {
        echo "<script>alert('Password minimal 8 karakter!');</script>";
    } else if ($password !== $confirm_password) {
        echo "<script>alert('Konfirmasi password tidak cocok!');</script>";
    } else {
        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Email tidak valid!');</script>";
            return;
        }

        // Check email and username availability
        $result = register($nama, $email, $username, $password, $confirm_password, $jenis_akun);
        if ($result === "email-taken") {
            echo "<script>alert('Email sudah terdaftar!');</script>";
        } else if ($result === "username-taken") {
            echo "<script>alert('Username sudah terdaftar!');</script>";
        } else if ($result === "success") {
            echo "<script>
                alert('Registrasi berhasil! Silakan login.');
                document.location.href = 'login.php';
            </script>";
        } else {
            echo "<script>alert('Terjadi kesalahan, silakan coba lagi!');</script>";
        }
    }
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="../../public/css/register.css">
</head>
<body>
    <div class="form-container">
        <h2>Register</h2>
        <form method="post" action="" autocomplete="off">
            <div class="form-group">
                <label>Nama Lengkap:</label>
                <input type="text" name="nama" required minlength="3" maxlength="50" placeholder="Masukkan nama lengkap">
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required placeholder="Masukkan email">
            </div>
            
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" required minlength="4" maxlength="20" pattern="[a-zA-Z0-9_]+" placeholder="Masukkan username">
                <small class="password-hint">Hanya huruf, angka, dan underscore (_)</small>
            </div>
            
            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required minlength="8" placeholder="Masukkan password">
                <small class="password-hint">Minimal 8 karakter</small>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password:</label>
                <input type="password" name="confirm_password" required minlength="8" placeholder="Konfirmasi password">
            </div>

            <div class="form-group">
                <label>Jenis Akun:</label>
                <select name="jenis_akun" required>
                    <option value="">Pilih jenis akun</option>
                    <option value="user">User</option>
                    <option value="sales">Sales</option>
                </select>
            </div>
            
            <div class="form-group">
                <button type="submit" name="register" class="btn">Register</button>
            </div>
        </form>
        
        <div class="login-link">
            Sudah punya akun? <a href="login.php">Login</a>
        </div>
    </div>

    <script>
        // Validasi password match dengan JavaScript di sisi klien
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.querySelector('input[name="password"]').value;
            const confirmPassword = document.querySelector('input[name="confirm_password"]').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Konfirmasi password tidak cocok!');
            }
        });
    </script>
</body>
</html>
