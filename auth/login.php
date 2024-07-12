<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="../assets/css/style.css">
  <title>Login</title>
</head>

<body class="d-flex align-items-center">
  <form method="post" enctype="multipart/form-data" action="../handels/handellogin.php" class="w-50 m-auto mt-5 p-5 rounded bg-primary-subtle text-dark">


    <div class="mb-3">
      <label for="email" class="form-label">User Email</label>
      <input name="email" type="email" class="form-control" id="userEmail" aria-describedby="userNameHelp">
    </div>

    <div class="mb-3">
      <label for="pass" class="form-label">User password</label>
      <input name="password" type="password" class="form-control" id="userPassword">
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