//<?php
//require '/vendor/autoload.php';
//header("Location: http://www.example.com/another-page.php");
//exit();
//?>
<?php
//get the session log in
session_start();
$FName = $_POST["FName"];
$LName = $_POST["LName"];


//reach out to database to add the name and generate a userID
//connect to database
echo "Attempting to connect to DB server: $host ...";
$conn = new mysqli("newoneplease.ciqqgo3etyax.us-west-1.rds.amazonaws.com", "admin", "welovesecurity!", "labdata");
if (!$conn)
        echo "DID NOT CONNECT";
else
       echo " connected!";

//check if name is already in database
//$result = $conn->query("SELECT * FROM user_T WHERE FName =\"$FName\" and LName = \"$LName\");
//if($result->num_rows == 0) {
	//credentials do not match
	//generate random userID
	//$userID = rand(1, 10000);
$userID = 123;
	//make sure userID does not exist
	//$result = $conn->query("SELECT * FROM user_T WHERE userID = $userID");
	//while($result->num_rows != 0) { //I am not actually sure if this is going to work like this
		//userID does already exist
		//generate new random userID
		//$userID = rand(1, 10000);
		//$result = $conn->query("SELECT * FROM user_T WHERE userID = $userID");
	//}	
	//add new user to database
	$conn->query("INSERT INTO user_T values ($userID, \"$FName\", \"$LName\", 123456, NULL)";
//} else {
	//credentials do match
	//die("Full name already signed up." . $conn->error() );
//}



//close connection
mysqli_close($conn);
						 
echo "Completed. Please contact admin for further instructions."

?>
