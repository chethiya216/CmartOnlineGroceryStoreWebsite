<?php
    include 'config.php';
    session_start();
    $admin_id = $_SESSION['admin_id'];
    if (!isset($admin_id)) {
        header('location:login.php');
    };
    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die('query failed');
        header('location:admin_contacts.php');
    }

    if (isset($_POST['submit'])) {
        $message_id = $_POST['message_id'];
        $currentDate = date('Y-m-d');
        $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE id = '$message_id'") or die('query failed');
        if (mysqli_num_rows($select_message) > 0) {
            $fetch_message = mysqli_fetch_assoc($select_message);
            $reviewName = $fetch_message['name'];
            $reviewMessage = $fetch_message['message'];
            $queryReviews = "INSERT INTO reviews (message_id, r_date, r_name, r_comment) VALUES ('$message_id','$currentDate', '$reviewName', '$reviewMessage')";
            mysqli_query($conn, $queryReviews) or die('query failed');
            header('location:admin_reviews.php');
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>messages</title>
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- admin css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">
</head>

<body>
    <?php include 'admin_header.php'; ?>
    <section class="messages">
        <h1 class="title">messages</h1>
        <div class="box-container">
            <?php
            $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
            if (mysqli_num_rows($select_message) > 0) {
                while ($fetch_message = mysqli_fetch_assoc($select_message)) {
            ?>
                    <div class="box">
                        <form action="" method="POST">
                            <input type="hidden" name="message_id" value="<?php echo $fetch_message['id']; ?>">
                            <p><?php echo '"' . $fetch_message['message'] . '"'; ?></p>
                            <p>name : <span><?php echo $fetch_message['name']; ?></span> </p>
                            <input type="submit" name="submit" value="add as review" class="delete-btn" style="margin-left: 7rem; margin-bottom:10px; background:green;">
                            <a href=" admin_contacts.php?delete=<?php echo $fetch_message['id']; ?>" onclick="return confirm('delete this message?');" class="delete-btn" style="margin-left: 6.5rem;">delete message</a>
                        </form>
                    </div>


            <?php
                }
            } else {
                echo '<p class="empty" style="border:transparent;">you have no messages!</p>';
            }
            ?>
        </div>
    </section>
    <!-- admin js file link -->
    <script src="js/admin_script.js"></script>
</body>

</html>