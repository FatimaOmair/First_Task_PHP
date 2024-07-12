<?php
session_start();

$conn = mysqli_connect('localhost', 'root', '', 'task1');
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);
    $email = strip_tags(trim($email));
    $password = strip_tags(trim($password));

    $errors = [];
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
    }


    if(empty($errors)) {
        $sql ="SELECT * FROM `users` WHERE `email` = '$email'";
        $query = mysqli_query($conn, $sql);
        if(mysqli_num_rows($query)){
            $user = mysqli_fetch_assoc($query);
            $userPassword = $user['password'];
            if( password_verify($password , $userPassword) ){
                $_SESSION['user_id'] = $user['id'];
                header("location: ../users/choices.php");
            }else{
                $_SESSION['errors'] = ['Email or password is incorrect'];
                header("location: ../auth/login.php");
            }

        }else{
            $_SESSION['errors'] = ['Email or password is incorrect'];
        header("location: ../auth/login.php");

        }

    } else {
        $_SESSION['errors'] = $errors;
        header("location: ../auth/login.php");
    }
} 