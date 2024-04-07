<?php
include "config.php";
session_start();
include 'users/checklogin.php';

$ids = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

$sql = "SELECT sales_orders.*, sale_relations.*, product.pro_name, product.price, product.img, users.user_name, sales_orders.address
        FROM sales_orders
        JOIN sale_relations ON sales_orders.so_no = sale_relations.so_no
        JOIN product ON sale_relations.pro_id = product.pro_id
        JOIN users ON sales_orders.user_no = users.user_no
        WHERE sales_orders.so_no = '$ids'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error in SQL query: " . mysqli_error($conn));
}

// Fetch all rows into an array
$rows = [];
while ($row = mysqli_fetch_assoc($result)) {
    $rows[] = $row;
}

// Fetch the first row to get user_name outside the loop
if (!empty($rows)) {
    $address = $rows[0]['address'];
}

// Calculate total price
$totalPrice = 0;
foreach ($rows as $row) {
    $totalPrice += $row['price'] * $row['qty_ordered'];
}

// Add shipping cost
$shippingCost = 50;
$totalPriceWithShipping = $totalPrice + $shippingCost;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Website</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="bg-gray-100">
<div class="container mx-auto ">
      <header>
        <?php include 'comp/navnew.php' ?>
       <div class="head-image">
  <a>
    <img class="w-full h-full object-cover" src="img/payment/payment.png?<?php echo time(); ?>" alt="#" />
  </a>
</div>
      </header>
    </div>

    <div class="container mx-auto mt-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="returnCart">
                <h1 class="text-2xl font-bold mb-4">รายการสินค้า</h1>
                <div class="grid gap-4">
                    <?php foreach ($rows as $row) { ?>
                        <div class="item grid grid-cols-3 gap-4 bg-white p-4 rounded-lg shadow-md">
                            <img src="img/<?= $row['img'] ?>" class="w-full object-cover rounded">
                            <div class="info col-span-2">
                                <div class="name"><?= $row['pro_name'] ?></div>
                                <div class="price"><?= '$' . $row['price'] ?> / ต่อ 1 ชิ้น</div>
                            </div>
                            <div class="quantity">จำนวน <?= $row['qty_ordered'] ?> ชิ้น</div>
                            <div class="returnPrice"><?= '$' . ($row['price'] * $row['qty_ordered']) ?></div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                <h1 class="text-2xl font-bold mb-4">ที่อยู่จัดส่ง</h1>
                <div class="group mb-8">
                    <div id="address" class=" p-2 text-lg"><?= $address ?></div>
                </div>

                <div class="return mb-8">
                    <div class="row flex justify-between items-center">
                        <div>ราคารวมสินค้า</div>
                        <div class="totalQuantity"><?= $totalPrice ?></div>
                    </div>
                    <div class="row flex justify-between items-center">
                        <div>ค่าส่งสินค้า</div>
                        <div class="totalQuantity"><?= $shippingCost ?></div>
                    </div>
                    <div class="row flex justify-between items-center">
                        <div>Total Price</div>
                        <div class="ทั้งหมด"><?= '$' . $totalPriceWithShipping  ?></div>
                    </div>
                </div>

                <form action="payment_update.php" method="post" enctype="multipart/form-data" class="mb-8">
                    <input type="hidden" name="so_no" value="<?= $ids ?>">
                    <input type="hidden" name="pro_name" value="<?= $row['pro_name'] ?>">
                    <input type="hidden" name="total" value="<?= '$' . $totalPriceWithShipping  ?>">
                    <div class="custom-file mb-4">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="myfile" onchange="PreviewImage();">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                    </div>
                    <div class="form-group mb-4">
                        <?php
                        if (!empty($rows[0]["image_data"])) {
                            echo '<img id="uploadPreview" class="product-image img-fluid rounded-circle" src="data:image/jpeg;base64,' . base64_encode(end($rows)["image_data"]) . '" width="100px">';
                        } else {
                            echo '<img id="uploadPreview" class="product-image img-fluid">';
                        }
                        ?>
                    </div>

                    <div class="delete-button flex justify-center items-center mt-4">
                        <button class="bg-gray-700 text-white px-6 py-3 rounded-full font-bold hover:bg-gray-800" type="submit">แจ้งชำระเงิน</button>
                    </div>
                </form>

                <div class="delete-button flex justify-center items-center mt-4">
                    <!-- เพิ่มปุ่มลบและใส่ JavaScript function -->
                    <a href="delete_order_item.php?so_no=<?= $row['so_no'] ?>" onclick='return chkConfirm();'>
                        <button class='bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700'>ลบการสั่งซื้อ</button>
                    </a>
                </div>
            </div>
        </div>
        <?php include 'comp/footer.php' ?>
    </div>

    <script>
        function PreviewImage() {
            var files = document.getElementById("exampleInputFile").files;
            var previewImage = document.getElementById("uploadPreview");

            if (files.length > 0) {
                var lastImage = files[files.length - 1];
                var reader = new FileReader();

                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                };

                reader.readAsDataURL(lastImage);
            } else {
                previewImage.src = ''; // ลบรูปภาพที่แสดงออก
            }
        }
    </script>

</body>

</html>
