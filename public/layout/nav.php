
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar Responsive</title>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body>
    <header>

        <div class="container">
            <!-- Logo -->
            <div class="logo">LOGO</div>

            <!-- Search Bar -->
            <!-- <div class="search-bar">
                <i class="ph ph-magnifying-glass"></i>
                <form action="" method="POST" id="search-bar">
                    <input type="text" name="search_term" id="search-input" placeholder="Search">
                    <button type="submit" >Cari</button>
                </form>
            </div> -->


            <!-- Login & Signup -->
            <div class="auth-buttons">
                <a href="view/auth/login.php" class="login">Sign Up</a>
                <a href="view/auth/login.php" class="signup">Login</a>
            </div>
        </div>

        <nav class="navbar">
            <!-- Desktop Menu -->
            <ul class="menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="womenProduct.php">Wanita</a></li>
                <li><a href="manProduct.php ">Pria</a></li>
                <li><a href="childProduct.php">Anak</a></li>
                <li><a href="salesPage.php">Sales</a></li>
            </ul>

            <!-- icons -->
            <div class="hamburger" id="menu-toggle">
                <i class="ph ph-list"></i>
            </div>
        </nav>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="mobile-menu">
            <button id="menu-close" class="close-btn">
                <i class="ph ph-x"></i>
            </button>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="womenProduct.php">Wanita</a></li>
                <li><a href="manProduct.php ">Pria</a></li>
                <li><a href="childProduct.php">Anak</a></li>
                <li><a href="salesPage.php">Sales</a></li>
                <li> <a href="view/auth/login.php" class="login">Login</a></li>
                <li><a href="view/auth/login.php" class="signup">Sign up</a></li>
            </ul>
        </div>
    </header>

</body>

</html>