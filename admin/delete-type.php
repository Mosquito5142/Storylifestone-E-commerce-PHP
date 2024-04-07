<?php
// ทำการเชื่อมต่อฐานข้อมูล
include '../config.php';

// ตรวจสอบว่ามีการส่งค่า ID มาหรือไม่
if(isset($_GET['id'])) {
    $type_id = $_GET['id'];

    // เตรียมคำสั่ง SQL เพื่อลบข้อมูลประเภท
    $sql = "DELETE FROM `type` WHERE `type_id` = $type_id";

    // ทำการลบข้อมูล
    if ($conn->query($sql) === TRUE) {
        echo "ลบข้อมูลเรียบร้อยแล้ว";
    } else {
        echo "เกิดข้อผิดพลาดในการลบข้อมูล: " . $conn->error;
    }
} else {
    echo "ไม่ได้ระบุรหัสประเภท";
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
