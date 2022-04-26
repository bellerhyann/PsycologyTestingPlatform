<?php

$link_main = "adminDashboard.php";


$conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");

if (!$conn) {
	die("Unable to Connect.".mysqli_connect_error());
}

$user_id = $_POST["user_id"];


//Delete specific data
$cmd = "DELETE FROM user_T WHERE userID = '$user_id'";
$result1 = mysqli_query($conn, $cmd);
if (!$result1) {
   	print("Failed to delete data<br>");
} else {
	print("Success to delete data<br>");
}
 
mysqli_close($conn);
echo "<a href=", $link_main ,">", "Go back to Main Page","</a>";
?>
