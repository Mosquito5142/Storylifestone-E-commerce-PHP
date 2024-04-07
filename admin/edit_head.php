<?php
// เช็คว่ามีการส่งค่า hero1_content และ hero2_content มาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["hero1_content"]) && isset($_POST["hero2_content"])) {
    $new_hero1_content = $_POST["hero1_content"];
    $new_hero2_content = $_POST["hero2_content"];
    
    // บันทึกข้อความลงในไฟล์ hero1_content.php และ hero2_content.php
    file_put_contents('../comp/setweb/hero1.php', $new_hero1_content);
    file_put_contents('../comp/setweb/hero2.php', $new_hero2_content);
}

// ดึงเนื้อหา hero1 และ hero2 จากไฟล์
$hero1_content = file_get_contents('../comp/setweb/hero1.php');
$hero2_content = file_get_contents('../comp/setweb/hero2.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Edit Hero Sections</title>
    <style>
        .container {
            padding: 20px;
        }
        .form-container {
            max-width: 600px;
            margin: auto;
            background-color: #f3f4f6;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-container h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            font-size: 16px;
            font-weight: bold;
        }
        .form-group textarea {
            width: 100%;
            min-height: 150px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            resize: vertical;
        }
        .form-group button {
            padding: 10px 20px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .form-group button:hover {
            background-color: #45a049;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body class="">
<div class="container mx-auto">
  <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Hero เดิม</h1>
        <div class="head-image">
            <a>
                <img style="max-width: 100%; height: auto;" src="../img/hero/head.png?<?php echo time(); ?>" alt="#" />
            </a>
        </div>
        <h1 class="text-2xl font-bold mb-4">แก้ไข Hero</h1>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['myfile']) && $_FILES['myfile']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = '../img/hero/';
                $uploadFile = $uploadDir . 'head.png';

                // Validate and sanitize file type if needed
                // ...

                // Validate and sanitize file size if needed
                // ...

                // Delete old data (if needed)
                // ...

                if (move_uploaded_file($_FILES['myfile']['tmp_name'], $uploadFile)) {
                    echo '<p class="text-green-500">บันทึกข้อมูลเรียบร้อยแล้ว</p>';
                } else {
                    echo '<p class="text-red-500">เกิดข้อผิดพลาดในการอัพโหลดไฟล์</p>';
                }
            } else {
                echo '<p class="text-red-500">กรุณาเลือกไฟล์ที่ต้องการอัพโหลด</p>';
            }
        }
        ?>

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <label for="exampleInputFile" class="block text-sm font-medium text-gray-700">เลือกรูปภาพใหม่</label>
            <input type="file" class="mt-1 mb-4" id="exampleInputFile" name="myfile" accept="image/*">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">บันทึก</button>
        </form>
        

        <div class="container mx-auto">
    <div class="container mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">แก้ไข Hero</h1>

        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="form-container">
            <div class="form-group">
                <label for="hero1_content">Hero Section 1 Content:</label>
                <textarea name="hero1_content" id="hero1_content" class="form-control" placeholder="Enter content for hero section 1"><?php echo $hero1_content; ?></textarea>
            </div>
            <div class="form-group">
                <label for="hero2_content">Hero Section 2 Content:</label>
                <textarea name="hero2_content" id="hero2_content" class="form-control" placeholder="Enter content for hero section 2"><?php echo $hero2_content; ?></textarea>
            </div>
            <button type="submit" class="bg-green-300">Save</button>
        </form>
    </div>
</div>

</div>

</body>
</html>
