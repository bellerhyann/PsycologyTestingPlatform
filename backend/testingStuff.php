<?php 
	//Author: Skyeler Knuuttila
	//given blockID, return array of all stim and stimTypes
	//in form ["A1.png", "image", "B1.wav", "sound", .....]
	$blockID = 1; //given from json

	$conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");
	if (!$conn)
        	die("BlockID not found: Database Error.".mysqli_connect_error());
	
	//start with an array of trialID's
	$trialList = array(); //empty array
	$queryString = ("SELECT trialID FROM blockTrial_T WHERE blockID = $blockID ORDER BY trialOrder");
	$result =  mysqli_query($conn, $queryString);
	while($row = mysqli_fetch_assoc($result)) {
    		array_push($trialList, $row['trialID']);
	}

	//get array of stim and stimType by trial
	$stimList = array();
	for ($i = 0; $i <= sizeOf($trialList); $i++) {
		$queryString = ("SELECT * FROM trial_T, stimuli_T WHERE trialID = $trialList[$i] AND stimIDOne = stimID OR trialID = $trialList[$i] AND stimIDTwo = stimID");
	      	$result =  mysqli_query($conn, $queryString);
	      	while($row = mysqli_fetch_assoc($result)) {
    			array_push($stimList, $row['stimID']);
			array_push($stimList, $row['stimType']);
		}	
	}
	echo implode(" ", $stimList);
?>
