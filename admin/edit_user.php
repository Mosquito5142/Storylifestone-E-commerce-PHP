<?php
include "chack_login.php";
include "../config.php";

// Connect to the database
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Error " . mysqli_connect_error());
}

// Check if user_id is set in the URL
if (isset($_GET['user_id'])) {
    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);

    // Fetch user data
    $query = "SELECT * FROM `users` WHERE `user_no` = $user_id";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        $user = mysqli_fetch_assoc($result);
    } else {
        die("Error in SQL query: " . mysqli_error($conn));
    }
} else {
    // Redirect if user_id is not set
    header("Location: user_Management.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form data, update the database, etc.

    // Example: Update user data
    $newUserName = mysqli_real_escape_string($conn, $_POST['user_name']);
    $newUserEmail = mysqli_real_escape_string($conn, $_POST['user_email']);
    $newUserLogin = mysqli_real_escape_string($conn, $_POST['user_login']);
    $newPassword = mysqli_real_escape_string($conn, $_POST['password']);

    // Hash the new password before storing it in the database
    $hashedPassword = md5($newPassword);

    $updateQuery = "UPDATE `users` SET `user_name`='$newUserName', `user_email`='$newUserEmail', `user_login`='$newUserLogin', `user_password`='$hashedPassword' WHERE `user_no`='$user_id'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if (!$updateResult) {
        die("Error updating user data: " . mysqli_error($conn));
    }

    // Redirect to the user information page after updating
    header("Location: admin_index.php");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Edit User</title>
</head>
<body class="bg-gray-100">
<div class="container mx-auto">
    <header >
      <?php include 'navadmin.php' ?>
    </header>
  </div>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-semibold mb-8">Edit User</h1>

        <form action="edit_user.php?user_id=<?php echo $user_id; ?>" method="POST">
            <div class="mb-4">
                <label for="user_name" class="block text-gray-600">Name:</label>
                <input type="text" id="user_name" name="user_name" value="<?php echo $user['user_name']; ?>" class="form-input mt-1 block w-full" required>
            </div>

            <div class="mb-4">
                <label for="user_email" class="block text-gray-600">Email:</label>
                <input type="email" id="user_email" name="user_email" value="<?php echo $user['user_email']; ?>" class="form-input mt-1 block w-full" required>
            </div>

            <div class="mb-4">
                <label for="user_login" class="block text-gray-600">Login:</label>
                <input type="text" id="user_login" name="user_login" value="<?php echo $user['user_login']; ?>" class="form-input mt-1 block w-full" required>
            </div>

            <!-- Password input field -->
            <div class="mb-4">
                <label for="password" class="block text-gray-600">New Password:</label>
                <input type="password" id="password" name="password" class="form-input mt-1 block w-full">
                <p class="text-gray-500 text-sm mt-2">Leave it blank if you don't want to change the password.</p>
            </div>

            <div class="mb-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update User</button>
            </div>
        </form>
    </div>
</body>
</html>
