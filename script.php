<?php
require_once("dbconnect.php");
require_once("util.php");
$dbconnection = new dbconnector;
$dbconnection->connect();
$result = $dbconnection->getallunapproved();
$num_matches = count($result);

$currenttime = time();

for( $i = 0 ; $i < $num_matches ; $i++){
  $row = $result[$i];
  if( $row['auth_id1'] != 0  || $row['auth_id2'] != 0)
  {
  if($currenttime - $row['lastemail_time'] >= 60){
      newissue_mailer($row['title'], $row['description'], $row['resolution'], array($row['auth_id1'],$row['auth_id2']), true);
    }
  }
  }
  die();
 ?>
