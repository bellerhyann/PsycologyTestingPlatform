<?php
      //session_start();
      $conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");
      if (!$conn)
        die("Database Error." . mysqli_connect_error());

      //find current phase
      $userID = 1223;
      $queryString = ("SELECT phaseID FROM user_T WHERE userID = $userID");
      $result =  mysqli_query($conn, $queryString);
      $userPH = $result->fetch_assoc() ?? -1;
      $userPH = $userPH['phaseID']; //userPH now stores the phase the user is on 

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
        echo implode(" ", $trialList);
            
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
        // push out array here
        // pushes out to javascript code as "var stimListi = {data here, data here, data here};\n"
        // go to webpage, right click, view page source to view the output
        //echo implode(" ", $stimList);
        //echo "/n";
      }
      ?>
