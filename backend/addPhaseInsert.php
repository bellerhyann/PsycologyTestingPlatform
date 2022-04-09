<?php
//Insert new phase into phase table and blockphase table

//open connection to database
$conn = new mysqli("newoneplease.ciqqgo3etyax.us-west-1.rds.amazonaws.com:3306", "admin", "Ilovesecurity!", "labdata");

$phaseID = $_POST["phaseID"];
$allowedTime = $_POST["allowedTime"];
$instructions = $_POST["instructions"];
$nextPhase = $_POST["nextPhase"];
//hopefully nextPhase will be defaulted to NULL or something if left blank by admin.

//insert each block/phase into blockphase table.
//$blockIDs should be an array of whatever blocks admin selected for this phase.
foreach ($_POST["blockIDs"] as $blockIDs){
    $queryString = "INSERT INTO blockphase_T values (\"$phaseID\", \"$blockIDs\")";
    $stmt = mysqli_query($conn, $queryString);
}

//insert phase into phase table.
//I need to check the order of these values for phase_T and update it! 
$queryString = ("INSERT INTO phase_T values (\"$phaseID\", \"$allowedTime\", \"$nextPhase\", \"$instructions\")");
$phaseINS = mysqli_query($conn, $queryString);


//close connection
$conn->close();

?>
