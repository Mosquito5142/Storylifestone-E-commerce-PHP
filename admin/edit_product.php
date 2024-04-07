<?php
include "chack_login.php";
include "../config.php";
$pro_id = $_GET["pro_id"];
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("error" . mysqli_connect_error());
}
$sql = "SELECT * FROM product WHERE pro_id='$pro_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <!-- Include Tailwind CSS CDN or download and link locally -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100">
    <form action="productupdate_save.php" method="post" enctype="multipart/form-data" class="max-w-4xl mx-auto my-8 p-8 bg-white rounded shadow-md">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="mb-4">
                <label for="pro_id" class="block text-sm font-medium text-gray-600">รหัสสินค้า</label>
                <input type="text" class="mt-1 p-2 border rounded-md w-full" name="pro_id" id="imput_pro_id" value='<?php echo $row["pro_id"]; ?>'>
                <input type="hidden" name="old_pro_id" value='<?php echo $row["pro_id"]; ?>'>
            </div>
            <div class="mb-4">
                <label for="pro_name" class="block text-sm font-medium text-gray-600">ชื่อสินค้า</label>
                <input type="text" class="mt-1 p-2 border rounded-md w-full" name="pro_name" id="imput_pro_name" value='<?php echo $row["pro_name"]; ?>'>
            </div>
            <div class="mb-4">
                <label for="pro_detail" class="block text-sm font-medium text-gray-600">รายละเอียดสินค้า</label>
                <input type="text" class="mt-1 p-2 border rounded-md w-full" name="pro_detail" id="imput_pro_detail" value='<?php echo $row["pro_detail"]; ?>'>
            </div>
            <div class="mb-4">
                        <label for="costprice" class="block text-sm font-medium text-gray-600">ราคาต้นทุน</label>
                        <input type="text" name="costprice" id="costprice" placeholder="กรอกราคา" class="mt-1 p-2 w-full border rounded-md" value='<?php echo $row["costprice"]; ?>'>
                    </div>
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-600">ราคา</label>
                <input type="text" class="mt-1 p-2 border rounded-md w-full" name="price" id="imput_price" value='<?php echo $row["price"]; ?>'>
            </div>
            <div class="mb-4">
                <label for="amount_to_add" class="block text-sm font-medium text-red-600">เพิ่มจำนวนสินค้า</label>
                <input type="number" class="mt-1 p-2 border rounded-md w-full" name="amount_to_add" id="input_amount_to_add">
            </div>
            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-600">จำนวนสินค้าคงคลัง</label>
                <input type="text" class="mt-1 p-2 border rounded-md w-full" name="amount" id="imput_amount" value='<?php echo $row["amount"]; ?>'>
            </div>
            <div class="mb-4">
                <?php
                include "../config.php";
                $conn = mysqli_connect($servername, $username, $password, $dbname);
                if (!$conn) {
                    die("Error " . mysqli_connect_error());
                }
                $sql = "SELECT `type_id`, `type_name` FROM `type` WHERE 1";
                $result = mysqli_query($conn, $sql);
                ?>
                <label for="type_id" class="block text-sm font-medium text-gray-600">ประเภทสินค้า</label>
                <select class="mt-1 p-2 border rounded-md w-full" name="type_id" value="<?php echo $row["type_name"]; ?>">
                    <?php while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row["type_id"] . "'>" . $row["type_name"] . "</option>";
                    } ?>
                </select>
            </div>
            <div class="mb-4">
                <label for="exampleInputFile" class="block text-sm font-medium text-gray-600">File input</label>
                <div class="mt-1 p-2 border rounded-md w-full">
                    <input type="file" class="custom-file-input" id="exampleInputFile" name="myfile" onchange="PreviewImage();" value='<?php echo $row["img"]; ?>'>
                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                </div>
            </div>
            <div class="mb-4">
                <img class="product-image img-fluid" id="uploadPreview">
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
        </div>
    </form>
    <script>
        function PreviewImage() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("exampleInputFile").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("uploadPreview").src = oFREvent.target.result;
            }
        }
    </script>
</body>
</html>
