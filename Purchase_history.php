<?php include "config.php";
 session_start(); 
 include 'users/checklogin.php'
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
    tbody td {
  /* 1. Animate the background-color
     from transparent to white on hover */
  background-color: rgba(255,255,255,0);
  transition: all 0.2s linear; 
  transition-delay: 0.3s, 0s;
  /* 2. Animate the opacity on hover */
  opacity: 0.6;
}
tbody tr:hover td {
  background-color: rgba(255,255,255,1);
  transition-delay: 0s, 0s;
  opacity: 1;
  font-size: 2em;
}

td {
  /* 3. Scale the text using transform on hover */
  transform-origin: center left;
  transition-property: transform;
  transition-duration: 0.4s;
  transition-timing-function: ease-in-out;
}
tr:hover td {
  transform: scale(1.1);
}





/* Codepen styling */
* { box-sizing: border-box }

table {
  width: 100%;
  margin: 0;
  text-align: center;
}
th, td {
  padding: 0.5em;
}
  </style>
  
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
        <div class="main-content top-10vw">
            <table>
                <thead class="">
                    <tr>
                        <th>เลขที่ใบสั่งซื้อ</th>
                        <th>วันที่สั่งซื้อ</th>
                        <th>ชื่อผู้ซื้อ</th>
                        <th>ที่อยู่</th>
                        <th>ข้อมูลการสั่งซื้อ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "config.php";
                    $conn = mysqli_connect($servername, $username, $password, $dbname);
                    if (!$conn) {
                        die("Error " . mysqli_connect_error());
                    }

                    // Assuming there is a timestamp column named 'timestamp_column'
                    $sql = "SELECT * FROM sales_orders 
                            JOIN users ON sales_orders.user_no = users.user_no
                            WHERE sales_orders.user_no = {$_SESSION['user_no']} 
                            AND sales_orders.order_status IN ('รอตรวจสอบ', 'กำลังจัดส่ง','จัดส่งสินค้าเรียบร้อย')ORDER BY so_no DESC";

                    $result = mysqli_query($conn, $sql);

                    // Check for errors
                    if (!$result) {
                        die("Error in SQL query: " . mysqli_error($conn));
                    }

                    while ($row = mysqli_fetch_array($result)) {
                        ?>
                        <tr>
                            <td><?php echo $row['so_no']; ?></td>
                            <td><?php echo $row['so_date']; ?></td>
                            <td><?php echo $row['user_name']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><a class="text-cyan-500 underline decoration-indigo-500" href="check_so.php?id=<?= $row['so_no'] ?>"><?php echo $row['order_status'] ?></a></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>