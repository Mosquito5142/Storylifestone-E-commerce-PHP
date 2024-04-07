<?php
$servername = "fdb32.awardspace.net";
$username = "4448917_datadb";
$password = "admin1233";
$dbname = "4448917_datadb";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
//echo "Connected successfully";
?>