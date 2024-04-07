<?php
include "chack_login.php";
include '../config.php';
 
// Get selected type from the URL, default to 'all' if not set
$selectedType = isset($_GET['type']) ? $_GET['type'] : 'all';
 
// Construct the SQL query based on the selected type
$sql = "SELECT * FROM product
        INNER JOIN type ON product.type_id = type.type_id";
 
if ($selectedType !== 'all') {
  $sql .= " WHERE type_name = '$selectedType'";
}
 
$result = mysqli_query($conn, $sql);
?>
 
 
<!DOCTYPE html>
<html lang="en">
 
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Management</title>
  <!-- Include your CSS stylesheets here -->
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
 
<body class="bg-gray-100">
  <div class="container mx-auto">
    <header class="mb-8">
      <?php include 'navadmin.php' ?>
    </header>
  </div>
  <div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-4">Product Management</h1>
 
    <!-- เพิ่มเมนู dropdown เลือกประเภท -->
    <label for="productType" class="mr-2">Select Product Type:</label>
    <select id="productType" onchange="filterProducts()">
  <option value="all" <?php echo ($selectedType === 'all') ? 'selected' : ''; ?>>All Products</option>
  <?php
  // Query to retrieve types from the type table
  $typeQuery = "SELECT `type_id`, `type_name` FROM `type` WHERE 1";
  $typeResult = mysqli_query($conn, $typeQuery);
 
  // Check if the query was successful
  if ($typeResult) {
    while ($typeRow = mysqli_fetch_array($typeResult)) :
      $type = $typeRow['type_name'];
  ?>
      <option value="<?= $type ?>" <?php echo ($selectedType === $type) ? 'selected' : ''; ?>><?= $type ?></option>
  <?php
    endwhile;
 
    // Free the result set
    mysqli_free_result($typeResult);
  }
  ?>
</select>
 
    <a href="add_product.php" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Add New Product</a>
    <a href="type-management.php" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Add New Type</a>
    <br>
    <div class="overflow-x-auto pt-4">
      <table class="w-full table-auto border-collapse border border-gray-300">
        <thead>
          <tr>
            <th class="border border-gray-300 px-4 py-2">ID</th>
            <th class="border border-gray-300 px-4 py-2">Name</th>
            <th class="border border-gray-300 px-4 py-2">Detail</th>
            <th class="border border-gray-300 px-4 py-2">Price</th>
            <th class="border border-gray-300 px-4 py-2">Quantity</th>
            <th class="border border-gray-300 px-4 py-2">Image</th>
            <th class="border border-gray-300 px-4 py-2">Type Name</th>
            <th class="border border-gray-300 px-4 py-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td class='border border-gray-300 px-4 py-2'>{$row['pro_id']}</td>";
            echo "<td class='border border-gray-300 px-4 py-2'>{$row['pro_name']}</td>";
            echo "<td class='border border-gray-300 px-4 py-2'>{$row['pro_detail']}</td>";
            echo "<td class='border border-gray-300 px-4 py-2'>{$row['price']}</td>";
            echo "<td class='border border-gray-300 px-4 py-2'>{$row['amount']}</td>";
            echo "<td class='border border-gray-300 px-4 py-2'><img src='../img/{$row['img']}' alt='{$row['pro_name']}' class='w-12 h-12 object-cover'></td>";
            echo "<td class='border border-gray-300 px-4 py-2'>{$row['type_name']}</td>";
            echo "<td class='border border-gray-300 px-4 py-2'>
                    <a href='edit_product.php?pro_id={$row['pro_id']}' class='text-blue-500 hover:underline'>Edit</a>
                    <a href='delete_product.php?pro_id={$row['pro_id']}' class='text-red-500 hover:underline ml-2'>Delete</a>
                  </td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
 <!-- Include your JavaScript code here -->
<script>
  function filterProducts() {
    // รับค่าประเภทที่เลือกจาก dropdown
    var selectedType = document.getElementById('productType').value;
 
    // ถ้าเลือก 'All Products' ให้กลับไปที่ product_list.php โดยไม่ระบุประเภท
// ถ้าเลือก 'All Products' ให้กลับไปที่ product-management.php โดยไม่ระบุประเภท
if (selectedType === 'all') {
  window.location.href = 'product-management.php';
} else {
  // ถ้าไม่ใช่ 'All Products' ให้ส่งค่าไปยังหน้า product-management.php พร้อมกับประเภทที่เลือก
  window.location.href = 'product-management.php?type=' + selectedType;
}
 
  }
</script>
 
</body>
 
</html>