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
                <a href="/experimentBuilder.php'" class="button">Edit Lab</a>
                <a href="/experimentBuilder.php'" class="button">View Data</a
                <br>
         </div>
        
    </body>
</html>
