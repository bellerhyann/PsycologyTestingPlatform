<?php
$conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");

if( $mysqli->connect_errno ) {
	echo $mysqli->connect_errno . ' : ' . $mysqli->connect_error;
}

$first_name = $_POST["first_name"];
$last_name = $_POST["last_name"];
$user_id = $_POST["user_id"];
$phase_id = $_POST["phase_id"];


//Delete specific data

?>
