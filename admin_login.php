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

            $message[] = 'Only admins can login!';
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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login | CMart</title>
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
            font-family: 'Roboto', sans-serif;
        }
        
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <p class="header-title"><i class="fas fa-shopping-cart"></i>CMart</p>
            <h2>Admin Sign In</h2>
            <p>Welcome back! Please log in to manage the store.</p>
        </div>

        <?php if (isset($message)): ?>
            <div class="alert"><?= htmlspecialchars($message[0]) ?><i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>
        <?php endif; ?>

        <form action="" method="post" id="loginForm">
            <div class="form-group">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" name="email" id="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <i class="fas fa-lock input-icon"></i>
                <input type="password" name="password" id="password" placeholder="Enter your password" required>
                <i class="fas fa-eye password-toggle" onclick="togglePassword('password', this)"></i>
            </div>
            <div class="forgot-password">
                <a href="admin-password-reset.php">Forgot Password?</a>
            </div>
            <div class="button-wrapper">
                <button type="submit" name="submit" class="login-btn">Sign In</button>
            </div>
        </form>

        <div class="divider"><span>or</span></div>

        <div class="register-link">
            Don't have an admin account? <a href="admin_register.php">Create Account</a>
        </div>
    </div>

    <script>

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            if (!email || !password) {
                e.preventDefault();
                showMessage('Please fill in all required fields');
                return false;
            }

            if (!isValidEmail(email)) {
                e.preventDefault();
                showMessage('Please enter a valid email address');
                return false;
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => alert.remove());
            }, 5000);
        });
    </script>
    <script src="js/admin_script.js"></script>
</body>
</html>