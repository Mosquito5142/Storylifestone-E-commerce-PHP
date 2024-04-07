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
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Website</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="">

    <div class="container mx-auto">
        <header>
            <?php include 'comp/navnew.php' ?>
        </header>
    </div>

    <div class="container mx-auto mt-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="returnCart">
                <h1 class="text-2xl font-bold mb-4">รายการสินค้า</h1>
                <div class="list grid gap-4">
                    <?php foreach ($rows as $row) { ?>
                        <div class="item grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-4">
                            <img src="img/<?= $row['img'] ?>" class="w-full object-cover rounded md:col-span-1 lg:col-span-1 xl:col-span-1">
                            <div class="info md:col-span-2 lg:col-span-2 xl:col-span-2">
                                <div class="name"><?= $row['pro_name'] ?></div>
                                <div class="price"><?= '$' . $row['price'] ?> / ต่อ 1 ชิ้น</div>
                            </div>
                            <div class="quantity"><?= $row['qty_ordered'] ?> ชิ้น</div>
                            <div class="returnPrice"><?= '$' . ($row['price'] * $row['qty_ordered']) ?></div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                <h1 class="text-2xl font-bold mb-4">ที่อยู่จัดส่ง</h1>
                <div class="group mb-8">
                    <div id="address" class="p-2 text-lg"><?= $address ?></div>
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
                    <div class="form-group mb-4">
                        <h1>หลักฐานการชำระเงิน</h1>
                        <?php
                        if (!empty($rows[0]["image_data"])) {
                            echo '<img id="uploadPreview" class="product-image img-fluid rounded-circle" src="data:image/jpeg;base64,' . base64_encode(end($rows)["image_data"]) . '"">';
                        } else {
                            echo '<img id="uploadPreview" class="product-image img-fluid">';
                        }
                        ?>
                    </div>
                    <br>
                    <div class="form-group mb-4">
                        <h1>หลักฐานการส่งสินค้า</h1>
                        <?php
                        if (!empty($rows[0]["image_data"])) {
                            echo '<img id="uploadPreview" class="product-image img-fluid rounded-circle" src="data:image/jpeg;base64,' . base64_encode(end($rows)["delivery_image_data"]) . '"">';
                        } else {
                            echo '<img id="uploadPreview" class="product-image img-fluid">';
                        }
                        ?>
                    </div>
            </div>
        </div>
        <?php include 'comp/footer.php' ?>
    </div>
</body>

</html>
