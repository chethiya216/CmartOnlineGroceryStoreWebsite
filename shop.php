<?php

include 'config.php';

session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// if (!isset($user_id)) {
//     header('location:login.php');
// }

if (isset($_POST['add_to_cart'])) {

    if (!$user_id) {
        $_SESSION['redirect_message'] = 'Please login to add items to your cart';
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
        $message[] = 'already added to cart!';
    } else {
        mysqli_query($conn, "INSERT INTO `cart`(user_id, product_id, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('query failed');
        $message[] = 'product added to cart!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | CMart</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!--   css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'header.php'; ?>
    <div class="heading">
        <h3>Our Store</h3>
        <p> <a href="home.php">Home</a> / Shop </p>
    </div>

    <section class="products">

        <h1 class="title">Latest Products</h1>

        <div class="box-container">

            <?php
                $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
                if (mysqli_num_rows($select_products) > 0) {
                    while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
            <div class="product-card">
                <form action="" method="post" class="box">
                    <div class="product-wrapper">
                        <a href="view-product.php?id=<?php echo $fetch_products['id']; ?>">
                            <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
                            <img class="image" src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                            <div class="name"><?php echo $fetch_products['name']; ?></div>
                            <div class="price-qty">
                                <div class="price">Rs:<?php echo $fetch_products['price']; ?>/-</div>
                                <div class="prod-qty">(<?php 
                                    if ($fetch_products['qty'] > 0) {
                                        echo $fetch_products['qty'] . ' left';
                                    } else {
                                        echo 'Out of stock';
                                    }
                                    ?>)</div>
                            </div>
                             
                            <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
                            <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
                            <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                            <?php if ($fetch_products['qty'] > 0) { ?>
                                <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                            <?php }else{ ?>
                                <input type="submit" value="Out Of Stock" class="btn" hidden disabled>
                            <?php } ?>
                        </a>
                    </div>
                </form> 
            </div>
            <?php
                    }
                } else {
                    echo '<p class="empty">No products added yet!</p>';
                }
            ?>
        </div>

    </section>

    <?php include 'footer.php'; ?>

    <!--   js file link  -->
    <script src="js/script.js"></script>

</body>

</html>