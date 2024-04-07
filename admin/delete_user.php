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
    header("Location: index.php");
    exit();
}

// Handle deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Example: Delete user
    $deleteQuery = "DELETE FROM `users` WHERE `user_no` = $user_id";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if (!$deleteResult) {
        die("Error deleting user: " . mysqli_error($conn));
    }

    // Redirect to the user information page after deletion
    header("Location: user_Management.php");
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
    <title>Delete User</title>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-semibold mb-8">Delete User</h1>

        <p class="mb-4">Are you sure you want to delete the user <?php echo $user['user_name']; ?>?</p>

        <form action="delete_user.php?user_id=<?php echo $user_id; ?>" method="POST">
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete User</button>
        </form>
    </div>
</body>
</html>
