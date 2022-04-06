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
        }

        function getQuestionData()
        {
          document.getElementById("questionHelpButton").addEventListener("mouseover", helpToolTip);
          
          <?php 
            $conn = new mysqli("newoneplease.ciqqgo3etyax.us-west-1.rds.amazonaws.com:3306","admin","Ilovesecurity!","labdata",3306);
            $queryString = ("SELECT stimID, stimType FROM labdata.stimuli_T");
            $stimIDs = mysqli_query($conn, $queryString);
            $i = 0;
            while($row = mysqli_fetch_array($stimIDs))
            {
                $stims[$i] = array('stimID' => $row['stimID'], 'stimType' => $row['stimType']);
            }
            $numOfStims = $stimIDs -> num_rows;

          ?>

          var stims = <?php echo json_encode($stims); ?>;
          var numOfStims = <?php echo $numOfStims; ?>;
          for(i=0; i< numOfStims ; i++)
          {

          }
          
          

          for(let i = 0; i < stims.length; i++)
          {
            document.write(stims[i]);
          }

          document.write("Completed PHP to JS array!");
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
  </body>
</html>