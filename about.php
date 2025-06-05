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
    <title>About</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- css file link  -->
    <link rel="stylesheet" href="css/style.css">

</head>

<body>

    <?php include 'header.php'; ?>

    <div class="heading">
        <h3>What We Do..</h3>
        <p> <a href="home.php">Home</a> / About </p>
    </div>

    <section class="about">

        <div class="flex">

            <div class="content">
                <h3>why choose us?</h3>
                <p>Choose us for fresh, local produce, exceptional customer service, competitive prices, a wide product selection, and convenient shopping options, including in-store, curbside pickup, and home delivery services. <br> Experience the best in grocery shopping with our fresh produce, excellent customer service, competitive pricing, vast selection, and convenient options like in-store, curbside pickup, and home delivery. Quality and value guaranteed.</p>
                <a href="contact.php" class="btn">contact us</a>
            </div>

        </div>

        <section class="about">

            <div class="flex">

                <div class="image">
                    <img src="" alt="">
                </div>

                <div class="content">
                    <h3>about us</h3>
                    <p>At our grocery store, we are dedicated to providing the freshest produce, exceptional customer service, and unbeatable prices. We offer a wide range of products to meet all your needs, sourced locally whenever possible. <br> Our convenient shopping options include in-store, curbside pickup, and home delivery. Shop with us for quality, value, and a seamless shopping experience.</p>
                </div>

            </div>

        </section>

    </section>

    <section class="reviews">

        <h1 class="title">what our clients say</h1>

        <div class="box-container">

            <div class="box-container">
                <?php
                $select_message = mysqli_query($conn, "SELECT * FROM `reviews`") or die('query failed');
                if (mysqli_num_rows($select_message) > 0) {
                    while ($fetch_message = mysqli_fetch_assoc($select_message)) {

                ?>
                        <div class="box">
                            <p><?php echo '"' . $fetch_message['r_comment'] . '"'; ?></p>
                            <h3> <span><?php echo $fetch_message['r_name']; ?></span> </h3>
                        
                        </div>

                <?php
                    };
                } else {
                    echo '<p class="empty">you have no messages!</p>';
                }
                ?>

                <p></p>
            </div>

        </div>

    </section>

    <?php include 'footer.php'; ?>

    <!-- js file link  -->
    <script src="js/script.js"></script>

</body>

</html>