-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 11 Feb 2025 pada 14.31
-- Versi server: 8.4.3
-- Versi PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toko_online`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `customers`
--

CREATE TABLE `customers` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text,
  `saldo` decimal(15,2) DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `password`, `phone`, `address`, `saldo`, `created_at`, `username`) VALUES
(1, 'dul', 'farel@gmail.com', '$2y$10$Oasr60JcJyuQMOGoJdInyec.aJp8T2jCAb6YGiwgBzvgdDIuIKKra', '14e156', 'ko', 0.00, '2025-02-06 11:33:30', 'duldul');

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `sales_id` int DEFAULT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(50) NOT NULL,
  `description` text,
  `price` decimal(15,2) NOT NULL,
  `stock` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(255) DEFAULT NULL,
  `size` varchar(50) NOT NULL,
  `gender` enum('Anak','Pria','Wanita') NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `sales_id`, `name`, `category`, `description`, `price`, `stock`, `created_at`, `image`, `size`, `gender`, `status`) VALUES
(4, 1, 'BAJU BOXY', 'Baju', 'bahan tipis, lembut dan nyaman dipakai', 40000.00, 1, '2025-02-11 04:27:19', '../../public/uploads/2872caaa013b3b0dd774b6277e172f3b.jpg', 'L', 'Anak', '0'),
(5, 1, 'KEMEJA COKLAT', 'kemeja', 'bahan tipis, nyaman dan enak dipakai', 49000.00, 1, '2025-02-11 04:51:50', '../../public/uploads/9d6ace2b06e87633b158df74c6424ebd.jpg', 'XL', 'Pria', '0'),
(6, 1, 'KEMEJA BIRU MUDA', 'kemeja', 'bahan nyaman, halus, tipis dan enak dipakai', 49000.00, 1, '2025-02-11 04:53:03', '../../public/uploads/18168849dcc10a16e4f96a10485dae34.jpg', 'L', 'Pria', '0'),
(7, 1, 'KEMEJA BIRU TUA', 'kemeja', 'bahan nyaman, tipis dan enak dipakai', 49000.00, 1, '2025-02-11 04:54:26', '../../public/uploads/ef99ed5848302f724fc046aa330bdadf.jpg', 'L', 'Pria', '0'),
(8, 1, 'POLO T-SHIRT', 'baju', 'bahan tipis, nyaman dan enak dipakai', 50000.00, 1, '2025-02-11 04:56:40', '../../public/uploads/5dd725549e11785cc81d904d6aa68d15.jpg', 'L', 'Pria', '0'),
(9, 1, 'BAJU BOXY', 'baju', 'bahan tipis, nyaman dan enak dipakai', 49000.00, 1, '2025-02-11 04:58:44', '../../public/uploads/793946265ac225c134a86fb8e50bd1b6.jpg', 'L', 'Anak', '0'),
(10, 1, 'BAJU BOXY', 'baju', 'bahan tipis, nyaman dan enak dipakai', 50000.00, 1, '2025-02-11 05:01:17', '../../public/uploads/53004d59f42d0d0db290a0378bb67a01.jpg', 'XL', 'Pria', '0'),
(13, 1, 'SEPATU VANS', 'sepatu', 'barang masih baru dan masih segel ', 399000.00, 1, '2025-02-11 05:15:54', '../../public/uploads/a7a42cf55a3a84034a4d73027e5b78c0.jpg', '40', 'Anak', '0'),
(15, 2, 'JAKET NIKE ', 'jaket', 'bahan nya bagus dan sangat nyaman dipakai', 900000.00, 1, '2025-02-11 12:04:35', '../../public/uploads/67ab3cd3c9d17_7ace012b58a1d1a8ea6915b2456ad88e.jpg', 'XL', 'Pria', '0'),
(16, 2, 'JAKET KULIT', 'jaket', 'bahan nyaman dan enak dipakai', 500000.00, 1, '2025-02-11 13:40:48', '../../public/uploads/67ab536053199_d438f676af165c7f0735f2e11555d416.jpg', 'XL', 'Pria', '0'),
(17, 2, 'JAKET NIKE', 'jaket', 'bahan nyaman dan enak dipakai', 900000.00, 1, '2025-02-11 13:44:24', '../../public/uploads/67ab543829672_53b1ca0b96023aad068613d24edcf3cd.jpg', 'L', 'Pria', '0'),
(18, 2, 'JAKET CASUAL', 'jaket', 'bahan nyaman dan enak dipakai', 550000.00, 1, '2025-02-11 13:45:42', '../../public/uploads/67ab54866fe23_7b52c97592b8068e960cca20c939a23a.jpg', 'L', 'Pria', '0'),
(19, 2, 'JAKET CROP', 'jaket', 'bahan nyaman dan enak dipakai', 450000.00, 1, '2025-02-11 13:47:58', '../../public/uploads/67ab550e827aa_7edd159beddb89c0c17480b302fcf893.jpg', 'L', 'Pria', '0'),
(20, 2, 'JAKET LARI', 'jaket', 'bahan nyaman dan enak dipakai', 450000.00, 1, '2025-02-11 13:49:16', '../../public/uploads/67ab555bf29af_7494212e2e32c3574f112e73a963d60f.jpg', 'XL', 'Pria', '0'),
(21, 2, 'JAKET LARI', 'jaket', 'bahan nyaman dan enak dipakai', 450000.00, 1, '2025-02-11 13:50:14', '../../public/uploads/67ab5596b0210_6ade0ec2abb6799ad11dcc99b8c0b7b0.jpg', 'XL', 'Pria', '0'),
(22, 2, 'JAKET CROP', 'jaket', 'bahan nyaman dan enak dipakai', 450000.00, 1, '2025-02-11 13:52:00', '../../public/uploads/67ab56007b771_a364de3938a75c290d116fc41f1c50c6.jpg', 'L', 'Pria', '0'),
(23, 2, 'JAKET BOMBER', 'jaket', 'bahan nyaman dan enak dipakai', 350000.00, 1, '2025-02-11 13:54:57', '../../public/uploads/67ab56b19ed36_b3b3333ed8f5bee976ec6e81fdc90ccf.jpg', 'L', 'Anak', '0'),
(24, 2, 'JAKET ADINDA', 'jaket', 'bahan nyaman dan enak dipakai', 600000.00, 1, '2025-02-11 13:55:57', '../../public/uploads/67ab56eda068d_d292db92a814bfe98490397f7ba92772.jpg', 'XL', 'Pria', '0'),
(25, 2, ' CARDIGAN', 'cardigan', 'bahan nyaman dan enak dipakai', 60000.00, 1, '2025-02-11 14:01:05', '../../public/uploads/67ab58211bb06_0a7ddde7036ed76bcc43ea2d61d8af3e.jpg', 'L', 'Wanita', '0'),
(26, 2, 'HOODIE', 'jaket', 'bahan nyaman dan enak dipakai', 40000.00, 1, '2025-02-11 14:05:21', '../../public/uploads/67ab59212b043_3a3f8e97e221eb2e95885274d4e8dcb3.jpg', 'L', 'Wanita', '0'),
(27, 2, 'HOODIE TANGAN KELINCI', 'jaket', 'bahan nyaman dan enak dipakai', 60000.00, 1, '2025-02-11 14:06:53', '../../public/uploads/67ab597dbd2c6_7fdc59fd1cd34bf047b8e3365202a34b.jpg', 'L', 'Wanita', '0'),
(28, 2, 'HOODIE GARIS GARIS', 'jaket', 'bahan nyaman dan enak dipakai', 130000.00, 1, '2025-02-11 14:08:26', '../../public/uploads/67ab59da48c97_34cf71318dfcc703455493e89cd228a8.jpg', 'L', 'Wanita', '0'),
(29, 2, 'CROFTOP', 'baju', 'bahan nyaman dan enak dipakai', 50000.00, 1, '2025-02-11 14:09:27', '../../public/uploads/67ab5a17acf98_394c5bfdc975556a6c81dd20b3f6d3ed.jpg', 'L', 'Wanita', '0'),
(30, 2, 'NIKE', 'koskaki', 'bahan nyaman dan enak dipakai', 15000.00, 1, '2025-02-11 14:13:27', '../../public/uploads/67ab5b07504de_0cd56d22a243e32b39793e06046f8f42.jpg', '40', 'Pria', '0'),
(31, 2, 'KOSKAKI PENDEK', 'koskaki', 'bahan nyaman dan enak dipakai', 18000.00, 1, '2025-02-11 14:14:49', '../../public/uploads/67ab5b59d5820_2c5ed4427b4c743595333680eb1d0cef.jpg', '40', 'Wanita', '0'),
(32, 2, 'KOSKAKI PENDEK', 'koskaki', 'bahan nyaman dan enak dipakai', 13000.00, 1, '2025-02-11 14:15:54', '../../public/uploads/67ab5b99f280b_5f1a8802c89d8f0c141818c36a591ff1.jpg', '40', 'Wanita', '0'),
(33, 2, 'KOSKAKI POLOS', 'koskaki', 'bahan nyaman dan enak dipakai', 12000.00, 1, '2025-02-11 14:17:27', '../../public/uploads/67ab5bf79b0f2_57ecc993d0d4bf300474aa62bf150bd9.jpg', '40', 'Wanita', '0'),
(34, 2, 'KOSKAKI HITAM POLOS', 'koskaki', 'bahan nyaman dan enak dipakai', 20000.00, 1, '2025-02-11 14:18:30', '../../public/uploads/67ab5c363445c_232d761fb505669f647d8312cc7c55c6.jpg', '40', 'Wanita', '0'),
(35, 1, 'SEPATU COMPAS', 'sepatu', 'barang masih baru dan nyaman saat di pakai', 500000.00, 1, '2025-02-11 14:24:07', '../../public/uploads/67ab5d875bd15_c00b9465943bf456426f279829828661.jpg', '40', 'Wanita', '0'),
(36, 1, 'SEPATU BASKET', 'sepatu', 'barang masih baru dan nyaman saat di pakai', 600000.00, 1, '2025-02-11 14:25:14', '../../public/uploads/67ab5dcac46b5_cfcc3cefa14a19c980953d75cb803e1d.jpg', '40', 'Pria', '0'),
(37, 1, 'SAPATU JORDAN', 'sepatu', 'barang masih baru dan nyaman saat di pakai', 1500000.00, 1, '2025-02-11 14:26:36', '../../public/uploads/67ab5e1c63dc5_8faaa776bb0654eb4794676a56fbe3cc.jpg', '40', 'Pria', '0');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sales`
--

CREATE TABLE `sales` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `region` varchar(100) DEFAULT NULL,
  `saldo` decimal(15,2) DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `username` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `sales`
--

INSERT INTO `sales` (`id`, `name`, `email`, `password`, `phone`, `region`, `saldo`, `created_at`, `username`) VALUES
(1, 'farel', 'farel@gmail.com', '$2y$10$LahcbUJ00PcAjDW/mUf0HuWiwwudfPyll0ZjNrhSUN/oFni0sNw8a', '08231518623', 'kota bandung', 0.00, '2025-02-06 11:27:25', 'farel'),
(2, 'sales', 'sales@gmail.com', '$2y$10$AHTMvCZQvI6kzqJUHxRgh.o/cp887NsVpvszhRlmHsdW7kgxb5y8i', '0812313232', 'jakarta', 0.00, '2025-02-07 11:25:58', 'sales');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sales_id` (`sales_id`);

--
-- Indeks untuk tabel `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`sales_id`) REFERENCES `sales` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
