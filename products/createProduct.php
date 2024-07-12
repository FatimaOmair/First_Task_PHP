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

  <title>Document</title>
</head>

<body>
  <form method="post" enctype="multipart/form-data" action="../handels/handelCreateProduct.php" class="w-50 m-auto mt-5 p-5 rounded bg-primary-subtle text-dark">
    <div class="mb-3">
      <label for="name" class="form-label">Product Name</label>
      <input name="name" type="text" class="form-control" id="name" aria-describedby="nameHelp">
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <input name="description" type="text" class="form-control" id="productDescription" aria-describedby="nameHelp">
    </div>

    <div class="mb-3">
      <label for="price" class="form-label">Price</label>
      <input name="price" type="number" class="form-control" id="price">
    </div>


    <div class="mb-3">
      <label for="image" class="form-label">Image</label>
      <input name="image" type="file" class="form-control" id="image">
    </div>

    <div class="mb-3 form-check">
      <input name="terms" type="checkbox" class="form-check-input" id="termsCheck">
      <label class="form-check-label" for="termsCheck">Check me out</label>
    </div>
    <?php
    require('../shared/notifications.php');
    ?>
    <button name="register" type="submit" class="btn btn-primary">Submit</button>
  </form>
</body>

</html>