<? php
//get blockID from post
$blockID = $_POST["blockID"];

//open connection to database
$conn = new mysqli("newoneplease.ciqqgo3etyax.us-west-1.rds.amazonaws.com:3306", "admin", "Ilovesecurity!", "labdata");
if (!$conn)
        die("BlockID not found: Database Error.".mysqli_connect_error());

//find how many trials are in this block
$queryString = "SELECT trialNum FROM block_T WHERE blockID = $blockID";
$count =  mysqli_query($conn, $queryString);

//create view where blockID is used
$createView = "create view dataBlock if not exists AS SELECT * FROM data_T WHERE blockID = $blockID";
//run query
$result =  mysqli_query($conn, $createView);

//create query
$queryString = "SELECT stimIDOne, stimIDTwo, isCorrect, clicked, clickTime, phaseID FROM trial_T, dataBlock WHERE trialID.trial_T = trialID.dataBlock GROUP BY phaseID";
//run query
$stats =  mysqli_query($conn, $queryString);

//create new file
$myfile = fopen("renameMe.txt", "w") or die("Unable to open file!");

//iterate through query and add each line to the file
while($row = mysqli_fetch_assoc($stats)) {
  //if this is the start of a block
  if($row % $count == 0) {
    //write top of file info
    $txt = "BlockID:\t" . $blockID . "\n PhaseID:\t" . $row["phaseID"] . "\n";
    fwrite($myfile, $txt);
    $txt = "Stim1\t| Stim2\t| Match\t| Comparison Time\t| User Clicked\n";
    fwrite($myfile, $txt);
  }
  
  $txt = $row["stimIDOne"] . "\t| " . $row["stimIDTwo"] . "\t| " . $row["isCorrect"] . "\t| " . $row["clickTime"] . "\t| " . $row["clicked"] . "\n";
  fwrite($myfile, $txt);
  
}

//delete view
$dropView = "DROP VIEW[dataBlock]";
$result =  mysqli_query($conn, $dropView);

//close connection
mysqli_close($conn);

?>
