<?php
	//get the session log in
	$FName = $_POST["FName"];
	$LName = $_POST["LName"];


	//reach out to database to add the name and generate a userID
	//connect to database
	echo "Attempting to connect to DB server: ...";
	$conn = new mysqli("newoneplease.ciqqgo3etyax.us-west-1.rds.amazonaws.com:3306","admin","Ilovesecurity!","labdata",3306);
	if (!$conn) {
		echo "DID NOT CONNECT";
	}
	else {
		echo " connected!";
	}

//check if name is already in database
//$queryString = ("SELECT * FROM user_T WHERE FName =\"$FName\" and LName = \"$LName\");
//$result = mysqli_query($conn, $queryString);

//if(mysqli_fetch_assoc($result) == NULL) {
	//credentials do match
	//die("Name already exists." .mysqli_connect_error());
//}
//else
//{
	//credentials do not match
	//generate random userID
	$userID = rand(1, 10000);

	//make sure userID does not exist
	//$result = $conn->query("SELECT * FROM user_T WHERE userID = $userID");
	//while($result->num_rows != 0) { //I am not actually sure if this is going to work like this
		//userID does already exist
		//generate new random userID
		//$userID = rand(1, 10000);
		//$result = $conn->query("SELECT * FROM user_T WHERE userID = $userID");
	//}	
	//add new user to database
	$queryString = ("INSERT INTO user_T values ($userID, \"$FName\", \"$LName\", 1, NULL)");
	mysqli_query($conn, $queryString);
		
	//close connection
	mysqli_close($conn);
							
	echo "Completed. Please contact admin for further instructions.";

	header("Location: /userDashboard.html");
	exit;
		     
//} 


?>
