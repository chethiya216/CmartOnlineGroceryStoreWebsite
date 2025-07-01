<?php
include("config.php");
session_start();

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

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

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE product_id = '$product_id' AND user_id = '$user_id'") or die('Query failed: ' . mysqli_error($conn));

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'Already added to cart!';
    } else {
        mysqli_query($conn, "INSERT INTO `cart`(user_id, product_id, name, price, quantity, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image')") or die('Query failed: ' . mysqli_error($conn));
        $message[] = 'Product added to cart!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Name | CMart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="font-poppins text-gray-800 bg-white text-lg leading-relaxed">
    <?php
    include 'header.php';

    if (isset($messages)) {
        foreach ($messages as $msg) {
            echo '
            <div class="fixed top-5 right-5 bg-green-500 text-white p-4 rounded-lg flex items-center justify-between max-w-sm z-50">
                <span>' .  ($msg) . '</span>
                <i class="fas fa-times cursor-pointer" onclick="this.parentElement.remove();"></i>
            </div>
            ';
        }
    }
    ?>


    <main class="pt-8">
        <div class="max-w-7xl mx-auto">
            <?php
            $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$product_id'") or die('Query failed: ' . mysqli_error($conn));
            if (mysqli_num_rows($select_product) > 0) {
                while ($fetch_product = mysqli_fetch_assoc($select_product)) {
            ?>
            <div class="grid grid-cols-2 md:grid-cols-[2fr,3fr] gap-4 mb-8">
                <!-- Product Images -->
                <div class="col-md-5 gap-4">
                    <div class="relative bg-gray-100 rounded-xl overflow-hidden aspect-square max-w-auto flex items-center justify-center shadow-md">
                        <img src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="<?php echo $fetch_product['name']; ?>" class="w-full h-full object-cover transition-transform duration-300 hover:scale-105 border-none" id="mainImage">
                    </div>
                </div>

                <!-- Product Details -->
                <div class="col-md-7 gap-2 bg-gray-100 p-10 rounded-xl object-fill shadow-md">
                    <form action="" method="post">
                        <input type="hidden" name="product_id" value="<?php echo  ($fetch_product['id']); ?>">
                        <input type="hidden" name="product_image" value="<?php echo  ($fetch_product['image']); ?>">
                        <input type="hidden" name="product_name" value="<?php echo  ($fetch_product['name']); ?>">
                        <input type="hidden" name="product_price" value="<?php echo  ($fetch_product['price']); ?>">

                        <div class="flex flex-row items-center gap-4 justify-between mb-8">
                            <h1 class="text-5xl font-semibold"><?php echo  ($fetch_product['name']); ?></h1>
                            
                        </div>

                        <div class="flex flex-row items-center gap-4 mb-8 justify-between">
                            <div class="text-5xl font-semibold text-red-600">LKR <?php echo  ($fetch_product['price']); ?></div>
                            <div class="flex items-center gap-2">
                                <p class="text-2xl font-medium">Availability :</p>
                                <?php if ($fetch_product['qty'] > 0) { ?>
                                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xl font-semibold">In Stock</span>
                                <?php } else { ?>
                                    <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xl font-semibold">Out of Stock</span>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="quantity flex gap-3 items-center mb-8">
                            <p class="text-2xl font-semibold">Quantity :</p>
                            <div class="inline-flex items-center bg-white rounded-xl border-2 border-gray-200 overflow-hidden shadow-sm">
                                <button type="button" class="px-4 py-3 bg-gray-50 hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors font-bold text-lg" onclick="decreaseQuantity()">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" min="1" max="<?php echo  ($fetch_product['qty']); ?>" name="product_quantity" value="1" 
                                       class="w-16 py-3 text-center border-0 focus:ring-0 font-bold text-lg bg-white" 
                                       id="quantityInput" onchange="validateQuantity()">
                                <button type="button" class="px-4 py-3 bg-gray-50 hover:bg-gray-100 text-gray-600 hover:text-gray-800 transition-colors font-bold text-lg" onclick="increaseQuantity()">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex flex-col items-start mb-8">
                            <p class="text-2xl font-semibold mb-2">Product Description : </p>
                            <p class="text-2xl pl-2"><?php echo  ($fetch_product['description']); ?></p>
                        </div>

                        <div class="flex gap-4 mt-8">
                            <?php if ($fetch_product['qty'] > 0) { ?>
                                <button type="submit" name="add_to_cart" class="bg-green-500 text-white px-6 py-3 rounded-lg text-3xl font-semibold shadow-md hover:bg-green-600 transition-all duration-300 flex items-center gap-2">
                                    <i class="fas fa-shopping-cart"></i> Add to Cart
                                </button>
                            <?php } else { ?>
                                <button type="submit" name="add_to_cart" class="bg-red-500 text-white px-6 py-3 rounded-lg text-2xl font-semibold shadow-md cursor-not-allowed" disabled>
                                    <i class="fas fa-shopping-cart"></i> Out of Stock
                                </button>
                            <?php } ?>
                            
                            <!-- <button type="submit" name="buy_now" class="bg-gray-800 text-white px-6 py-3 rounded-lg text-2xl font-semibold shadow-md hover:bg-green-600 transition-all duration-300 flex items-center gap-2">
                                <i class="fas fa-bolt"></i> Buy Now
                            </button> -->
                        </div>
                    </form>
                </div>
            </div>
            <?php
                }
            } else {
                echo '<p class="text-center text-lg text-gray-600">No products added yet!</p>';
            }
            ?>
        </div>
    </main>

    <?php include 'footer.php'; ?>
    <script src="js/script.js"></script>
    <script>
      function increaseQuantity() {
            const input = document.getElementById('quantityInput');
            const currentValue = parseInt(input.value);
            const maxValue = parseInt(input.max);
            if (currentValue < maxValue) {
                input.value = currentValue + 1;
            }
        }

        function decreaseQuantity() {
            const input = document.getElementById('quantityInput');
            const currentValue = parseInt(input.value);
            const minValue = parseInt(input.min);
            if (currentValue > minValue) {
                input.value = currentValue - 1;
            }
        }

        function validateQuantity() {
            const input = document.getElementById('quantityInput');
            const value = parseInt(input.value);
            const min = parseInt(input.min);
            const max = parseInt(input.max);
            
            if (value < min) input.value = min;
            if (value > max) input.value = max;
        }
    </script>
</body>
</html>