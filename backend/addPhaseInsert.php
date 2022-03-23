<?php
//Insert new phase into phase table and blockphase table

//open connection to database
$conn = new mysqli("newoneplease.ciqqgo3etyax.us-west-1.rds.amazonaws.com:3306", "admin", "welovesecurity!", "labdata");

$phaseID = $_POST["phaseID"];
$allowedTime = $_POST["allowedTime"];
$instructions = $_POST["instructions"];
$nextPhase = $_POST["nextPhase"];
//hopefully nextPhase will be defaulted to NULL or something if left blank by admin.

//insert each block/phase into blockphase table.
//$blockIDs should be an array of whatever blocks admin selected for this phase.
foreach ($_POST["blockIDs"] as $blockIDs){
    $stmt = "INSERT INTO blockphase_T values (\"$phaseID\", \"$blockIDs\")";
    $conn->query($stmt); 
}

//insert phase into phase table.
$conn->query("INSERT INTO phase_T values (\"$phaseID\", \"$allowedTime\", \"$nextPhase\", \"$instructions\")");

//close connection
$conn->close();

?>
