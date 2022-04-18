<?php 

$conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");
if (!$conn) {
	die("Unable to Connect.".mysqli_connect_error());
}

$phaseNum = 1;

$queryString = "SELECT blockID FROM phaseBlock_T WHERE phaseID = $phaseNum ";
$block = mysqli_query($conn, $queryString); //holds all of the blockID's in our phase

while ($row = mysqli_fetch_row($block))
{

  echo "BLOCK ".$row[0]."<br>"; //this prints out each blockID we find belonging to the phaseNum

  //Now grab the TrialID's for each block
  $queryString = "SELECT trialID FROM blockTrial_T WHERE blockID = $row[0]";
  $trials = mysqli_query($conn, $queryString);

  while ($trialRows = mysqli_fetch_row($trials))
    {
    	//echo "Trial ".$trialRows[0]."   ";
       //grab the correct response for this trial 
       $queryString = "SELECT isCorrect FROM trial_T WHERE trialID = \"$trialRows[0]\"";
       $correctRSP = mysqli_query($conn, $queryString);
       $curr = $correctRSP->fetch_assoc();
       $curr = $curr['isCorrect'];
	  
	echo $curr;
    }

}
?>
