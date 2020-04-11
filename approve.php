<?php
// Dependency for databse connections.
require_once("dbconnect.php");
session_start();

// Checks if a auth_id is provided and call approvepost() from dbconnect.php.
if(isset($_POST['auth_id']))
{
  $dbconnection = new dbconnector;
  $dbconnection->connect();
  /* approvepost() checks if the provided auth_id is valid and  performs appropriate actions to approve /**
   * returns 0 if auth_idis invalid or an error occurs
   */
  $status = $dbconnection->approvepost($_POST['auth_id'], 0);
  if($status == 1)
  {
    $_SESSION['approved'] = true;
    header("Location:review.php");
  }
  else
  {
    echo 'Post unavailable or already approved';
  }
}

// Performs post approval for a superadmin without an auth_id.
elseif(isset($_POST['post_id']) && $_SESSION['role_type'] == 'superadmin')
{
  $dbconnection = new dbconnector;
  $dbconnection->connect();
  $status = $dbconnection->approvepost($_POST['post_id'], 1);
  if($status == 1)
  {
    $_SESSION['approved'] = true;
    header('Location:post.php?post_id='.$_POST['post_id']);
  }
  else
  {
    echo 'Post unavailable or already approved';
  }
}

// Error message when no auth_id is provided or if a non superadmin or admin user tries to access.
else
{
  echo "Invalid Request";
}
