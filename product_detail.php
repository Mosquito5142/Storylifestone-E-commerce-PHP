<?php
include "config.php";
session_start();

// รับค่า pro_id จาก URL
$ids = $_GET['pro_id'];

// ดึงข้อมูลของสินค้าปัจจุบัน
$sql = "SELECT * FROM product, type WHERE product.type_id=type.type_id AND product.pro_id='$ids'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

// รับค่า type_id ของสินค้าปัจจุบัน
$type_id = $row['type_id'];

// คำสั่ง SQL เพื่อดึงข้อมูลสินค้าที่เกี่ยวข้อง
$related_sql = "SELECT * FROM product WHERE type_id='$type_id' AND pro_id != '$ids' LIMIT 4";
$related_result = mysqli_query($conn, $related_sql);
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="bg-gray-100">
  <div class="head_bg">
    <div class="container mx-auto">
      <header>
        <?php include 'comp/navnew.php' ?>
      </header>
    </div>
  </div>
  <div class="container mx-auto">
    <div class="main-content">
      <div class="flex flex-col md:flex-row justify-between">
        <div class="p-8">
          <img class="w-100 h-64 md:h-96 object-cover rounded-lg" src="img/<?= $row['img'] ?>" alt="<?= $row['pro_name'] ?>" />
        </div>
        <div class="w-full md:w-1/2 p-8">
          <div class="flex flex-col justify-between">
            <h2 class="text-2xl font-bold"><?= $row['pro_name'] ?></h2>
            <p class="text-gray-700">ประเภทสินค้า : <?= $row['type_name'] ?></p>
            <p class="text-gray-700"><?= $row['pro_detail'] ?></p>
            <p class="mt-4 text-gray-700 <?= $row['amount'] == 0 ? 'text-red-500' : '' ?>">คงเหลือ: <?= $row['amount'] ?></p>
          </div>
          <div class="pt-10">
            <?php if ($row['amount'] > 0) : ?>
              <a class="bg-black text-white font-bold py-2 px-4 rounded-full hover:bg-gray-800" href="order.php?id=<?= $row['pro_id'] ?>">
                Add to Cart - <?= $row['price'] ?> บาท
              </a>
            <?php else : ?>
              <p class="text-red-500">Out of Stock</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <div class="related-products">
      <h2 class="text-xl font-semibold mt-10 mb-4">สินค้าที่เกี่ยวข้อง</h2>
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php while ($related_row = mysqli_fetch_array($related_result)) : ?>
          <div class="product-card">
            <a href="product_detail.php?pro_id=<?= $related_row['pro_id'] ?>">
              <img class="w-full h-48 object-cover" src="img/<?= $related_row['img'] ?>" alt="<?= $related_row['pro_name'] ?>">
              <div class="mt-2">
                <h3 class="text-lg font-semibold"><?= $related_row['pro_name'] ?></h3>
                <p class="text-gray-700">Price: <?= $related_row['price'] ?> บาท</p>
              </div>
            </a>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
    <?php include 'comp/footer.php' ?>
  </div>
</body>

</html>
