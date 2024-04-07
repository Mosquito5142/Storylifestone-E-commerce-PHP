<style>
  #drp-btn:hover #drp-list,
  #orders-btn:hover #orders-list {
    display: block;
  }

  #drp-list,
  #orders-list {
    display: none;
  }
</style>
<nav>
  <div class="">
    <div class="flex flex-wrap items-center justify-between bg-white md:p-5">
      <div class="p-4 px-4 text-2xl font-bold">
      <?php include '../comp/setweb/webname.php'; ?> <span class="text-red-500">admin</span></div>
      <div class="p-4 md:hidden">
        <a id="menu-button" class="h-6 transition-opacity duration-500 ease-in-out cursor-pointer hover:opacity-[0.5]">
          <i class="fa-solid fa-list"></i>
        </a>
      </div>
      <div id="menu" class="md:block">
        <ul class="items-center w-screen text-lg md:w-auto md:flex">
          <li class="p-4 py-3 md:mx-3 border-b border-orange-50 md:px-7 md:border-0">
            <a href="admin_index.php">หน้าแรก</a>
          </li>
          <li class="p-4 border-b border-orange-50 md:px-7 md:border-0">
            <a href="product-management.php">จัดการคลังสินค้า</a>
          </li>
          <li class="p-4 border-b border-orange-50 md:px-7 md:border-0">
            <a href="order-management.php">จัดการคำสั่งซื้อ</a>
          </li>
          <li id="drp-btn" class="px-4">
  <div class="relative inline-flex py-2">
    <div>
      <span class="pr-[0.25rem]"><?php echo $_SESSION["admin_name"]; ?></span>
      <div id="drp-list" class="absolute z-10 hidden mt-2 bg-white rounded-md shadow-lg top-10">
        <a href="webname.php" class="block px-4 py-2 text-gray-800 hover:rounded-b">แก้ไขชื่อร้าน</a>
        <a href="logout.php" class="block px-4 py-2 text-gray-800 hover:rounded-b">ออกจากระบบ</a>
      </div>
    </div>
    <?php if (!isset($_SESSION["admin_name"])) : ?>
      <a href="../users/login.php" class="pr-[0.25rem]">กรุณาเข้าสู่ระบบ</a>
    <?php endif; ?>
  </div>
</li>
        </ul>
      </div>
    </div>
  </div>
</nav>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    var menuButton = document.getElementById("menu-button");
    var menu = document.getElementById("menu");

    menuButton.addEventListener("click", function() {
      menu.classList.toggle("hidden");
    });
  });
</script>