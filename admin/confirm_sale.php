<?php
include "check_login.php";
include '../config.php';

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$so_no = isset($_POST['so_no']) ? mysqli_real_escape_string($conn, $_POST['so_no']) : '';

// Update order status in sales_orders table
$updateOrderStatusQuery = "UPDATE sales_orders SET order_status='กำลังจัดส่ง' WHERE so_no='$so_no' LIMIT 1";

if (mysqli_query($conn, $updateOrderStatusQuery)) {
    echo "Order status updated successfully";

    // Update product quantity in product table
    $updateProductQuantityQuery = "UPDATE product
                                   SET amount = amount - (
                                       SELECT qty_ordered
                                       FROM sale_relations
                                       WHERE sale_relations.so_no = '$so_no'
                                       AND sale_relations.pro_id = product.pro_id
                                   )
                                   WHERE EXISTS (
                                       SELECT 1
                                       FROM sale_relations
                                       WHERE sale_relations.so_no = '$so_no'
                                       AND sale_relations.pro_id = product.pro_id
                                   )";

    if (mysqli_query($conn, $updateProductQuantityQuery)) {
        echo "Product quantity updated successfully";
    } else {
        echo "Error updating product quantity: " . mysqli_error($conn);
    }

    header("Location: order-management.php");
} else {
    echo "Error updating order status: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
