<?php
include "chack_login.php";
include "../config.php";
    $selected_month = isset($_GET['month']) ? $_GET['month'] : date('m');
    $selected_year = isset($_GET['year']) ? $_GET['year'] : date('Y');
    // ดึงข้อมูลจำนวนสินค้าแต่ละชนิดจากฐานข้อมูล
    $sql_product_count = "SELECT p.pro_name,p.pro_id,p.price,p.costprice, COUNT(sr.pro_id) AS product_count
                      FROM sale_relations sr
                      INNER JOIN product p ON sr.pro_id = p.pro_id
                      INNER JOIN sales_orders so ON sr.so_no = so.so_no
                      WHERE MONTH(so.so_date) = '$selected_month' AND YEAR(so.so_date) = '$selected_year'
                      GROUP BY p.pro_name";



    $result_product_count = $conn->query($sql_product_count);

    // เก็บข้อมูลในรูปแบบของ array
    $product_count_data = array();
    if ($result_product_count->num_rows > 0) {
        while ($row = $result_product_count->fetch_assoc()) {
            $product_count_data[] = array(
                "pro_id" => $row["pro_id"],
                "pro_name" => $row["pro_name"],
                "costprice" => $row['costprice'],
                "price" => $row["price"],
                "product_count" => $row["product_count"]
            );
        }
    }
    //ยอดรวมราคาขายกับกำไร
    function calculateTotalSales($product_count_data) {
        $total_sales = 0;
        foreach ($product_count_data as $product) {
            if (isset($product['product_count']) && isset($product['price'])) {
                // ตรวจสอบว่าข้อมูลขายได้จำนวนสินค้าและราคาต่อหน่วยมีค่าถูกต้องหรือไม่
                $total_price = $product['product_count'] * $product['price'];
                $total_sales += $total_price;
            }
        }
        return $total_sales;
    }
    function calculateTotalProfit($product_count_data) {
        $total_profit = 0;
        foreach ($product_count_data as $product) {
            if (isset($product['product_count']) && isset($product['price']) && isset($product['costprice'])) {
                // ตรวจสอบว่าข้อมูลขายได้จำนวนสินค้า ราคาขาย และราคาต้นทุนมีค่าถูกต้องหรือไม่
                $total_price = $product['product_count'] * $product['price'];
                $total_cost = $product['product_count'] * $product['costprice'];
                $total_profit += ($total_price - $total_cost);
            }
        }
        return $total_profit;
    }

    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Data Graph</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100">
<div class="container mx-auto">
    <header >
      <?php include 'navadmin.php' ?>
    </header>
    <div class="container mx-auto">
        <div class="flex justify-center items-center space-x-4 mb-8">
            <form method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="flex items-center space-x-4">
                    <label for="month" class="font-semibold">เลือกเดือน:</label>
                    <select name="month" id="month" class="px-2 py-1 rounded-md border border-gray-300">
                        <?php
                        $months_thai = array(
                            '01' => 'มกราคม',
                            '02' => 'กุมภาพันธ์',
                            '03' => 'มีนาคม',
                            '04' => 'เมษายน',
                            '05' => 'พฤษภาคม',
                            '06' => 'มิถุนายน',
                            '07' => 'กรกฎาคม',
                            '08' => 'สิงหาคม',
                            '09' => 'กันยายน',
                            '10' => 'ตุลาคม',
                            '11' => 'พฤศจิกายน',
                            '12' => 'ธันวาคม'
                        );
                        foreach ($months_thai as $month_num => $month_name) {
                            echo "<option value=\"$month_num\"";
                            if ($selected_month == $month_num) {
                                echo " selected";
                            }
                            echo ">$month_name</option>";
                        }
                        ?>
                    </select>

                    <label for="year" class="font-semibold">เลือกปี:</label>
                    <select name="year" id="year" class="px-2 py-1 rounded-md border border-gray-300">
                        <?php
                        $current_year = date('Y');
                        for ($year = $current_year; $year >= $current_year - 10; $year--) {
                            echo "<option value=\"$year\"";
                            if ($selected_year == $year) {
                                echo " selected";
                            }
                            echo ">$year</option>";
                        }
                        ?>
                    </select>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">ส่งข้อมูล</button>
                </div>
            </form>
        </div>
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold">สรุปข้อมูลการขายสินค้า</h1>
            <?php
            $months_thai = array(
                '01' => 'มกราคม',
                '02' => 'กุมภาพันธ์',
                '03' => 'มีนาคม',
                '04' => 'เมษายน',
                '05' => 'พฤษภาคม',
                '06' => 'มิถุนายน',
                '07' => 'กรกฎาคม',
                '08' => 'สิงหาคม',
                '09' => 'กันยายน',
                '10' => 'ตุลาคม',
                '11' => 'พฤศจิกายน',
                '12' => 'ธันวาคม'
            );
            ?>
            <p class="text-lg">เดือน <?php echo $months_thai[$selected_month]; ?> ปี <?php echo $selected_year; ?></p>
        </div>
        <div class="flxe">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <canvas id="productChart" width="800" height="400"></canvas>
        </div>
        <div class="justify-center items-center mt-8">
    <h1 class="text-2xl font-bold">รายละเอียด</h1>
    <div class="mt-4">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ชื่อ</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ขายได้จำนวน</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ราคาต้นทุน</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ราคาขาย</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ราคาขายทั้งหมด</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">กำไร</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php foreach ($product_count_data as $product) : ?>
                    <?php 
                        // คำนวณราคารวมของสินค้าแต่ละชนิด
                        $total_price = $product['product_count'] * $product['price'];
                    ?>
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $product['pro_name']; ?></td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo $product['product_count'];?> ชิ้น</td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo number_format($product['costprice']) ?> บาท</td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo number_format($product['price']) ?> บาท</td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo number_format($total_price) ?> บาท</td>
                        <td class="px-6 py-4 whitespace-nowrap"><?php echo number_format($total_price-($product['costprice']*$product['product_count'])) ?> บาท</td>
                        
                    </tr>
                <?php endforeach; ?>
                <tr>
                        <td  class="px-6 py-4 whitespace-nowrap text-red-500 font-bold">รวม</td>
                        <td  class="px-6 py-4 whitespace-nowrap"></td>
                        <td  class="px-6 py-4 whitespace-nowrap"></td>
                        <td  class="px-6 py-4 whitespace-nowrap"></td>  
                        <td class="px-6 py-4 whitespace-nowrap text-red-500 font-bold"><?php echo number_format(calculateTotalSales($product_count_data)) ?> บาท</td>
                        <td class="px-6 py-4 whitespace-nowrap text-red-500 font-bold"><?php echo number_format(calculateTotalProfit($product_count_data)) ?> บาท</td>
                        
                </tr>
            </tbody>
        </table>
    </div>
</div>

    </div>

    <script>
        // ข้อมูลจำนวนสินค้าแต่ละชนิด
        var productCountData = <?php echo json_encode($product_count_data); ?>;

        // จัดรูปแบบข้อมูลสำหรับกราฟ
        var productNames = [];
        var productCounts = [];

        productCountData.forEach(function(item) {
            productNames.push(item.pro_name);
            productCounts.push(item.product_count);
        });

        // สร้างกราฟ
        var ctx = document.getElementById('productChart').getContext('2d');
        var productChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: productNames,
                datasets: [{
                    label: 'จำนวนสินค้า',
                    data: productCounts,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: '#000',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // อัพเดทฟอร์มโดยอัตโนมัติเมื่อมีการเลือกเดือน
        document.getElementById('month').addEventListener('change', function() {
            this.form.submit();
            
        })
        document.getElementById('year').addEventListener('change', function() {
            this.form.submit();
            
        });
    </script>
</body>
</html>
