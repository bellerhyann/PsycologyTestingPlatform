<?php
	//get the session log in
	$FName = $_POST["FName"];
	$LName = $_POST["LName"];
	//reach out to database to add the name and generate a userID
	//connect to database
	echo "Attempting to connect to DB server: ...";
	$conn = new mysqli("newoneplease.ciqqgo3etyax.us-west-1.rds.amazonaws.com:3306","admin","Ilovesecurity!","labdata",3306);
	if (!$conn) {
		die("Unable to Connect.".mysqli_connect_error());
	}
	else {
		echo " connected!";
	}
//check if name is already in database
$queryString = ("SELECT * FROM user_T WHERE FName =\"$FName\" and LName = \"$LName\"");
$result = mysqli_query($conn, $queryString);

//Updated code to check if User exists - 3/31/2022
if(mysqli_num_rows($result) > 0){
    die('User Already exists'.mysqli_connect_error());
}

//generate random userID
$userID = rand(1, 999) + 1000;

	//make sure userID does not exist
	//$result = $conn->query("SELECT * FROM user_T WHERE userID = $userID");
	//while($result->num_rows != 0) { //I am not actually sure if this is going to work like this
		//userID does already exist
		//generate new random userID
		//$userID = rand(1, 10000);
		//$result = $conn->query("SELECT * FROM user_T WHERE userID = $userID");
	//}	
	//add new user to database
	//$queryString = ("INSERT INTO user_T values ($userID, \"$FName\", \"$LName\", 1, NULL)");
	//mysqli_query($conn, $queryString);


    //add new user to database
    $queryString = ("INSERT INTO user_T values ($userID, \"$FName\", \"$LName\", 1, NULL)");
	mysqli_query($conn, $queryString);

	//close connection
	mysqli_close($conn);
// 	//close connection
// 	mysqli_close($conn);

	echo "Completed. Please contact admin for further instructions.";


// } 


?>
