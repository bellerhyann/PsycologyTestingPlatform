<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./src/styles.css">
        <title>Experiment Builder</title>
    </head>
    <style>
        #experiment_builder_body
        {
            background: url("images/backgroundphoto1.jpg");
            background-size: cover;
            justify-content: center;
            vertical-align: center;
        } 

        #dashboard
        {
            color: #6C2037;
            border-radius: 50px;
            margin-top: 5%;
            margin-bottom: auto;
            margin-left: auto;
            margin-right: auto;
            width: 60pc;
            height: 35pc;
        }

        table, th, td 
        {
            background-color: white;
            border-radius: 5px;
            margin-top: 10px;
            margin-left: 280px;
            color: black;
            border: 1px solid black;
        }  

        #welcomeUserMsg
        {
            text-decoration: underline;
            justify-content: center;
            width: 275px;
            vertical-align: center;
            margin-top: auto;
            margin-bottom: auto;
            margin-left: 340px;
            margin-right: 142px;
        }

        .dropbtn 
        {
            background-color: #04AA6D;
            color: white;
            padding: 16px;
            font-size: 16px;
            border: none;
        }

        .dropdown 
        {
            position: relative;
            display: inline-block;
        }

        .dropdown-content 
        {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a 
        {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #ddd;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown:hover .dropbtn {
            background-color: #3e8e41;
        }
    </style>
    <body class="body">
        <div id="dashboard">
            <h1 id="welcomeUserMsg">Welcome, <?php session_start(); 
                $conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac"); 
                if (!$conn)
                    die("Database Error.".mysqli_connect_error());
                $userID = $_SESSION["adminUserID"];
                $queryString = ("SELECT FName FROM user_T WHERE userID = $userID");
                $result =  mysqli_query($conn, $queryString);
            while ($row=mysqli_fetch_row($result)) {
                echo $row[0];	
            }
                  ?>!</h1>
            //<table>
              //<tr>
                    //<th>Pretesting Phase 1</th>
                //</tr>
                //<tr>
                  //<td>Block 1</td>
                //</tr>
                //<tr>
                  //<td>Block 2</td>
                //</tr>
                //<tr>
                  //<td>Block 3</td>
                //</tr>
            //</table>
     <?php
            //connect to SQL using Username Password Ect
            $conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");
            if (!$conn) {
                die("Unable to Connect.".mysqli_connect_error());
                }

            $queryString = "SELECT * FROM phase_t";
            $result = mysqli_query($conn, $queryString);

            echo "<table border=1>";
            echo "<tr> <th>Phase ID</th> <th>Time allowed</th> <th>Next Phase</th> <th>Instructions</th> <th>Audio file name</th>< /tr>";
            while ($row = mysqli_fetch_array($result))
            {
                //printf("Select returned %d rows.\n", $result->phaseID)
                echo "<tr> <td>".$row["phaseID"]."</td>"."<td>".$row["allowedTime"]."</td>".
                "<td>".$row["nextPhase"]."</td><td>".$row["instructions"]."</td><td>".$row["audiofileName"]."</td></tr>";
            }

            //close connection
            mysqli_close($conn);
            ?>
            
            
            <div class="dropdown">
                <button class="dropbtn"><a href="editPhase1.html">EDIT PHASE</a></button>
            </div>
            <div class="dropdown">
                <button class="dropbtn"><a href="editStim.php">EDIT STIMULI</a></button>
            </div>
           
        </div>
    </body>
</html>
