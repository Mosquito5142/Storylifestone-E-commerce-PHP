<?php
// เชื่อมต่อกับฐานข้อมูล หรือทำการ include file ที่มีการเชื่อมต่อฐานข้อมูลไว้ตรงนี้

// ตรวจสอบว่ามีการส่งข้อมูลมาจากฟอร์มหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบว่ามีข้อมูลสีที่ส่งมาหรือไม่
    if (isset($_POST['selectedColor'])) {
        // รับค่าสีจากฟอร์ม
        $selectedColor = $_POST['selectedColor'];

        // ตรวจสอบความถูกต้องของค่าสี
        if (preg_match('/^#[a-f0-9]{6}$/i', $selectedColor)) {
            // ทำตามกระบวนการบันทึกสีลงในฐานข้อมูลหรือไฟล์ตามที่คุณต้องการ
            // ตัวอย่างเช่น: บันทึกลงในฐานข้อมูล MySQL
            // $sql = "INSERT INTO colors (color_code) VALUES ('$selectedColor')";
            // mysqli_query($connection, $sql);

            // หรือบันทึกลงในไฟล์
            // file_put_contents('selected_color.txt', $selectedColor);

            // แสดงข้อความว่าบันทึกสีเรียบร้อย
            echo "บันทึกสี $selectedColor เรียบร้อยแล้ว";
        } else {
            // ถ้าค่าสีไม่ถูกต้อง
            echo "ข้อมูลสีไม่ถูกต้อง";
        }
    } else {
        // ถ้าไม่มีข้อมูลสีที่ส่งมา
        echo "ไม่พบข้อมูลสี";
    }
}
?>
