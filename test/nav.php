<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation</title>
    <style>
        .nav {
            background-color: <?php echo $selected_color; ?>;
            /* ส่วนอื่น ๆ ของ CSS */
        }
    </style>
</head>
<body>
    <nav class="nav">
        <!-- เมนูนำทาง -->
        <ul>
            <li><a href="#">หน้าแรก</a></li>
            <li><a href="#">เกี่ยวกับเรา</a></li>
            <li><a href="#">บริการ</a></li>
            <!-- เพิ่มเมนูอื่น ๆ ตามต้องการ -->
        </ul>
    </nav>
</body>
</html>
