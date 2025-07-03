<?php

include 'config.php';

session_start();

// $user_id = $_SESSION['user_id'];
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// if (!isset($user_id)) {
//     header('location:login.php');
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders | CMart</title>

    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!--css file-->
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        .status-pending { color: #ef4444; }
        .status-completed { color: #10b981; }
        .table-container { max-width: 100%; overflow-x: auto; }
        table { border-collapse: separate; border-spacing: 0; }
        th, td { border: 1px solid #d1d5db; } /* Tailwind's gray-300 */
        thead th { border-bottom: 2px solid #9ca3af; } /* Tailwind's gray-400 for header */
        tbody tr:last-child td { border-bottom: 1px solid #d1d5db; } /* Ensure last row has bottom border */
        @media (max-width: 640px) {
            th, td { font-size: 0.75rem; padding: 0.5rem; }
        }
    </style>

</head>

<body>

    <?php include 'header.php'; ?>

    <div class="w-full">
        <div class="heading">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Your Orders</h3>
            <p> <a href="home.php">Home</a> / Orders </p>
        </div>

        <section class="placed-orders">
            <div class="table-container bg-white shadow-md rounded-lg">
                <?php
                $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
                if (mysqli_num_rows($order_query) > 0) {
                ?>
                    <table role="grid" aria-labelledby="orders-table" class="w-full px-8 py-6 ">
                        <thead>
                            <tr class="bg-gray-200 text-gray-700 text-2xl">
                                <th class="py-3 px-4 text-left">Placed On</th>
                                <th class="py-3 px-4 text-left">Name</th>
                                <th class="py-3 px-4 text-left">Phone Number</th>
                                <th class="py-3 px-4 text-left">Email</th>
                                <th class="py-3 px-4 text-left">Payment Method</th>
                                <th class="py-3 px-4 text-left">Items</th>
                                <th class="py-3 px-4 text-left">Total Price</th>
                                <th class="py-3 px-4 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($fetch_orders = mysqli_fetch_assoc($order_query)) { ?>
                                <tr class="hover:bg-gray-50 text-2xl text-green-800">
                                    <td class="py-3 px-4"><?php echo htmlspecialchars($fetch_orders['placed_on']); ?></td>
                                    <td class="py-3 px-4"><?php echo htmlspecialchars($fetch_orders['name']); ?></td>
                                    <td class="py-3 px-4"><?php echo htmlspecialchars($fetch_orders['number']); ?></td>
                                    <td class="py-3 px-4"><?php echo htmlspecialchars($fetch_orders['email']); ?></td>
                                    <td class="py-3 px-4"><?php echo htmlspecialchars($fetch_orders['method']); ?></td>
                                    <td class="py-3 px-4"><?php echo htmlspecialchars($fetch_orders['total_products']); ?></td>
                                    <td class="py-3 px-4">Rs: <?php echo htmlspecialchars($fetch_orders['total_price']); ?>/-</td>
                                    <td class="py-3 px-4">
                                        <span class="<?php echo $fetch_orders['payment_status'] == 'pending' ? 'status-pending' : 'status-completed'; ?>">
                                            <?php echo htmlspecialchars($fetch_orders['payment_status']); ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php
                } else {
                    echo '<p class="text-center text-gray-600 py-6 border border-gray-300 rounded-lg text-3xl">No orders placed yet!</p>';
                }
                // $stmt->close();
                ?>
            </div>
        </section>
    </div>

    <?php include 'footer.php'; ?>

    <!-- js file -->
    <script src="js/script.js"></script>

</body>

</html>