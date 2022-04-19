<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./src/styles.css">
        <title>Admin Dashboard</title>
    </head>
    <style>
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

        body{
            font-family: 'Verdana', sans-serif;
        }
        .center
        {
            text-align: center;
            color: white;
        }

        .background
        {
            background-color: rgb(26, 16, 41);
            text-align: center;
            
        }

        .boxMain
        {
            margin-right: 20px;
            margin-left: 20px;
            margin-top: 10px;
            justify-content: center;
            color: white;
        }

        .box2
        {
            margin-right: 20px;
            margin-left: 20px;
            margin-top: 50px;
            justify-content: center;
            color: white;
            border: 1px solid grey;
            background-color: grey;
            padding: 10px;
        }

        .box3
        {
            margin-right: 20px;
            margin-left: 20px;
            border: 1px solid grey;
            background-color: grey;
            padding: 10px;
        }
        .button{
            background-color: #384e5c;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 15px;
            margin: 4px 2px;
            cursor: pointer;
        }

    </style>
    <body class="body">
        <div class="body_content">
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

        
            
            
            <?php
            //connect to SQL using Username Password Ect
            $conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");
            if (!$conn) {
                die("Unable to Connect.".mysqli_connect_error());
                }

            $queryString = "SELECT * FROM user_T";
            $result = mysqli_query($conn, $queryString);

            echo "<table border=1>";
            echo "<caption>Lab Users</caption>";
            echo "<tr> <th>First Name</th> <th>Last Name </th><th>User ID</th><th>Phase ID</th></tr>";
            while ($row = mysqli_fetch_array($result))
            {
                //printf("Select returned %d rows.\n", $result->userID)
                echo "<tr> <td>".$row["FName"]."</td>"."<td>".$row["LName"]."</td>".
                "<td>".$row["userID"]."</td><td>".$row["phaseID"]."</td></tr>";
            }

            //close connection
            mysqli_close($conn);
            ?>
        
         </div>
         <div>
                <a href="experimentBuilder.php" class="button">Edit Lab</a>
                <a href="'" class="button">View Data</a
                <br>
         </div>
        
    </body>
    
</html>
