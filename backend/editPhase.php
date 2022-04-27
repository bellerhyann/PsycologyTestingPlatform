<?php
  //Back end is waiting on front end for two post fixes listed below 
  //this needs to be sending multiple values 
  $blockNum = $_POST["numBlocks"];
  $askPrompt = $_POST["askPrompt"];
  $prompt = $_POST["prompt"];
  $score = $_POST["showScoreboard"];

  //We also still need something from front end to identify which base like baseline ect 
  $phaseNum = $_POST["phaseID"]; 

  //this keeps track when we put in the order
  $count = 1;

$conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");
if (!$conn) {
	die("Unable to Connect.".mysqli_connect_error());
}
else {
	echo " connected!";
}

//first update the phase_T with new phase info
$queryString = "UPDATE phase_T SET instructions prompt = \"$prompt\" AND scoreboard = $score  AND askPrompt = $askPrompt WHERE phaseID = $phaseNum";
$result = mysqli_query($conn, $queryString);

//next we need to loop and add each block that is in the phase 
//this will be in the phaseblock_T
//frist lets delete aany existing data for this phase 
$queryString = "DELETE FROM phaseblock_t WHERE phaseID = $phaseNum";
$result = mysqli_query($conn, $queryString);

while ($count <= $blockNum)//unsure how to do this waiting on front end to update code 
{
 $blockRQ = "block";
 //need to convert count to a string and add it to blockRQ to then post the value
 $holder = strval($count);
 $blockRQ .=$holder;
	
 $blockID = $_POST["$blockRQ"];
 $queryString = "INSERT INTO phaseblock_t values ($phaseNum, $blockID, $count)"; 
 $result = mysqli_query($conn, $queryString);
 $count = $count + 1;
}

  //echo "Block ID: " . $blockID . PHP_EOL;
  //echo "Prompt: " . $prompt . PHP_EOL;
?>
