<?php
include "chack_login.php";
include "../config.php";

$item_no = $_POST["pro_id"];
$item_name = $_POST["pro_name"];
$pro_detail = $_POST["pro_detail"];
$costprice =  $_POST["costprice"];
$price = $_POST["price"];
$qty_on_hand = $_POST["qty_on_hand"];
$type_id = $_POST["type_id"];

if ($_FILES["myfile"]["name"] <> "") {
    $image_name = $_FILES["myfile"]["name"];
    $image_type = $_FILES["myfile"]["type"];

    // Move the uploaded file to the "img" folder
    $upload_folder = "../img/";
    $upload_path = $upload_folder . $image_name;

    // Move the uploaded file to the destination folder
    if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $upload_path)) {
        $upload_message = "File uploaded successfully.";
    } else {
        $upload_message = "Error uploading file.";
        exit();
    }
} else {
    $image_name = "";
    $image_type = "";
    $image_data = "";
}

$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Error: " . mysqli_connect_error());
}

$sql = "INSERT INTO `product` (`pro_id`, `pro_name`, `pro_detail`,`costprice`, `price`, `amount`, `img`, `type_id`)
VALUES ('$item_no', '$item_name', '$pro_detail', '$costprice', '$price', '$qty_on_hand', '$image_name', '$type_id');";

if (mysqli_query($conn, $sql)) {
    $insert_message = "Product inserted successfully.";
} else {
    $insert_message = "Error: " . mysqli_error($conn);
}

mysqli_close($conn);

// Output the messages after database operations
if (isset($upload_message)) {
    echo $upload_message;
}
if (isset($insert_message)) {
    echo $insert_message;
}

// Redirect after a certain time
header("Refresh:1;url=product-management.php");
?>
