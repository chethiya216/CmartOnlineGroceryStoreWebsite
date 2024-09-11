<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>orders</title>

    <!-- font awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!--css file-->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>your picks</h3>
        <p> <a href="home.php">home</a> / orders </p>
    </div>

    <section class="placed-orders">

        <h1 class="title">placed orders</h1>

        <div class="box-container">

            <?php
            $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE user_id = '$user_id'") or die('query failed');
            if (mysqli_num_rows($order_query) > 0) {
                while ($fetch_orders = mysqli_fetch_assoc($order_query)) {
            ?>
                    <div class="box">
                        <p> placed on : <span><?php echo $fetch_orders['placed_on']; ?></span> </p>
                        <p> name : <span><?php echo $fetch_orders['name']; ?></span> </p>
                        <p> number : <span><?php echo $fetch_orders['number']; ?></span> </p>
                        <p> email : <span><?php echo $fetch_orders['email']; ?></span> </p>
                        <p> payment method : <span><?php echo $fetch_orders['method']; ?></span> </p>
                        <p> items : <span><?php echo $fetch_orders['total_products']; ?></span> </p>
                        <p> total price : <span>Rs:<?php echo $fetch_orders['total_price']; ?>/-</span> </p>
                        <p> order status : <span style="color:<?php if ($fetch_orders['payment_status'] == 'pending') {
                                                                    echo 'red';
                                                                } else {
                                                                    echo 'green';
                                                                } ?>;"><?php echo $fetch_orders['payment_status']; ?></span> </p>
                    </div>

                    <!-- <table  style="width:100%; border-collapse: collapse; font-size:2rem; justify-content:space between;">
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td style="padding: 12px 15px; text-align: left;">placed on:</td>
                            <td style="padding: 12px 15px; text-align: left;"><span><?php echo $fetch_orders['placed_on']; ?></span></td>
                        </tr>
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td style="padding: 12px 15px; text-align: left;">name:</td>
                            <td style="padding: 12px 15px; text-align: left;"><span><?php echo $fetch_orders['name']; ?></span></td>
                        </tr>
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td style="padding: 12px 15px; text-align: left;">number:</td>
                            <td style="padding: 12px 15px; text-align: left;"><span><?php echo $fetch_orders['number']; ?></span></td>
                        </tr>
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td style="padding: 12px 15px; text-align: left;">email:</td>
                            <td style="padding: 12px 15px; text-align: left;"><span><?php echo $fetch_orders['email']; ?></span></td>
                        </tr>
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td style="padding: 12px 15px; text-align: left;">payment method:</td>
                            <td style="padding: 12px 15px; text-align: left;"><span><?php echo $fetch_orders['method']; ?></span></td>
                        </tr>
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td style="padding: 12px 15px; text-align: left;">items:</td>
                            <td style="padding: 12px 15px; text-align: left;"><span><?php echo $fetch_orders['total_products']; ?></span></td>
                        </tr>
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td style="padding: 12px 15px; text-align: left;">total price:</td>
                            <td style="padding: 12px 15px; text-align: left;"><span>Rs:<?php echo $fetch_orders['total_price']; ?>/-</span></td>
                        </tr>
                        <tr style="border-bottom: 1px solid #ddd;">
                            <td style="padding: 12px 15px; text-align: left;">payment status:</td>
                            <td style="padding: 12px 15px; text-align: left;"><span style="color:<?php if ($fetch_orders['payment_status'] == 'pending') {
                                                                                                        echo 'red';
                                                                                                    } else {
                                                                                                        echo 'green';
                                                                                                    } ?>;"><?php echo $fetch_orders['payment_status']; ?></span></td>
                        </tr>
                    </table> -->

                
            <?php
                    
            }
            } else {
                echo '<p class="empty">no orders placed yet!</p>';
            }
            ?>
        </div>

    </section>

    <?php include 'footer.php'; ?>

    <!-- js file -->
    <script src="js/script.js"></script>

</body>

</html>