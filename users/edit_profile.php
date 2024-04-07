<?php
  session_start();
  $user_name = $_SESSION["user_name"];
  include "../config.php"; 
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  if(!$conn) { die("error".mysqli_connect_error());}
  $sql = "SELECT * FROM users WHERE `user_name`='$user_name'";
  $result = mysqli_query($conn,$sql);
  $row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
  <div class="container mx-auto">
      <header>

      </header>
    </div>
  <div class="container mx-auto flex pt-5">
  <div class="bg-white p-8 rounded shadow-md w-full">
        <h1 class="text-2xl font-bold mb-6">Edit Profile</h1>
        <form action="process_edit_profile.php" method="post" enctype="multipart/form-data">
            <div class="">
                <div class="mb-4">
                    <label for="user_no" class="block text-sm font-medium text-gray-600 mb-2">ไอดีผู้ใช้</label>
                    <input type="textbox" disabled class="form-input w-full px-4 py-2 rounded-md focus:outline-none focus:ring focus:border-blue-300" name="user_no" id="input_user_no" placeholder="ไอดี" autofocus value='<?php echo $row["user_no"];?>'>
                    <input type="hidden"  name="old_user_no" value='<?php echo $row["user_no"];?>'>
                </div>
                <div class="mb-4">
                    <label for="user_tel" class="block text-sm font-medium text-gray-600 mb-2">เบอร์โทร</label>
                    <input type="textbox" class="form-input w-full px-4 py-2 rounded-md focus:outline-none focus:ring focus:border-blue-300" name="user_tel" id="user_tel" placeholder="เบอร์โทร" value='<?php echo $row["user_tel"];?>'>
                </div>
                <div class="mb-4">
                    <label for="user_email" class="block text-sm font-medium text-gray-600 mb-2">อีเมล</label>
                    <input type="textbox" class="form-input w-full px-4 py-2 rounded-md focus:outline-none focus:ring focus:border-blue-300" name="user_email" id="user_email" placeholder="อีเมล" value='<?php echo $row["user_email"];?>'>
                </div>

                <div class="mb-4">
                    <label for="user_name" class="block text-sm font-medium text-gray-600 mb-2">ชื่อ</label>
                    <input type="textbox" class="form-input w-full px-4 py-2 rounded-md focus:outline-none focus:ring focus:border-blue-300" name="user_name" id="user_name" placeholder="ชื่อ" value='<?php echo $row["user_name"];?>'>
                </div>

                <div class="mb-4">
                    <label for="user_password" class="block text-sm font-medium text-gray-600 mb-2">รหัสผ่าน</label>
                    <input type="password" class="form-input w-full px-4 py-2 rounded-md focus:outline-none focus:ring focus:border-blue-300" name="user_password" id="user_password" placeholder="รหัสผ่าน" value='<?php echo $row["user_password"];?>'>
                </div>

                <div class="mb-4">
                    <label for="exampleInputFile" class="block text-sm font-medium text-gray-600 mb-2">เลือกรูปภาพ</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="myfile" onchange="PreviewImage();">
                        <label class="custom-file-label" for="exampleInputFile">เลือกรูปภาพ</label>
                    </div>
                </div>

                <div class="mb-4">
                    <?php 
                        if($row["image_name"] <> "") {
                            echo '<img class="rounded-full w-20 h-20 object-cover" id="uploadPreview" src="data:image/jpeg;base64,' . base64_encode($row["image_data"]) . '">';
                        } else {
                            echo '<img id="uploadPreview" class="rounded-full w-20 h-20 object-cover">';
                        }
                    ?>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300">
                    บันทึก
                </button>
            </div>
        </form>
    </div>
    </div>
    <?php include '../comp/footer.php' ?>
    <script type="text/javascript">
        function PreviewImage() {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById("exampleInputFile").files[0]);
            oFReader.onload = function (oFREvent) {
                document.getElementById("uploadPreview").src = oFREvent.target.result;
            }
        }
    </script>
    </body>

</html>
