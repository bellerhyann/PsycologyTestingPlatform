<?php

$phaseNum = $_POST["phaseNum"];
$user = $_POST["userID"];
//$phaseNum = 4111;
//$user = 1223;


//connect to the database
$conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");
if (!$conn) {
	die("Unable to Connect.".mysqli_connect_error());
}

//now print to a file 
$file = "phaseUserData.txt";
$txt = fopen($file, "w");
fwrite($txt, "UserID: ".$user." PhaseID: ".$phaseNum); 

//see how a user did on response time for the entire phase 
$queryString = "SELECT AVG(clickTime) AS result FROM data_T WHERE phaseID = $phaseNum AND userID = $user AND clicked = 1";
$phaseT = mysqli_query($conn, $queryString);
$phasetavg = $phaseT->fetch_assoc();
$phasetavg = $phasetavg['result'];

fwrite($txt, " avg response time (ms): ".$phasetavg."\n"); 




//****************************************************************************************************************************
//info about blocks in phase 

$queryString = "SELECT blockID FROM phaseBlock_T WHERE phaseID = $phaseNum";
$block = mysqli_query($conn, $queryString);
//loops through each block in the phase
while ($row = mysqli_fetch_row($block))
{
   //response time avg in this block
   $queryString = "SELECT AVG(clickTime) AS result FROM data_T WHERE phaseID = $phaseNum AND blockID = $row[0] AND clicked = 1 AND userID = $user";
   $blockt = mysqli_query($conn, $queryString);
   $blockavg = $blockt->fetch_assoc();
   $blockavg = $blockavg['result'];
	   
   fwrite($txt,"BlockID: ".$row[0]." avg response time (ms): ".$blockavg."\n"); 
    
	
    $queryString = "SELECT trialID FROM blockTrial_T WHERE blockID = $row[0]";
    $trials = mysqli_query($conn, $queryString);
    //loop through each trial 
	
    fwrite($txt,"TrialID:   |  avg response time (ms) |  Correct Response \n"); 
    while ($trialRows = mysqli_fetch_row($trials))
    {
        //grab the correct the response for the trial 
        $queryString = "SELECT isCorrect FROM trial_T WHERE trialID = \"$trialRows[0]\"";
        $ans = mysqli_query($conn, $queryString); //holds if the trial is a go or no go 
	$useANS = $ans->fetch_assoc();
	$useANS = $useANS['isCorrect'];

        //what the user found
        $queryString = "SELECT clicked FROM data_T WHERE trialID = \"$trialRows[0]\" AND blockID = $row[0] AND userID = $user";
        $userrps = mysqli_query($conn, $queryString);
	$userF = $userrps->fetch_assoc();
	$userF = $userF['clicked'] ?? -1;
	
	    
	//if the user has a response for this - sometimes it can be empty due to the nature of some phases 
	//letting users move on once a certain score is reached 
	if ($userF != -1)
	{
        	if ($useANS == $userF)
        	{
            	//user gave the correct response
            	$printANS = "+";
       	 	}
        	else 
            	$printANS = "-";
        
        	//grab resp time
        	$queryString = "SELECT clickTime FROM data_T WHERE trialID = \"$trialRows[0]\" AND blockID = $row[0] AND userID = $user";
        	$time = mysqli_query($conn, $queryString);
		$timeP = $time->fetch_assoc();
		$timeP = $timeP['clickTime'];



        	fwrite($txt,$trialRows[0]."     | ".$timeP."      | ".$printANS);
	}
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

echo "File downloaded!";

?>
