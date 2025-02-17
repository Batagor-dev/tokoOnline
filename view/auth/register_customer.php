<?php
// register_customer.php
require '../../function/function.php';

$errorMessages = []; // Menyimpan pesan error

// Fetch customer data if user is logged in or needs to edit their details
$customerData = null;
if (isset($_SESSION['user_id'])) {
    // Assuming user_id is stored in session after login
    $userId = $_SESSION['user_id'];

    // Query to fetch customer data from the 'costumer' table
    $query = "SELECT * FROM costumer WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $userId]);
    $customerData = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST["register"])) {
    $nama = htmlspecialchars($_POST["nama"]);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $username = htmlspecialchars($_POST["username"]);
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];
    $phone = htmlspecialchars($_POST["phone"]);
    $address = htmlspecialchars($_POST["address"]);

    // Password validation
    if (strlen($password) < 8) {
        $errorMessages[] = 'Password minimal 8 karakter!';
    } else if ($password !== $confirm_password) {
        $errorMessages[] = 'Konfirmasi password tidak cocok!';
    } else {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessages[] = 'Email tidak valid!';
        }
    }

    // Validasi nomor telepon
    if (!preg_match('/^08[0-9]{8,12}$/', $phone)) {
        $errorMessages[] = 'Nomor telepon harus diawali dengan 08 dan terdiri dari 8 hingga 12 digit angka!';
    }

    // Jika tidak ada error, lakukan registrasi
    if (empty($errorMessages)) {
        // Call function to register customer
        $result = register_customer($nama, $email, $username, $password, $phone, $address);
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
        <h2>Register</h2>
        <form method="post" action="" autocomplete="off">

            <!-- Tampilkan pesan error -->
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
                <input type="text" name="nama" required minlength="3" maxlength="50" placeholder="Masukkan nama lengkap"
                    value="<?php echo $customerData ? $customerData['nama'] : ''; ?>">
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required placeholder="Masukkan email"
                    value="<?php echo $customerData ? $customerData['email'] : ''; ?>">
            </div>

            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" required minlength="4" maxlength="20" pattern="[a-zA-Z0-9_]+"
                    placeholder="Masukkan username"
                    value="<?php echo $customerData ? $customerData['username'] : ''; ?>">
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
                <input type="text" name="phone" required placeholder="Masukkan nomor telepon"
                    value="<?php echo $customerData ? $customerData['phone'] : ''; ?>" pattern="08[0-9]{8,12}"
                    title="Nomor telepon harus diawali dengan 08 dan diikuti 8-12 digit angka">
            </div>

            <div class="form-group">
                <label>Alamat:</label>
                <input type="text" name="address" required placeholder="Masukkan alamat"
                    value="<?php echo $customerData ? $customerData['address'] : ''; ?>">
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
        // Client-side password match validation
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