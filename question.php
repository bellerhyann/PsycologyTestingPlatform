<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./src/styles.css">
    <title>Question</title>
    <script type = "text/javascript">
        function getQuestionData()
        {
          var stimType = '<?php SELECT stimID, stimType, groupID FROM stimuli_T; ?>'; // grab file type from database
          var stimID = '<?php echo $stimID; ?>'; // grab file name from database
          Window.print(stimID);
        }

        function displayFirstImg() 
        {    
            document.getElementById("img").src = "./images/apple.jpg";
        }
        
        function displaySecondImg() 
        {
          document.getElementById("img").src = "./images/banana.jpg";
          setTimeout(hideImage, 3000);
          setTimeout(showButton, 3000);
        }

        function hideImage() 
        {
          document.getElementById("img").style.display="none";
        }

        function showButton() 
        {
          document.getElementById("pressButton").style.display="block";
        }

        function displayQuestion() 
        {
          document.getElementById("pressButton").style.display="none";
          document.getElementById("img").style.display="inline";
          displayFirstImg();
          setTimeout(displaySecondImg, 5000);
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
  <body onload = "getQuestionData()">
    <img id="img">
    <button id="pressButton">Press</button>
  </body>
</html>