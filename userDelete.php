<?php
$conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");

if( $mysqli->connect_errno ) {
	echo $mysqli->connect_errno . ' : ' . $mysqli->connect_error;
}

$user_id = $_POST["user_id"];


//Delete specific data
$cmd = 'DELETE FROM user_T WHERE userID = $user_id';
$result1 = mysqli_query($conn, $cmd);
if (!$result1) {
    print("Failed to delete data<br>");
}
 
mysqli_close($conn);

?>