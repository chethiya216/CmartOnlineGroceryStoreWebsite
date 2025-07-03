<?php

include 'config.php';
session_start();

if (isset($_POST['submit'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));

    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');



    if (mysqli_num_rows($select_users) > 0) {
        $row = mysqli_fetch_assoc($select_users);
        // Update the password
        $update_password = mysqli_query($conn, "UPDATE `users` SET password = '$pass' WHERE email = '$email'") or die('query failed');
        if ($update_password) {
            $message[] = 'Password updated successfully!';
            header('location:login.php');
        } else {
            $message[] = 'Failed to update password!';
        }
    } else {
        $message[] = 'Email not found!';
    }

}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password | CMart</title>
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

<body>

    <div class="login-container">
        <div class="login-header">
            <p class="header-title"><i class="fas fa-shopping-cart"></i>CMart</p>
            <h2>Reset Password</h2>
            <p>Enter email assigned to your account to reset your password.</p>
        </div>

        <?php if (isset($message)): ?>
            <div class="alert"><?= $message[0] ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="form-group">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" name="password" id="password" placeholder="Enter new password" required>
                <i class="fas fa-eye password-toggle" onclick="togglePassword(this)"></i>
            </div>
            <div class="button-wrapper">
                <button type="submit" name="submit" class="login-btn">Update Password</button>
            </div>
        </form>

        <div class="divider"><span>or</span></div>

        <div class="register-link">
            Want to create an account? <a href="register.php">Create Account</a>
        </div>
    </div>
    <script>
        document.getElementById('loginForm')
            .addEventListener('submit', function(e) {
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;

                if (!email || !password) {
                    e.preventDefault();
                    showMessage('Please fill in all required fields');
                    resetLoginButton();
                    return false;
                }

                if (!isValidEmail(email)) {
                    e.preventDefault();
                    showMessage('Please enter a valid email address');
                    resetLoginButton();
                    return false;
                }
            }
            );
            
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                bsAlert.close();
            });
        }, 5000);
        });
    </script>
    <script src="js/script.js"></script>
</body>

</html>