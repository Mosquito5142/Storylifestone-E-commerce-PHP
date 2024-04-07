<?php
session_start();
include "../config.php";

$admin_name = $_POST['login'];
$admin_password = $_POST['password'];

$con = mysqli_connect($servername, $username, $password, $dbname);
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL";
    exit();
}

$sql = "SELECT * FROM admin WHERE admin_name='$admin_name' AND admin_password='$admin_password'";
$result = mysqli_query($con, $sql);

$row = mysqli_fetch_array($result);
$rowcount = mysqli_num_rows($result);

if ($rowcount > 0) {
    $_SESSION["admin_name"] = $row['admin_name'];
    $_SESSION["admin_no"] = $row["admin_no"];
    $_SESSION["admin_email"] = $row['admin_email'];
    // Add other session variables as needed

    header("location: admin_index.php");
} else {
    header("location: login_admin.php");
}
?>
