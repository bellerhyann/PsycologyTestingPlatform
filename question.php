<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./src/styles.css">
    <title>Question</title>
    <script type = "text/javascript">
        var questionHelpPrompt, image_stim1, image_stim2, sound_stim1, sound_stim2;
        var questionsLeft = 999;
        var dummy = "chrissssxxxssss";
        function onLoad()
        {
          questionHelpButton = document.getElementById("questionHelpButton");
          questionHelpButton.addEventListener("mouseover", helpToolTip);
          questionHelpPrompt = document.getElementById("questionHelpPrompt");
          image_stim1 = document.getElementById("image_stim1");
          image_stim2 = document.getElementById("image_stim2");
          sound_stim1 = document.getElementById("sound_stim1");
          sound_stim2 = document.getElementById("sound_stim2");
          questionsLeft = 999;
          getQuestionData();
        }

        // get question data from database, convert PHP to JS and store
        function getQuestionData()
        {
          <?php 
            $conn = new mysqli("newoneplease.ciqqgo3etyax.us-west-1.rds.amazonaws.com:3306","admin","Ilovesecurity!","labdata",3306); // establish mysqli connection
            $queryString = ("SELECT stimID, stimType FROM labdata.stimuli_T"); // grab stim data from stimuli datatable
            $stimIDs = mysqli_query($conn, $queryString); // query with above info

            $i = 0; // incrementor variable
            while($row = mysqli_fetch_array($stimIDs)) // fetch data
            {
                $stims[$i] = array('stimID' => $row['stimID'], 'stimType' => $row['stimType']); // store values in PHP array
                $i++; // next index
            }
            $numOfStims = $stimIDs -> num_rows; // grab total # of rows in database

          ?>

          var stims = <?php echo json_encode($stims); ?>; // converts PHP array and stores in JS array of {stimID: name, stimType: type} objects
          var numStims = <?php echo $numOfStims; ?>; // stores total number of stims in database
          
          // to access web console: inspect element then click console to view the below messages!!
          console.log(stims); // throws stims object to web console for testing
          console.log("Successfully loaded stimuli data!!!!!!!"); // confirmation message
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
    <br>
    <div id="questionHelpPrompt">Insert question help here:<br>Line 2 <br>Line 3 <br></div>

    <div>
      <img id="image_stim1">
      <img id="image_stim2">
    </div>

    <audio>
      <source id="sound_stim1">
      <source id="sound_stim2">
    </audio>

    <p id="arrayData"></p>
  </body>
</html>