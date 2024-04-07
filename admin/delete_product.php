<?php
include "chack_login.php";
include "../config.php";

// Check if the request method is GET and if "pro_id" parameter is set
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["pro_id"])) {
    $pro_id = $_GET["pro_id"];

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Error: " . mysqli_connect_error());
    }

    $sql = "DELETE FROM product WHERE pro_id='$pro_id'";
    if (mysqli_query($conn, $sql)) {
        // Move this echo statement below the header() call
        header("Refresh:0;url=product-management.php");
        echo "Product deleted successfully.";
    } else {
        echo "Error deleting product: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    // Change the message to inform about the correct usage
    echo "Please provide a valid product ID.";
}
?>
