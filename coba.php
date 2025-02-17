<?php
session_start();
require 'function/function.php';

// Check if an 'id' is provided in the URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Retrieve the product details by ID
    $product = getProductByIdProduct($conn, $productId);

    // Check if the product exists
    if (!$product) {
        echo "Product not found!";
        exit;
    }

    // Ambil nomor WhatsApp dari tabel sales berdasarkan ID penjual (seller_id)
    $sellerId = $product['sales_id']; // Gunakan 'sales_id' sesuai dengan tabel
    $query = "SELECT phone FROM sales WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $sellerId);
    $stmt->execute();
    $result = $stmt->get_result();
    $salesData = $result->fetch_assoc();

    // Jika nomor ada, ubah formatnya
    if ($salesData) {
        $phone = $salesData['phone'];

        // Pastikan hanya angka
        $phone = preg_replace('/\D/', '', $phone);

        // Jika nomor diawali dengan 08, ubah menjadi 62
        if (strpos($phone, '08') === 0) {
            $phone = '62' . substr($phone, 1);
        }
    } else {
        $phone = '6281234567890'; // Default jika tidak ditemukan
    }
} else {
    echo "No product selected.";
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
   

    <!-- font google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@1,800&family=Poppins:wght@400;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="public/css/nav.css">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php include 'public/layout/nav.php'; ?>

    <section class="product-detail-section">
    <div class="product-detail-container">
        <div class="product-detail-card">
            <img src="public/uploads/<?= $product['image'] ?>"
                    alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>" class="product-detail-image">
                <div class="product-detail-info">
                    <h2 class="product-detail-name"><?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?></h2>
                    <p class="product-detail-category">Category:
                        <?= htmlspecialchars($product['category'], ENT_QUOTES, 'UTF-8') ?></p>
                    <p class="product-detail-price">Rp <?= number_format($product['price'], 2) ?></p>
                    <p class="product-detail-stock">Stock: <?= htmlspecialchars($product['stock'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                    <p class="product-detail-size">Size: <?= htmlspecialchars($product['size'], ENT_QUOTES, 'UTF-8') ?></p>
                    <p class="product-detail-gender">Gender:
                        <?= htmlspecialchars($product['gender'], ENT_QUOTES, 'UTF-8') ?></p>
                    <p class="product-detail-description">
                        <?= htmlspecialchars($product['description'], ENT_QUOTES, 'UTF-8') ?>
                    </p>
    
                    <!-- Purchase and Add to Cart Buttons -->
                    <div class="product-detail-buttons">
                       <!-- Tautan WhatsApp otomatis dengan nomor yang diambil dari database -->
<a href="https://wa.me/<?= $phone ?>?text=Halo,%20saya%20tertarik%20dengan%20produk%20Anda!" class="btn btn-buy">
    Buy Now
</a>

                    
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script src="public/js/nav.js"></script>
</body>

</html>