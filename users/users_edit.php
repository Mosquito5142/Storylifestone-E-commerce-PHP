<?php include '../config.php';
 session_start(); 
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
  </style>
</head>
<body>
  <div class="head_bg bg-gray-100">
    <div class="container mx-auto">
      <header>
        <?php include '../comp/navnew.php' ?>
      </header>
    </div>
  </div>
  <div class="container mx-auto">
    <div class="main-content">
    
<?php
              include "../config.php";
              $user_no = $_GET["user_no"];
              $conn = mysqli_connect($servername,$username,$password,$dbname);
              if(!$conn) { die("error".mysqli_connect_error());}
              $sql = "SELECT * FROM users WHERE user_no='$user_no'";
              $result = mysqli_query($conn,$sql);
              $row=mysqli_fetch_assoc($result);
              ?>
              <form action="users_save.php" method="post" enctype="multipart/form-data">
                <div class="card-body">
                  <div class="row">
                      <div class="col-md-6">                      
                        <div class="form-group">
                            <label for="user_no">user_no</label>
                            <input type="textbox" disabled class="form-control" name="user_no" id="imput_user_no" placeholder="enter user_no" autofocus value='<?php echo $row["user_no"];?>'>
                            <input type="hidden"  name="old_user_no" value='<?php echo $row["user_no"];?>'>
                         </div>
                         <div class="form-group">
                          <label for="item_name">user_tel</label>
                          <input type="textbox" class="form-control" name="user_tel" id="user_tel" placeholder="user_tel" value='<?php echo $row["user_tel"];?>'>
                        </div>
                        <div class="form-group">
                          <label for="item_name">user_email</label>
                          <input type="textbox" class="form-control" name="user_email" id="user_email" placeholder="enter user_email" value='<?php echo $row["user_email"];?>'>
                        </div>
                        <div class="form-group">
                          <label for="item_name">user_name</label>
                          <input type="textbox" class="form-control" name="user_name" id="user_name" placeholder="enter user_email" value='<?php echo $row["user_name"];?>'>
                        </div>
                        <div class="form-group">
                          <label for="user_no">user_login</label>
                          <input type="textbox" class="form-control" name="user_login" id="user_login" placeholder="enter user_login" value='<?php echo $row["user_login"];?>'>
                        </div>
                        <div class="form-group">
                          <label for="location">user_password</label>
                          <input type="password" class="form-control" name="user_password" id="user_password" placeholder="enter user_password" value='<?php echo $row["user_password"];?>'>
                        </div>                                                                   
                      </div>
                      <div class="col-md-6">      
                        <div class="form-group">
                            <label for="exampleInputFile">File input</label>
                              <div class="input-group">
                                <div class="custom-file">
                                  <input type="file" class="custom-file-input" id="exampleInputFile" name="myfile" onchange="PreviewImage();">
                                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>                          
                                </div>
                              </div>                         
                          </div>     
                          <div class="form-group">
                          <?php 
                                if($row["image_name"]<>"")
                                echo '<img class="product-image img-fluid rounded-circle" id="uploadPreview"" src="data:image/jpeg;base64,'.base64_encode($row["image_data"]).'" width="100px">';
                                else 
                                echo '<img class="product-image img-fluid" id="uploadPreview">';
                              ?>
                          </div>                                                      
                      </div>
                    </div>               
                  </div>               
                <div class="card-footer">
                          <button type="submit" class="btn btn-primary">Submit</button>
                </div>
             </form>
      </div>
      </div>
<script>
    function PreviewImage()
    {
      var oFReader = new FileReader();
      oFReader.readAsDataURL(document.getElementById("exampleInputFile").files[0]);
      oFReader.onload = function(oFREvent){
        document.getElementById("uploadPreview").src=oFREvent.target.result;
      }
    }
     
</script>
</body>
</html>
