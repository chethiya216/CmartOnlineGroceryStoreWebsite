<?php
// if (isset($_SESSION['user_id']) && $_SESSION['user_id']):
if (isset($message)) {
    foreach ($message as $message) {
        echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
    }
}
?>

<header class="header">

    <div class="header-2">

        <div class="flex">

            <div id="basket" class="fas fa-shopping-cart">
                <a href="home.php" class="logo"> CMart</a>
            </div>

            <nav class="navbar">
                <?php  ?>
                <a href="home.php">Home</a>
                <a href="shop.php">Shop</a>
                <a href="orders.php">Orders</a>
                <a href="contact.php">Contact</a>
                <a href="about.php">About</a>

            </nav>

            <div class="icons">
                <div id="menu-btn" class="fas fa-bars"></div>
                <a href="search_page.php" class="fas fa-"></a>
                <a href="search_page.php" class="fas fa-search"></a>
                <div id="user-btn" class="fas fa-user"></div>

                <?php
                $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
                $cart_rows_number = mysqli_num_rows($select_cart_number);
                ?>

                <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>

                <div class="log">
                    <p>New <a href="login.php">Login</a> | <a href="register.php">Register</a> </p>
                </div>

            </div>

            <div class="user-box">
                <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id']): ?>
                    <div class="user-box-wrapper">
                        <p>Username : <span><?php echo $_SESSION['user_name']; ?></span></p>
                        <p>Email : <span><?php echo $_SESSION['user_email']; ?></span></p>
                    </div>
                    <a href="logout.php" class="delete-btn">Logout</a>
                <?php else: ?>
                    <div class="log">
                        <p>New <a href="login.php">Login</a> | <a href="register.php">Register</a></p>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>

</header>