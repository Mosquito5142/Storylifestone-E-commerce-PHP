<?php
include "chack_login.php";
include '../config.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-8">Add New Product</h1>
        <!-- form start -->
        <form action="product_insert.php" method="post" enctype="multipart/form-data" class="bg-white p-8 rounded shadow-md">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <div class="mb-4">
                        <label for="pro_id" class="block text-sm font-medium text-gray-600">รหัสสินค้า</label>
                        <input type="text" name="pro_id" id="imput_pro_id" placeholder="กรอก ID" class="mt-1 p-2 w-full border rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="pro_name" class="block text-sm font-medium text-gray-600">ชื่อสินค้า</label>
                        <input type="text" name="pro_name" id="imput_pro_name" placeholder="กรอกชื่อ" class="mt-1 p-2 w-full border rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="pro_detail" class="block text-sm font-medium text-gray-600">รายละเอียดสินค้า</label>
                        <input type="text" name="pro_detail" id="imput_pro_detail" placeholder="กรอกรายละเอียดสินค้า" class="mt-1 p-2 w-full border rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="costprice" class="block text-sm font-medium text-gray-600">ราคาต้นทุน</label>
                        <input type="text" name="costprice" id="costprice" placeholder="กรอกราคา" class="mt-1 p-2 w-full border rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-600">ราคา</label>
                        <input type="text" name="price" id="imput_price" placeholder="กรอกราคา" class="mt-1 p-2 w-full border rounded-md">
                    </div>
                    <div class="mb-4">
                        <label for="qty_on_hand" class="block text-sm font-medium text-gray-600">จำนวนสินค้า</label>
                        <input type="text" name="qty_on_hand" id="imput_qty_on_hand" placeholder="กรอกจำนวนสินค้า" class="mt-1 p-2 w-full border rounded-md">
                    </div>
                </div>
                <div>
                    <div class="mb-4">
                        <label for="type_id" class="block text-sm font-medium text-gray-600">ประเภทสินค้า</label>
                        <?php
                        include "../config.php";
                        $conn = mysqli_connect($servername, $username, $password, $dbname);
                        if (!$conn) {
                            die("Error " . mysqli_connect_error());
                        }
                        $sql = "SELECT `type_id`, `type_name` FROM `type` WHERE 1";
                        $result = mysqli_query($conn, $sql);
                        ?>
                        <select name="type_id" class="mt-1 p-2 w-full border rounded-md">
                            <?php while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='" . $row["type_id"] . "'>" . $row["type_name"] . "</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="exampleInputFile" class="block text-sm font-medium text-gray-600">File input</label>
                        <div class="flex items-center">
                            <label class="w-64 flex items-center px-2 py-1 bg-white text-gray-800 rounded-md shadow-md border border-gray-300 cursor-pointer">
                                Choose file
                                <input type="file" class="hidden" id="exampleInputFile" name="myfile" onchange="PreviewImage();">
                            </label>
                            <span class="ml-2" id="file-chosen">No file chosen</span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <img class="product-image w-full  object-cover rounded-md" id="uploadPreview">
                    </div>
                </div>
            </div>
            <div class="mt-8">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
            </div>
        </form>
    </div>
    <script>
        function PreviewImage() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("exampleInputFile").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("uploadPreview").src = oFREvent.target.result;
            }

            // Display the chosen file name
            var fileName = document.getElementById("exampleInputFile").files[0].name;
            document.getElementById("file-chosen").innerText = fileName;
        }
        function validateForm() {
        var proId = document.getElementById("imput_pro_id").value;
        var proName = document.getElementById("imput_pro_name").value;
        var proDetail = document.getElementById("imput_pro_detail").value;
        var price = document.getElementById("imput_price").value;
        var qtyOnHand = document.getElementById("imput_qty_on_hand").value;
        var fileInput = document.getElementById("exampleInputFile").value;

        if (proId === "" || proName === "" || proDetail === "" || price === "" || qtyOnHand === "" || fileInput === "") {
            alert("Please fill out all fields");
            return false; // Prevent form submission
        }

        return true; // Allow form submission
    }

    // Attach the validation function to the form's onsubmit event
    document.forms[0].onsubmit = validateForm;
    </script>
</body>

</html>
