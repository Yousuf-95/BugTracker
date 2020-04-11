<?php
// Start session, import database and util files and check for user login

session_start();
require_once('dbconnect.php');
require_once('util.php');

if(!isset($_SESSION['username']))
{
     if(!isset($_POST['auth_id']))
     {
       $_SESSION['error'] = 'noaccess';
       header("Location:login.php");
     }
}

$dbconnection = new dbconnector;
$dbconnection->connect();
// If all fields in form are set then edit post

if(isset($_POST['action']))
{
  if($_POST['action'] == 'delete')
  {
    $dbconnection->deleteUser($_POST['id']);
    $_SESSION['success'] = 'User Details Updated';
  }
  header( 'Location: superadmin.php' ) ;
}

// If get id is not set, redirect to superadmin panel

if(!isset($_GET['id']))
{
  $_SESSION['error'] = "Missing User ID";
  header('Location: superadmin.php');
}


// get the user details to edit
$user = $dbconnection->getUser($_GET['id']);

?>

<html>
<head>
<link rel="stylesheet" href="css\style.css">
<link rel="icon" type="image/png" href="images/favicon.png">
<title>Delete</title>
</head>
<body>
  <!-- Display confirmation message and button to confirm deleting a User -->
<div class="confirm-action">
<p>Confirm: Delete user : <?php echo $user['username']; ?></p>
<form method="post">
<input type="hidden" name="id" value="<?= $user['id'] ?>">
<button type="submit" name="action" value="delete" class="btn btn-secondary">Delete</button>
<a href="superadmin.php" class="btn btn-secondary btn2link">Cancel</a>
</form>
</div>
</body>
</html>
