<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto flex justify-center items-center h-screen">
        <div class="bg-white p-8 rounded shadow-md w-full md:w-96">
            <h1 class="text-2xl font-bold mb-8 text-center">Admin Login</h1>

            <?php
            // Display error message if set
            if (isset($error_message)) {
                echo '<p class="text-red-500 mb-4">' . $error_message . '</p>';
            }
            ?>

            <form action="login_admin2.php" method="post">
                <div class="mb-4">
                    <label for="login" class="block text-sm font-medium text-gray-600">Username</label>
                    <input type="text" name="login" id="login" class="mt-1 p-2 w-full border rounded-md" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-600">Password</label>
                    <input type="password" name="password" id="password" class="mt-1 p-2 w-full border rounded-md" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
