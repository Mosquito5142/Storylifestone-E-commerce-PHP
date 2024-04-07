<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูล</title>
</head>
<body>
    <?php
    // ทำการเชื่อมต่อฐานข้อมูล
    include '../config.php';

    // ตรวจสอบว่ามีการส่งค่า ID มาหรือไม่
    if(isset($_GET['id'])) {
        $type_id = $_GET['id'];

        // สร้างคำสั่ง SQL เพื่อดึงข้อมูลประเภทที่ต้องการแก้ไข
        $sql = "SELECT * FROM `type` WHERE `type_id` = $type_id";

        // ประมวลผลคำสั่ง SQL
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
    ?>
            <h2>แก้ไขข้อมูล</h2>
            <form action="update-type.php" method="post">
                <input type="hidden" name="type_id" value="<?php echo $row['type_id']; ?>">
                <label for="type_name">ชื่อประเภท:</label><br>
                <input type="text" id="type_name" name="type_name" value="<?php echo $row['type_name']; ?>"><br><br>
                <input type="submit" value="บันทึก">
            </form>
    <?php
        } else {
            echo "ไม่พบข้อมูลประเภท";
        }
    } else {
        echo "ไม่ได้ระบุรหัสประเภท";
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
    ?>
</body>
</html>
