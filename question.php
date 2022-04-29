<!DOCTYPE html>
<html>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./src/styles.css">
  <script type="text/javascript">
    var questionHelpButton, questionHelpPrompt, image_stim1, image_stim2, sound_stim1, sound_stim2;
    var stims; // converts PHP array and stores in JS array of {stimID: name, stimType: type} objects
    var numStims; // used for total number of stims in database
    var blockList;

    function createCookie(name, value, days) {
      var expires;

      if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
      } else {
        expires = "";
      }

      document.cookie = escape(name) + "=" +
        escape(value) + expires + "; path=/";
    }

    function onLoad() {
      questionHelpButton = document.getElementById("questionHelpButton");
      questionHelpButton.addEventListener("click", helpToolTip);
      questionHelpPrompt = document.getElementById("questionHelpPrompt");

      imageStim = document.getElementById("imageStim");
      soundStim = document.getElementById("soundStim");
      getBlockList();
      // automatically start loop based on phase ID
      for (let i = 0; i < blockList.length(); i++) {
        getQuestionData(i); // gets all question data from database
      }
      getNextComparison(0); // gets next comparison
    }


    function getBlockList() {
      <?php
        //Author: Skyeler Knuuttila
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
        echo "User PhaseID: ", json_encode($userPH);

        //create an array of blockID's from that phase 
        $blockList = array();
        $queryString = ("SELECT blockID FROM phaseBlock_T WHERE phaseID = $userPH ORDER BY blockOrder");
        $result =  mysqli_query($conn, $queryString);
        while ($row = mysqli_fetch_assoc($result)) {
          array_push($blockList, $row['blockID']);
        }

        //given blockID, return array of all stim and stimTypes
        //in form ["A1.png", "image", "B1.wav", "sound", .....]
        for($i = 0; $i<=sizeOF($blockList); $i++)
        {
          $blockID = $i;

          //start with an array of trialID's
          $trialList = array(); //empty array
          $queryString = ("SELECT trialID FROM blockTrial_T WHERE blockID = $blockID ORDER BY trialOrder");
          $result =  mysqli_query($conn, $queryString);
          while ($row = mysqli_fetch_assoc($result)) {
            array_push($trialList, $row['trialID']);
          }

          //get array of stim and stimType by trial
          $stimList = array();
          for ($i = 0; $i <= sizeOf($trialList) - 1; $i++) 
          {
            //$trialList[$i] is a string, we need an int
            $trialID = intval($trialList[$i]);
            $queryString = ("SELECT * FROM trial_T, stimuli_T WHERE trialID = $trialID AND stimIDOne = stimID OR trialID = $trialID AND stimIDTwo = stimID");
            $result =  mysqli_query($conn, $queryString);
            while ($row = mysqli_fetch_assoc($result)) 
            {
              array_push($stimList, $row['stimID']);
              array_push($stimList, $row['stimtype']);
            }
          }
          // push out array here
          echo "var stimList", $i, " = ", json_encode($stimList);

        }
        //$stimList is the array frontend will need to pull
      ?>

      //grab the array '$blockList' from the php
      //var users = <php echo json_encode($userArray); ?>;
      blockList = <?php echo json_encode($blockList); ?>;
    }

    // get question data from database, convert PHP to JS and store
    // getQuestionData() written by Chris B & Nick Wood
    function getQuestionData(index) {
      createCookie("gfg", "GeeksforGeeks", "10");
      //this needs to be put in a for loop and needs to post one blockID
      // add a loop to give block id 
      <?php
      //Author: Skyeler Knuuttila
      //given blockID, return array of all stim and stimTypes
      //in form ["A1.png", "image", "B1.wav", "sound", .....]
      $blockID = $_COOKIE["gfg"];

      $conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");
      if (!$conn)
        die("BlockID not found: Database Error." . mysqli_connect_error());

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
        //$trialList[$i] is a string, we need an int
        $trialID = intval($trialList[$i]);
        $queryString = ("SELECT * FROM trial_T, stimuli_T WHERE trialID = $trialID AND stimIDOne = stimID OR trialID = $trialID AND stimIDTwo = stimID");
        $result =  mysqli_query($conn, $queryString);
        while ($row = mysqli_fetch_assoc($result)) {
          array_push($stimList, $row['stimID']);
          array_push($stimList, $row['stimtype']);
        }
      }
      //$stimList is the array frontend will need to pull
      ?>
    }

    function getNextComparison(index) {
      if (stims[index].stimType == "sound") {
        //soundStim.innerHTML += "<source src='https://behaviorsci-assets.s3.us-west-1.amazonaws.com/A1.wav' type='audio/wav'>";
        soundStim.src = "https://behaviorsci-assets.s3.us-west-1.amazonaws.com/" + stims[index].stimID + ".wav";
        console.log("Got sound file: ", soundStim.src);
      } else stimType == "image" {
        imageStim.src = "https://behaviorsci-assets.s3.us-west-1.amazonaws.com/" + stims[index].stimID + ".png";
        console.log("Got image file: ", imageStim.src);
      }
    }

    function helpToolTip() {
      if (questionHelpPrompt.style.display == "none")
        questionHelpPrompt.style.display = "flex";
      else // questionHelpPrompt.style.display == "flex"
        questionHelpPrompt.style.display = "none";
    }
  </script>
  <title>Question</title>
</head>
<style>
  #imgtoimgBody {
    background-color: white;
    margin-top: 20%;
    margin-bottom: 20%;
    display: flex;
    margin-left: auto;
    margin-right: auto;
    justify-content: center;
  }

  #image {
    position: fixed;
    /* or absolute */
    top: 50%;
    left: 50%;
  }

  #pressButton {
    display: flex;
    vertical-align: center;
    width: 19pc;
    margin-left: auto;
    margin-right: auto;
    justify-content: center;
  }
</style>

<body class="background">
  <img id="questionHelpButton" src="./images/questionHelpButton.png" width="50" height="50">
  <div id="questionHelpPrompt">Insert question help here:<br>Line 2 <br>Line 3 <br></div>

  <img id="imageStim"></img>

  <audio id="soundStim" src="" type="audio/wav" controls></audio>

  <p id="arrayData"></p>
</body>

</html>