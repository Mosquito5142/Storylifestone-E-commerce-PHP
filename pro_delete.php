<?php
session_start();

if (isset($_GET['Line'])) {
    $lineToDelete = $_GET['Line'];

    if (isset($_SESSION['strProductID'][$lineToDelete])) {
        // ลบสินค้าในตะกร้า
        unset($_SESSION['strProductID'][$lineToDelete]);
        unset($_SESSION['strQty'][$lineToDelete]);

        // รีเฟรชหน้าตะกร้าหลังจากลบสินค้า
        header("Location: cart.php");
    }
}
?>
