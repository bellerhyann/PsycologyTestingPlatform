<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./src/styles.css">
        <title>Stimuli Editor</title>
    </head>
    <style>
        body{
            background-color: #37111d;
        }
        #edit_stim_body
        {
            background-color: #37111d;
            background-size: cover;
            display: flex;
            margin-left: auto;
            margin-right: auto;
            justify-content: center;
        } 
        #dashboard
        {
            color: #6C2037;
            margin-top: 10%;
            margin-bottom: auto;
            margin-left: auto;
            margin-right: auto;
            width: 20pc;
            height: 100pc;
        }

        table, th, td 
        {
            background-color: white;
            border-radius: 5px;
            color: black;
            border: 1px solid black;
            margin: auto;
        }
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #7e4747;
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
            background-color:#F0C975;
        }
        .boxMain
        {
            margin: auto;
            border-radius: 5px;
            background-color: #6C2037;
            padding: 10px;
            box-sizing: content-box;
            width: 50%;
            color: white;
            display: flex;
            justify-content: center;            
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
    <body id="edit_stim_body">
        <div id="dashboard">
            <h1 id="title" class="h1">Edit Stimuli</h1>
            <br>
            <br>
            <div id="boxMain">
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
            
                <br>
                <br>
                <form action="./backend/uploadStimuli.php" id="upload_stim" method="post" enctype="multipart/form-data">
                    <input name="imgFile" type="file" class="dropbtn">
                    <br>
                    <br>
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
                    <br>
                    <br>
                    <select id="stim_ext" name="stim_ext">
                        <option value="image">image</option>
                        <option value="sound">sound</option>
                    </select>
                    <div class="dropdown"><input type="submit" name="submit" value="Upload" id="btn"></div>
                </form>
                <br>
                <br>
            </div>
        </div>
    </body>
</html>
