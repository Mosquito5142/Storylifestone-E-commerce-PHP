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
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">  
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div class="head_bg bg-gray-100">
        <div class="container mx-auto">
            <header>
                <?php include 'comp/navnew.php' ?>
            </header>
        </div>
    </div>
    <div class="container mx-auto">
        <div class="main-content">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h1 class="text-2xl font-semibold mb-4">รายการสินค้า</h1>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php
                        foreach ($rows as $row) {
                        ?>
                            <div class="bg-white p-4 rounded-lg shadow-md">
                                <img src="img/<?= $row['img'] ?>" class="w-full h-40 object-cover" alt="<?= $row['pro_name'] ?>">
                                <div class="mt-4">
                                    <div class="text-lg font-semibold"><?= $row['pro_name'] ?></div>
                                    <div class="text-sm"><?= '$' . $row['price'] ?> / ต่อ 1 ชิ้น</div>
                                </div>
                                <div class="mt-2">จำนวน <?= $row['qty_ordered'] ?> ชิ้น</div>
                                <div class="mt-2"><?= '$' . ($row['price'] * $row['qty_ordered']) ?></div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="bg-gray-100 p-4 rounded-lg shadow-md">
                    <h1 class="text-2xl font-semibold mb-4">ที่อยู่จัดส่ง</h1>
                    <div class="mt-4">
                        <div id="address" class="border rounded p-2 text-lg"><?= $address ?></div>
                    </div>
                    <div class="mt-4">
                        <div class="flex justify-between items-center">
                            <div>ราคารวมสินค้า</div>
                            <div><?= $totalPrice ?></div>
                        </div>
                        <div class="flex justify-between items-center">
                            <div>ค่าส่งสินค้า</div>
                            <div><?= $shippingCost ?></div>
                        </div>
                        <div class="flex justify-between items-center">
                            <div>Total Price</div>
                            <div><?= '$' . $totalPriceWithShipping ?></div>
                        </div>
                    </div>
                    <a href="confirm.php?so_no=<?php echo htmlspecialchars($ids, ENT_QUOTES, 'UTF-8'); ?>">
                        <button class="w-full mt-4 bg-gray-700 text-white py-2 px-4 rounded">ยืนยันการสั่งซื้อ</button>
                    </a>
                    <div class="mt-4">
                        <a href="delete_order_item.php?so_no=<?= $row['so_no'] ?>" onclick='return chkConfirm();'>
                            <button class='w-full bg-red-500 text-white py-2 px-4 rounded hover:bg-red-700'>ลบการสั่งซื้อ</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
