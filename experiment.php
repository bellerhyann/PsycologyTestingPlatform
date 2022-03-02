<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="./src/styles.css">
  </head>
  <body id="user_dashboard_body">
      <?php
      require '/vendor/autoload.php';
        $userID = $_GET['userID'];
        // echo "<h1> Welcome,  User #" . $userID . "!</h1>";
        header("Location: /userDashboard.html");
      ?>
  </body>
</html>
