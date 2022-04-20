<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./src/styles.css">
    <title>Question</title>
    <script type = "text/javascript">
        var questionHelpButton, questionHelpPrompt, image_stim1, image_stim2, sound_stim1, sound_stim2;
        var stims; // converts PHP array and stores in JS array of {stimID: name, stimType: type} objects
        var numStims; // used for total number of stims in database
        
        function onLoad()
        {
          questionHelpButton = document.getElementById("questionHelpButton");
          questionHelpButton.addEventListener("click", helpToolTip);
          questionHelpPrompt = document.getElementById("questionHelpPrompt");

          imageStim = document.getElementById("imageStim");
          soundStim = document.getElementById("soundStim");
          getUserData();
          getQuestionData(); // gets all question data from database
          getNextComparison(0); // gets next comparison
        }

	
        function getUserData()
        { 
          console.log
          (
            <?php 
              session_start();
              $conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac"); 
              if (!$conn)
                  die("Database Error.".mysqli_connect_error());
		  
              $userID = $_SESSION["userID"];
              $queryString = ("SELECT phaseID FROM user_T WHERE userID = $userID");
              $result =  mysqli_query($conn, $queryString);
	      $userPH = $result->fetch_assoc();
	      $userPH = $userPH['phaseID']; //userPH now stores the phase yje user is on 
		  
              //while ($row=mysqli_fetch_row($result))
                //echo $row[0];	
	     ?>
          );
        }
        // get question data from database, convert PHP to JS and store
        // getQuestionData() written by Chris B & Nick Wood
        function getQuestionData()
        {
          <?php
            $conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");
            if (!$conn)
                die("Database Error.".mysqli_connect_error());
		
	     //grab the blocks for the phase 
	     $queryString = "SELECT blockID FROM phaseBlock_T WHERE phaseID = $userPH ";
	     $block = mysqli_query($conn, $queryString); //holds all of the blockID's in our phase
		
	     while ($row = mysqli_fetch_row($row))
	     {
	       //Now grab the TrialID's for each block
               $queryString = "SELECT trialID FROM blockTrial_T WHERE blockID = $row[0]";
               $trials = mysqli_query($conn, $queryString);
	
	       //loops through each trial in each block 
	       while ($trialRows = mysqli_fetch_row($trials))
	       {
		 //$trialRows holds the trialID so now let's grab each stim in that trial 
		 $queryString = "SELECT * FROM trial_T WHERE trialID = \"$trialRows\"";
		 $infoQuery = mysqli_query($conn, $queryString);
		  
		 $trialInfo = mysqli_fetch_row($infoQuery);
		 //$trialInfo[0] = trialID     ^
		 //$trialInfo[1] = stimIDOne   ^
		 //$trialInfo[2] = stimIDTwo   ^
		 //$trialInfo[3] = isCorrect   ^
		       
		 //So now inside this loop I would call what you need to display for each trial
		       
	       }
	     }
            
            //$queryString = ("SELECT stimID, stimType FROM stimuli_T"); // grab stim data from stimuli datatable
            //$stimIDs = mysqli_query($conn, $queryString); // query with above info

            $i = 0; // incrementor variable
            //while($row = mysqli_fetch_array($stimIDs)) // fetch data
            //{
              //  $stims[$i] = array('stimID' => $row['stimID'], 'stimType' => $row['stimType']); // store values in PHP array
               // $i++; // next index
            //}
            //$numOfStims = $stimIDs -> num_rows; // grab total # of rows in database

          ?>

	  stimOne = <?php echo json_encode($trialInfo[1]); ?>;
	  stimTwo = <?php echo json_encode($trialInfo[2]); ?>;
          stims = <?php echo json_encode($stims); ?>; // converts PHP array and stores in JS array of {stimID: name, stimType: type} objects
          numStims = <?php echo $numOfStims; ?>; // stores total number of stims in database
        }

        function getNextComparison(index)
        {
          if(stims[index].stimType == "sound")
          {
            //soundStim.innerHTML += "<source src='https://behaviorsci-assets.s3.us-west-1.amazonaws.com/A1.wav' type='audio/wav'>";
            soundStim.src = "https://elasticbeanstalk-us-west-1-391170265189.s3.us-west-1.amazonaws.com/stimuli/sounds/" + stims[index].stimID + ".wav";
            console.log("Got sound file: ", soundStim.src);
          }
          else stimType == "image"
          {
            imageStim.src = "https://elasticbeanstalk-us-west-1-391170265189.s3.us-west-1.amazonaws.com/stimuli/images/" + stims[index].stimID + ".png";
            console.log("Got image file: ", imageStim.src);
          }
        }

        function helpToolTip()
        {
          if(questionHelpPrompt.style.display == "none")
            questionHelpPrompt.style.display = "flex";
          else // questionHelpPrompt.style.display == "flex"
            questionHelpPrompt.style.display = "none"; 
        }


    </script>
  </head>
  <style>
    #imgtoimgBody
    {
      background-color: white;
      margin-top: 20%;
      margin-bottom: 20%;
      display: flex;
      margin-left: auto;
      margin-right: auto;
      justify-content: center;
    }

    #image
    {
      position: fixed; /* or absolute */
      top: 50%;
      left: 50%;
    }

    #pressButton
    {
      display: flex;
      vertical-align: center;
      width: 19pc;
      margin-left: auto;
      margin-right: auto;
      justify-content: center;
    }
  </style>
  <body onload = "onLoad()">
    <img id="questionHelpButton" src="./images/questionHelpButton.png" width="50" height="50">
    <div id="questionHelpPrompt">Insert question help here:<br>Line 2 <br>Line 3 <br></div>

    <img id="imageStim"></img>

    <audio id="soundStim" src="" type="audio/wav"controls></audio>

    <p id="arrayData"></p>
  </body>
</html>
