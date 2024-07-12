<?php
session_start();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn = mysqli_connect('localhost', 'root', '', 'task1');

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "SELECT * FROM `products` WHERE `id`='$id'";
    $query = mysqli_query($conn, $sql);

    if (mysqli_num_rows($query) > 0) {
        $product = mysqli_fetch_assoc($query);
        $image = $product['image'];

        $deletesql = "DELETE FROM `products` WHERE `id`='$id'";
        if (mysqli_query($conn, $deletesql)) {
            
            $imagePath = "../assets/img/uploads/" . $image;
            if ($image && file_exists($imagePath)) {
                unlink($imagePath);
            }
            $_SESSION['success'] = "Product deleted successfully";
        } else {
            $_SESSION['errors'] = ['Failed to delete product'];
        }

        header('Location: ../products/allProducts.php');
        exit();
    } else {
        $_SESSION['errors'] = ['Data not found'];
        header('Location: ../products/allProducts.php');
        exit();
    }

    mysqli_close($conn);
} else {
    $_SESSION['errors'] = ['Something went wrong'];
    header('Location: ../products/allProducts.php');
    exit();
}
?>
