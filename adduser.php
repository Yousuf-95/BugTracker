<?php
require_once("dbconnect.php");
session_start();
if(!isset($_SESSION['username']))
{
     $_SESSION['error'] = 'noaccess';
     header("Location:login.php");
}
if($_SESSION['role_type'] != 'superadmin')
{
  echo "<strong>Unauthorised Access</strong>";
  die();
}

$dbconnection = new dbconnector;
$dbconnection->connect();
if(($dbconnection->checkavailability($_POST['username']))->num_rows > 0)
{
  $_SESSION['error'] = "Please Enter a Valid Username";
  header("Location:register.php");
}
else
{
  $success = $dbconnection->register($_POST['name'], $_POST['username'], $_POST['password'], $_POST['email'], $_POST['role']);
  if($success)
  {
    $_SESSION['success'] = 'User Creation Successfull';
    header("Location:superadmin.php");
  }
  else
  {
    $_SESSION['error']='Registration Failed';
    header("Location:register.php");
  }
}
?>
