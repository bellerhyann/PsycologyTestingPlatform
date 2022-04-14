<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./src/styles.css">
    <title>User Dashboard</title>
  </head>
  <style>
    #user_dashboard_body
    {
      background: url("images/backgroundphoto1.jpg");
      background-size: cover;
      justify-content: center;
      vertical-align: center;
    } 

    #dashboard
    {
      color: #F0C975;
      border-radius: 50px;
      margin-top: 5%;
      margin-bottom: auto;
      margin-left: auto;
      margin-right: auto;
      width: 60pc;
      height: 35pc;
    }

    #welcomeUserMsg
    {
      justify-content: center;
      width: 295px;
      vertical-align: center;
      margin-top: 341px;
      margin-bottom: auto;
      margin-left: 340px;
      margin-right: 142px;
    }

    #beginSessionButton
    { 
      display: flex;
      background-color: #6C2037;
      border-style: solid;
      border-width: .25pc;
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
      text-align:center;
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
          <h1 id="welcomeUserMsg">Welcome, User#<?php session_start(); echo $_SESSION["FName"]; ?>!</h1>
          <!-- Iron out the example test -->
          <!-- For CSS, make new id for begin session button-->
          <h1><a href="./question.php" class="button" id="beginSessionButton">Begin Session</a></h1>
      </div>
  </body>
</html>
