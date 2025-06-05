<?php
include 'config.php';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpass = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

    if (mysqli_num_rows($select_users) > 0) {
        $message[] = 'user already exists!';
    } else {
        if ($pass != $cpass) {
            $message[] = 'confirm password not matched!';
        } else {
            $user_type = 'user';
            mysqli_query($conn, "INSERT INTO `users`(name, email, password, user_type) VALUES('$name', '$email', '$cpass', '$user_type')") or die('query failed');
            $message[] = 'registered successfully!';
            header('location:login.php');
            exit;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | CMart</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        :root {
            --green1: #081c15;
            --green3: #52b788;
            --green4: #74c69d;
            --green5: #d8f3dc;
            --hoverr: #2CA58D;
            --button: #2CA58D;
            --button-hover: #06b90f;
            --purple: #a946d3;
            --red: #c0392b;
            --black: #333;
            --white: #fff;
            --light-color: #666;
            --light-bg: #f5f5f5;
        }

        body {
            font-family: 'Rubik', sans-serif;
            background: linear-gradient(135deg, var(--green4) 0%, var(--green1) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-container {
            background: var(--white);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            width: 100%;
            max-width: 1000px;
            min-height: 600px;
            display: flex;
        }

        .form-section {
            flex: 1;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: var(--white);
        }

        .image-section {
            flex: 1;
            background: linear-gradient(135deg, rgba(82, 183, 136, 0.8), rgba(8, 28, 21, 0.8)),
                        url('https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
            text-align: center;
        }

        .image-content h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .image-content p {
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .form h3 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: var(--black);
            font-weight: 600;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--green3);
            font-size: 1.6rem;
        }

        .box {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: 2px solid var(--light-bg);
            border-radius: 8px;
            font-size: 1.6rem;
            background: var(--white);
            transition: all 0.3s ease;
        }

        .box:focus {
            border-color: var(--green3);
            box-shadow: 0 0 0 3px rgba(82, 183, 136, 0.1);
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--green3);
            font-size: 1.6rem;
        }

        .password-toggle:hover {
            color: var(--hoverr);
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: var(--button);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 1.6rem;
            font-weight: 600;
            cursor: pointer;
            text-transform: uppercase;
            margin-top: 15px;
        }

        .btn:hover {
            background: var(--button-hover);
            box-shadow: 0 10px 25px rgba(82, 183, 136, 0.3);
        }

        .form p {
            font-size: 1.6rem;
            color: var(--light-color);
            margin-top: 15px;
            text-align: center;
        }

        .form p a {
            color: var(--button);
            text-decoration: none;
        }

        .form p a:hover {
            color: var(--button-hover);
            text-decoration: underline;
        }

        .message {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--red);
            color: var(--white);
            padding: 15px 20px;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 1000;
            animation: slideIn 0.5s ease-out;
            max-width: 300px;
        }

        .message.success {
            background: var(--green3);
        }

        .message i.close {
            cursor: pointer;
            font-size: 1.8rem;
        }

        .box.error {
            border-color: var(--red);
            animation: shake 0.5s ease-in-out;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        @media (max-width: 768px) {
            .auth-container {
                flex-direction: column;
                max-width: 400px;
                min-height: auto;
            }
            .image-section {
                order: -1;
                min-height: 200px;
                flex: none;
            }
            .image-content h2 {
                font-size: 1.8rem;
            }
            .form-section {
                padding: 30px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }
            .form-section {
                padding: 20px;
            }
            .message {
                right: 10px;
                left: 10px;
                max-width: none;
            }
        }
    </style>
</head>
<body>
    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '
            <div class="message ' . (strpos($msg, 'successfully') !== false ? 'success' : '') . '">
                <i class="fas fa-' . (strpos($msg, 'successfully') !== false ? 'check-circle' : 'exclamation-circle') . '"></i>
                <span>' . htmlspecialchars($msg) . '</span>
                <i class="fas fa-times close" onclick="this.parentElement.remove();"></i>
            </div>
            ';
        }
    }
    ?>

    <div class="auth-container">
        <div class="form-section">
            <form action="" method="post" class="form">
                <h3>Register Now</h3>
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" placeholder="Enter your name" required class="box form-control">
                </div>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Enter your email" required class="box form-control">
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Enter your password" required class="box form-control" id="registerPassword">
                    <i class="fas fa-eye password-toggle" onclick="togglePassword('registerPassword', this)"></i>
                </div>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="cpassword" placeholder="Confirm your password" required class="box form-control" id="confirmPassword">
                    <i class="fas fa-eye password-toggle" onclick="togglePassword('confirmPassword', this)"></i>
                </div>
                <input type="submit" name="submit" value="Register Now" class="btn">
                <p>Already have an account? <a href="login.php">Login Now</a></p>
            </form>
        </div>
        <div class="image-section">
            <div class="image-content">
                <h2>Join CMart</h2>
                <p>Create your account today and unlock exclusive deals and a seamless shopping experience.</p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, icon) {
            const passwordInput = document.getElementById(inputId);
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.box');
            const form = document.querySelector('.form');

            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                input.addEventListener('blur', function() {
                    if (this.value === '') {
                        this.parentElement.classList.remove('focused');
                    }
                    validateInput(this);
                });
                input.addEventListener('input', function() {
                    validateInput(this);
                });
            });

            form.addEventListener('submit', function(e) {
                const formInputs = this.querySelectorAll('.box');
                let isValid = true;

                formInputs.forEach(input => {
                    if (!validateInput(input)) {
                        isValid = false;
                    }
                });

                const password = document.querySelector('input[name="password"]').value;
                const confirmPassword = document.querySelector('input[name="cpassword"]').value;
                if (password !== confirmPassword) {
                    const confirmInput = document.querySelector('input[name="cpassword"]');
                    confirmInput.classList.add('error');
                    showMessage('Passwords do not match!', 'error');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                }
            });

            const messages = document.querySelectorAll('.message');
            messages.forEach(message => {
                setTimeout(() => {
                    if (message.parentElement) {
                        message.style.animation = 'slideIn 0.5s ease-out reverse';
                        setTimeout(() => {
                            message.remove();
                        }, 500);
                    }
                }, 1000);
            });
        });

        function validateInput(input) {
            const value = input.value.trim();
            if (input.type === 'email') {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    input.classList.add('error');
                    return false;
                }
            } else if (input.type === 'password') {
                if (value.length < 6) {
                    input.classList.add('error');
                    return false;
                }
            } else if (input.name === 'name') {
                if (value.length < 2) {
                    input.classList.add('error');
                    return false;
                }
            }
            if (value === '') {
                input.classList.add('error');
                return false;
            }
            input.classList.remove('error');
            return true;
        }

        function showMessage(text, type = 'info') {
            const message = document.createElement('div');
            message.className = `message ${type === 'success' ? 'success' : ''}`;
            message.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
                <span>${text}</span>
                <i class="fas fa-times close" onclick="this.parentElement.remove();"></i>
            `;
            document.body.appendChild(message);
            setTimeout(() => {
                if (message.parentElement) {
                    message.style.animation = 'slideIn 0.5s ease-out reverse';
                    setTimeout(() => {
                        message.remove();
                    }, 500);
                }
            }, 5000);
        }
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>