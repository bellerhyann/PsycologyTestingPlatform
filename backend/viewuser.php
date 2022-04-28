<?php
 //connect to SQL using Username Password Ect
$conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");
if (!$conn) {
	 die("Unable to Connect.".mysqli_connect_error());
     }

$queryString = "SELECT * FROM user_T WHERE password = /"/"";
$result = mysqli_query($conn, $queryString);

echo "<table border=1>";
echo "<tr> <th>First Name</th> <th>Last Name </th><th>User ID</th> </tr>";
while ($row = mysqli_fetch_array($result))
  {
    //printf("Select returned %d rows.\n", $result->userID)
	echo "<tr> <td>".$row["FName"]."</td>"."<td>".$row["LName"]."</td>".
  	"<td>".$row["userID"]."</td> </tr>";
  }

  //close connection
mysqli_close($conn);
?>
