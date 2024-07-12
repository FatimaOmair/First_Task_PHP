<?php

session_start();



if($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    
    $name = strip_tags(trim($name));
    $email = strip_tags(trim($email));
    $password = strip_tags(trim($password));

   
    
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
        $connection = mysqli_connect('localhost', 'root', '', 'task1');
        $sql = "INSERT into `users` (`name`, `email`, `password`) VALUES
         ('$name', '$email', '$password')";
        if(mysqli_query($connection, $sql)) {
            
            $_SESSION['user_id'] = mysqli_insert_id($connection);
            header("location: ../auth/login.php");
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    } else {
        $_SESSION['errors'] = $errors;
        header("location: ../auth/register.php");
    }

}