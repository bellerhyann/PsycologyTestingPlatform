<!DOCTYPE html>
<html>
<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<body>

<div id="myPlot" style="width:100%;max-width:700px"></div>
<script type = "text/javascript">
  <?php
 $conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");
 if (!$conn) {
   	die("Unable to Connect.".mysqli_connect_error());
 }
//THE LINE BELOW THIS STILL NEEDS TO BE GIVEN PHASE ID FROM USER
 $queryString = ("SELECT * FROM data_T ORDER BY phaseID ASC, blockID ASC, BO ASC, userID ASC"); // grab data from data table ordered as shown
 $data = mysqli_query($conn, $queryString); // query with above info
//var_dump($data);
 if($data->num_rows > 0)
 {
     //initialize needed variables
	 $phaseIndex = -1;
     $blockIndex = -1;//-1 because on first run of while loop, prevBlock won't equal currBlock as there is no prevBlock yet.
	 $prevPhase = 'what';
     $prevBlock = 'what';
     $prevTrial = 'what';
	 $highestBlockIndex = 0;
     //sift through each row in the data_T at specified phaseID
     while($row = mysqli_fetch_array($data))
     {
        $trialID = $row['trialID'];
		$currPhase = $row['phaseID'];
        $currBlock = $row['blockID'];
        $currUser = $row['userID'];

        if($prevBlock != $currBlock || $prevPhase != $currPhase)
        {//If the block changed, we need to increment block index
            if($blockIndex >= 0 && $phaseIndex >= 0)
            {//block will change on first iteration but we can't record percentCorrect yet
                $percentCorrect[$phaseIndex][$blockIndex] = ($sumCorrect/$numTrials)*100;
                //record percent correct as array of floats corresponding to each block in the phase
            }
            //increment blockIndex as the above if statement specifies we are on data for a new block.
			if($prevPhase != $currPhase)
			{
				$bi = 0;
				while($bi <= $blockIndex)
				{//create X axis for phase
					$blockOrder[$phaseIndex][$bi] = $bi+1;
					$bi++;
				}
				$phaseIndex++;
				$usedPhases[$phaseIndex] = $currPhase;
				if($highestBlockIndex <$blockIndex) $highestBlockIndex = $blockIndex;
				$blockIndex = 0;
			}
			else if($prevBlock != $currBlock)
			{
				$blockIndex++;
			}
            //reset variables for next block
            $sumCorrect = 0;
            $numTrials = 0;
        }
        //WHERE trialID = $trialID
        $queryString = ("SELECT * FROM trial_T");
        $trial = mysqli_query($conn, $queryString);
        while($trialRow = mysqli_fetch_array($trial))
		{
			if($trialRow["trialID"] == $trialID)
		    {
			    $isCorrect = $trialRow['isCorrect'];
		    }
	    }
        //Increment sumCorrect depending on whether or not user
        //clicked in time or not and whether or not they were supposed to. 
        //This code assumes clickTime is stored in data_T as milliseconds.
        if($isCorrect == 1 && $row['clicked'] == 1 && $row['clickTime'] < 8000)
        {
            $sumCorrect++;
        }//if above is true, they clicked when they were supposed to. if below, they didn't click and weren't supposed to.
        else if($isCorrect == 0 && ($row['clicked'] == 0 || $row['clickTime'] >= 8000))
        {
            $sumCorrect++;
        }
        $numTrials++;
	$prevPhase = $currPhase;
        $prevBlock = $currBlock;
        $prevTrial = $trialID;
     }
     $percentCorrect[$phaseIndex][$blockIndex] = ($sumCorrect/$numTrials)*100;
     //create data for X-axis that is just an array of values 1 through i
     //where i is the blocks in order from first in phase to last in phase.
     $bi = 0;
	 while($bi <= $blockIndex)
	 {
		$blockOrder[$phaseIndex][$bi] = $bi+1;
		$bi++;
	 }
 }

?>
var xArray = <?php echo json_encode($blockOrder); ?>;
console.log(xArray);
var yArray = <?php echo json_encode($percentCorrect); ?>;
console.log(yArray);
var phaseIDs = <?php echo json_encode($usedPhases); ?>;
console.log(phaseIDs);
var upperRange = <?php echo ($highestBlockIndex+1); ?>;
console.log(upperRange);

// Define Data
var i = 0;
var data = new Array();
while(i<=(<?php echo $phaseIndex; ?>))
{
	//check if phase has 2 or more blocks.
	if(yArray[i].length > 1)
	{
		data.push({x: xArray[i], y: yArray[i], mode:"lines", name:"Phase: " + phaseIDs[i]});
		console.log("Phase: " + phaseIDs[i]);
	}
	i++;
}
console.log(data);
// Define Layout
var layout = {
  xaxis: {range: [1, upperRange], title: "Block"},
  yaxis: {range: [0, 100], title: "% Correct"},  
  title: "All Phase Results"
};

// Display using Plotly
Plotly.newPlot("myPlot", data, layout);
</script>

</body>
</html>
