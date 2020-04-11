<?php
if(isset($_POST['username']))
{
	// include Database connection file
	require_once("dbconnect.php");
  $dbconnection = new dbconnector;
  $dbconnection->connect();
	$result = $dbconnection->checkavailability($_POST['username']);

	if($result->num_rows > 0)
	{
		// username is already exists
		echo '<div style="color: red;"> <b>'.$_POST['username'].'</b> is already in use. </div>';
	}
	else
	{
		// username is available.
		echo '<div style="color: green;"> <b>'.$_POST['username'].'</b> is available. </div>';
	}
}
?>
