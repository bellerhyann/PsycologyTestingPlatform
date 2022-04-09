<?php

//$phaseNum = $_POST["phaseNum"];
//$user = $_POST["user"];
$phaseNum = 1;
$user = 1223;


//connect to the database
$conn = new mysqli("newoneplease.ciqqgo3etyax.us-west-1.rds.amazonaws.com:3306","admin","Ilovesecurity!","labdata",3306);
if (!$conn) {
	die("Unable to Connect.".mysqli_connect_error());
}

//now print to a file 
//Phase: 1  | avg response Time: 783 ms 
$file = "phaseUserData.txt";
$txt = fopen($file, "w");
fwrite($txt, "UserID: ".$user."PhaseID: ".$phaseNum); //this will need to be updated later for ease of user 


//gives us all rows in data_T for our phase with our user 
$queryString = "SELECT * FROM data_T WHERE phaseID = $phaseNum AND userID = $user"; 
$result = mysqli_query($conn, $queryString);

$queryString = "SELECT blockID FROM phaseBlock_T WHERE phaseID = $phaseNum ";
$block = mysqli_query($conn, $queryString); //holds all of the blockID's in our phase


//overall average time of entire phase
//This works I tested it in sql workbench
$queryString = "SELECT AVG(clickTime) AS avgColName FROM data_T WHERE phaseID = $phaseNum  AND clicked = 1 AND userID = $user";
$entPhaseCT = mysqli_query($conn, $queryString);
$data = mysqli_fetch_assoc($entPhaseCT)

//writing avg to output file 
fwrite($txt,' AVG Click Time: '.$data["avgColName"]);

//now print phase results from the user 
//trialID     | response time | correct

//loops through each block in the phase
while ($row = mysqli_fetch_array($block))
{
    fwrite($txt, "\n BlockID: ".$row[blockID]."\n TrialID | Response Time (ms) | Correct ");
    //grabing the trials in the block
    $queryString = "SELECT trialID FROM blockTrial_T WHERE blockID = $row[blockID]";
    $trials = mysqli_query($conn, $queryString);

    //loop through each trial 
    while ($trialRows = mysqli_fetch_array($trials))
    {
        //grab the correct the response for the trial 
        $queryString = "SELECT isCorrect FROM trial_T WHERE trialID = $trialRows[trialID]";
        $ans = mysqli_query($conn, $queryString); //holds if the trial is a go or no go 

        //what the user found
        $queryString = "SELECT clicked FROM data_T WHERE trialID = $trialRows[trialID] AND blockID = $row[blockID] AND userID = $user";
        $userAns = mysqli_query($conn, $queryString);

        if ($ans == $userAns)
        {
            //user gave the correct response
            $printANS = "+";
        }
        else 
            $printANS = "-";
        
        //grab resp time
        $queryString = "SELECT clickTime FROM data_T WHERE trialID = $trialRows[trialID] AND blockID = $row[blockID] AND userID = $user";
        $time = mysqli_query($conn, $queryString);



        fwrite($txt, "\n".$trialRows["trialID"]." | ".$time." | ".$printANS);
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
