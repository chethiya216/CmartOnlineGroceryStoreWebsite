<?php
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
    exit();
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `reviews` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_reviews.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Reviews | CMart</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- admin css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">
</head>

<body>

    <?php include 'admin_header.php'; ?>

    <section class="messages">

        <h1 class="title">Add Reviews</h1>

        <div class="box-container">

            <?php
            //$message_id = $_POST['message_id'];
            $select_message = mysqli_query($conn, "SELECT * FROM `reviews` ") or die('query failed');
            if (mysqli_num_rows($select_message) > 0) {
                while ($fetch_message = mysqli_fetch_assoc($select_message)) {
            ?>
                    <div class="box">
                        <p><?php echo '"' . $fetch_message['r_comment'] . '"'; ?></p>
                        <p> Name: <span><?php echo $fetch_message['r_name']; ?></span> </p>

                        <a href="admin_reviews.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('Delete this review?');" class="delete-btn" style = 'margin-left:7rem;'>Delete Review</a>
                    </div>
            <?php
                }
            } else {
                echo '<p class="empty" style="border:transparent;">You have no reviews!</p>';
            }
            ?>
        </div>

    </section>

    <!-- admin js file link  -->
    <script src="js/admin_script.js"></script>

</body>

</html>