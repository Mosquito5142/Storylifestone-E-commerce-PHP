<?php
// ทำการเชื่อมต่อฐานข้อมูล
include '../config.php';

// ตรวจสอบว่ามีการส่งข้อมูลแบบ POST มาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับข้อมูลที่ส่งมาจากฟอร์ม
    $type_id = $_POST['type_id'];
    $type_name = $_POST['type_name'];

    // เตรียมคำสั่ง SQL เพื่อปรับปรุงข้อมูล
    $sql = "UPDATE `type` SET `type_name`='$type_name' WHERE `type_id`='$type_id'";

    // ทำการปรับปรุงข้อมูล
    if ($conn->query($sql) === TRUE) {
        echo "ปรับปรุงข้อมูลเรียบร้อยแล้ว";
        header("Location: type-management.php");
    } else {
        echo "เกิดข้อผิดพลาดในการปรับปรุง: " . $conn->error;
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
