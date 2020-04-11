<?php
/* dependency for newissue_mailer(), contains email alert template.
 * -Contains the generateEmail() function
 */
require_once('issueAlert.php');


//Function to display error messages
function displayerror($message, $source = 'undefined')
{
  if($source == 'login')
  {
    echo '<div style="color:red;"><b>Incorrect Username/Password.</b><div>';
  }
  elseif($source == 'noaccess')
  {
    echo '<div style="color:red;"><b>Please Login First.</b><div>';
  }
  else
  {
    echo '<div style="color:red;"><b>'.$message.'</b><div>';
  }
}

/*Function to send out new issue and approval reminder email alerts
  @returns - 0 on failure and 1 on success*/
function newissue_mailer($title, $description, $resolution, $auth_id, $isReminder = false)
{
  $from = "yf.yousuf95@gmail.com";
  //Array containing the list of email addresses that're to be notified.
  $to_emails = array("yf.yousuf95@gmail.com");
  if($isReminder)
  {
    $subject = "Issue Approval Reminder";
  }
  else
  {
    $subject = "New Issue Created";
  }
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  // Create email headers
  $headers .= 'From: AIS Knowledge Base <'.$from.'>'."\r\n".
    'Reply-To: '.$from."\r\n" .
    'X-Mailer: PHP/' . phpversion();
  $state = 1;
  foreach($to_emails as $index => $to_email)
  {
    if($auth_id[$index] != 0)
    {
      //generateEmail returns the content of the email in HTML format.
      $message = generateEmail($title, $description, $resolution, $auth_id[$index], $isReminder);
      if(!mail($to_email, $subject, $message, $headers))
      {
        $state = 0;
      }
    }
  }
  return $state;
}
?>
