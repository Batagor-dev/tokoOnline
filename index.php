<?php
session_start();
require 'function/function.php';

// Retrieve all products
$products = getAllProductsSales($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="public/css/index.css">

    <!-- font google -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@1,800&family=Poppins:wght@400;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="public/css/nav.css">
</head>

<body>
    <?php include 'public/layout/nav.php'; ?>
    <section class="hero-section">
        <div class="hero-content">
            <img src="public/img/benner.png" alt="">
            <img src="public/img/kotak.png" alt="" class="kotak">
            <div class="text-overlay">
                <h1>Buy And Sell In One Place</h1>
            </div>
        </div>
    </section>

    <section class="product-section">
        <div class="product-container">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                     <a href="coba.php?id=<?= $product['id'] ?>" class="product-link">
                            <img src="public/uploads/<?= $product['image'] ?>"
                                alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>" class="product-image">
                            <div class="product-info">
                                <p class="product-price">Rp <?= number_format($product['price'], 2) ?></p>
                                <p class="product-brand"><?= htmlspecialchars($product['name']) ?></p>
                                <p class="product-size">Size: <?= htmlspecialchars($product['size']) ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center">Belum ada produk tersedia.</div>
            <?php endif ?>
        </div>
    </section>

    <script src="public/js/nav.js"></script>
</body>

</html>