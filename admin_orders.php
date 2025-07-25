<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_POST['update_order'])) {

    $order_update_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $update_payment = isset($_POST['update_payment']) ? mysqli_real_escape_string($conn, $_POST['update_payment']) : '';

    $query = "UPDATE `orders` SET payment_status = '$update_payment' WHERE id = '$order_update_id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Query failed: ' . mysqli_error($conn));
    }

    $message[] = 'Payment status has been updated!';
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `orders` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders | CMart</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!--   admin css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

    <?php include 'admin_header.php'; ?>

    <section class="orders">

        <h1 class="title">placed orders</h1>

        <div class="box-container">
            <?php
            $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('query failed');
            if (mysqli_num_rows($select_orders) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
            ?>

                    <div class="box">
                        <p> User Id : <span><?php echo $fetch_orders['user_id']; ?></span> </p>
                        <p> Placed on : <span> <?php echo $fetch_orders['placed_on']; ?></span> </p>
                        <p> Name : <span><?php echo $fetch_orders['name']; ?></span> </p>
                        <p> Number : <span><?php echo $fetch_orders['number']; ?></span> </p>
                        <p> Email : <span><?php echo $fetch_orders['email']; ?></span> </p>
                        <p> Total products : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
                        <p> Total price : <span>Rs:<?php echo $fetch_orders['total_price']; ?>/-</span> </p>
                        <p> Payment method : <span><?php echo $fetch_orders['method']; ?></span> </p>
                        <form action="" method="post">
                            <input type="hidden" name="order_id" value="<?php echo $fetch_orders['id']; ?>">
                            <select name="update_payment">
                                <option value="" selected disabled><?php echo $fetch_orders['payment_status']; ?></option>
                                <option value="Pending">Pending</option>
                                <option value="Completed">Will arrive soon</option>
                            </select>
                            <input type="submit" value="update" name="update_order" class="option-btn">
                            <a href="admin_orders.php?delete=<?php echo $fetch_orders['id']; ?>" onclick="return confirm('delete this order?');" class="delete-btn">Delete</a>
                        </form>
                    </div>


            <?php
                }
            } else {
                echo '<p class="empty">No orders placed yet!</p>';
            }
            ?>
        </div>

    </section>



    <!--   admin js file link  -->
    <script src="js/admin_script.js"></script>

</body>

</html>

<!-- fumino satsuki  -->