<?php
// โค้ดเริ่มต้นของหน้าเว็บของคุณ

// ตรวจสอบว่ามีการส่งข้อมูลแก้ไขมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["webname"])) {
    // บันทึกข้อความที่ถูกแก้ไขลงในไฟล์
    $new_webname = $_POST["webname"];
    file_put_contents('../comp/setweb/webname.php', $new_webname);
}

// ดึงข้อความจากไฟล์ navnew.php
$nav_content = file_get_contents('../comp/setweb/webname.php');

// แสดงฟอร์มสำหรับแก้ไขข้อความ
echo "<form method='post' action='".$_SERVER["PHP_SELF"]."'>";
echo "<textarea name='webname'>$nav_content</textarea><br>";
echo "<input type='submit' value='บันทึก'>";
echo "</form>";

// โค้ดส่วนที่เหลือของหน้าเว็บของคุณ
?>
