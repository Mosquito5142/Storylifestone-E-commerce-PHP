<?php
include "chack_login.php";
include "../config.php";

// Connect to the database
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Error " . mysqli_connect_error());
}

// Fetch data from MySQL
$query = "SELECT `user_no`, `user_email`,`user_tel`, `user_name`,`user_password`, `image_name`, `image_type`, `image_data` FROM `users`";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    die("Error in SQL query: " . mysqli_error($conn));
}

// Initialize an empty array to store user data
$users = array();

// Fetch the data row by row and store it in the $users array
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
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
    <title>User Information</title>
</head>
<body class="bg-gray-100">
<div class="container mx-auto">
    <header >
      <?php include 'navadmin.php' ?>
    </header>
  </div>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-semibold mb-8">User Information</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8">
            <?php foreach ($users as $user): ?>
                <div class="bg-white p-4 rounded shadow-md relative">
                    <?php
                    // Build the image path based on your file structure
                    $imagePath = "data:" . $user['image_type'] . ";base64," . base64_encode($user['image_data']);
                    ?>
                    <img src="<?php echo $imagePath; ?>" alt="<?php echo $user['user_name']; ?>" class="w-full h-40 object-cover mb-4 rounded">

                    <div class="mb-2"><strong>ชื่อ:</strong> <?php echo $user['user_name']; ?></div>
                    <div class="mb-2"><strong>Email:</strong> <?php echo $user['user_email']; ?></div>
                    <div class="mb-2"><strong>เบอร์โทร:</strong> <?php echo $user['user_tel']; ?></div>

                    <!-- Edit and Delete Buttons -->
                    <div class="absolute top-2 right-2">
                        <a href="edit_user.php?user_id=<?php echo $user['user_no']; ?>" class="text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                        <a href="delete_user.php?user_id=<?php echo $user['user_no']; ?>" class="text-red-500 hover:text-red-700">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
