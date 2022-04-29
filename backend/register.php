<?php
//get the session log in
$FName = $_POST["FName"];
$LName = $_POST["LName"];
//reach out to database to add the name and generate a userID
//connect to database
echo "Attempting to connect to DB server: ...";
$conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");
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
    echo "<script> alert('User already exists!');window.location='register.html'</script>";
}

//generate random userID
$userID = rand(1, 999) + 1000;

//make sure userID does not exist
$result = $conn->query("SELECT * FROM user_T WHERE userID = $userID");
while($result->num_rows > 0) { //I am not actually sure if this is going to work like this; It works after I changed it to "> 0" from "!=0";4/8/22
		//userID does already exist
//generate new random userID
$userID = rand(1, 999) + 1000;
$result = $conn->query("SELECT * FROM user_T WHERE userID = $userID");
	}	

//add new user to database
$queryString = ("INSERT INTO user_T values ($userID, \"$FName\", \"$LName\", 1, NULL)");
mysqli_query($conn, $queryString);

//close connection
mysqli_close($conn);

echo echo "<script> alert('Completed. Please contact admin for further instructions.');window.location='register.html'</script>";

?>
