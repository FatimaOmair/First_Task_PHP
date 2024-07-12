<?php
session_start();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn = mysqli_connect('localhost', 'root', '', 'task1');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM `users` WHERE `id`='$id'";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) > 0) {
        $user = mysqli_fetch_assoc($query);


        $deletesql = "DELETE FROM `users` WHERE `id`='$id'";
        if (mysqli_query($conn, $deletesql)) {
            $_SESSION['success'] = "user deleted successfully";
        } else {
            $_SESSION['errors'] = ['Failed to delete admin'];
        }

        header('Location: ../users/allUsers.php');
    } else {
        $_SESSION['errors'] = ['Data not found'];
        header('Location: ../users/allUsers.php');
    }

    mysqli_close($conn);
} else {
    $_SESSION['errors'] = ['Something went wrong'];
    header('Location: ../users/allUsers.php');
}
