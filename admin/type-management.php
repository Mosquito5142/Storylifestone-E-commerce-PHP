<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แสดงข้อมูล</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<a href="add-type.php">เพิ่มข้อมูล</a>
<table>
    <tr>
        <th>รหัสประเภท</th>
        <th>ชื่อประเภท</th>
        <th>แก้ไข</th>
        <th>ลบ</th>
    </tr>
    <?php
    // ทำการเชื่อมต่อฐานข้อมูล
    include '../config.php';

    // สร้างคำสั่ง SQL เพื่อดึงข้อมูล
    $sql = "SELECT `type_id`, `type_name` FROM `type`";

    // ประมวลผลคำสั่ง SQL
    $result = $conn->query($sql);

    // ตรวจสอบว่ามีข้อมูลหรือไม่
    if ($result->num_rows > 0) {
        // แสดงข้อมูลในรูปแบบของตาราง HTML
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["type_id"]. "</td>";
            echo "<td>" . $row["type_name"]. "</td>";
            echo "<td><a href='edit-type.php?id=" . $row["type_id"] . "'>แก้ไข</a></td>";
            echo "<td><a href='delete-type.php?id=" . $row["type_id"] . "' onclick='return confirm(\"คุณแน่ใจที่จะลบข้อมูลนี้?\")'>ลบ</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='4'>0 รายการ</td></tr>";
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
    ?>
</table>
</body>
</html>
