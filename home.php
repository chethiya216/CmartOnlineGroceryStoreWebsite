<?php

include 'config.php';

session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;


if (isset($_POST['add_to_cart'])) {

    if (!$user_id) {
        $_SESSION['redirect_message'] = 'Please login to add items to your cart!';
        header('location:login.php');
        exit;
    }

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE product_id = '$product_id' AND user_id = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'Already added to cart!';
    } else {
        mysqli_query($conn, "INSERT INTO cart(user_id, product_id, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message[] = 'Product added to cart!';
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
    <?php 
    include 'header.php'; 
    
    if(isset($messages)){
        foreach($messages as $message){
            echo '
            <div class="message">
                <span>'.$message.'</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            ';
        }
    }
    ?>
    
    <!-- Home Section -->
    <section class="home">
        <div class="video-container">
            <video src="images/QuickCart.mp4" autoplay muted loop></video>
        </div>
        
        <div class="content">
            <h3>Freshness You Can Trust, Savings You Deserve</h3>
            <p>Our commitment is unwavering. With quality guaranteed and prices that delight, we ensure every purchase brings satisfaction and value. Trust in freshness, revel in savings.</p>
            <a href="shop.php" class="white-btn">Discover More</a>
        </div>
    </section>

    <!-- Products Section -->
    <section class="products">
        <div class="container">
            <h1 class="title">Recent Products</h1>
            
            <div class="box-container">
                <?php
                $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 9") or die('query failed');
                if (mysqli_num_rows($select_products) > 0) {
                    while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                ?>
                    <form action="" method="post" class="box">
                        <div class="product-wrapper">
                            <a href="view-product.php?id=<?php echo $fetch_products['id']; ?>">
                                <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                                <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                                <div class="name"><?php echo $fetch_products['name']; ?></div>
                                <div class="price-qty">
                                    <div class="price">Rs:<?php echo $fetch_products['price']; ?>/-</div>
                                    <!-- <div class="prod-qty">(<?php 
                                        if ($fetch_products['qty'] > 0) {
                                            echo $fetch_products['qty'] . ' left';
                                        } else {
                                            echo 'Out of stock';
                                        }
                                        ?>)
                                    </div> -->
                                </div>
                                <?php if ($fetch_products['qty'] > 0) { ?>
                                    <!-- <input type="number" min="1" name="product_quantity" value="1" class="qty"> -->
                                <?php } else { ?>
                                    <!-- <input type="number" min="1" name="product_quantity" class="qty" value="0" hidden> -->
                                <?php } ?>
                                <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                                <?php if ($fetch_products['qty'] > 0) { ?>
                                    <!-- <input type="submit" value="add to cart" name="add_to_cart" class="btn"> -->
                                <?php }else{ ?>
                                    <!-- <input type="submit" value="Out Of Stock" class="btn" hidden disabled> -->
                                <?php } ?>
                            </a>
                        </div>
                    </form> 
                <?php
                    }
                } else {
                    echo '<p class="empty">No products added yet!</p>';
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
        // Fixed script for user box toggle
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle user box
            const userBtn = document.getElementById('user-btn');
            const userBox = document.querySelector('.user-box');
            
            if (userBtn && userBox) {
                userBtn.addEventListener('click', function(e) {
                    e.stopPropagation(); // Prevent event from bubbling up
                    userBox.classList.toggle('active');
                });
            }
            
            // Close user box when clicking anywhere else
            document.addEventListener('click', function(e) {
                if (userBox && userBox.classList.contains('active') && 
                    !userBox.contains(e.target) && 
                    e.target !== userBtn) {
                    userBox.classList.remove('active');
                }
            });
            
            // Smooth scrolling
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // Close messages when clicking the X icon
            document.querySelectorAll('.message .fa-times').forEach(icon => {
                icon.addEventListener('click', function() {
                    this.parentElement.style.display = 'none';
                });
            });
        });
    </script>
</body>
</html>