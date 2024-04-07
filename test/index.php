<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เลือกสี</title>
</head>
<body>
    <h1>เลือกสีที่คุณต้องการ</h1>

    <form id="colorForm" method="post" action="save_color.php">
        <label for="colorPicker">เลือกสี:</label>
        <input type="color" id="colorPicker" name="selectedColor">

        <button type="submit">บันทึกสี</button>
    </form>
</body>
</html>
