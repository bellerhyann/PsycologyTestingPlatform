<?php
//This file will output all data current held for a phase 
//needs to be sent which phase we are looking at 
//$phaseNum = $_POST["phaseNum"];
$phaseNum = 1;

//connect to the database
$conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");
if (!$conn) {
	die("Unable to Connect.".mysqli_connect_error());
}

//finds all data in data_T that matches our phase and all of it's blocks 

//gives us all rows in data_T for our phase 
$queryString = "SELECT * FROM data_T WHERE phaseID = $phaseNum"; 
$result = mysqli_query($conn, $queryString);

$queryString = "SELECT blockID FROM phaseBlock_T WHERE phaseID = $phaseNum ";
$block = mysqli_query($conn, $queryString); //holds all of the blockID's in our phase

//find avg response time for each block 
//SELECT AVG (clickTime) FROM data_T WHERE phaseID and blockID

//overall average time of entire phase
//This works I tested it in sql workbench
$queryString = "SELECT AVG(clickTime) AS result FROM data_T WHERE phaseID = $phaseNum AND clicked = 1";
$entPhaseCT = mysqli_query($conn, $queryString);
$phaseCT = $entPhaseCT->fetch_assoc();
$phaseCT = $phaseCT['result'];


//number of users who have done the phase 
$queryString = "SELECT COUNT(DISTINCT userID) AS result FROM data_T WHERE phaseID = $phaseNum";
$users = mysqli_query($conn, $queryString);
$userNum = $users->fetch_assoc();
$userNum = $userNum['result'];

echo $userNum "/n/n";

//now print to a file 
//Phase: 1  | avg response Time: 783 ms 
$file = "phaseData.txt";
$txt = fopen($file, "w");
fwrite($txt, "Phase: ".$phaseNum." | Number of students taken phase: ".$userNum." | Phase avg ".$phaseCT);
fwrite($txt, "BlockID  | avg response time | % correct");

//now find the average of each block and % correct
while ($row = mysqli_fetch_array($block))
{
    //avg click time
    $queryString = "SELECT AVG(clickTime) AS result FROM data_T WHERE phaseID = $phaseNum AND blockID = $row[blockID] AND clicked = 1";
    $blockin = mysqli_query($conn, $queryString);
    $blockAVG = $blockin->fetch_assoc();
    $blockAVG = $blockAVG['result'];


    //finding correct % within each block 
    //we are gonna need to look at each trial so let's select all trials frrom blockTrial_T
    $queryString = "SELECT trialID FROM blockTrial_T WHERE blockID = $row[blockID]";
    $trials = mysqli_query($conn, $queryString);

    //loop through each trial 
    while ($trialRows = mysqli_fetch_array($trials))
    {
        //grab the correct response for this trial 
        $queryString = "SELECT isCorrect FROM trial_T WHERE trialID = $trialRows[trialID]";
        $correctRSP = mysqli_query($conn, $queryString);
	$curr = $correctRSP->fetch_assoc();
	$curr = $curr['isCorrect'];
	    
        $queryString = "SELECT COUNT(clicked) AS result FROM data_T WHERE phaseID = $phaseNum AND blockID = $row[blockID] AND trialID = $trialRows[trialID] AND clicked = $curr";
        $stat = mysqli_query($conn, $queryString);
	$count = $stat->fetch_assoc();
	$count = $count['result'];
	    
	    
        //this gives us a decimal with .00 and then multiple by 100 to give us the % - DOES NOT WORK BEACUSE NOT STRING
        $correctPER = (bcdiv($count,$userNum, 2)) * 100;
	    
	//BlockID     | avg response time | % correct
	fwrite($txt,"\n".$row["blockID"]." | ".$blockAVG." | ".$correctPER);	    

    }

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
