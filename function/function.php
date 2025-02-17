<?php
$conn = mysqli_connect("localhost", "root", "", "toko_online");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fungsi Login
function login($data)
{
    global $conn;

    $username = $data["username"];
    $password = $data["password"];

    // Cek di tabel customers
    $stmt = $conn->prepare("SELECT * FROM customers WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            $_SESSION["jenis_akun"] = "customer"; // Set jenis akun
            return "success";
        }
    }

    // Cek di tabel sales
    $stmt = $conn->prepare("SELECT * FROM sales WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            $_SESSION["jenis_akun"] = "sales"; // Set jenis akun
            return "success";
        }
    }

    return "failed";
}
function register_customer($nama, $email, $username, $password, $phone, $address)
{
    global $conn;

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah email atau username sudah terdaftar
    $check_email_query = "SELECT * FROM customers WHERE email = ?";
    $check_username_query = "SELECT * FROM customers WHERE username = ?";

    // Cek email
    if ($stmt = $conn->prepare($check_email_query)) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $email_result = $stmt->get_result();
        $stmt->close();
    } else {
        return "Error preparing email check query: " . $conn->error;
    }

    // Cek username
    if ($stmt = $conn->prepare($check_username_query)) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $username_result = $stmt->get_result();
        $stmt->close();
    } else {
        return "Error preparing username check query: " . $conn->error;
    }

    // Jika email atau username sudah terdaftar
    if ($email_result->num_rows > 0) {
        return "email-taken";
    } elseif ($username_result->num_rows > 0) {
        return "username-taken";
    } else {
        // Masukkan data ke dalam tabel customer
        $insert_query = "INSERT INTO customers (name, email, username, password, phone, address) 
                         VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($insert_query)) {
            $stmt->bind_param('ssssss', $nama, $email, $username, $hashed_password, $phone, $address);
            if ($stmt->execute()) {
                $stmt->close();
                return "success";
            } else {
                $stmt->close();
                return "Error during registration: " . $stmt->error;
            }
        } else {
            return "Error preparing insert query: " . $conn->error;
        }
    }
}

function register_sales($nama, $email, $username, $password, $phone, $region)
{
    global $conn;

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Cek apakah email atau username sudah terdaftar
    $check_email_query = "SELECT * FROM sales WHERE email = ?";
    $check_username_query = "SELECT * FROM sales WHERE username = ?";

    // Cek email
    if ($stmt = $conn->prepare($check_email_query)) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $email_result = $stmt->get_result();
        $stmt->close();
    } else {
        return "Error preparing email check query: " . $conn->error;
    }

    // Cek username
    if ($stmt = $conn->prepare($check_username_query)) {
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $username_result = $stmt->get_result();
        $stmt->close();
    } else {
        return "Error preparing username check query: " . $conn->error;
    }

    // Jika email atau username sudah terdaftar
    if ($email_result->num_rows > 0) {
        return "email-taken";
    } elseif ($username_result->num_rows > 0) {
        return "username-taken";
    } else {
        // Masukkan data ke dalam tabel sales
        $insert_query = "INSERT INTO sales (name, email, username, password, phone, region) 
                         VALUES (?, ?, ?, ?, ?, ?)";

        if ($stmt = $conn->prepare($insert_query)) {
            $stmt->bind_param('ssssss', $nama, $email, $username, $hashed_password, $phone, $region);
            if ($stmt->execute()) {
                $stmt->close();
                return "success";
            } else {
                $stmt->close();
                return "Error during registration: " . $stmt->error;
            }
        } else {
            return "Error preparing insert query: " . $conn->error;
        }
    }
}


// Function untuk menambahkan produk
function addProduct($conn, $sales_id)
{
    if (isset($_POST['add_product'])) {
        $name = htmlspecialchars($_POST['name']);
        $category = htmlspecialchars($_POST['category']);
        $description = htmlspecialchars($_POST['description']);
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $status = $_POST['status'];
        $size = htmlspecialchars($_POST['size']);
        $gender = $_POST['gender'];
        $image = uploadImage(); // Pastikan fungsi ini mengembalikan string valid

        // Pastikan semua field tidak kosong
        if (empty($name) || empty($category) || empty($price) || empty($stock) || empty($status) || empty($size) || empty($gender) || empty($image)) {
            echo "<script>alert('Semua kolom harus diisi!');</script>";
            return;
        }

        // Query untuk menambahkan produk ke dalam database
        $query = "INSERT INTO products (sales_id, name, category, description, price, stock, status, size, gender, image) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "isssdiisss", $sales_id, $name, $category, $description, $price, $stock, $status, $size, $gender, $image);

        if (mysqli_stmt_execute($stmt)) {
            // Redirect lebih aman menggunakan header()
            header("Location: management.php");
            exit();
        } else {
            echo "<script>alert('Gagal menambahkan produk!');</script>";
        }
    }
}




// Function untuk upload gambar
function uploadImage()
{
    // Cek apakah file gambar diunggah
    if (empty($_FILES['image']['name'])) {
        return null; // Tidak ada file yang diunggah
    }

    // Konfigurasi direktori upload
    $target_dir = "../../public/uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true); // Buat direktori jika belum ada
    }

    // Validasi file
    $file_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . uniqid() . '_' . $file_name; // Tambahkan uniqid untuk menghindari nama file duplikat
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    $max_file_size = 2 * 1024 * 1024; // 2MB

    // Cek ekstensi file
    if (!in_array($imageFileType, $allowed_types)) {
        echo "<script>alert('Hanya file JPG, JPEG, PNG, dan GIF yang diizinkan!');</script>";
        return null;
    }

    // Cek ukuran file
    if ($_FILES["image"]["size"] > $max_file_size) {
        echo "<script>alert('Ukuran file terlalu besar! Maksimal 2MB.');</script>";
        return null;
    }

    // Cek apakah file adalah gambar asli
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('File yang diunggah bukan gambar yang valid!');</script>";
        return null;
    }

    // Coba upload file
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        return $target_file; // Kembalikan path file jika berhasil diunggah
    } else {
        echo "<script>alert('Gagal mengupload gambar!');</script>";
        return null;
    }
}

// Function untuk mendapatkan produk berdasarkan ID
function getProductById($conn, $product_id, $sales_id)
{
    $query = "SELECT * FROM products WHERE id = ? AND sales_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $product_id, $sales_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

// Function untuk mengupdate produk
function updateProduct($conn, $product_id, $sales_id)
{
    if (isset($_POST['update_product'])) {
        $name = htmlspecialchars($_POST['name']);
        $category = htmlspecialchars($_POST['category']);
        $description = htmlspecialchars($_POST['description']);
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $size = htmlspecialchars($_POST['size']);
        $gender = $_POST['gender'];  // Menambahkan gender

        $query = "UPDATE products SET name = ?, category = ?, description = ?, price = ?, stock = ?, size = ?, gender = ? WHERE id = ? AND sales_id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssdiissii", $name, $category, $description, $price, $stock, $status, $size, $gender, $product_id, $sales_id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: management.php");
            exit();
        } else {
            echo "<script>alert('Gagal memperbarui produk!');</script>";
        }
    }
}

// Function untuk menghapus produk
function deleteProduct($conn, $product_id, $sales_id)
{
    $query = "DELETE FROM products WHERE id = ? AND sales_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $product_id, $sales_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: sales.php");
        exit();
    } else {
        echo "<script>alert('Gagal menghapus produk!');</script>";
    }
}

// Function untuk mendapatkan semua produk milik sales yang login
function getAllProducts($conn, $sales_id)
{
    $query = "SELECT * FROM products WHERE sales_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $sales_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}


function getAllProductsSales($conn)
{
    $query = "SELECT * FROM products";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();  // Ambil hasil query
    return $result->fetch_all(MYSQLI_ASSOC); // Ubah ke array asosiatif
}


// Fungsi untuk mengambil saldo berdasarkan sales_id
function getSalesBalance($conn, $sales_id)
{
    $query = "SELECT saldo FROM sales WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $sales_id); // Menggunakan parameter sales_id
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['saldo']; // Mengembalikan saldo yang ditemukan
    } else {
        return 0; // Jika tidak ada data, mengembalikan saldo 0
    }
}

function searchProducts($conn, $search_term) {
    // Escape string untuk menghindari SQL Injection
    $search_term = mysqli_real_escape_string($conn, $search_term);

    // Query untuk mencari produk berdasarkan nama
    $query = "SELECT * FROM products WHERE name LIKE ?";
    $stmt = $conn->prepare($query);
    $search_term = "%$search_term%";
    $stmt->bind_param("s", $search_term);
    $stmt->execute();
    
    // Ambil hasil query
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getProductByIdProduct($conn, $id)
{
    // Make sure to prepare and bind parameters to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $id); // "i" for integer
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the product is found
    if ($result->num_rows > 0) {
        return $result->fetch_assoc(); // Return the product data as an associative array
    } else {
        return null; // No product found
    }
}



// Menutup koneksi di bagian akhir, setelah semua operasi selesai
// mysqli_close($conn);
?>