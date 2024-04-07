<?php
include "chack_login.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Website</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto">
        <header>
            <?php include 'navadmin.php' ?>
        </header>
    </div>
    <div class="container mx-auto">
        <div class="main-content mt-10">
            <h1> ตรวจสอบคำสั่งซื้อ</h1>

            <!-- Dropdown filter -->
            <label for="orderStatus" class="block mt-4 text-sm font-medium text-gray-700">Filter by Order Status:</label>
            <select id="orderStatus" name="orderStatus" class="block w-full mt-1 p-2 border border-gray-300 rounded-md">
                <option value="รอตรวจสอบ">ตัวเลือกแสดงผล</option>
                <option value="รอตรวจสอบ">รอตรวจสอบ</option>
                <option value="กำลังจัดส่ง">กำลังจัดส่ง</option>
                <option value="จัดส่งสินค้าเรียบร้อย">จัดส่งสินค้าเรียบร้อย</option>
            </select>

            <div class="overflow-x-auto mt-4">
                <table class="min-w-full bg-white border border-gray-300">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="py-2">เลขที่ใบสั่งซื้อ</th>
                            <th class="py-2">วันที่สั่งซื้อ</th>
                            <th class="py-2">ชื่อผู้ซื้อ</th>
                            <th class="py-2">ที่อยู่</th>
                            <th class="py-2">ข้อมูลการสั่งซื้อ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include "../config.php";
                        $conn = mysqli_connect($servername, $username, $password, $dbname);
                        if (!$conn) {
                            die("Error " . mysqli_connect_error());
                        }

                        // Get the selected order status from the dropdown
                        $filterOrderStatus = isset($_GET['orderStatus']) ? $_GET['orderStatus'] : 'รอตรวจสอบ';

                        $sql = "SELECT * FROM sales_orders 
                                JOIN users ON sales_orders.user_no = users.user_no
                                WHERE sales_orders.order_status = '$filterOrderStatus' ORDER BY so_no DESC";

                        $result = mysqli_query($conn, $sql);

                        if (!$result) {
                            die("Error in SQL query: " . mysqli_error($conn));
                        }

                        while ($row = mysqli_fetch_array($result)) {
                        ?>
                            <tr>
                                <td class="py-2"><?php echo $row['so_no']; ?></td>
                                <td class="py-2"><?php echo $row['so_date']; ?></td>
                                <td class="py-2"><?php echo $row['user_name']; ?></td>
                                <td class="py-2"><?php echo $row['address']; ?></td>
                                <td class="py-2">
                                    <?php
                                    $soStatus = $row['order_status'];
                                    $soNo = $row['so_no'];

                                    if ($soStatus == 'รอตรวจสอบ') {
                                        echo '<a class="text-cyan-500 underline decoration-indigo-500" href="admin_chek.php?id=' . $soNo . '">' . $soStatus . '</a>';
                                    } elseif ($soStatus == 'กำลังจัดส่ง') {
                                        echo '<a class="text-cyan-500 underline decoration-indigo-500" href="delivery_up.php?id=' . $soNo . '">' . $soStatus . '</a>';
                                    } elseif ($soStatus == 'จัดส่งสินค้าเรียบร้อย') {
                                        echo '<a class="text-cyan-500 underline decoration-indigo-500" href="admin_so.php?id=' . $soNo . '">' . $soStatus . '</a>';
                                    } else {
                                        echo $soStatus;
                                    }
                                    ?>
                                </td>

                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <script>
            document.getElementById('orderStatus').addEventListener('change', function() {
                var selectedOrderStatus = this.value;
                window.location.href = 'order-management.php?orderStatus=' + selectedOrderStatus;
            });
        </script>

</body>

</html>