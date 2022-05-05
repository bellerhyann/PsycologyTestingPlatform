function updateDB() {
      <?php
//Author: Skyeler K. 
//Updates Databse from user side 

        //given an array of clickTime's for each blockID
        //blockID, phaseID, trialID's, and userID are given
        session_start();
        $userID = $_SESSION['userID'];
        $phaseID = $_SESSION['phaseID'];
        $trialList = $_SESSION['trialList'];
        $blockID = $_POST['blockID'];
        $conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");
        if (!$conn)
          die("Database Error." . mysqli_connect_error());
        
        //iterate through $trialList and given array
        for ($i = 0; $i <= sizeOf($trialList) - 1; $i++) {
          $trialID = $trialList[$i];
          $clicked = true;
          //if clickTime == 8000, 'clicked' = false
          if($clickTimeList[$i] == 8000) {
            $clicked = false; 
          }
          //create query
          $queryString = ("INSERT INTO data_T VALUES($i, \"$trialID\", $userID, $phaseID, $clicked, $clickTime[$i], $blockID");
          //run query
          $result =  mysqli_query($conn, $queryString);
        }
        //close connection
        mysqli_close($conn);
      ?>
    }
