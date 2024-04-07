<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["webname"])) {
    $new_webname = $_POST["webname"];

    
    // บันทึกข้อความลงในไฟล์ hero1_content.php และ hero2_content.php
    file_put_contents('../comp/setweb/webname.php', $new_webname);
}

// ดึงเนื้อหา hero1 และ hero2 จากไฟล์
$webname = file_get_contents('../comp/setweb/webname.php');
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
        <h1 class="text-2xl font-bold mb-4">แก้ไข Hero</h1>

        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="form-container">
            <div class="form-group">
                <label for="webname">Hero Section 1 Content:</label>
                <textarea name="webname" id="webname" class="form-control" placeholder="Enter content for webname"><?php echo $webname; ?></textarea>
            </div>
            <button type="submit" class="bg-green-300">Save</button>
        </form>
    </div>
</div>

</body>
</html>
