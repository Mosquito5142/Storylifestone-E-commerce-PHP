<?php
include "chack_login.php";
include "../config.php";

// Check if the request method is GET and if "id" parameter is set
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["user_no"])) {
    $user_no = $_GET["user_no"];

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Error: " . mysqli_connect_error());
    }

    $sql = "DELETE FROM users WHERE user_no='$user_no'";
    if (mysqli_query($conn, $sql)) {
        echo "Product deleted successfully.";
        header("Refresh:0;url=admin_index.php");
    } else {
        echo "Error deleting product: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>
