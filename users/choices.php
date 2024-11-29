<?php 
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/choices.css">
    <title>choices</title>

</head>

<div class="container d-flex flex-wrap justify-content-center align-items-center h-100">

    <div class="card m-5" style="width: 18rem;">
        <img src="../assets/img/cards/download.png" class="card-img-top img-fluid" alt="Download Image">
        <div class="card-body">
            <h5 class="card-title">Show all users</h5>
            <a href="./allUsers.php" class="btn btn-primary">Show</a>
        </div>
    </div>

    <div class="card m-5" style="width: 18rem;">
        <img src="../assets/img/cards/products.png" class="card-img-top img-fluid" alt="Products Image">
        <div class="card-body">
            <h5 class="card-title">Show all products</h5>
            <a href="../products/allProducts.php" class="btn btn-primary">Show</a>
        </div>
    </div>

    <div class="card m-5" style="width: 18rem;">
        <img src="../assets/img/cards/yourProducts.jpg" class="card-img-center img-fluid" alt="Your Products Image">
        <div class="card-body">
            <h5 class="card-title">Show your products</h5>
            <a href="../products/allYourProducts.php" class="btn btn-primary">Show</a>
        </div>
    </div>

    <div class="card m-5" style="width: 18rem;">
        <img src="../assets/img/cards/createProduct.jpg" class="card-img-top img-fluid" alt="Create Product Image">
        <div class="card-body">
            <h5 class="card-title">Create new product</h5>
            <a href="../products/createProduct.php" class="btn btn-primary">Craete</a>
        </div>
    </div>

    
</div>

</html>