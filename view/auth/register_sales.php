<?php

require '../../function/function.php';

$errorMessages = []; // Menyimpan pesan error

if (isset($_POST["register"])) {
    $nama = htmlspecialchars($_POST["nama"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $username = htmlspecialchars($_POST["username"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $phone = htmlspecialchars($_POST["phone"]);
    $region = htmlspecialchars($_POST["region"]);

    // Validasi password
    if (strlen($password) < 8) {
        $errorMessages[] = 'Password minimal 8 karakter!';
    } else if ($password !== $confirm_password) {
        $errorMessages[] = 'Konfirmasi password tidak cocok!';
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessages[] = 'Email tidak valid!';
        }
    }

    // Jika tidak ada error, lakukan registrasi
    if (empty($errorMessages)) {
        // Panggil fungsi untuk registrasi sales
        $result = register_sales($nama, $email, $username, $password, $phone, $region);
        if ($result === "email-taken") {
            $errorMessages[] = 'Email sudah terdaftar!';
        } else if ($result === "username-taken") {
            $errorMessages[] = 'Username sudah terdaftar!';
        } else if ($result === "success") {
            echo "<script>
                document.location.href = 'login.php';
            </script>";
        } else {
            $errorMessages[] = 'Terjadi kesalahan, silakan coba lagi!';
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
        <h2>Register as Sales</h2>
        <form method="post" action="" autocomplete="off">

            <?php if (!empty($errorMessages)): ?>
                <div class="error-messages">
                    <ul>
                        <?php foreach ($errorMessages as $message): ?>
                            <li><?= $message ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label>Nama Lengkap:</label>
                <input type="text" name="nama" required minlength="3" maxlength="50"
                    placeholder="Masukkan nama lengkap">
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required placeholder="Masukkan email">
            </div>

            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" required minlength="4" maxlength="20" pattern="[a-zA-Z0-9_]+"
                    placeholder="Masukkan username">
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
                <label>Nomor Telepon:</label>
                <input type="text" name="phone" required placeholder="Masukkan nomor telepon">
            </div>

            <div class="form-group">
                <label>Wilayah Kerja:</label>
                <input type="text" name="region" required placeholder="Masukkan wilayah kerja">
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
        document.querySelector('form').addEventListener('submit', function (e) {
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