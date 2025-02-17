<?php
require '../../function/function.php';

session_start(); // Mulai session

$error_message = "";

if (isset($_POST["login"])) {
    $username = htmlspecialchars($_POST["username"]); // Sanitasi input
    $password = htmlspecialchars($_POST["password"]); // Sanitasi input

    $result = login($_POST);
    if ($result === "success") {
        session_regenerate_id(true); // Regenerate session ID untuk mencegah session fixation

        if ($_SESSION["jenis_akun"] === "sales") {
            header("Location: ../sales/sales.php");
        } else {
            header("Location: ../user/user.php");
        }
        exit;
    } else {
        $error_message = "Username atau password salah!";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="../../public/css/login.css">
</head>

<body>
    <div class="form-container">
        <h2>Login</h2>

        <!-- Tampilkan pesan error -->
        <?php if (!empty($error_message)): ?>
            <div class="error-message" style="color: red;"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" required maxlength="50"> <!-- Batasi panjang input -->
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" required maxlength="50"> <!-- Batasi panjang input -->
            </div>

            <div class="form-group">
                <button type="submit" name="login" class="btn">Login</button>
            </div>
        </form>

        <div class="register-link">
            Belum punya akun? Daftar sebagai
            <a href="register_sales.php">Sales</a> |
        </div>

    </div>
</body>

</html>