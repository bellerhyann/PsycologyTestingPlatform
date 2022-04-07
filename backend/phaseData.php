<?php
//This file will output all data current held for a phase 
//needs to be sent which phase we are looking at 
//$phaseNum = $_POST["phaseNum"];
$phaseNum = 1;

//connect to the database
$conn = new mysqli("newoneplease.ciqqgo3etyax.us-west-1.rds.amazonaws.com:3306","admin","Ilovesecurity!","labdata",3306);
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
$queryString = "SELECT AVG(clickTime) FROM data_T WHERE phaseID = $phaseNum AND clicked = 1";
$entPhaseCT = mysqli_query($conn, $queryString);

//number of users who have done the phase 
$queryString = "SELECT COUNT(DISTINCT userID) FROM data_T WHERE phaseID = $phaseNum";
$userNum = mysqli_query($conn, $queryString);

//now find the average of each block and % correct
while ($row = mysqli_fetch_array($block))
{
    //avg click time
    $queryString = "SELECT AVG(clickTime) FROM data_T WHERE phaseID = $phaseNum AND blockID = $row[blockID] AND clicked = 1";
    $blockavg = mysqli_query($conn, $queryString);

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

        //if it's a go trial 
        if ($correctRPS)
        {
            //clicked should be 1
            $queryString = "SELECT COUNT(clicked) FROM data_T WHERE phaseID = $phaseNum AND blockID = $row[blockID] AND trialID = $trialRows[trialID] AND clicked = 1";

        }
        //else its a no go 
        else
        {
            //clicked should be 0
            $queryString = "SELECT COUNT(clicked) FROM data_T WHERE phaseID = $phaseNum AND blockID = $row[blockID] AND trialID = $trialRows[trialID] AND clicked = 0";
        }

        $count = mysqli_query($conn, $queryString);

        //this gives us a decimal with .00 and then multiple by 100 to give us the %
        $correctPER = (bcdiv($count,$userNum, 2)) * 100;
    }

}

//now print to a file 
//Phase: 1  | avg response Time: 783 ms 
$file = "phaseData.txt";
$txt = fopen($file, "w");
fwrite($txt, "Phase: ".$phaseNum."\n Hello");
fclose($txt);

//BlockID     | avg response time | % correct
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
