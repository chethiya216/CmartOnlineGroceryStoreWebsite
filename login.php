<?php

include 'config.php';
session_start();

if (isset($_POST['submit'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {

        $row = mysqli_fetch_assoc($select_users);

        if ($row['user_type'] == 'admin') {

            $_SESSION['admin_name'] = $row['name'];
            $_SESSION['admin_email'] = $row['email'];
            $_SESSION['admin_id'] = $row['id'];
            header('location:admin_page.php');
        } elseif ($row['user_type'] == 'user') {

            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');
        }
    } else {
        $message[] = 'incorrect email or password!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | CMart</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!--   css file link  -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        .input-group {
            position: relative;
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #777;
            font-size: 1.8rem;
        }
    </style>
</head>

<body style="background-image: url(images/background.png);">

    <?php
    if (isset($message)) {
        foreach ($message as $message) {
            echo '
      <div class="message">
         <span>' . $message . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
        }
    }
    ?>

    <div class="form-container">

        <!-- <form action="" method="post">
            <h3>Login now</h3>
            <input type="email" name="email" placeholder="Enter your email" required class="box">
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="passwordField" placeholder="Enter your password" required class="box">
                <i class="fas fa-eye password-toggle" id="togglePassword"></i>
            </div>
            <input type="submit" name="submit" value="login now" class="btn">
            <p>Don't have an account? <a href="register.php">Register Now</a></p>
        </form> -->
        <form action="" method="post" class="form">
                <h3>Login Now</h3>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Enter your email" required class="box form-control">
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Enter your password" required class="box form-control" id="loginPassword">
                    <i class="fas fa-eye password-toggle" onclick="togglePassword('loginPassword', this)"></i>
                </div>
                <input type="submit" name="submit" value="Login Now" class="btn">
                <p>Don't have an account? <a href="register.php">Register Now</a></p>
            </form>

    </div>
    <script>
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('passwordField');
        
        togglePassword.addEventListener('click', function() {
            // Toggle the password field type
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            
            // Toggle the eye icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>