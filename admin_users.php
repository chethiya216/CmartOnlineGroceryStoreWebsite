<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_users.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Users | CMart</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!--   admin css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">

    <style>

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            .header h1 {
                font-size: 2rem;
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .stats {
                justify-content: center;
                gap: 1rem;
            }
            
            .stat-item {
                font-size: 0.9rem;
            }
            
            table {
                font-size: 0.9rem;
            }
            
            th, td {
                padding: 1rem;
            }
            
            .user-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
        }

        @media (max-width: 480px) {
            th, td {
                padding: 0.8rem 0.5rem;
            }
            
            .delete-btn {
                padding: 0.5rem 0.8rem;
                font-size: 0.8rem;
            }
        }
    </style>

</head>

<body>

    <?php include 'admin_header.php'; ?>

    <section class="users">

        <h1 class="title"> user accounts </h1>

        <div class="box-container">
            <div class="container">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>User Type</th>
                                <th style="text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $fetch_users = mysqli_query($conn, "SELECT * FROM users") or die('query failed');
                            while ($user = mysqli_fetch_assoc($fetch_users)) {
                            ?>
                                <tr>
                                    <td>
                                        <div class="user-id"><?php echo $user['id']; ?></div>
                                    </td>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-name"><?php echo $user['name']; ?></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-email">
                                            <?php echo $user['email']; ?></div>
                                    </td>
                                    <td>
                                        <span class="user-type <?php echo $user['user_type']; ?>">
                                            <i class="fas fa-<?php echo $user['user_type'] == 'admin' ? 'shield-alt' : 'user'; ?>"></i>
                                            <?php echo $user['user_type']; ?>
                                        </span>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="admin_users.php?delete=<?php echo $user['id']; ?>" 
                                        onclick="return confirm('Are you sure you want to delete this user?');" 
                                        class="user-delete-btn">
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php
            // };
            ?>
        </div>

    </section>

    <!--   admin js file link  -->
    <script src="js/admin_script.js"></script>

</body>

</html>