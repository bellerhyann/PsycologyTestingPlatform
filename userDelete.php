<?php

$link_main = "adminDashboard.php";


$conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");

if (!$conn) {
	die("Unable to Connect.".mysqli_connect_error());
}

$stmt = $mysqli->prepare('DELETE * FROM user_T WHERE Password IS NULL');

$stmt->execute();

$stmt = $mysqli->prepare('DELETE * FROM data_T');

$stmt->execute();

mysqli_close($conn);
echo "<a href=", $link_main ,">", "Go back to Main Page","</a>";
?>
