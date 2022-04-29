<?php
session_start();
$userID = $_POST["userID"];

//attatch the login to the session to transfer it between php files
$_SESSION["userID"] = $userID;

//reach out to database to see if the userID exists
	//connect to database
$conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");
if (!$conn)
	die("UserID not found: Database Error.".mysqli_connect_error());

	//check if userID matches one in the database
$query = "SELECT * FROM user_T WHERE userID = $userID"; //int doesn't need to be in quotations
$result = mysqli_query($conn, $query);
if(mysqli_fetch_assoc($result) == NULL) {
	//credentials do not match
	echo "<script> alert('Account not found!');window.location='../userLogin.html'</script>";
	//die("UserID not found.");
} else {
	//credentials do match
	//close connection
	mysqli_close($conn);
	//redirect to dashboard.html
	header("location: /userDashboard.php");
	exit;
}

?>
