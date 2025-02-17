<?php
session_start();
require '../../function/function.php';

// Cek login dan jenis akun
if (!isset($_SESSION['login']) || $_SESSION['jenis_akun'] !== 'sales') {
    header("Location: ../auth/login.php");
    exit();
}

$sales_id = $_SESSION['id']; // Ambil ID sales yang login

// Proses permintaan (POST dan GET)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['add_product'])) {
        addProduct($conn, $sales_id);
    } elseif (isset($_POST['update_product'])) {
        $product_id = $_POST['product_id'] ?? null;
        if ($product_id) {
            updateProduct($conn, $product_id, $sales_id);
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if (isset($_GET['delete']) && isset($_GET['id'])) {
        deleteProduct($conn, $_GET['id'], $sales_id);
    }
}

// Ambil semua produk untuk ditampilkan di tabel
$products = getAllProducts($conn, $sales_id);
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk</title>
    <link rel="stylesheet" href="../../public/css/management.css">
</head>

<body>
    <div class="container">
        <!-- Tombol kembali -->
        <a href="../dashboard.php" class="back-button">&larr; Kembali</a>

        <h2 class="page-title">Manajemen Produk</h2>

        <!-- Tombol untuk membuka modal -->
        <button id="openModal" class="add-product-button">Tambah Produk</button>

        <!-- Tabel untuk menampilkan produk -->
       <div class="product-container">
    <?php if (!empty($products)): ?>
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <img src="<?= htmlspecialchars($product['image']) ?>" alt="Produk">
                <h3><?= htmlspecialchars($product['name']) ?></h3>
                <p>Kategori: <?= htmlspecialchars($product['category']) ?></p>
                <p>Harga: Rp <?= number_format($product['price'], 2, ',', '.') ?></p>
                <p>Stok: <?= htmlspecialchars($product['stock']) ?></p>
                <p>Ukuran: <?= htmlspecialchars($product['size']) ?></p>
                <p>Gender: <?= htmlspecialchars($product['gender']) ?></p>
                <p><?= htmlspecialchars($product['description']) ?></p>
                <div class="action-buttons">
                    <button class="edit-button" onclick="openEditModal(<?= $product['id'] ?>, '<?= htmlspecialchars($product['name']) ?>')">Edit</button>
                    <a href="?delete&id=<?= $product['id'] ?>" class="delete-button" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Produk belum ada</p>
    <?php endif; ?>
</div>

    </div>

    <!-- Modal Tambah Produk -->
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h4>Tambah Produk</h4>
            </div>
            <div class="modal-body">
                <form action="management.php" method="POST" enctype="multipart/form-data">
                    <label for="name">Nama Produk:</label>
                    <input type="text" id="name" name="name" required><br>

                    <label for="category">Kategori:</label>
                    <input type="text" id="category" name="category" required><br>

                    <label for="description">Deskripsi:</label>
                    <textarea id="description" name="description"></textarea><br>

                    <label for="price">Harga:</label>
                    <input type="number" id="price" name="price" required><br>

                    <label for="stock">Stok:</label>
                    <input type="number" id="stock" name="stock" required><br>

                    <label for="status">Status:</label>
                    <input type="text" id="status" name="status" required>
                    <br>

                    <label for="size">Ukuran:</label>
                    <input type="text" id="size" name="size" required><br>

                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <option value="Anak">Anak</option>
                        <option value="Pria">Pria</option>
                        <option value="Wanita">Wanita</option>
                    </select><br>

                    <label for="image">Gambar Produk:</label>
                    <input type="file" id="image" name="image" accept="image/*" required><br>

                    <button type="submit" name="add_product" class="submit-button">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Produk -->
<div id="editProductModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <span class="close">&times;</span>
            <h4>Edit Produk</h4>
        </div>
        <div class="modal-body">
            <form action="management.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" id="editProductId" name="product_id">

                <label for="editName">Nama Produk:</label>
                <input type="text" id="editName" name="name" required><br>

                <label for="editCategory">Kategori:</label>
                <input type="text" id="editCategory" name="category" required><br>

                <label for="editDescription">Deskripsi:</label>
                <textarea id="editDescription" name="description"></textarea><br>

                <label for="editPrice">Harga:</label>
                <input type="number" id="editPrice" name="price" required><br>

                <label for="editStock">Stok:</label>
                <input type="number" id="editStock" name="stock" required><br>

                <label for="editSize">Ukuran:</label>
                <input type="text" id="editSize" name="size" required><br>

                <label for="editGender">Gender:</label>
                <select id="editGender" name="gender" required>
                    <option value="Anak">Anak</option>
                    <option value="Pria">Pria</option>
                    <option value="Wanita">Wanita</option>
                </select><br>

                <label for="editImage">Gambar Produk:</label>
                <input type="file" id="editImage" name="image" accept="image/*"><br>

                <button type="submit" name="update_product" class="submit-button">Update Produk</button>
            </form>
        </div>
    </div>
</div>


    <script>
      // JavaScript untuk membuka dan menutup modal
document.getElementById('openModal').addEventListener('click', function () {
    document.getElementById('addProductModal').style.display = 'block';
});

document.querySelector('.close').addEventListener('click', function () {
    document.getElementById('addProductModal').style.display = 'none';
});

window.onclick = function (event) {
    var modal = document.getElementById('addProductModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
};

// JavaScript untuk membuka dan menutup modal Edit Produk
function openEditModal(productId, productName, productCategory, productDescription, productPrice, productStock, productSize, productGender) {
    document.getElementById('editProductModal').style.display = 'block';

    // Menetapkan nilai ke form di modal edit
    document.getElementById('editProductId').value = productId;
    document.getElementById('editName').value = productName;
    document.getElementById('editCategory').value = productCategory;
    document.getElementById('editDescription').value = productDescription;
    document.getElementById('editPrice').value = productPrice;
    document.getElementById('editStock').value = productStock;
    document.getElementById('editSize').value = productSize;
    document.getElementById('editGender').value = productGender;
}

// Menutup modal edit saat klik tombol close
document.querySelector('.close').addEventListener('click', function () {
    document.getElementById('editProductModal').style.display = 'none';
});

window.onclick = function (event) {
    var modal = document.getElementById('editProductModal');
    if (event.target == modal) {
        modal.style.display = 'none';
    }
};
 
    </script>
</body>

</html>