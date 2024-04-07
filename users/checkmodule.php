<?php 
include "../main/session.php"; 
include "../users/checklogin.php";
if(isset($_SESSION['user_login']))
{
  $checkuser = checkuser($_SESSION['user_login'],$module);
  if($checkuser=="no")
  {
    echo '<meta http-equiv="refresh" content="0;url=../index.php">';
    exit();
  }
}
else
{
  echo '<meta http-equiv="refresh" content="0;url=../index.php">';
  exit();
}
?>