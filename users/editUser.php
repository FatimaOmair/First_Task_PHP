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

$sql= "select * from users where id=$id";
$usersQuery = mysqli_query($conn, $sql);
$user= mysqli_fetch_assoc($usersQuery);



mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Update User</title>
</head>
<body>
<form method="post" enctype="multipart/form-data" action="../handels/updateUserHandler.php?id=<?php echo $id;?>" class="w-50 m-auto mt-5 p-5 rounded bg-primary-subtle">
  <div class="mb-3">
    <label for="name" class="form-label">User Name</label>
    <input name="name" value="<?php echo htmlspecialchars($user['name']); ?>" type="text" class="form-control" id="name" aria-describedby="userNameHelp">
  </div>

  <div class="mb-3">
    <label for="email" class="form-label">User Email</label>
    <input name="email" value="<?php echo htmlspecialchars($user['email']); ?>" type="email" class="form-control" id="userEmail" aria-describedby="userNameHelp">
  </div>

  <div class="mb-3">
    <label for="password" class="form-label">User Password</label>
    <input name="password" value="<?php echo htmlspecialchars($user['password']); ?>" type="password" class="form-control" id="userPassword">
  </div>

  <div class="mb-3 form-check">
    <input name="terms" type="checkbox" class="form-check-input" id="termsCheck">
    <label class="form-check-label" for="termsCheck">Check me out</label>
  </div>
  <?php require('../shared/notifications.php');?>
  <button name="register" type="submit" class="btn btn-primary">Submit</button>
</form>
</body>
</html>
