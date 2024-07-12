<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    extract($_POST);
    $name = strip_tags(trim($name));
    $description = strip_tags(trim($description));
    $price = floatval($price);
    $user_id = $_SESSION['user_id']; 

    $errors = [];

   
    if (empty($name)) {
        $errors[] = "Product name is required";
    } elseif (!is_string($name)) {
        $errors[] = "Product name must be a string";
    } elseif (strlen($name) < 3 || strlen($name) > 50) {
        $errors[] = "Product name must be between 3 and 50 characters";
    }

   
    if (empty($description)) {
        $errors[] = "Description is required";
    } elseif (!is_string($description)) {
        $errors[] = "Description must be a string";
    } elseif (strlen($description) < 10 || strlen($description) > 500) {
        $errors[] = "Description must be between 10 and 500 characters";
    }

    
    if (empty($price)) {
        $errors[] = "Price is required";
    } elseif (!is_numeric($price) || $price <= 0) {
        $errors[] = "Price must be a positive number";
    }

    $newName = null;
    if ($_FILES['image']['name']) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_type = $_FILES['image']['type'];
        $image_size = $_FILES['image']['size'];

        $allowed_extensions = ['jpg', 'png', 'jpeg', 'webp'];
        $image_extension = pathinfo($image_name, PATHINFO_EXTENSION);
        $newName = uniqid() . $name . '.' . $image_extension;
        if (!in_array($image_extension, $allowed_extensions)) {
            $errors[] = "Image must be jpg, png, jpeg or webp";
        } elseif ($image_size > 5 * 1024 * 1024) {
            $errors[] = "Image size must be less than 5MB";
        }
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: ../products/createProduct.php');
        exit();
    } else {
        $conn = mysqli_connect('localhost', 'root', '', 'task1');

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "INSERT INTO `products` (`user_id`, `name`, `description`, `price`, `image`) 
                VALUES ('$user_id', '$name', '$description', '$price', '$newName')";

        if (mysqli_query($conn, $sql)) {
            if ($_FILES['image']['name']) {
                move_uploaded_file($image_tmp, "../assets/img/uploads/$newName");
            }
            $_SESSION['success'] = "Product added successfully";
            header('Location: ../products/allProducts.php');
            exit();
        } else {
            $errors[] = "Error: " . $sql . "<br>" . mysqli_error($conn);
            $_SESSION['errors'] = $errors;
            header('Location: ../products/createProduct.php');
            exit();
        }
    }
}
