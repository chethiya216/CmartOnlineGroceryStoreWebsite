<?php

include 'config.php';

if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $message[] = 'user already exist!';
    } else {
        if ($pass != $cpass) {
            $message[] = 'confirm password not matched!';
        } else {
            $user_type = 'user';
            mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query failed');
            $message[] = 'registered successfully!';
            header('Location:login.php');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | CMart</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('images/background.png') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-size: larger;
        }
    </style>
</head>

<body background="images/background.png">
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

    <div class="login-container">
        <div class="login-header">
            <p class="header-title">
                <i class="fas fa-shopping-cart"></i>
                CMart
            </p>
            <p>Create Your Account</p>
            <p>Join us today and start shopping!</p>
        </div>

        <form action="" method="post">
            <div class="form-group">
                <i class="fas fa-user input-icon"></i>
                <input type="text" name="name" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" name="email" placeholder="Enter your email address" required>
            </div>

            <div class="form-group">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" name="password" id="password" placeholder="Create a password" required>
                <i class="fas fa-eye password-toggle" onclick="togglePassword('password', this)"></i>
            </div>

            <div class="form-group">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" name="cpassword" id="cpassword" placeholder="Confirm your password" required>
                <i class="fas fa-eye password-toggle" onclick="togglePassword('cpassword', this)"></i>
            </div>

            <div class="register-button-wrapper">
                <!-- <input type="submit" name="submit" value="Create Account" class="login-btn"> -->
                <button type="submit" name="submit" class="login-btn">Create Account</button>
            </div>

            <div class="divider"><span>or</span></div>

            <div class="register-link">
                Already have an account? <a href="login.php">Sign In</a>
            </div>
        </form>
    </div>

    <script>

        // Add smooth focus transitions
        document.querySelectorAll('.form-group input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });

        // Password confirmation validation
        document.getElementById('cpassword').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            
            if (confirmPassword && password !== confirmPassword) {
                this.style.borderColor = '#ff6b6b';
            } else {
                this.style.borderColor = '#e1e8ed';
            }
        });
    </script>
    <script src="js/script.js"></script>
</body>

</html>