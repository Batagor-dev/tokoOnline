<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "toko_online");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ambil gender dari URL, default ke "wanita"
$gender = isset($_GET['gender']) ? $_GET['gender'] : 'anak';

// Query untuk mengambil produk berdasarkan gender
$query = "SELECT * FROM products WHERE gender = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $gender);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <link rel="stylesheet" href="public/css/women.css">
    <link rel="stylesheet" href="public/css/nav.css">
</head>

<body>
    <?php include 'public/layout/nav.php'; ?>
    <h2>Produk dengan Gender: <?= htmlspecialchars($gender) ?></h2>
    <section class="product-section">
        <div class="product-container">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($product = $result->fetch_assoc()): ?>
                    <div class="product-card">
                        <a href="coba.php?id=<?= $product['id'] ?>" class="product-link">
                            <img src="public/uploads/<?= htmlspecialchars($product['image'], ENT_QUOTES, 'UTF-8') ?>"
                                alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>" class="product-image">
                            <div class="product-info">
                                <p class="product-price">Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
                                <p class="product-brand"><?= htmlspecialchars($product['name']) ?></p>
                                <p class="product-size">Size: <?= htmlspecialchars($product['size']) ?></p>
                            </div>
                        </a>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="text-center">Belum ada produk tersedia.</div>
            <?php endif; ?>
        </div>
    </section>
</body>
<script src="public/js/nav.js"></script>

</html>

<?php
$stmt->close();
$conn->close();
?>