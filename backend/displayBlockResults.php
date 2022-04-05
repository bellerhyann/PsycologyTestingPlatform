<? php
//get blockID from post
$blockID = $_POST["blockID"];

//open connection to database

//create view where blockID is used
$createView = "create view dataBlock if not exists AS SELECT * FROM data_T WHERE blockID = $blockID";
//run query


//create query
$queryString = "SELECT stimIDOne, stimIDTwo, isCorrect, clicked, clickTime FROM trial_T, dataBlock WHERE trialID.trial_T = trialID.dataBlock GROUP BY blockID";
//run query


//create new file
$myfile = fopen("renameMe.txt", "w") or die("Unable to open file!");

//write top of file info
$txt = "BlockID:\t" . $blockID\n;
fwrite($myfile, $txt);


//iterate through query and add each line to the file


?>
