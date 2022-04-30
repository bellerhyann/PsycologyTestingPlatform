<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./src/styles.css">
        <title>Experiment Builder</title>
    </head>
    <style>
        body{
            background-color: #37111d;
            font-family: 'Verdana', sans-serif;
        }
        #experiment_builder_body
        {
            background-color: #37111d;
            background-size: cover;
            margin-top: 20%;
            margin-bottom: 20%;
            display: flex;
            margin-left: auto;
            margin-right: auto;
            justify-content: center;
        } 
        .boxMain
        {
            margin: auto;
            border-radius: 5px;
            background-color: #6C2037;
            padding: 2px;
            box-sizing: content-box;
            width: 20%;
            color: white;
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
    </style>
    <body>
            <h1 id="title" class="h1">Welcome, 
                <?php session_start(); 
                $conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac"); 
                if (!$conn)
                    die("Database Error.".mysqli_connect_error());
                $userID = $_SESSION["adminUserID"];
                $queryString = ("SELECT FName FROM user_T WHERE userID = $userID");
                $result =  mysqli_query($conn, $queryString);
            while ($row=mysqli_fetch_row($result)) {
                echo $row[0];	
            }
                  ?>
                !</h1>
                <br>
        <div class="boxMain">
            <?php
            //connect to SQL using Username Password Ect
            $conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");
            if (!$conn) {
                die("Unable to Connect.".mysqli_connect_error());
                }

            $queryString = "SELECT * FROM phaseblock_t";
            $result = mysqli_query($conn, $queryString);

            echo "<table border=1>";
            echo "<tr> <th>Phase ID</th> <th>block ID</th> <th>Order</th></tr>";
            while ($row = mysqli_fetch_array($result))
            {
                //printf("Select returned %d rows.\n", $result->phaseID)
                echo "<tr> <td>".$row["phaseID"]."</td>"."<td>".$row["blockID"]."</td>".
                "<td>".$row["blockOrder"]."</td> </tr>";
            }

            //close connection
            mysqli_close($conn);
            ?>
                <div class="button_position">
                        <a href="editPhase1.html" style="text-decoration: none;"><button id="btn">EDIT PHASE</button></a>
                        <br>
                        <a href="editStim.php" style="text-decoration: none;"><button id="btn">EDIT STIMULI</button></a>
                </div>
            <br>
            <br>
        </div>
    </body>
</html>
