<?php

include 'config.php';

session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;


if (isset($_POST['add_to_cart'])) {

    // if (!$user_id) {
    //     header('home.php');
    //     exit;
    // }

    if (!$user_id) {
        $_SESSION['redirect_message'] = 'Please login to add items to your cart';
        header('location:login.php');
        exit;
    }

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'already added to cart!';
    } else {
        mysqli_query($conn, "INSERT INTO cart(user_id, name, price, quantity, image) VALUES('$user_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message[] = 'product added to cart!';
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMart - Fresh Groceries</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <?php include 'header.php'; ?>
    <!-- Home Section -->
    <section class="home">
        <div class="video-container">
            <!-- Video background -->
            <video src="images/QuickCart.mp4" autoplay muted loop></video>
        </div>
        
        <div class="content">
            <h3>Freshness You Can Trust, Savings You Deserve</h3>
            <p>Our commitment is unwavering. With quality guaranteed and prices that delight, we ensure every purchase brings satisfaction and value. Trust in freshness, revel in savings.</p>
            <a href="#" class="white-btn">Discover More</a>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products">
        <div class="container">
            <h1 class="title">Recent Products</h1>
            
            <div class="box-container">
                <!-- Product 1 -->
                <?php
                    $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 5") or die('query failed');
                    if (mysqli_num_rows($select_products) > 0) {
                        while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                    ?>
                            <form action="" method="post" class="box">
                                <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                                <div class="name"><?php echo $fetch_products['name']; ?></div>
                                <div class="price">Rs:<?php echo $fetch_products['price']; ?>/-</div>
                                <input type="number" min="1" name="product_quantity" value="1" class="qty">
                                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                                <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                            </form> 
                    <?php
                        }
                    } else {
                        echo '<p class="empty">no products added yet!</p>';
                    }
                    ?>

            </div>
            
            <div class="load-more">
                <a href="shop.php" class="option-btn">Load More Products</a>
            </div>
        </div>
    </section>


    <!-- Home Contact Section -->
    <section class="home-contact">
        <div class="content">
            <h3>Need Help?</h3>
            <p>Don't hesitate to get in touch with our customer service management.</p>
            <a href="contact.php" class="white-btn">Contact Us</a>
        </div>
    </section>

    <?php include 'footer.php'; ?>

    <script>
        // Simple script for smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
    <script src="js/script.js"></script>
</body>
</html>