<?php
//get the login info from frontend html
$adminUserID = $_POST["userID"];
$password = $_POST["password"];

//if we need to save the login info as a session, this code will work
//session.start()
//$_SESSION["adminUserID"] = $adminUser;
//$_SESSION["password"] = $password;


//reach out to database to see if the credentials match admin credentials
	//connect to database
$conn = new mysqli("newoneplease.ciqqgo3etyax.us-west-1.rds.amazonaws.com:3306", "admin", "Ilovesecurity!", "labdata");
if (!$conn)
        die("Username or Password not found: Database Error.".mysqli_connect_error());

	//check if userID and password matches an admin
$query = "SELECT * FROM user_T WHERE userID = $adminUserID and password = \"$password\"";
$result = mysqli_query($conn, $query);
if(mysqli_fetch_assoc($result) == NULL) {
	//credentials do not match
	die("Username or Password not found." . mysqli_connect_error());
} else {
	//credentials do match
	//close connection
  mysqli_close($conn);
	//redirect to adminDashboard.html
	header("location: /adminDashboard.html");
	exit;
}

?>
