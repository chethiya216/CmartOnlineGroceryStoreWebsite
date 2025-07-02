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
            $user_type = 'admin';
            mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass','$user_type')") or die('query failed');
            $message[] = 'registered successfully!';
            header('location:login.php');
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Register | CMart</title>
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
            <h2>Create Admin Account</h2>
            <p>Join us today to manage the store!</p>
        </div>

        <?php if (isset($message)): ?>
            <div class="alert"><?= htmlspecialchars($message[0]) ?><i class="fas fa-times" onclick="this.parentElement.remove();"></i></div>
        <?php endif; ?>

        <form action="" method="post" id="registerForm">
            <div class="form-group">
                <i class="fas fa-user input-icon"></i>
                <input type="text" name="name" id="name" placeholder="Enter your full name" required>
            </div>
            <div class="form-group">
                <i class="fas fa-envelope input-icon"></i>
                <input type="email" name="email" id="email" placeholder="Enter your email address" required>
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
                <button type="submit" name="submit" class="login-btn">Create Account</button>
            </div>
        </form>

        <div class="divider"><span>or</span></div>

        <div class="register-link">
            Already have an admin account? <a href="admin_login.php">Sign In</a>
        </div>
    </div>

    <script>
        document.querySelectorAll('.form-group input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        });

        document.getElementById('cpassword').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            if (confirmPassword && password !== confirmPassword) {
                this.style.borderColor = '#ff6b6b';
            } else {
                this.style.borderColor = '#e1e8ed';
            }
        });

        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const cpassword = document.getElementById('cpassword').value;

            if (!name || !email || !password || !cpassword) {
                e.preventDefault();
                showMessage('Please fill in all required fields');
                return false;
            }

            if (!isValidEmail(email)) {
                e.preventDefault();
                showMessage('Please enter a valid email address');
                return false;
            }

            if (password !== cpassword) {
                e.preventDefault();
                showMessage('Confirm password does not match');
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