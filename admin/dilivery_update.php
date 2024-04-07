<?php
include "chack_login.php";
include "../config.php";

// Assuming 'so_no' is coming from the form as a hidden input
$so_no = isset($_POST['so_no']) ? mysqli_real_escape_string($conn, $_POST['so_no']) : '';
$image_name = $_FILES["myfile"]["name"];
$image_type = $_FILES["myfile"]["type"];

// Check if a file is selected
if ($image_name <> "") {
    $image_data = addslashes(file_get_contents($_FILES["myfile"]["tmp_name"]));

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "UPDATE sales_orders SET ";
    $sql .= "delivery_image_name='$image_name', delivery_image_type='$image_type', delivery_image_data='$image_data' , order_status='จัดส่งสินค้าเรียบร้อย'";
    $sql .= " WHERE so_no='$so_no'";

    if (mysqli_query($conn, $sql)) {
        echo "Update successfully";
        // Redirect to a success page or wherever you want to go
        header("Location:order-management.php");
        exit(); // Ensure script stops execution after the redirect
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "No file selected.";
}

?>
