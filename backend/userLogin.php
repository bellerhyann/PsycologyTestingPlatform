<?php
//get the session log in
session_start();
$_SESSION["userID"] = $_POST["userID"];

//reach out to database to see if the userID exists
	//connect to database
echo "Attempting to connect to DB server: $host ...";
$conn = new mysqli("newoneplease.ciqqgo3etyax.us-west-1.rds.amazonaws.com:3306", "admin", "welovesecurity!", "labdata");
if ($conn->connect_error)
        die("UserID not found: Database Error.".mysqli_connect_error());
else
        echo " connected!<br>";

	//check if userID matches one in the database
$result = $conn->query("SELECT * FROM user_T WHERE userID = $userID); //int doesn't need to be in quotations
if($result->num_rows == 0) {
	//credentials do not match
	die("UserID not found." . $conn->error() );
} else {
	//credentials do match
	//close connection
	$conn->close();
	//redirect to dashboard.html
	header("location: /userDashboard.html");
	exit;
}

?>
