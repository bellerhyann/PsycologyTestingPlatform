<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./src/styles.css">
  <script type="text/javascript">
    //Contributor for PHP: Skyeler Knuutila
    //Contributor for JS: Chris Barry

    var questionHelpButton, questionHelpPrompt, imageStim, soundStim, nextQuestionButton;
    var timer = 8; // number of seconds user has to answer
    var questionTimer;
    var clickTime = 0; // how long it takes user to click
    var block0,block1,block2,block3,block4,block5,block6,block7,block8,block9,block10;
    var currIndex = 0;
    var currBlock = 0;

    function onLoad() {
      //document.getElementById("title").innerHTML = timer; // remove when done testing
      questionHelpButton = document.getElementById("questionHelpButton");
      questionHelpButton.addEventListener("click", helpToolTip);
      questionHelpPrompt = document.getElementById("questionHelpPrompt");

      imageStim = document.getElementById("imageStim");
      soundStim = document.getElementById("soundStim");

      nextQuestionButton = document.getElementById("nextQuestionButton");
      nextQuestionButton.innerHTML = "Start";
      getQuestionData();
    }

    function getQuestionData() {
      <?php
      session_start();
      $conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");
      if (!$conn)
        die("Database Error." . mysqli_connect_error());
      
      //find current phase
      $userID = $_SESSION["userID"];
      $queryString = ("SELECT phaseID FROM user_T WHERE userID = $userID");
      $result =  mysqli_query($conn, $queryString);
      $userPH = $result->fetch_assoc() ?? -1;
      $userPH = $userPH['phaseID']; //userPH now stores the phase the user is on

      //Gets Phase Prompt
      $queryString = "SELECT prompt FROM phase_T WHERE phaseID = $userPH";
      $result=  mysqli_query($conn, $queryString);
      $prompt= $result->fetch_assoc();
      $prompt= $prompt['prompt'];  

      //create an array of blockID's from that phase 
      $blockList = array();
      $queryString = ("SELECT blockID FROM phaseBlock_T WHERE phaseID = $userPH ORDER BY blockOrder");
      $result =  mysqli_query($conn, $queryString);
      while ($row = mysqli_fetch_assoc($result)) {
        array_push($blockList, $row['blockID']);
      }
      //given blockID, return array of all stim and stimTypes
      //in form ["A1.png", "image", "B1.wav", "sound", .....]
      for ($j = 0; $j < sizeOf($blockList); $j++) {
        $blockID = $blockList[$j];

        //start with an array of trialID's
        $trialList = array(); //empty array
        $queryString = ("SELECT trialID FROM blockTrial_T WHERE blockID = $blockID ORDER BY trialOrder");
        $result =  mysqli_query($conn, $queryString);
        while ($row = mysqli_fetch_assoc($result)) {
          array_push($trialList, $row['trialID']);
        }

        //get array of stim and stimType by trial
        $stimList = array();
        for ($i = 0; $i <= sizeOf($trialList) - 1; $i++) {
          $trialID = $trialList[$i];
          $queryString = ("SELECT * FROM trial_T, stimuli_T WHERE trialID = \"$trialID\" AND stimIDOne = stimID OR trialID = \"$trialID\" AND stimIDTwo = stimID");
          $result =  mysqli_query($conn, $queryString);
          while ($row = mysqli_fetch_assoc($result)) {
            array_push($stimList, $row['stimID']);
            array_push($stimList, $row['stimtype']);
          }
        }
        // push out array here
        // pushes out to javascript code as "var stimListi = {data here, data here, data here};\n"
        // go to webpage, right click, view page source to view the output
        echo "block", $j, " = ", json_encode($stimList), ";\n";
      }?>
      console.log("All blocks loaded");
    }

    function getStimuli()
    {
      // get the first stimuli for this comparison
      console.log("Block",currBlock,"[",currIndex,"]"," FileName: ", block[currIndex]);
      if (block[currIndex+1]== "sound") {
        soundStim.src = "https://behaviorsci-assets.s3.us-west-1.amazonaws.com/" + block[currIndex] + ".wav";
        console.log("Got sound file: ", soundStim.src);
      } else{ //block[currIndex+1] == "image"
        imageStim.src = "https://behaviorsci-assets.s3.us-west-1.amazonaws.com/" + block[currIndex] + ".png";
        //console.log("Got image file: ", imageStim.src);
      }
      currIndex += 2; // advance to next stimID in block list
      if(currIndex == block.length) // reached end of current block
      {
        currBlock ++;
        currIndex = 0;
      }
    }
    function getNextQuestion() {
      nextQuestionButton.style.visibility = "hidden";
      if(nextQuestionButton.innerHTML == "Start") {
        nextQuestionButton.innerHTML = "Next";
      }
      document.getElementById("boxMain").style.visibility = "visible";
      questionTimer = setInterval(checkTimer, 1000); // calls checkTimer every 1000 milliseconds (every 1 second)

      eval("block = " + "block" + currBlock); // sets the current block properly
      // get stim 1
      getStimuli();
      // wait 3 seconds
      // get stim 2
      getStimuli();
    }

    function helpToolTip() {
      if (questionHelpPrompt.style.display == "none")
        questionHelpPrompt.style.display = "flex";
      else // questionHelpPrompt.style.display == "flex"
        questionHelpPrompt.style.display = "none";
    }

    function checkTimer() {
      if (timer == 1) {
        clearInterval(questionTimer); // stops the timer
        document.getElementById("boxMain").style.visibility = "hidden"; // hide the main box
        nextQuestionButton.style.visibility = "visible"; // show the next question button
        timer = 8;
      } else // timer != 0
      {
        timer--;

      }
    }

    function clicked() {
      clearInterval(questionTimer); // stops the timer
      document.getElementById("boxMain").style.visibility = "hidden"; // hide the main box
      nextQuestionButton.style.visibility = "visible"; // show next question button
    }
  </script>
  <title>Question</title>
</head>
<style>
  #body {
    background-color: #37111d;
  }

  #boxMain {
    visibility: hidden;
    margin: auto;
    border-radius: 5px;
    padding: 10px;
    box-sizing: content-box;
    width: 60%;
    color: white;
    margin-top: -130px;
    margin-left: 563px;
  }

  #clickButton {
    margin-left: 90px;
    padding: 20px;
    font-size: 40px;
    background-color: #ffffff;
    width: 192px;
    border: none;
    border-radius: 5px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    cursor: pointer;
    font-weight: 600;
  }

  #clickButton:hover{
    background-color: #969696;
  }

  #nextQuestionButton {
    margin-left: 664px;
    margin-top: 326px;
    padding: 20px;
    font-size: 40px;
    background-color: #6C2037;
    border: none;
    border-radius: 5px;
    color: #F0C975;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    cursor: pointer;
    font-weight: 600;
  }

  #nextQuestionButton:hover {
    background-color: #F0C975;
    color: #6C2037;
  }


  #questionHelpPrompt {
    display: none;
    color: #F0C975;
  }
</style>

<body id="body" onload="onLoad()">
  <img id="questionHelpButton" src="../images/questionHelpButton.png" width="50" height="50">
  <div id="questionHelpPrompt">Insert question help here:<br>Line 2 <br>Line 3 <br></div><br>

  <a id="nextQuestionButton" onclick="getNextQuestion()"></a>
  <div id="boxMain">
    <img id="imageStim"></img>
    <audio id="soundStim" src="" type="audio/wav" controls autoplay></audio><br>
    <button class="button" id="clickButton" alt="click" onclick="clicked()"></button>
  </div>
</body>

</html>
