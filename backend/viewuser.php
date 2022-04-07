<?php
 //connect to SQL using Username Password Ect
 $conn = new mysqli("newoneplease.ciqqgo3etyax.us-west-1.rds.amazonaws.com:3306","admin","Ilovesecurity!","labdata",3306);
if (!$conn) {
	 die("Unable to Connect.".mysqli_connect_error());
     }

$queryString = "SELECT * FROM user_T";
$result = mysqli_query($conn, $queryString);

echo "<table border=1>";
echo "<tr> <th>First Name</th> <th>User ID</th> </tr>";
while ($row = mysqli_fetch_array($result))
  {
    //printf("Select returned %d rows.\n", $result->userID)
	echo "<tr> <td>".$row["FName"]."</td>".
  	"<td>".$row["userID"]."</td> </tr>";
  }

  //close connection
mysqli_close($conn);
?>
