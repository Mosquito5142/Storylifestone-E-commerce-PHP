<?php
ob_start(); // เริ่ม output buffering
include "config.php";
session_start();

// เชื่อมต่อกับฐานข้อมูล
$con = mysqli_connect($servername, $username, $password, $dbname);
if (mysqli_connect_errno()) {
    echo "Fail to connect to MySQL";
    exit();
}

// ดึงวันที่ปัจจุบัน
$so_date = date('Y-m-d');
$so_no = $_POST['so_no'];
$address = $_POST['first_name'] . ' ' . $_POST['last_name'] . ' เบอร์โทรผู้รับ : ' . $_POST['tel'] . '  บ้านเลขที่ : ' . $_POST['address']. ' ตำบล :  ' . $_POST['district']. ' อำเภอ : ' . $_POST['canton']. ' จังหวัด : ' . $_POST['county']. ' รหัสไปรษณีย์ : ' .$_POST['postal'];
$i = 0;

if (isset($_SESSION['user_no'])) {
    $user_no = $_SESSION['user_no'];

    // เพิ่มข้อมูลในตาราง sales_orders
    $sql_sales_orders = "INSERT INTO sales_orders (so_no, so_date, user_no, address,  order_status) VALUES ('$so_no', '$so_date', '$user_no','$address','Pending')";

    if (mysqli_query($con, $sql_sales_orders)) {
        echo "New record created successfully in sales_orders";
    } else {
        echo "Error: " . $sql_sales_orders . "<br>" . mysqli_error($con);
    }

    if ($_SESSION["intLine"] >= 0) {
        while ($i <= $_SESSION["intLine"]) {
            // ตรวจสอบว่ามีข้อมูลที่ต้องการหรือไม่
            if (isset($_SESSION["strProductID"][$i], $_SESSION["strQty"][$i])) {
                $pro_no = $_SESSION["strProductID"][$i];
                $qty_ordered = $_SESSION["strQty"][$i];
    
                $sql_sale_relations = "INSERT INTO sale_relations (so_no, pro_id, qty_ordered) VALUES ('$so_no', '$pro_no', '$qty_ordered')";
    
                if (mysqli_query($con, $sql_sale_relations)) {
                   
                } else {
                    echo "Error: " . $sql_sale_relations . "<br>" . mysqli_error($con);
                }
            }$i++;
        }

    }
        unset($_SESSION["intLine"]);
unset($_SESSION["strProductID"]);
unset($_SESSION["strQty"]);
         header("Location: so_detail.php?id=$so_no");
         ob_end_flush(); // สิ้นสุด output buffering และส่งเนื้อหาทั้งหมดไปยัง client
    }
?>
