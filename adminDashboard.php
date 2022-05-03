<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./src/styles.css">
        <title>Admin Dashboard</title>
    </head>
    <style>
        body{
            font-family: 'Verdana', sans-serif;
            justify-content: center;
        }
        table, th, td 
        {
            background-color: white;
            border-radius: 5px;
            color: black;
            border: 1px solid black;
            margin: auto;
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
            color: #
        }
        .boxMain
        {
            margin-right: 20px;
            margin-left: 20px;
            margin-top: 10px;
            justify-content: center;
            color: white;
        }
        #btn
        {
            display: flex;
            background-color: #6C2037;
            border-radius: 5px;
            width: 10pc;
            margin-left: auto;
            margin-right: auto;
            justify-content: center;
            color: #F0C975;
            text-decoration: none;
            padding: 10px;
            font-size: 14px;
            font-family: 'Verdana', sans-serif;
        }

        #btn:hover
        {
            background-color: #F0C975;
            color: #6C2037;
        }
        .button_position{
            margin: auto;
            width: 50%;
            padding: 20px;
        }
        .h1
        {
            text-align: center;
            color: #F0C975;
        }
        #title
        {
            text-align: center;
            border-radius: 5px;
            margin-left: auto;
            margin-right: auto;
            background-color: #F0C975;
            color: #6C2037;
            width: 15pc;
            font-size: 40px;
            padding: 20px;
        }
    </style>
    <body class="body">
        <div class="body_content">
            <h1 id="title" class="h1">Welcome, <?php session_start(); 
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

            $queryString = "SELECT * FROM user_T WHERE password is null";
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
         <div class="button_position">
                <a href="experimentBuilder.php" style="text-decoration: none;"><button id="btn">EDIT LAB</button></a>
		        <a href="dataCenter.html" style="text-decoration: none;"><button id="btn">VIEW DATA</button></a>
                <a href="userDelete.html" style="text-decoration: none;"><button id="btn">RESET DATA</button></a>
		<br>
         </div>
        
    </body>
    
</html>
