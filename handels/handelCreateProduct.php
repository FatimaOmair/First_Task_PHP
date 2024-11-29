<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract and sanitize POST data
    extract($_POST);
    $name = strip_tags(trim($name));
    $description = strip_tags(trim($description));
    $price = floatval($price);

    // Ensure user is logged in and session contains user_id
    if (!isset($_SESSION['user_id'])) {
        die("Error: User is not logged in or user ID is not set.");
    }
    $user_id = $_SESSION['user_id']; // Fetch user ID from session

    // Initialize errors array
    $errors = [];

    // Validate Name
    if (empty($name)) {
        $errors[] = "Product name is required.";
    } elseif (!is_string($name)) {
        $errors[] = "Product name must be a string.";
    } elseif (strlen($name) < 3 || strlen($name) > 50) {
        $errors[] = "Product name must be between 3 and 50 characters.";
    }

    // Validate Description
    if (empty($description)) {
        $errors[] = "Description is required.";
    } elseif (!is_string($description)) {
        $errors[] = "Description must be a string.";
    } elseif (strlen($description) < 10 || strlen($description) > 500) {
        $errors[] = "Description must be between 10 and 500 characters.";
    }

    // Validate Price
    if (empty($price)) {
        $errors[] = "Price is required.";
    } elseif (!is_numeric($price) || $price <= 0) {
        $errors[] = "Price must be a positive number.";
    }

    // File upload processing
    $newName = null;
    if (isset($_FILES['image']) && $_FILES['image']['name']) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];

        $allowed_extensions = ['jpg', 'png', 'jpeg', 'webp'];
        $image_extension = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $newName = uniqid() . "_" . $name . "." . $image_extension;

        // Validate Image
        if (!in_array($image_extension, $allowed_extensions)) {
            $errors[] = "Image must be in JPG, PNG, JPEG, or WEBP format.";
        } elseif ($image_size > 5 * 1024 * 1024) { // Maximum 5MB
            $errors[] = "Image size must not exceed 5MB.";
        }
    }

    // Check for errors
    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('Location: ../products/createProduct.php');
        exit();
    } else {
        // Connect to the database
        $conn = mysqli_connect('localhost', 'root', '', 'task1');

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Use a prepared statement for secure insertion
        $stmt = $conn->prepare("INSERT INTO `products` (`user_id`, `name`, `description`, `price`, `image`) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issds", $user_id, $name, $description, $price, $newName);

        if ($stmt->execute()) {
            // Move the uploaded image to the appropriate directory
            if ($_FILES['image']['name']) {
                move_uploaded_file($image_tmp, "../assets/img/uploads/$newName");
            }

            // Success message
            $_SESSION['success'] = "Product added successfully.";
            header('Location: ../products/allProducts.php');
            exit();
        } else {
            // Handle SQL errors
            $errors[] = "Error: " . $stmt->error;
            $_SESSION['errors'] = $errors;
            header('Location: ../products/createProduct.php');
            exit();
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
} else {
    // Redirect if the request method is not POST
    header("Location: ../products/createProduct.php");
    exit();
}
?>
