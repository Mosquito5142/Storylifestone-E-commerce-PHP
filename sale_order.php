<?php
session_start();
include "config.php";
$result = mysqli_query($conn, '
  SELECT AUTO_INCREMENT
  FROM information_schema.TABLES
  WHERE TABLE_SCHEMA = "4448917_datadb"
  AND TABLE_NAME = "sales_orders"
');
$row = mysqli_fetch_array($result);
$next_so_no = $row["AUTO_INCREMENT"];
$next_so_no = str_pad((string)$next_so_no, 5, "0", STR_PAD_LEFT);
$currentDate = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Website</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="font-sans bg-gray-100">
    <div class="head_bg bg-gray-100">
        <div class="container mx-auto">
            <header>
                <?php include 'comp/navnew.php' ?>
            </header>
        </div>
    </div>
    <br><br><br>
    <div class="container mx-auto">
        <div class="main-content flex">

            <!-- ส่วนที่แสดงรายการสินค้า -->
            <div class="w-full md:w-2/3 mr-10">
                <?php
                $i = 0;
                $sumprice = 0;
                $EMS = 50;
                while ($i <= $_SESSION["intLine"]) {
                    if (isset($_SESSION["strProductID"][$i]) && $_SESSION["strProductID"][$i] !== "") {
                        // ดึงข้อมูลสินค้าจากฐานข้อมูลหรือ array อื่น ๆ
                        $product_id = $_SESSION["strProductID"][$i];
                        $quantity = $_SESSION["strQty"][$i];

                        $sql = "SELECT * FROM product ,type where product.type_id=type.type_id and pro_id='" . $product_id . "'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_array($result);
                        $subtotal = $quantity * $row['price'];
                        $sumprice += $subtotal;
                ?>
                        <div class="flex items-start gap-7 mb-6" style="position: relative;">
                            <img class="w-32 h-32 bg-gray-400" src="img/<?= $row['img'] ?>" alt="<?= $row['pro_name'] ?>">
                            <div class="flex flex-col items-start gap-7">
                                <div class="ttext-black text-sm"><?= $row['pro_name'] ?></div>
                                <div class="text-black text-sm"><?= 'จำนวน: ' . $quantity ?> ชิ้น</div>
                                <div class="text-black text-2xl font-semibold"><?= '$' . $row['price'] ?></div>
                            </div>
                        </div>
                <?php
                    }
                    $i++;
                    $total = $sumprice + $EMS;
                }
                ?>

            </div>

            <!-- ส่วนที่แสดงรายละเอียดการจัดส่ง -->
            <div class="w-full md:w-1/3 pl-6">

                <form action="addsale_order.php" method="post" onsubmit="return validateAddressForm()">
                    <input type="hidden" name="so_no" value="<?= $next_so_no ?>">
                    <div class="border-t border-gray-400 mt-4 pt-4">
                        <div class="text-black text-xl font-semibold mb-4">ที่อยู่จัดส่ง</div>

                        <!-- Form for entering shipping information -->
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="first_name" class="text-sm text-gray-600">ชื่อ</label>
                                <input type="text" name="first_name" id="first_name" class="border p-2 w-full">
                            </div>
                            <div class="mb-4">
                                <label for="last_name" class="text-sm text-gray-600">นามสกุล</label>
                                <input type="text" name="last_name" id="last_name" class="border p-2 w-full">
                            </div>
                            <div class="mb-4">
                                <label for="tel" class="text-sm text-gray-600">โทร</label>
                                <input type="text" name="tel" id="tel" class="border p-2 w-full">
                            </div>
                            <div class="mb-4">
                                <label for="address" class="text-sm text-gray-600">ที่อยู่</label>
                                <input type="text" name="address" id="address" class="border p-2 w-full">
                            </div>
                            <div class="mb-4">
                                <label for="district" class="text-sm text-gray-600">ตำบล</label>
                                <input type="text" name="district" id="district" class="border p-2 w-full">
                            </div>
                            <div class="mb-4">
                                <label for="canton" class="text-sm text-gray-600">อำเภอ</label>
                                <input type="text" name="canton" id="canton" class="border p-2 w-full">
                            </div>
                            <div class="mb-4">
                                <label for="county" class="text-sm text-gray-600">จังหวัด</label>
                                <input type="text" name="county" id="county" class="border p-2 w-full">
                            </div>
                            <div class="mb-4">
                                <label for="postal" class="text-sm text-gray-600">รหัสไปรษณีย์</label>
                                <input type="text" name="postal" id="postal" class="border p-2 w-full">
                            </div>
                            <!-- Add more fields as needed -->
                        </div>

                        <div class="flex justify-end mt-4">
                            <button type="submit" class="bg-black text-white py-2 px-4 rounded">สั่งซื้อสินค้า</button>
                        </div>
                    </div>
                </form>

                <div class="border-t border-black my-4"></div>

                <div class="flex justify-between items-center">
                    <div>
                        <div class="text-black text-xl font-semibold">ค่าจัดส่ง</div>
                        <div class="text-black text-xl font-semibold">รวม</div>
                    </div>
                    <div>
                        <div class="text-black text-xl font-semibold"><?= '฿' . $EMS ?> บาท</div>
                        <div class="text-black text-xl font-semibold"><?= '฿' . $total ?> บาท</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateAddressForm() {
            var firstName = document.getElementById("first_name").value;
            var lastName = document.getElementById("last_name").value;
            var tel = document.getElementById("tel").value;
            var address = document.getElementById("address").value;
            var district = document.getElementById("district").value;
            var canton = document.getElementById("canton").value;
            var county = document.getElementById("county").value;
            var postal = document.getElementById("postal").value;

            if (firstName === "" || lastName === "" || tel === "" || address === "" || district === "" || canton === "" || county === "" || postal === "") {
                alert("Please fill in all fields.");
                return false;
            }

            if (isNaN(tel)) {
                alert("Phone number must be a number.");
                return false;
            }

            if (isNaN(postal) || postal.length !== 5) {
                alert("Postal code must be a 5-digit number.");
                return false;
            }

            return true;
        }
    </script>
</body>

</html>