<?php
  include 'config.php';
  session_start();
 
  // Handle sorting
  $sort = isset($_GET['sort']) ? $_GET['sort'] : 'pro_id';
  $sortOptions = [
    'price_asc' => 'price ASC',
    'price_desc' => 'price DESC',
    'name_asc' => 'pro_name ASC',
    'name_desc' => 'pro_name DESC',
  ];
 
  $orderBy = $sortOptions[$sort] ?? 'pro_id';
 
  // Get search term and selected type from the URL
  $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
  $selectedType = isset($_GET['type']) ? $_GET['type'] : 'all';
 
  // Construct the SQL query based on the search term and selected type
  $sql = "SELECT * FROM product INNER JOIN type ON product.type_id = type.type_id
          WHERE (pro_name LIKE '%$searchTerm%' OR type_name LIKE '%$searchTerm%')";
 
  if ($selectedType !== 'all') {
    $sql .= " AND type_name = '$selectedType'";
  }
 
  $sql .= " ORDER BY $orderBy";
 
  $result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
 
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shopping Website</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
*::-webkit-scrollbar {
  display: none;
}
.sidebar {
  width: 20%;
  padding: 10px;
  display: flex;
  flex-direction: column;
}
.sidebar-search {
  padding: 10px;
  border: 2px solid transparent;
  width: 100%;
  font-size: 1.2vw;
  outline: none;
  border-radius: 5px;
  background: #f2f2f2;
  border: 1px solid #52525B;
  transition: 0.3s;
  margin-bottom: 20px;
}
.sidebar-search:focus {
  border: 2px solid gray;
}
.sidebar-items {
  background: #f2f2f2;
  margin-bottom: 10px;
  padding: 10px;
  border-radius: 5px;
  border: 1px solid #52525B;
  color: #000;
  transition: 300ms;
  font-size: 1.2vw;
}
.sidebar-items:hover {
  background: gray;
  color: #fff;
}
.product-container {
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  transition: box-shadow 0.3s ease;
  border-radius: 10px; /* Adjust the value for the border radius */
}
 
.product-container:hover {
  box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}
 
.buy-btn{
  position: relative;
  display: block;
  text-align: center;
  line-height: 63px;
  background: #F5F5F5;
  border-radius: 5%;
  font-size: 20px;
  color: #000;
  transition: .5s;
}
 
.buy-btn::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  border-radius: 10%;
  background: #fff;
  transition: .5s;
  transform: scale(.9);
  z-index: -1;
}
 
.buy-btn:hover::before {
  transform: scale(1.1);
  box-shadow: 0 0 15px #778899;
}
 
.buy-btn:hover {
  color: #RRGGBB;
  box-shadow: 0 0 5px #778899;
  text-shadow: 0 0 5px #778899;
}
  </style>
</head>
 
<body class="bg-stone-100">
  <div class="container mx-auto">
      <header>
        <?php include 'comp/navnew.php' ?>
      </header>
      <?php include 'hero.php' ?>
    </div>
    <div class="container mx-auto">
  <div class="flex pt-5">
  <div class="sidebar">
    <form method="GET" action="">
      <input name="search" onkeyup="searchsomething(this)" id="txt_search" type="text" class="sidebar-search" placeholder="ค้นหา" value="<?= $searchTerm ?>">
      <button type="submit">Search</button>
    </form>
 
    <a href="?type=all" class="sidebar-items text-base sm:text-lg md:text-xl lg:text-2xl xl:text-lg">ทั้งหมด</a>
 
    <?php
      // Query to retrieve types from the type table
      $typeQuery = "SELECT `type_id`, `type_name` FROM `type` WHERE 1";
      $typeResult = mysqli_query($conn, $typeQuery);
 
      // Check if the query was successful
      if ($typeResult) {
        while ($typeRow = mysqli_fetch_array($typeResult)) :
          $type = $typeRow['type_name'];
    ?>
          <a href="?type=<?= $type ?>" class="sidebar-items text-base sm:text-lg md:text-xl lg:text-2xl xl:text-lg"><?= $type ?></a>
    <?php
        endwhile;
 
        // Free the result set
        mysqli_free_result($typeResult);
      }
    ?>
  </div>
<div class="product grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
  <?php
    while ($row = mysqli_fetch_array($result)) :
  ?>
  <div class="product-container">
      <a href="product_detail.php?pro_id=<?= $row['pro_id'] ?>" class="product-items">
        <img class="product-img w-full h-48 object-cover rounded-md" src="../img/<?= $row['img'] ?>" alt="<?= $row['pro_name'] ?>">
        <div class="name-product h-20">
        <p class="text-lg mt-2"><?= $row['pro_name'] ?></p>
        <p class="text-gray-700"><?= $row['type_name'] ?></p>
        </div>
        </a>
        <?php if ($row['amount'] > 0) : ?>
    <div class="py-2">
        <a href="cart_index.php?id=<?= $row['pro_id'] ?>" class="buy-btn">เพิ่มลงตะกร้าสินค้า</a>
    </div>
<?php else : ?>
    <div class="py-2">
    <a class="buy-btn">สินค้าหมด</a>
    </div>
<?php endif; ?>

        </div>
  <?php
    endwhile;
  ?>
</div>
  </div>
  <?php include 'comp/footer.php' ?>
  </div>
 
  <script>
  </script>
</body>
 
</html>