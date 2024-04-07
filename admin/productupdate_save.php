<?php
include "chack_login.php";
include "../config.php";

$item_no = $_POST["pro_id"];
$old_item_no = $_POST["old_pro_id"]; // Corrected variable name
$item_name = $_POST["pro_name"];
$pro_detail = $_POST["pro_detail"];
$costprice =  $_POST["costprice"];
$price = $_POST["price"];
$qty_on_hand = (int)$_POST["amount"]; // แปลงเป็น int
$input_amount_to_add = isset($_POST["amount_to_add"]) ? (int)$_POST["amount_to_add"] : 0; // แปลงเป็น int
$type_id = $_POST["type_id"];
$add_product = $input_amount_to_add + $qty_on_hand; // ทำการบวกกัน
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Error: " . mysqli_connect_error());
}

// Check if a new file has been uploaded
if ($_FILES["myfile"]["name"] <> "") {
    $image_name = $_FILES["myfile"]["name"];
    $image_type = $_FILES["myfile"]["type"];

    // Move the uploaded file to the "img" folder
    $upload_folder = "../img/";
    $upload_path = $upload_folder . $image_name;

    // Move the uploaded file to the destination folder
    if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $upload_path)) {
        echo "File uploaded successfully.";
        
        // Update image information in the database
        $sql = "UPDATE `product` SET 
                `pro_id`='$item_no', 
                `pro_name`='$item_name', 
                `pro_detail`='$pro_detail', 
                `price`='$price', 
                `amount`='$add_product', 
                `img`='$image_name', 
                `type_id`='$type_id' 
                WHERE `pro_id`='$old_item_no'";
    } else {
        echo "Error uploading file.";
        exit();
    }
} else {
    // No new file uploaded, keep the existing image information in the database
    $sql = "UPDATE `product` SET 
            `pro_id`='$item_no', 
            `pro_name`='$item_name', 
            `pro_detail`='$pro_detail', 
            `costprice`='$costprice', 
            `price`='$price', 
            `amount`='$add_product', 
            `type_id`='$type_id' 
            WHERE `pro_id`='$old_item_no'";
}

if (mysqli_query($conn, $sql)) {
    mysqli_close($conn); // Close the database connection before redirecting
    header("Refresh:1;url=product-management.php");
    echo "Product updated successfully."; // Move this line after the header() call
} else {
    echo "Error: " . mysqli_error($conn);
}

?>
