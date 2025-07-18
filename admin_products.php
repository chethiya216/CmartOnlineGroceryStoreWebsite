<?php

include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
    header('location:login.php');
};

if (isset($_POST['add_product'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $quantity = $_POST['qty'];
    $description = $_POST['description'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_folder = 'uploaded_img/' . $image;

    $select_product = mysqli_query($conn, query: "SELECT * FROM `products` WHERE name = '$name'") or die('query failed');

    if (mysqli_num_rows($select_product) > 0) {
        $message[] = 'Product name already added';
    } else {
        $add_product_query = mysqli_query($conn, "INSERT INTO `products`(name, price, image, qty, description) VALUES('$name', '$price', '$image','$quantity', '$description')") or die('query failed');

        if ($add_product_query) {
            // if ($image_size > 2048) {
            //     $message[] = 'image size is too large';
            // } else {
                move_uploaded_file($image_tmp_name, $image_folder);
                $message[] = 'Product added successfully!';
            // }
        } else {
            $message[] = 'Product could not be added!';
        }
    }
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_image_query = mysqli_query($conn, "SELECT image FROM `products` WHERE id = '$delete_id'") or die('query failed');
    $fetch_delete_image = mysqli_fetch_assoc($delete_image_query);
    unlink('uploaded_img/' . $fetch_delete_image['image']);
    mysqli_query($conn, "DELETE FROM `products` WHERE id = '$delete_id'") or die('query failed');
    header('location:admin_products.php');
}

if (isset($_POST['update_product'])) {

    $update_p_id = $_POST['update_p_id'];
    $update_name = $_POST['update_name'];
    $update_price = $_POST['update_price'];
    $update_quantity = $_POST['update_quantity'];
    $update_description = $_POST['update_description'];

    mysqli_query($conn, "UPDATE `products` SET name = '$update_name', price = '$update_price', qty = '$update_quantity', description = '$update_description' WHERE id = '$update_p_id'") or die('query failed');

    $update_image = $_FILES['update_image']['name'];
    $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
    $update_description = $_POST['update_description'];
    $update_quantity = $_POST['update_quantity'];
    $update_folder = 'uploaded_img/' . $update_image;
    $update_old_image = $_POST['update_old_image'];

    if (!empty($update_image)) {
        // if ($update_image_size > 2000000) {
        //     $message[] = 'image file size is too large';
        // } else {
            mysqli_query($conn, "UPDATE `products` SET image = '$update_image' WHERE id = '$update_p_id'") or die('query failed');
            move_uploaded_file($update_image_tmp_name, $update_folder);
            unlink('uploaded_img/' . $update_old_image);
        // }
    }

    header('location:admin_products.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Products | CMart</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="css/admin_style.css">

</head>

<body>

    <?php include 'admin_header.php'; ?>

    <!-- product CRUD section starts  -->

    <section class="add-products">

        <h1 class="title">shop products</h1>

        <form action="" method="post" enctype="multipart/form-data">
            <h3>add product</h3>
            <input type="text" name="name" class="box" placeholder="Enter product name" required>
            <input type="number" min="0" name="price" class="box" placeholder="Enter product price" required>
            <input type="file" name="image" accept="image/jpg, image/jpeg, image/png" class="box" required>
            <p id="rec-size">⚠️ Recommended image size 300 x 300 px.</p>
            <input type="text" name="qty" class="box" placeholder="Enter product quantity" required>
            <textarea name="description" class="box" placeholder="Enter product description" required></textarea>
            <input type="submit" value="add product" name="add_product" class="btn">
        </form>

    </section>

    <!-- product CRUD section ends -->

    <!-- show products  -->

    <section class="show-products">

        <div class="box-container">

            <?php
            $select_products = mysqli_query($conn, "SELECT * FROM `products`") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
            ?>
                    <!-- grid view -->
                    <!-- <div class="box">
                        <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="">
                        <div class="name"><?php echo $fetch_products['name']; ?></div>
                        <div class="price">Rs:<?php echo $fetch_products['price']; ?>/-</div>
                        <div class="quantity">Qty:<?php echo $fetch_products['qty']; ?></div>
                        <a href="admin_products.php?update=<?php echo $fetch_products['id']; ?>" class="option-btn">update</a>
                        <a href="admin_products.php?delete=<?php echo $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
                    </div> -->


                    <!-- table view -->
                    <table style="margin-right: auto; display: block;">
                        <thead>
                            <tr class="box">
                                <th class="box" style="font-size: 2rem;">Image</th>
                                <th class="box" style="font-size: 2rem;">Name</th>
                                <th class="box" style="font-size: 2rem;">Price</th>
                                <th class="box" style="font-size: 2rem;">Quantity</th>
                                <th class="box" style="font-size: 2rem;">Description</th>
                                <th style="font-size: 2rem;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
                                echo "<tr class='box' style='background-color: #f2f2f2; border-bottom: 1px solid #ccc; text-align: left;'>";
                                echo '<td style="width: 100px; font-size: 2rem; padding: 10px; text-align: center;"><img src="uploaded_img/' . $fetch_products['image'] . '" alt=""></td>';
                                echo '<td style="padding: 10px; font-size: 2rem;">' . $fetch_products['name'] . '</td>';
                                echo '<td style="padding: 10px; font-size: 2rem;">Rs: ' . $fetch_products['price'] . '/-</td>';
                                echo '<td style="padding: 10px; font-size: 2rem;">' . $fetch_products['qty'] . '</td>';
                                echo '<td style="padding: 10px; font-size: 2rem;">' . $fetch_products['description'] . '</td>';
                                echo '<td style="padding: 10px; text-align: center;">';
                                echo '<a href="admin_products.php?update=' . $fetch_products['id'] . '" class="fa-solid fa-pen-to-square option-btn" style="background-color: #4CAF50; color: white; padding: 10px 10px; margin:5px; text-decoration: none;" title="Edit Product"></a>';
                                echo '<a href="admin_products.php?delete=' . $fetch_products['id'] . '" class="fa-solid fa-trash-can delete-btn" style="background-color: #f44336; color: white; padding: 10px 10px; margin:5px; text-decoration: none;" onclick="return confirm(\'delete this product?\')" title="Delete Product"></a>';
                                echo '</td>';
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>

            <?php
                }
            } else {
                echo '<p class="empty">No products added yet!</p>';
            }
            ?>
        </div>

    </section>

    <section class="edit-product-form">

        <?php
        if (isset($_GET['update'])) {
            $update_id = $_GET['update'];
            $update_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'") or die('query failed');
            if (mysqli_num_rows($update_query) > 0) {
                while ($fetch_update = mysqli_fetch_assoc($update_query)) {
        ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['id']; ?>">
                        <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
                        <img src="uploaded_img/<?php echo $fetch_update['image']; ?>" alt="">
                        <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="Enter product name">
                        <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="Enter product price">
                        <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
                        <input type="text" name="update_quantity" value="<?php echo $fetch_update['qty']; ?>" class="box" required placeholder="Enter product quantity">
                        <textarea name="update_description" class="box" required placeholder="Enter product description"><?php echo $fetch_update['description']; ?></textarea>
                        <input type="submit" value="update" name="update_product" class="btn">
                        <input type="reset" value="cancel" id="close-update" class="delete-btn">
                    </form>
        <?php
                }
            }
        } else {
            echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
        }
        ?>

    </section>

    <!-- custom admin js file link  -->
    <script src="js/admin_script.js"></script>

</body>

</html>
