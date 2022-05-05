<?php
//Downloads a file to users PC that displays users prefromance in a block 
//Author: Bernadette K.

//get blockID from post
$blockID = $_POST["blockID"];
$userID = $_POST["userID"];

//open connection to database
$conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");
if (!$conn)
        die("BlockID not found: Database Error.".mysqli_connect_error());

//echo "<script> alert('Stand By! Downloading User Block Results...');window.location='../dataCenter.html'</script>";

//find how many trials are in this block
$queryString = "SELECT trialNum FROM block_T WHERE blockID = $blockID";
$trialNum =  mysqli_query($conn, $queryString);
$count = $trialNum->fetch_assoc();
$count = $count['trialNum'];

//create view where blockID and userID are used
$createView = "create view dataBlock AS SELECT * FROM data_T WHERE blockID = $blockID AND userID = $userID";
//run query
$result =  mysqli_query($conn, $createView);

//create query
$queryString = "SELECT BO, stimIDOne, stimIDTwo, isCorrect, clicked, clickTime, phaseID FROM trial_T, dataBlock WHERE trial_T.trialID = dataBlock.trialID ORDER BY phaseID, BO;";
//run query
$stats =  mysqli_query($conn, $queryString);

//create new file
$myfile = fopen("renameMe.txt", "w") or die("Unable to open file!");
//write some info at the top of the document
$txt = "All data for UserID: " . $userID . " on BlockID: " . $blockID . "\n";
fwrite($myfile, $txt);

//iterate through query and add each line to the file
$i = 0;
while($row = mysqli_fetch_assoc($stats)) {
  //if this is the start of a block
  $test = bcmod($i, $count);
  if($test == 0) {
    //write top of file info
    $txt = "\nBlockID:  " . $blockID . "\nUserID:  " . $userID . "\nPhaseID:   " . $row["phaseID"] . "\n";
    fwrite($myfile, $txt);
    $txt = "Stim1\t| Stim2\t| Match\t| Comparison Time  | Correct\n";
    fwrite($myfile, $txt);
  }
        
  //fix the "clicked" row to display Y/N 
  if($row["isCorrect"] == $row["clicked"]) {
        $correct = "Y";
  } else {
        $correct = "N";
  }
  
  $txt = $row["stimIDOne"] . "\t| " . $row["stimIDTwo"] . "\t| " . $row["isCorrect"] . "\t| " . $row["clickTime"] . "\t\t   | " . $correct . "\n";
  fwrite($myfile, $txt);
        
  $i = $i + 1;  
}

//delete view
$dropView = "DROP VIEW dataBlock";
$result =  mysqli_query($conn, $dropView);

//close connection
mysqli_close($conn);

fclose($myfile);
header('Content-Description: File Transfer');
header('Content-Disposition: attachment; filename='.basename("renameMe.txt"));
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize("renameMe.txt"));
header("Content-Type: text/plain");
readfile("renameMe.txt");

?>
