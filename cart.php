<?php

global $conn;
include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

if (isset($_POST['update_cart'])) {
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
    $message[] = 'cart quantity updated!';
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
    header('location:cart.php');
}

if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    header('location:cart.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart | CMart</title>

    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- Custom CSS file -->
    <link rel="stylesheet" href="css/style.css">

    <style>
        .table-container { max-width: 100%; overflow-x: auto; }
        table { border-collapse: separate; border-spacing: 0; }
        th, td { border: 1px solid #d1d5db; }
        thead th { border-bottom: 2px solid #9ca3af; }
        tbody tr:last-child td { border-bottom: 1px solid #d1d5db; }
        .quantity-input { width: 4rem; text-align: center; }
        .delete-btn:hover { color: #ef4444; }
        @media (max-width: 640px) {
            th, td { font-size: 0.75rem; padding: 0.5rem; }
            .quantity-input { width: 3rem; }
        }
    </style>
</head>
<body>
<?php include 'header.php'; ?>

<div class="w-lg">
    <div class="heading">
        <h3 class="text-2xl font-bold text-gray-800 mb-6">Shopping Cart</h3>
        <p><a href="home.php">Home</a> / Cart</p>
    </div>

    <section class="shopping-cart">
        <div class="table-container bg-white shadow-md rounded-lg">
            <?php
            $grand_total = 0;
            $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
            if (mysqli_num_rows($select_cart) > 0) {
                ?>
                <table role="grid" aria-labelledby="cart-table" class="w-full px-8 py-6">
                    <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider text-2xl">Image</th>
                        <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider text-2xl">Item Name</th>
                        <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider text-2xl">Price</th>
                        <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider text-2xl">Quantity</th>
                        <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider text-2xl">Subtotal</th>
                        <th class="py-4 px-6 text-left text-sm font-semibold text-gray-700 uppercase tracking-wider text-2xl">Action</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    <?php while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                        $sub_total = $fetch_cart['quantity'] * $fetch_cart['price'];
                        $grand_total += $sub_total;
                        ?>
                        <tr class="hover:bg-gray-50 text-lg text-gray-800">
                            <td class="py-3 px-4 text-center justify-center">
                                <img src="uploaded_img/<?php echo htmlspecialchars($fetch_cart['image']); ?>" alt="<?php echo htmlspecialchars($fetch_cart['name']); ?>" class="w-20 h-auto border-none justify-center rounded text-center items-center">
                            </td>
                            <td class="py-3 px-4 text-2xl"><?php echo htmlspecialchars($fetch_cart['name']); ?></td>
                            <td class="py-3 px-4 text-2xl">Rs: <?php echo htmlspecialchars($fetch_cart['price']); ?>/-</td>
                            <td class="py-3 px-4 text-2xl">
                                <input type="number" min="1" value="<?php echo htmlspecialchars($fetch_cart['quantity']); ?>"
                                       class="quantity-input border border-gray-300 rounded px-2 py-1 text-2xl bg-gray-200 w-full"
                                       data-cart-id="<?php echo $fetch_cart['id']; ?>">
                            </td>
                            <td class="py-3 px-4 text-2xl text-red">Rs: <?php echo htmlspecialchars($sub_total); ?>/-</td>
                            <td class="py-3 px-4">
                                <a href="cart.php?delete=<?php echo $fetch_cart['id']; ?>"
                                   class=" bg-red-500 text-white text-xl px-5 py-3 rounded hover:bg-red-600"
                                   onclick="return confirm('Delete this from cart?');"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <p class="text-center text-gray-600 py-6 border border-gray-300 rounded-lg text-xl">Your cart is empty!</p>
            <?php } ?>
        </div>

        <div class="flex justify-center mt-6">
            <a href="cart.php?delete_all"
               class="delete-btn bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 <?php echo ($grand_total > 0) ? '' : 'opacity-50 cursor-not-allowed'; ?>"
               onclick="return confirm('Delete all from cart?');">Delete All</a>
        </div>

        <div class="cart-total mt-6 text-center">
            <p class="text-xl font-semibold">Grand Total: <span>Rs: <?php echo htmlspecialchars($grand_total); ?>/-</span></p>
            <div class="flex justify-center gap-4 mt-4">
                <a href="shop.php" class="option-btn bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Continue Shopping</a>
                <a href="checkout.php"
                   class="btn bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 <?php echo ($grand_total > 0) ? '' : 'opacity-50 cursor-not-allowed'; ?>">Proceed to Checkout</a>
            </div>
        </div>
    </section>
</div>

<?php include 'footer.php'; ?>

<!-- Custom JS file -->
<script src="js/script.js"></script>
<script>
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const cartId = this.dataset.cartId;
            const quantity = parseInt(this.value);

            if (quantity < 1) {
                this.value = 1;
                alert('Quantity must be at least 1');
                return;
            }

            fetch('cart.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `update_cart=true&cart_id=${cartId}&cart_quantity=${quantity}`
            })
                .then(response => response.text())
                .then(() => {
                    // Update subtotal and grand total
                    const row = this.closest('tr');
                    const price = parseFloat(row.children[2].textContent.replace('Rs: ', '').replace('/-', ''));
                    const subtotal = (price * quantity).toFixed(2);
                    row.children[4].textContent = `Rs: ${subtotal}/-`;

                    // Recalculate grand total
                    let grandTotal = 0;
                    document.querySelectorAll('tbody tr').forEach(row => {
                        const sub = parseFloat(row.children[4].textContent.replace('Rs: ', '').replace('/-', ''));
                        grandTotal += sub;
                    });
                    document.querySelector('.cart-total span').textContent = `Rs: ${grandTotal.toFixed(2)}/-`;

                    // Update button states
                    const deleteAllBtn = document.querySelector('.delete-btn');
                    const checkoutBtn = document.querySelector('.btn');
                    if (grandTotal > 0) {
                        deleteAllBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                        checkoutBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    } else {
                        deleteAllBtn.classList.add('opacity-50', 'cursor-not-allowed');
                        checkoutBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to update quantity');
                    this.value = 1; // Reset to valid value on error
                });
        });
    });
</script>
</body>
</html>