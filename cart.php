<?php
session_start();
include "config.php";
include 'users/checklogin.php';
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Error " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Website</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="">

    <div class="container mx-auto">
        <header>
            <?php include 'comp/navnew.php' ?>
        </header>
    </div>

    <div class="container mx-auto flex justify-center items-center mt-10">
        <div class="w-3/4">
            <div class="text-2xl font-bold mb-4">Your Cart</div>

            <?php
            $sumprice = 0;
            $i = 0;
            while ($i <= $_SESSION["intLine"]) {
                if (isset($_SESSION["strProductID"][$i]) && $_SESSION["strProductID"][$i] !== "") {
                    $product_id = $_SESSION["strProductID"][$i];
                    $quantity = $_SESSION["strQty"][$i];

                    $sql = "SELECT * FROM product, type WHERE product.type_id = type.type_id AND pro_id='" . $product_id . "'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_array($result);
                    $amount = $row['amount'];

                    $subtotal = $quantity * $row['price'];
                    $sumprice += $subtotal;
            ?>
                    <form action="sale_order.php" method="post">
                        <input type="hidden" name="so_no" value="<?= $next_so_no ?>">
                        <div class="cart flex gap-7 py-3">
                            <img class="w-32 h-32 bg-gray-300" src="img/<?= $row['img'] ?>" alt="<?= $row['pro_name'] ?>">
                            <div class="flex-1 flex flex-col gap-4">
                                <a href="product_detail.php?pro_id=<?= $row['pro_id'] ?>" class="text-black text-2xl font-semibold leading-7 break-words"><?= $row['pro_name'] ?></a>
                                <div class="flex items-center">
                                    <?php if ($quantity > 1) : ?>
                                        <a class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-1 px-2 border rounded-l" href="disorder.php?id=<?= $row['pro_id'] ?>">-</a>
                                    <?php endif; ?>
                                    <div class="text-black text-sm font-normal leading-5 break-words">จำนวน: <?= $quantity ?></div><?php if ($quantity > $amount) : ?><h2 class="text-red-500"> ***จำนวนสินค้าไม่พอ***</h2><?php endif; ?>
                                    <?php if ($quantity < $amount) : ?>
                                    <a class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-1 px-2 border rounded-r" href="order.php?id=<?= $row['pro_id'] ?>">+</a>
                                <?php endif; ?>

                                </div>
                                <div>ราคา <?= $row['price'] ?> ต่อชิ้น</div>
                                <div class="text-black text-2xl font-semibold leading-7 break-words">รวม <?= $subtotal ?> บาท</div>
                            </div>
                            <div class="flex flex-col">
                                <a href="pro_delete.php?Line=<?= $i ?>" class="text-red-500 hover:underline">ลบออกจากตะกร้า</a>
                            </div>
                        </div>
            <?php
                }
                $i++;
            }
            ?>
            </div>
        
        <div class="cart gap-7">
                <div>
                    <div class="text-2xl font-semibold leading-7 break-words">
                        ราคารวม
                        <div class="flex justify-between">
                            <div class="text-sm font-normal leading-10 break-words ">รวมทั้งหมด</div>
                            <div class="text-sm font-normal leading-10 break-words "><?= $sumprice ?> บาท</div>
                        </div>
                    </div>
                    <div>
                        <button type="submit" name="submitOrder" class="text-center text-white text-base font-semibold leading-5 break-words bg-gray-900 border border-gray-900 w-48 h-12 mt-4">สั่งซื้อ</button>
                    </div>
                </div>
            </div>
            </form>
            
    </div>

</body>

</html>
