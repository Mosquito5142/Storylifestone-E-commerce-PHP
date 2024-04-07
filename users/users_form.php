<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<form action="users_insert.php" method="post" onsubmit ="return validateForm()" enctype="multipart/form-data" >
                <div class="card-body">
                  <div class="row">
                      <div class="col-md-8">  
                      <div class="form-group">
                          <label for="item_name">user_email</label>
                          <input required type="textbox" class="form-control" name="user_email" id="user_email" placeholder="enter user_email">
                        </div>                    
                        <div class="form-group">
                          <label for="item_name">user_name</label>
                          <input required type="textbox" class="form-control" name="user_name" id="user_name" placeholder="enter user_name">
                        </div>
                        <div class="form-group">
                          <label for="user_no">user_login</label>
                          <input required type="textbox" class="form-control" name="user_login" id="user_login" placeholder="enter user_login">
                        </div>
                        <div class="form-group">
                          <label for="location">user_password</label>
                          <input  type="password" class="form-control" name="user_password" id="user_password" placeholder="enter user_password">
                          <span id = "message1" style="color:red"> </span>
                        </div>  
                        <div class="form-group">
                          <label for="location">confirm_user_password</label>
                          <input  type="password" class="form-control" name="confirm_user_password" id="confirm_user_password" placeholder="enter confirm_user_password">
                          <span id = "message2" style="color:red"> </span>
                        </div>      
                      </div>
                      <div class="col-md-4">      
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
                             <img class="product-image img-fluid rounded-circle" id="uploadPreview">
                          </div>                                                      
                      </div>
                    </div>               
                  </div>               
                <div class="card-footer">
                          <button type="submit" class="btn btn-primary">Submit</button>
                </div>
             </form>
</body>
</html>