<?php
include "chack_login.php";
include "../config.php";

// เชื่อมต่อฐานข้อมูล
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
  die("Error " . mysqli_connect_error());
}

// คำสั่ง SQL สำหรับยอดขายรวม
$totalSalesQuery = "SELECT SUM(product.price * sale_relations.qty_ordered) AS totalSales
                   FROM sale_relations
                   JOIN product ON sale_relations.pro_id = product.pro_id";
$resultSales = mysqli_query($conn, $totalSalesQuery);
// Query to get the total price of all products
$totalPriceQuery = "SELECT SUM(price * amount) AS totalPrice FROM product";
$resultTotalPrice = mysqli_query($conn, $totalPriceQuery);
if (!$resultTotalPrice) {
  die("Error in SQL query: " . mysqli_error($conn));
}

// Fetch the total price
$rowTotalPrice = mysqli_fetch_assoc($resultTotalPrice);
$totalPrice = $rowTotalPrice['totalPrice'];

// คำสั่ง SQL สำหรับดึงข้อมูลสินค้า
$productDataQuery = "SELECT `pro_id`, `pro_name`, `pro_detail`, `price`, `amount`, `img`, `type_id` FROM `product` WHERE 1";
$resultProductData = mysqli_query($conn, $productDataQuery);

$topSellingProductsQuery = "SELECT `pro_name`, SUM(sale_relations.qty_ordered) AS totalSold
                            FROM product
                            JOIN sale_relations ON product.pro_id = sale_relations.pro_id
                            GROUP BY product.pro_id
                            ORDER BY totalSold DESC
                            LIMIT 5";

$resultTopSellingProducts = mysqli_query($conn, $topSellingProductsQuery);
// คำสั่ง SQL สำหรับดึงข้อมูลผู้ใช้ จำนวน 5 รายการ
$userDataQuery = "SELECT `user_no`, `user_email`, `user_name`,`user_password`, `image_name`, `image_type`, `image_data` FROM `users` LIMIT 5";
$resultUserData = mysqli_query($conn, $userDataQuery);

$userDataArray = array();
while ($row = mysqli_fetch_assoc($resultUserData)) {
  $userDataArray[] = $row;
}

// เช็คข้อผิดพลาด
if (!$resultProductData) {
  die("Error in SQL query: " . mysqli_error($conn));
}

$yourProductDataFromDatabase = array();
while ($row = mysqli_fetch_assoc($resultProductData)) {
  $yourProductDataFromDatabase[] = $row;
}

$rowSales = mysqli_fetch_assoc($resultSales);
$totalSales = $rowSales['totalSales'];

$countUsersQuery = "SELECT COUNT(*) as totalUsers FROM users";
$resultUsers = mysqli_query($conn, $countUsersQuery);


if (!$resultUsers) {
  die("Error in SQL query: " . mysqli_error($conn));
}

$topSellingProductsData = array();
while ($row = mysqli_fetch_assoc($resultTopSellingProducts)) {
  $topSellingProductsData[] = $row;
}

$rowUsers = mysqli_fetch_assoc($resultUsers);
$totalUsers = $rowUsers['totalUsers'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - E-commerce</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
  /* ปรับสีตัวอักษรในกราฟ */
  .chart-labels {
    color: #000; /* สีที่ต้องการ */
  }
  </style>
</head>

<body class="">
  <div class="container mx-auto">
    <header >
      <?php include 'navadmin.php' ?>
    </header>
  </div>
  <div class="container mx-auto">
    <div class="main-content mt-10">
      <section>
        <h1 class="text-3xl font-bold mb-6 text-center">Admin Dashboard</h1>
      </section>

<div class="flex items-stretch mb-10">
  <div class="w-1/2 mr-2">
    <h1 class="font-bold text-center">กราฟคลังสินค้า</h1>
    <canvas id="productChartLeft" class="w-full h-48"></canvas>
  </div>
  <div class="w-1/2 ml-2">
    <h1 class="font-bold text-center">กราฟสินค้าขายดี</h1>
    <canvas id="topSellingChart" class="w-full h-48"></canvas>
  </div>
</div>

      <div class="quick-links flex justify-around mb-10">
        <a href="user_Management.php" class="  text-lg bg-red-100 px-4 py-2 rounded transition duration-300 hover:bg-white">User Management</a>
        <a href="product-management.php" class="  text-lg bg-red-100 px-4 py-2 rounded transition duration-300 hover:bg-white">จัดการคลังสินค้า</a>
        <a href="order-management.php" class="  text-lg bg-red-100 px-4 py-2 rounded transition duration-300 hover:bg-white">รายการคำสั่งซื้อ</a>
        <a href="productChart.php" class="  text-lg bg-red-100 px-4 py-2 rounded transition duration-300 hover:bg-white">กราฟโดยละเอียด</a>
        <a href="edit_head.php" class="  text-lg bg-red-100 px-4 py-2 rounded transition duration-300 hover:bg-white">แก้ไขส่วนหัวเว็บ</a>
        <a href="edit_payment.php" class="  text-lg bg-red-100 px-4 py-2 rounded transition duration-300 hover:bg-white">แก้ไขการชำระเงิน</a>
      </div>

      <div class="w-4/5 mx-auto">
        <canvas id="productChart" class="w-full h-64"></canvas>
      </div>

      <section id="user-management" class="admin-section mb-10">
        <a  class="text-2xl font-bold mb-4">User Management</a>
        <div class="user-list overflow-y-auto">
          <table class="w-full">
            <thead>
              <tr>
                <th class="py-2 text-left">User ID</th>
                <th class="py-2 text-left">Name</th>
                <th class="py-2 text-left">Email</th>
                <th class="py-2 text-left">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($userDataArray as $userData) : ?>
                <tr>
                  <td class="py-2 text-left"><?php echo $userData['user_no']; ?></td>
                  <td class="py-2 text-left"><?php echo $userData['user_name']; ?></td>
                  <td class="py-2 text-left"><?php echo $userData['user_email']; ?></td>
                  <td class="py-2 text-left">
                    <a href="edit_user.php?user_id=<?php echo $user['user_no']; ?>" class="text-cyan-500 underline decoration-indigo-500">Edit</a>
                    <a href="delete_user.php?user_id=<?php echo $user['user_no']; ?>" class="text-cyan-500 underline decoration-indigo-500">Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
document.addEventListener('DOMContentLoaded', function() {
    // ดึงข้อมูลจากฐานข้อมูล (ในที่นี้ให้นำข้อมูลมาจาก PHP หรือ API)
    const productData = <?php echo json_encode($yourProductDataFromDatabase); ?>;

    // สร้างข้อมูลสำหรับกราฟ
    const labels = productData.map(product => product.pro_name);
    const data = productData.map(product => product.amount);

    // กำหนด canvas element
    const ctx = document.getElementById('productChartLeft').getContext('2d');

    // สร้างสีสำหรับกราฟแท่ง
    const colors = [
      'rgba(255, 99, 132, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(255, 206, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(153, 102, 255, 0.2)',
    ];
    const borderColors = [
      'rgba(255, 99, 132, 1)',
      'rgba(54, 162, 235, 1)',
      'rgba(255, 206, 86, 1)',
      'rgba(75, 192, 192, 1)',
      'rgba(153, 102, 255, 1)',
    ];

    // สร้างกราฟแท่ง
    const myChart = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: labels,
        datasets: [{
          label: 'จำนวนสินค้าคงเหลือ',
          data: data,
          backgroundColor: colors,
          borderColor: borderColors,
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        },
        plugins: {
          legend: {
            labels: {
              font: {
                size: 14, // ขนาดตัวอักษร
                family: 'Arial', // แบบอักษร
              },
              color: 'black' // สีตัวอักษร
            }
          }
        }
      }
    });
});
 document.addEventListener('DOMContentLoaded', function() {
    // ดึงข้อมูลจากฐานข้อมูล (ในที่นี้ให้นำข้อมูลมาจาก PHP หรือ API)
    const topSellingProductsData = <?php echo json_encode($topSellingProductsData); ?>;

    // สร้างข้อมูลสำหรับกราฟ
    const labelsTop = topSellingProductsData.map(product => product.pro_name);
    const dataTop = topSellingProductsData.map(product => product.totalSold);
    
    // สร้างสีสำหรับกราฟ
    const colors = [
      'rgba(255, 99, 132, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(255, 206, 86, 0.2)',
      'rgba(75, 192, 192, 0.2)',
      'rgba(153, 102, 255, 0.2)',
    ];
    const borderColors = [
      'rgba(255, 99, 132, 1)',
      'rgba(54, 162, 235, 1)',
      'rgba(255, 206, 86, 1)',
      'rgba(75, 192, 192, 1)',
      'rgba(153, 102, 255, 1)',
    ];

    // กำหนด canvas element
    const ctxTop = document.getElementById('topSellingChart').getContext('2d');

    // สร้างกราฟวงกลม
    const myChartTop = new Chart(ctxTop, {
      type: 'doughnut', // เปลี่ยนเป็น doughnut
      data: {
        labels: labelsTop,
        datasets: [{
          label: 'สินค้าที่ขายได้มากที่สุด',
          data: dataTop,
          backgroundColor: colors,
          borderColor: borderColors,
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        },
        plugins: {
          legend: {
            labels: {
              font: {
                size: 14, // ขนาดตัวอักษร
                family: 'Arial', // แบบอักษร
              },
              color: 'black' // สีตัวอักษร
            }
          }
        }
      }
    });
  });

</script>
</body>

</html>