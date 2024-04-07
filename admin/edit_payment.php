<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลการสั่งซื้อ</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">ข้อมูลการสั่งซื้อเดิม</h1>
    <div class="head-image">
        <a>
          <img style="max-width: 100%; height: auto;" src="../img/payment/payment.png?<?php echo time(); ?>" alt="#" />
        </a>
      </div>
        <h1 class="text-2xl font-bold mb-4">แก้ไขข้อมูลการสั่งซื้อ</h1>

        <?php
        // เช็คว่ามีข้อมูลใน $_POST หรือไม่
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // ตรวจสอบการอัพโหลดไฟล์
            if ($_FILES['myfile']['error'] === UPLOAD_ERR_OK) {
                // กำหนดที่อยู่ที่จะบันทึกไฟล์
                $uploadDir = '../img/payment/';
                $uploadFile = $uploadDir . 'payment.png';

                // ลบข้อมูลเก่าทั้งหมด
                // (คำเตือน: กรุณาตรวจสอบว่าเป็นการลบที่ถูกต้องก่อนใช้)
                // ...

                // อัพโหลดรูปภาพใหม่
                move_uploaded_file($_FILES['myfile']['tmp_name'], $uploadFile);

                echo '<p class="text-green-500">บันทึกข้อมูลเรียบร้อยแล้ว</p>';
            } else {
                echo '<p class="text-red-500">เกิดข้อผิดพลาดในการอัพโหลดไฟล์</p>';
            }
        }
        ?>

        <!-- แบบฟอร์มอัพโหลดรูปภาพ -->
        <form action="" method="post" enctype="multipart/form-data">
            <label for="exampleInputFile" class="block text-sm font-medium text-gray-700">เลือกรูปภาพใหม่</label>
            <input type="file" class="mt-1 mb-4" id="exampleInputFile" name="myfile" accept="image/*">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">บันทึก</button>
        </form>
    </div>
</body>

</html>
