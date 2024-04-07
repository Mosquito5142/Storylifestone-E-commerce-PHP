<style>
    #drp-btn:hover #drp-list,
    #orders-btn:hover #orders-list {
        display: block;
    }

    #drp-list,
    #orders-list {
        display: none;
    }
    .nav-profile-cart {
  position: relative;
}
.cartcount {
  position: absolute;
  top: -1px;
  right: -1px;
  width: 25px;
  height: 25px;
  background: red;
  border-radius: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
  color: #fff;
}
    
</style>
<nav>
    <div class="">
      <div class="flex flex-wrap items-center justify-between bg-white md:p-5">
        <div class="p-4 px-4 text-2xl font-bold"><?php include 'comp/setweb/webname.php'; ?></div>
        <div class="p-4 md:hidden">
          <a id="menu-button" class="h-6 transition-opacity duration-500 ease-in-out cursor-pointer hover:opacity-[0.5]">
            <i class="fa-solid fa-list"></i>
          </a>
        </div>
        <div id="menu" class="md:block">
          <ul class="items-center w-screen text-lg md:w-auto md:flex">
            <li class="p-4 py-3 md:mx-3 border-b border-orange-50 md:px-7 md:border-0">
              <a href="index.php">หน้าแรก</a>
            </li>
            <li class="nav-profile-cart p-4 border-b border-orange-50 md:px-7 md:border-0">
              <a href="cart.php">ตะกร้าสินค้า</a>
              <?php if (isset($_SESSION["strProductID"]) && count($_SESSION["strProductID"]) > 0) : ?>
        <div class="cartcount"><?php echo count($_SESSION["strProductID"]); ?></div>
    <?php endif; ?>
            </li>
            <li class="p-4 border-b border-orange-50 md:px-7 md:border-0">
              <div id="orders-btn">
                <span>รายการคำสั่งซื้อ</span>
                <div id="orders-list" class="absolute z-10 hidden mt-2 bg-white rounded-md shadow-lg top-10">
                  <a class="block px-4 py-2 text-gray-800 hover:rounded-t" href="sale_list.php">ยืนยันคำสั่งซื้อ</a>
                  <a  class="block px-4 py-2 text-gray-800 hover:rounded-b" href="Waiting_for_payment.php">แจ้งชำระเงิน</a>
                </div>
              </div>
            </li>
            <li id="drp-btn" class="px-4">
              <div id="drp-btn" class="px-4">
                <div class="relative inline-flex py-2">
                  <?php if (isset($_SESSION["user_name"])) : ?>
                    <div>
                      <span class="pr-[0.25rem]"><?php echo $_SESSION["user_name"]; ?></span>
                      <div id="drp-list" class="absolute z-10 hidden mt-2 bg-white rounded-md shadow-lg top-10">
                        <a href="Purchase_history.php" class="block px-4 py-2 text-gray-800 hover:rounded-t">
                          ประวัติการซื้อ
                        </a>
                        <a href="users/edit_profile.php" class="block px-4 py-2 text-gray-800">แก้ไขโปรไฟล์</a>
                        <a href="users/logout.php" class="block px-4 py-2 text-gray-800 hover:rounded-b">ออกจากระบบ</a>
                      </div>
                    </div>
                  <?php else : ?>
                    <a href="users/login.php" class="pr-[0.25rem]">กรุณาเข้าสู่ระบบ</a>
                  <?php endif; ?>
                </div>
              </div>
            </li>
            
          </ul>
        </div>
      </div>
    </div>
  </nav>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      var menuButton = document.getElementById("menu-button");
      var menu = document.getElementById("menu");

      menuButton.addEventListener("click", function () {
        menu.classList.toggle("hidden");
      });
    });
  </script>