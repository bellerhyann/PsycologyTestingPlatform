<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./src/styles.css">
    <title>Question</title>
    <script type = "text/javascript">
        function getQuestionData()
        {
          /*<?php 
          
          //$conn = new mysqli("newoneplease.ciqqgo3etyax.us-west-1.rds.amazonaws.com:3306","admin","Ilovesecurity!","labdata",3306);
          //$queryString = ("SELECT stimID FROM stimuli_T");
          //$stimID = mysqli_query($conn, $queryString);

         // $queryString = ("SELECT stimType from stumuli_T");
          //$stimType = mysqli_query($conn, $queryString);

          //?>;

          //var stimID = "<?php echo "$stimID" ?>";
          //var stimType = "<?php echo "$stimType" ?>";

          window.print(stimID, stimType);
          if(stimType == ".wav")
          {
          }
          else if(stimType == ".png")
          {

          }*/
        }

        function helpButtonClick
        {
          
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
    <img id="helpTooltip" src="/images/helpToolTip.png">
    <img id="img">
    <button id="pressButton">Press</button>
  </body>
</html>