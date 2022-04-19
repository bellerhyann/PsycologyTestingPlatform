<?php 

$conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");
if (!$conn) {
	die("Unable to Connect.".mysqli_connect_error());
}

//!!!this needs to be changed to a post from FrontEnd!!!!
$phaseNum = 1;

//Some general info for the entire Phase 

//overall average time of entire phase
$queryString = "SELECT AVG(clickTime) AS result FROM data_T WHERE phaseID = $phaseNum AND clicked = 1";
$entPhaseCT = mysqli_query($conn, $queryString);
$phaseCT = $entPhaseCT->fetch_assoc();
$phaseCT = $phaseCT['result'];

//echo $phaseCT."<br>";


//number of users who have done the phase 
$queryString = "SELECT COUNT(DISTINCT userID) AS result FROM data_T WHERE phaseID = $phaseNum";
$users = mysqli_query($conn, $queryString);
$userNum = $users->fetch_assoc();
$userNum = $userNum['result'];


//echo $userNum."<br>";

//now print to a file 
//Phase: 1  | avg response Time: 783 ms 
$file = "phaseData.txt";
$txt = fopen($file, "w");
fwrite($txt, "Phase: ".$phaseNum." | Number of students taken phase: ".$userNum." | Phase avg ".$phaseCT." ms\n");


//*********************************************************************************************************************
//info about the blocks in the phase 

//grabs all the blocks in the phase
$queryString = "SELECT blockID FROM phaseBlock_T WHERE phaseID = $phaseNum ";
$block = mysqli_query($conn, $queryString); //holds all of the blockID's in our phase

while ($row = mysqli_fetch_row($block))
{
    //avg click time for the block 
    $queryString = "SELECT AVG(clickTime) AS result FROM data_T WHERE phaseID = $phaseNum AND blockID = $row[0] AND clicked = 1";
    $blockin = mysqli_query($conn, $queryString);
    $blockAVG = $blockin->fetch_assoc();
    $blockAVG = $blockAVG['result'];
	

  //echo "BLOCK ".$row[0]."<br>"; //this prints out each blockID we find belonging to the phaseNum

  //Now grab the TrialID's for each block
  $queryString = "SELECT trialID FROM blockTrial_T WHERE blockID = $row[0]";
  $trials = mysqli_query($conn, $queryString);

	
  fwrite($txt, "BlockID  | avg response time ms");
  fwrite($txt,"\n".$row[0]."        | ".$blockAVG);
  
  fwrite($txt, "\nTrialID  | avg response time ms | % correct");
	
	
  //loop looks at each trial in the block
  while ($trialRows = mysqli_fetch_row($trials))
    {
       //echo "Trial ".$trialRows[0]."   ";
	  
       //grab the correct response for this trial 
       $queryString = "SELECT isCorrect FROM trial_T WHERE trialID = \"$trialRows[0]\"";
       $correctRSP = mysqli_query($conn, $queryString);
       $curr = $correctRSP->fetch_assoc();
       $curr = $curr['isCorrect'];
	  
       $queryString = "SELECT AVG(clickTime) AS result FROM data_T WHERE phaseID = $phaseNum AND blockID = $row[0] AND trialID = \"$trialRows[0]\" AND clicked = 1";
       $trialt = mysqli_query($conn, $queryString);
       $tAVG = $trialt->fetch_assoc();
       $tAVG = $tAVG['result'];
	  
	  
       $queryString = "SELECT COUNT(clicked) AS result FROM data_T WHERE phaseID = $phaseNum AND blockID = $row[0] AND trialID = \"$trialRows[0]\" AND clicked = $curr";
       $stat = mysqli_query($conn, $queryString);
       $count = $stat->fetch_assoc();
       $count = $count['result'];
	  
       //echo $curr."<br>";
	  
        //this gives us a decimal with .00 and then multiple by 100 to give us the %
        $correctPER = (bcdiv($count,$userNum, 2)) * 100;
	    
	//TrialID     | avg response time | % correct
	fwrite($txt,"\n".$trialRows[0]."     | ".$tAVG."    | ".$correctPER);	
    }
  fwrite($txt,"\n");

}

fclose($txt);
header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename='.basename($file));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file));
header("Content-Type: text/plain");
readfile($file);

//close connection
mysqli_close($conn);

?>
