<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'task1');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $name = strip_tags(trim($_POST['name']));
    $description = strip_tags(trim($_POST['description']));
    $id = intval($_GET['id']);
    
    $sql = "SELECT * FROM `products` WHERE `id` = '$id'";
    $query = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($query);
    $oldImage = $product['image'];

    $errors = [];

    if (empty($name)) {
        $errors[] = "Name is required";
    } elseif (!is_string($name)) {
        $errors[] = "Name must be a string";
    } elseif (strlen($name) < 3 || strlen($name) > 50) {
        $errors[] = "Name must be between 3 and 50 characters";
    }

    if (empty($description)) {
        $errors[] = "Description is required";
    } elseif (!is_string($description)) {
        $errors[] = "Description must be a string";
    } elseif (strlen($description) < 3 || strlen($description) > 255) {
        $errors[] = "Description must be between 3 and 255 characters";
    }

    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_type = $_FILES['image']['type'];
        $image_size = $_FILES['image']['size'];

        $allowed_extensions = ['jpg', 'png', 'jpeg', 'webp'];
        $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
        $newName = uniqid() . 'product' . '.' . $image_extension;

        if (!in_array($image_extension, $allowed_extensions)) {
            $errors[] = "Image must be jpg, png, jpeg or webp";
        } elseif ($image_size > 5 * 1024 * 1024) {
            $errors[] = "Image size must be less than 5MB";
        }
    } else {
        $newName = $oldImage;
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: ../products/allProducts.php');
        exit();
    } else {
        $sql = "UPDATE `products` SET `name`='$name', `description`='$description', `image`='$newName' WHERE `id`='$id'";

        if (mysqli_query($conn, $sql)) {
            if (!empty($_FILES['image']['name'])) {
                move_uploaded_file($image_tmp, "../assets/img/uploads/$newName");
                if ($oldImage && $oldImage != $newName && file_exists("../assets/img/uploads/" . $oldImage)) {
                    unlink("../assets/img/uploads/" . $oldImage);
                }
            }
            $_SESSION['success'] = "Product updated successfully";
            header('Location: ../products/allProducts.php');
            exit();
        } else {
            $errors[] = "Error: " . $sql . "<br>" . mysqli_error($conn);
            $_SESSION['errors'] = $errors;
            header('Location: ../products/allProducts.php');
            exit();
        }
    }
}
?>
