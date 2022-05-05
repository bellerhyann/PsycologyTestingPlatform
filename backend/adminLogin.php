<?php
//Login for Admins 
//Authors: Skyeler K. and Nick W.

//get the login info from frontend html
$adminUserID = $_POST["userID"];
$password = $_POST["password"];

//if we need to save the login info as a session, this code will work
session_start();
$_SESSION["adminUserID"] = $adminUserID;
$_SESSION["password"] = $password;


//reach out to database to see if the credentials match admin credentials
	//connect to database
$conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");
if (!$conn)
        die("Username or Password not found: Database Error.".mysqli_connect_error());

//check if userID exists
$query = "SELECT * FROM user_T WHERE userID = $adminUserID";
$result = mysqli_query($conn, $query);
$dataRow = mysqli_fetch_array($result);

if($dataRow == NULL) {
	//credentials do not match. User doesn't exist.
	die("Username not found." . mysqli_connect_error());

} else {
	//credentials might match
	//check if given password matches password for given userID
	$valid = password_verify($password, $dataRow["Password"]);
	if($valid == true){
		//credentials match
		//close connection
		mysqli_close($conn);
		//redirect to adminDashboard.php;
		header("location: /adminDashboard.php");
		exit;
	} else {
		//password 
		die("Incorrect password." . mysqli_connect_error());
	}
}

?>
