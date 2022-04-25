<?php 
		//Author: Skyeler Knuuttila
    //using this file to test things for question.php


    $conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac"); 
    if (!$conn)
    die("Database Error.".mysqli_connect_error());
		  
	  //find current phase
    $userID = 1066;
    $queryString = ("SELECT phaseID FROM user_T WHERE userID = $userID");
    $result =  mysqli_query($conn, $queryString);
	  $userPH = $result->fetch_assoc();
	  $userPH = $userPH['phaseID']; //userPH now stores the phase the user is on 
	
	  //create an array of blockID's from that phase 
		$blockList = array();
	  $queryString = ("SELECT blockID FROM phaseBlock_T WHERE phaseID = $phaseID ORDER BY blockOrder");
	  $result =  mysqli_query($conn, $queryString);
	  while($row = mysqli_fetch_array($result)) {
    			array_push($blockList, $row);
		}
    echo $blockList[0];
?>
