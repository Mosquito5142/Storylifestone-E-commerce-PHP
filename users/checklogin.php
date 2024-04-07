<?php
// ตรวจสอบว่า $_SESSION['user_no'] มีค่าหรือไม่
if (!isset($_SESSION['user_no'])) {
    // ถ้าไม่มีค่า ให้ redirect ไปยังหน้าที่คุณต้องการ
    header("Location: users/login.php");
    exit(); // ตัวออกจากการทำงานของ script
}

// ถ้ามี $_SESSION['user_no'] มีค่า คุณสามารถดำเนินการต่อได้ต่อจากนี้
// เช่น แสดงข้อมูลหรือทำอะไรก็ตามที่คุณต้องการทำ
?>
