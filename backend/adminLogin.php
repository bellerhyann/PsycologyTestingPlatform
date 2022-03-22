<?php
//get the session log in
session_start();
$_SESSION["adminUserID"] = $_POST["userID"];
$_SESSION["password"] = $_POST["password"];


//reach out to database to see if the credentials match admin credentials
	//connect to database
$conn = new mysqli("newoneplease.ciqqgo3etyax.us-west-1.rds.amazonaws.com:3306", "admin", "Ilovesecurity!", "labdata");
if (!$conn)
        die("Username or Password not found: Database Error.".mysqli_connect_error());
else
        echo " connected!<br>";

	//check if userID and password matches an admin
$query = "SELECT * FROM User_T WHERE userID = $_SESSION["adminUserID"] and password = \"$_SESSION["password"]\" and isAdmin = True";
$result = mysqli_query($conn, $query);
if(mysqli_fetch_assoc($result) == NULL) {
	//credentials do not match
	die("Username or Password not found." . $conn->error() );
} else {
	//credentials do match
	//close connection
  mysqli_close($conn);
	//redirect to adminDashboard.html
	header("location: /adminDashboard.html");
	exit;
}

?>
