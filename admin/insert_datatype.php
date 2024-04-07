<?php
include '../config.php';

// ตรวจสอบว่ามีการส่งข้อมูลแบบ POST มาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับข้อมูลที่ส่งมาจากแบบฟอร์ม
    $type_id = $_POST['type_id'];
    $type_name = $_POST['type_name'];

    // เตรียมคำสั่ง SQL เพื่อเพิ่มข้อมูล
    $sql = "INSERT INTO type (type_id, type_name) VALUES ('$type_id', '$type_name')";

    // ทำการเพิ่มข้อมูล
    if ($conn->query($sql) === TRUE) {
        // บันทึกข้อมูลเรียบร้อยแล้ว ทำการ redirect ไปยังหน้า index.php
        header("Location: type-management.php");
        exit(); // ต้องใช้ exit() เพื่อหยุดการทำงานของสคริปต์ทันทีหลังจาก header() เพื่อป้องกันข้อผิดพลาด
    } else {
        echo "เกิดข้อผิดพลาด: " . $sql . "<br>" . $conn->error;
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
