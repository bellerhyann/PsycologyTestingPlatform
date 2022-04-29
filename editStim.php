<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./src/styles.css">
        <title>Stimuli Editor</title>
    </head>
    <style>
        #edit_stim_body
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

        #content
        {
            margin-left: 250px;
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

        .dropbtn {
            background-color: #6C2037;
            color: black;
            padding: 16px;
            font-size: 16px;
            border: none;
        }

        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f1f1f1;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

            .dropdown-content a {
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
            background-color: #706538;
        }
    </style>
    <body class="body">
        <div id="dashboard">
            <?php
            //connect to SQL using Username Password Ect
            $conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac");
            if (!$conn) {
                die("Unable to Connect.".mysqli_connect_error());
                }
            
   

            $queryString = "SELECT * FROM stimuli_t";
            $result = mysqli_query($conn, $queryString);

            echo "<table border=1>";
            echo "<tr> <th>Stimuli ID</th> <th>Stimuli Type</th> <th>Group ID</th> </tr>";
            while ($row = mysqli_fetch_array($result))
            {
                //printf("Select returned %d rows.\n", $result->phaseID)
                echo "<tr> <td>".$row["stimID"]."</td>"."<td>".$row["stimtype"]."</td>".
                "<td>".$row["groupID"]."</td></tr>";
            }

            //close connection
            mysqli_close($conn);
            ?>
            
            <div id="content">
                <form action="./backend/uploadStimuli.php" id="upload_stim" method="post" enctype="multipart/form-data">
                    <div class="dropdown"><input name="imgFile" type="file" class="dropbtn">
                    
                    <select id="stim_key" name="stim_key">
                        <option value="A1">A1</option>
                        <option value="A2">A2</option>
                        <option value="A3">A3</option>
                        <option value="B1">B1</option>
                        <option value="B2">B2</option>
                        <option value="B3">B3</option>
                        <option value="C1">C1</option>
                        <option value="C2">C2</option>
                        <option value="C3">C3</option>
                    </select>

                    </div>
                    <div class="dropdown"><input type="submit" name="submit" value="Upload" class="dropbtn"></div>
                </form>
            </div>
        </div>
    </body>
</html>
