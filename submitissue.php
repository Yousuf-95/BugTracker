<?php

// Start session, import database and util files and check for user login

session_start();

if(!isset($_SESSION['username']))
{
     $_SESSION['error'] = 'noaccess';
     header("Location:login.php");
}
require_once("dbconnect.php");
require_once("util.php");

// Call addIssue method to add a new Issue

$dbconnection = new dbconnector;
$dbconnection->connect();
$UID1= mt_rand(1000000,9999999);
$UID2= mt_rand(1000000,9999999);
$success = $dbconnection->addIssue($_POST['title'], $_POST['description'],$_POST['resolution'],$_SESSION['user_id'], $UID1, $UID2);

// Display success or fail messages

if($success[0])
{
  $_SESSION['newissue']='true';
  if(newissue_mailer($_POST['title'], $_POST['description'], $_POST['resolution'], array($UID1, $UID2)))
  {
    echo "Email sent successfully";
  }
  else
  {
    echo "Email failed";
  }
  $_SESSION['error']='noerror';
  header("Location:addissue.php");
}
else {
  $_SESSION['error']='add_issue_failed';
  header("Location:addissue.php");
}
?>
