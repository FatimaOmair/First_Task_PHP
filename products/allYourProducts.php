<?php session_start();
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
    <title>Product Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/allProducts.css"> 
    <link rel="stylesheet" href="../assets/css/allUsers.css">
</head>
<body class="container">

<?php
$conn = mysqli_connect('localhost', 'root', '', 'task1');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT products.*, users.name AS user_name FROM products 
        JOIN users ON products.user_id = users.id 
        WHERE products.user_id = '$user_id'";

$productsQuery = mysqli_query($conn, $sql);

if (!$productsQuery) {
    die("Query failed: " . mysqli_error($conn));
}

$products = mysqli_fetch_all($productsQuery, MYSQLI_ASSOC);

mysqli_close($conn);
?>

<div class="table-responsive">
    <table class="table table-hover table-bordered">
    <?php require('../shared/notifications.php');?>
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Added by</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Price</th>
                <th scope="col">Image</th>
                <th scope="col">Created At</th>
                <th scope="col">Updated At</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['id']); ?></td>
                <td><?php echo htmlspecialchars($product['user_name']); ?></td>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['description']); ?></td>
                <td><?php echo htmlspecialchars($product['price']); ?></td>
                <td><img src="../assets/img/uploads/<?php echo htmlspecialchars($product['image']); ?>"style="width: 100px; height: auto;"></td>
                <td><?php echo htmlspecialchars($product['created_at']); ?></td>
                <td><?php echo htmlspecialchars($product['updated_at']); ?></td>
                <td>
                    <a href="../handels/handelDeleteProduct.php?id=<?php echo $product['id'] ?>" class="btn btn-outline-danger">Delete</a>
                    <a href="./updateProduct.php?id=<?php echo $product['id'] ?>" class="btn btn-outline-success">Edit</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
