<?php

session_start();



if($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    
    $name = strip_tags(trim($name));
    $email = strip_tags(trim($email));
    $password = strip_tags(trim($password));
    $id = intval($_GET['id']); 
   
    
    $errors = [];
   
    if(empty($name)) {
        $errors[] = "Name is required";
    } elseif(! is_string($name)) {
        $errors[] = "Name must be a string";
    } elseif(strlen($name) < 3 || strlen($name) > 50) {
        $errors[] = "Name length must be between 3 and 50";
    }

   
    if(empty($email)) {
        $errors[] = "Email is required";
    } elseif(! is_string($email)) {
        $errors[] = "Email must be a string";
    } elseif(strlen($email) < 3 || strlen($email) > 50) {
        $errors[] = "Email length must be between 3 and 50";
    } elseif(! filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email must be a valid email address";
    }

  
    if(empty($password)) {
        $errors[] = "Password is required";
    } elseif(! is_string($password)) {
        $errors[] = "Password must be a string";
    } elseif(strlen($password) < 8) {
        $errors[] = "Password length must be at least 8";
    } elseif(! preg_match("#[0-9]+#", $password)) {
        $errors[] = "Password must contain at least 1 number";
    } elseif(! preg_match("#[a-z]+#", $password)) {
        $errors[] = "Password must contain at least 1 lowercase letter";
    } elseif(! preg_match("#[A-Z]+#", $password)) {
        $errors[] = "Password must contain at least 1 uppercase letter";
    }


    if(empty($errors)) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $conn = mysqli_connect('localhost', 'root', '', 'task1');

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $sql = "UPDATE `users` SET `name`='$name', `email`='$email' ,`password`='$password' WHERE `id`='$id'";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['success'] = "user updated successfully";
        } else {
            $_SESSION['errors'] = ['Failed to update'];
        }

        header('Location: ../users/allUsers.php');

        
    } else {
        $_SESSION['errors'] = $errors;
        header("location: ../users/allUsers.php");
    }

}