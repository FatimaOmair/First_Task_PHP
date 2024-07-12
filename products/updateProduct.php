<?php session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

$id = $_GET['id'];


$conn = mysqli_connect("localhost", "root", "", "task1");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "select * from products where id=$id";
$productsQuery = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($productsQuery);



mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Update product</title>
</head>

<body>
    <form method="post" enctype="multipart/form-data" action="../handels/updateproductHandler.php?id=<?php echo $id; ?>" class="w-50 m-auto mt-5 p-5 rounded bg-primary-subtle">
        <div class="mb-3">
            <label for="name" class="form-label">product Name</label>
            <input name="name" value="<?php echo htmlspecialchars($product['name']); ?>" type="text" class="form-control" id="name" aria-describedby="productNameHelp">
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <input name="description" value="<?php echo htmlspecialchars($product['description']); ?>" type="text" class="form-control" id="desc" aria-describedby="productNameHelp">
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input name="price" value="<?php echo htmlspecialchars($product['price']); ?>" type="number" class="form-control" id="price">
        </div>

        <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" class="form-control">
            <img src="../assets/img/uploads/<?= $product['image'] ?>" style="width: 100px; height: 100px;">
        </div>

        <div class="mb-3 form-check">
            <input name="terms" type="checkbox" class="form-check-input" id="termsCheck">
            <label class="form-check-label" for="termsCheck">Check me out</label>
        </div>
        <?php require('../shared/notifications.php'); ?>
        <button name="register" type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>

</html>