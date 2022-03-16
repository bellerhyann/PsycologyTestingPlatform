
<?php
  $userID = $_GET['userID'];
  echo "<h1> Welcome,  User #" . $userID . "!</h1>";
  header("Location: /frontend/userDashboard.html");
?>