<?php
include "chack_login.php";
include '../config.php';
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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .checkoutLayout {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 50px;
            padding: 20px;
        }

        .checkoutLayout .right {
            background-color: black;
            border-radius: 20px;
            padding: 40px;
            color: #fff;
        }

        .checkoutLayout .right .form {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            border-bottom: 1px solid #7a7fe2;
            padding-bottom: 20px;
        }

        .checkoutLayout .form h1,
        .checkoutLayout .form .group:nth-child(-n+3) {
            grid-column-start: 1;
            grid-column-end: 3;
        }

        .checkoutLayout .form input,
        .checkoutLayout .form select {
            width: 100%;
            padding: 10px 20px;
            box-sizing: border-box;
            border-radius: 20px;
            margin-top: 10px;
            border: none;
            background-color: gray;
            color: #fff;
        }

        .checkoutLayout .right .return .row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .checkoutLayout .right .return .row div:nth-child(2) {
            font-weight: bold;
            font-size: x-large;
        }

        .buttonCheckout {
            width: 100%;
            height: 40px;
            border: none;
            border-radius: 20px;
            background-color: gray;
            margin-top: 20px;
            font-weight: bold;
            color: #fff;


        }

        .returnCart h1 {
            border-top: 1px solid #eee;
            padding: 20px 0;
        }

        .returnCart .list .item img {
            height: 150px;
            width: 150px;
        }

        .returnCart .list .item {
            display: grid;
            grid-template-columns: 80px 1fr 50px 80px;
            align-items: center;
            gap: 20px;
            margin-bottom: 30px;
            padding: 0 10px;
            box-shadow: 0 10px 20px #5555;
            border-radius: 20px;
        }

        .returnCart .list .item .name,
        .returnCart .list .item .returnPrice {
            font-size: large;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container mx-auto">
        <header>
            <?php include 'navadmin.php' ?>
        </header>
    </div>
    <div class="container mx-auto">
        <div class="main-content">
            <div class="checkoutLayout">
                <div class="returnCart">
                    <h1>รายการสินค้า</h1>
                    <form action="confirm_sale.php" method="post" enctype="multipart/form-data">
                    <div class="list">
                        <?php
                        foreach ($rows as $row) {
                        ?>
                            <div class="item">
                                <img src="../img/<?= $row['img'] ?>">
                                <div class="info">
                                    <div class="name"><?= $row['pro_name'] ?></div>
                                    <div class="price"><?= '$' . $row['price'] ?> / ต่อ 1 ชิ้น</div>
                                </div>
                                <div class="quantity">จำนวน <?= $row['qty_ordered'] ?> ชิ้น</div>
                                <div class="returnPrice"><?= '$' . ($row['price'] * $row['qty_ordered']) ?></div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>

                <div class="right">
                    <h1>ที่อยู่จัดส่ง</h1>

                    <div class="form">
                        <div class="group">
                            <br>
                            <div id="address" class="border rounded bg-gray-800 p-2 text-lg text-white"><?= $address ?></div>

                        </div>
                    </div>
                    <div class="return">
                        <div class="row">
                            <div>ราคารวมสินค้า</div>
                            <div class="totalQuantity"><?= $totalPrice ?></div>
                        </div>
                        <div class="row">
                            <div>ค่าส่งสินค้า</div>
                            <div class="totalQuantity"><?= $shippingCost ?></div>
                        </div>
                        <div class="row">
                            <div>Total Price</div>
                            <div class="ทั้งหมด"><?= '$' . $totalPriceWithShipping  ?></div>
                        </div>
                        <br>
                            <input type="hidden" name="so_no" value="<?= $ids ?>">
                            <div>
                                หลักฐานการชำระเงิน
                                <?php echo '<img class="img-circle elevation-2" src="data:image/jpeg;base64,' . base64_encode($row['image_data']) . '" >'; ?>
                            </div>
                            <button class="buttonCheckout bg-blue-300" type="submit">การสั่งซื้อสำเร็จ</button>
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
        </div>
    </div>
</body>

</html>