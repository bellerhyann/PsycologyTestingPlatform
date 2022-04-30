<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./src/styles.css">
    <title>User Dashboard</title>
  </head>
  <style>
    body{
      background-color: #37111d;
      font-family: 'Verdana', sans-serif;
    }
    #user_dashboard_body
    {
      background-size: cover;
    } 

    #dashboard
    {
      margin-left: auto;
      margin-right: auto;
      width: 60pc;
      height: 35pc;
    }

    #welcomeUserMsg
    {
      color: #F0C975;
      margin-top: 341px;
      margin-bottom: auto;
      text-align: center;

    }

    #beginSessionButtontag
    {
      margin-top: auto;
    }
    #beginSessionButton
    { 
      display: flex;
      background-color: #6C2037;
      border-radius: 5px;
      vertical-align: center;
      width: 25pc;
      height: 60px;
      margin-left: auto;
      margin-right: auto;
      justify-content: center;
      color: #F0C975;
      text-decoration: none;
      border: none;
      font-size: 50px;
    }

    #beginSessionButton:hover
    {
      background-color: #F0C975; 
      color: #6C2037;
    }
    
  </style>
  <!-- For CSS, make new id for user dashboard-->
  <body id="user_dashboard_body">
      <div id="dashboard">
      <h1 id="welcomeUserMsg">
        Welcome,
        <!-- Below Line Echos Users FirstName to HTML --> 
        <?php 
          session_start(); 
          $conn = new mysqli("us-cdbr-east-05.cleardb.net:3306", "b5541841c18a2e", "ee93a776", "heroku_8eb08016ed835ac"); 
          if (!$conn)
              die("Database Error.".mysqli_connect_error());
          $userID = $_SESSION["userID"];
          $queryString = ("SELECT FName FROM user_T WHERE userID = $userID");
          $result =  mysqli_query($conn, $queryString);
          while ($row=mysqli_fetch_row($result)) {
            echo $row[0];	
          }
		    ?>!
      </h1>
          <!-- Iron out the example test -->
          <!-- For CSS, make new id for begin session button-->
          <h1 id="beginSessionButtontag"><a href="./question.php" class="button" id="beginSessionButton">Begin Session</a></h1>
      </div>
  </body>
</html>
