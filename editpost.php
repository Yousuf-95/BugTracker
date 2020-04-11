<?php

// Start session, import database and util files and check for user login

session_start();
require_once('dbconnect.php');
require_once('util.php');

if(!isset($_SESSION['username']) || $_SESSION['role_type'] != 'superadmin')
{
     if(!isset($_GET['auth_id']) && !isset($_POST['auth_id']))
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
  if($_POST['action'] == 'update')
  {
    $dbconnection->editPost($_POST['title'], $_POST['description'], $_POST['resolution'],$_POST['post_id']);
    $_SESSION['success'] = 'Record Updated';
  }
  if(isset($_POST['auth_id']))
  {
    header('Location: review.php?auth_id='.$_POST['auth_id']);
  }
  else
  {
    header( 'Location: superadmin.php' );
  }
}

// If get id is not set, redirect to superadmin panel

if(!isset($_GET['post_id']) && isset($_SESSION['username']) && !isset($_GET['auth_id']))
{
  $_SESSION['error'] = "Missing Post ID";
  header('Location: superadmin.php');
}


// get the post to edit
if(isset($_GET['post_id']))
{
  $post = $dbconnection->getPost($_GET['post_id']);
}
else
{
  $result = $dbconnection->getunapproved($_GET['auth_id']);
  $post = $result->fetch_array(MYSQLI_ASSOC);
}

?>
<!doctype html>
<html lang="en">
<head>
        <title>Edit Issue - BugTracker</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="http://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
        <link rel="icon" type="image/png" href="images\favicon.png"><!--Favicon image at the top with title of browser tab-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/style2.css">
      </head>
    <body>
      <header>
        <nav class="navbar navbar-expand-sm bg-dark navbar-dark py-3">
          <div class="container">
            <a href="dashboard.php" class="navbar-brand logo"><img src = "images/Vectorbug.svg" alt="BugTracker"></a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ml-auto">
                <?php
                if($_SESSION['role_type'] == 'superadmin')
                { echo '<li class = "nav-item"><a class = "nav-link" href="superadmin.php">Admin Dashboard</a></li>'; }
                ?>
                <li class="nav-item"><a class="nav-link" href="addissue.php">Add Issue</a></li>
                <li class="nav-item dropdown"><a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><?php echo ucfirst($_SESSION['name']); ?></a>
                  <div class="dropdown-menu">
                    <a href="logout.php" class="dropdown-item">Logout</a>
                  </div>
                </li>
                <!-- <li class="'nav-item"><a class="nav-link" ><?php echo $_SESSION['name']; ?></a></li> -->
              </ul>
            </div>
          </div>
        </nav>
      </header>

<main>


  <div class="addnew-main">

<!-- Display error if any -->

    <?php
     if(isset($_SESSION['error']))
     {
       if($_SESSION['error']=='add_issue_failed')
       {
         displayerror('addissue');
         unset($_SESSION['error']);
       }
       if($_SESSION['error']=='noerror')
       {
         echo '<p style="color:green;"><b>Issue has been Submitted Successfully for Moderation.</b><p>';
         unset($_SESSION['error']);
       }
     }

  // Display issue to edit
  if($post != NULL)
  {
  ?>
  <div class="container mt-4">
  <form class="form-default form-create-topic"  method="post" name="editissue">
          <div class="form-group">
              <label for="title">Topic Title</label>
                  <input type="text" name="title" value="<?= $post['title'] ?>"class="form-control issue-title" id="title" placeholder="Title of your Issue">

          </div>
          <div class="form-group">
              <label for="description">Description</label>
                  <textarea name="description" class="form-control form-textarea" rows="5" cols="100" placeholder="Please Describe the Issue"><?= $post['description'] ?></textarea>
          </div>
          <div class="form-group">
              <label for="resolution">Resolution</label>
                  <textarea name="resolution" class="form-control form-textarea" rows="5" cols="100" placeholder="Resolution for the Described Issue"><?= $post['resolution'] ?></textarea>

          </div>
          <input type="hidden" name="post_id" value="<?= $post['post_id'] ?>">
          <?php if(isset($_GET['auth_id']))
                { echo '<input type="hidden" name="auth_id" value="'.$_GET['auth_id'].'">'; }
          ?>
          <input type="hidden" name="moderator" value="<?= isset($_GET['auth_id'])? 'admin' : 'superadmin' ?>">
          <button type="submit" name="action" value="update" class="btn btn-secondary" >Update</button>
          <button type="submit" name="action" value="cancel" class="btn btn-secondary" >Cancel</button>
      </form>
    </div>
      <?php
    }
    else
    {
      displayerror("Post not found");
    }
      ?>

      <!-- Javascript for form validation -->
      <script>
      $(function() {
        // Initialize form validation on the registration form.
        // It has the name attribute "registration"
        $("form[name='editissue']").validate({
          // Specify validation rules
          rules: {
            title: {
              required: true,
              minlength: 10,
              maxlength: 250
            },
            description: {
              required: true,
              minlength: 10
            },
            resolution: {
              required: true,
              minlength: 10
            }
          },
          // Specify validation error messages
          messages: {
            title: {
              required: "Please provide a title",
              minlength: "The title must be at least 10 characters long",
              maxlength: "The title must be less than 250 characters long"
            },
            description: {
              required: "Please provide a description",
              minlength: "The description must be at least 10 characters long"
            },
            resolution: {
              required: "Please provide a resolution",
              minlength: "The resolution must be at least 10 characters long"
            },
          },
          // Make sure the form is submitted to the destination defined
          // in the "action" attribute of the form when valid
          submitHandler: function(form) {
            form.submit();
          }
        });
      });
      </script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
