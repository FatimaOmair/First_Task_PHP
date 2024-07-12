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
    <title>User Table</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/allUsers.css"> 

</head>
<body class="container">

<?php
$conn = mysqli_connect('localhost', 'root', '', 'task1');

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$usersQuery = mysqli_query($conn, "SELECT * FROM users");

if (!$usersQuery) {
    die("Query failed: " . mysqli_error($conn));
}

$users = mysqli_fetch_all($usersQuery, MYSQLI_ASSOC);

mysqli_close($conn);
?>

<div class="table-responsive">
    <table class="table table-hover table-bordered">
    <?php require('../shared/notifications.php');?>
        <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Password</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['password']); ?></td>
                <td>
                    <a href="../handels/deleteUserHandler.php?id= <?php echo $user['id'] ?>" class="btn btn-outline-danger">Delete</a>
                    <a href="editUser.php?id=<?php echo $user['id'] ?>" class="btn btn-outline-success">Edit</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


</body>
</html>
