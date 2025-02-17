<?php
session_start();
require 'function/function.php';

// Ambil keyword pencarian dari URL jika ada
$search_term = isset($_GET['search_term']) ? $_GET['search_term'] : '';

// Ambil produk berdasarkan pencarian (jika ada)
$products = searchProducts($conn, $search_term);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama</title>
    <link rel="stylesheet" href="public/css/index.css">
    <link rel="stylesheet" href="public/css/nav.css">
    <link rel="stylesheet" href="public/css/coba.css">
    <script src="https://unpkg.com/@phosphor-icons/web"></script> <!-- Tambahkan Phosphor Icons -->
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

    <!-- Form Search dengan Ikon -->
    <section class="search-section">
        <div class="container">
            <form action="index.php" method="GET" class="search-form">
                <div class="search-box">
                    <i class="ph ph-magnifying-glass"></i>
                    <input type="text" name="search_term" id="search-input" placeholder="Cari produk..." 
                        value="<?= htmlspecialchars($search_term, ENT_QUOTES, 'UTF-8') ?>">
                </div>
                <button type="submit">Cari</button>
            </form>
        </div>
    </section>

    <section class="product-section">
        <div class="product-container">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <a href="coba.php?id=<?= $product['id'] ?>" class="product-link">
                            <img src="public/uploads/<?= $product['image'] ?>" 
                                alt="<?= htmlspecialchars($product['name'], ENT_QUOTES, 'UTF-8') ?>" 
                                class="product-image">
                            <div class="product-info">
                                <p class="product-price">Rp <?= number_format($product['price'], 2) ?></p>
                                <p class="product-brand"><?= htmlspecialchars($product['name']) ?></p>
                                <p class="product-size">Size: <?= htmlspecialchars($product['size']) ?></p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center">Belum ada produk ditemukan.</div>
            <?php endif ?>
        </div>
    </section>

    <script src="public/js/nav.js"></script>
</body>

</html>
