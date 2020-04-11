<?php

// Start session, import database and util files and check for user login

session_start();
require_once('dbconnect.php');
require_once('util.php');

if(!isset($_SESSION['username']))
{
     $_SESSION['error'] = 'noaccess';
     header("Location:login.php");
}
$dbconnection = new dbconnector;
$dbconnection->connect();
$post = $dbconnection->getPost($_GET['post_id']);

?>
<!Doctype html>
<html>
<head>
  <title><?php echo $post['title'].' - Knowledge Center'; ?></title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="css\style.css">
  <link rel="icon" type="image/png" href="images\favicon.png">
</head>
<body>
  <header>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark py-3">
      <div class="container">
        <a href="dashboard.php" class="navbar-brand">AIS Solutions</a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <?php
            if($_SESSION['role_type'] == 'superadmin')
            { echo '<li class = "nav-item"><a class = "nav-link" href="superadmin.php">Admin Dashboard</a></li>'; }
            ?>
            <li class="nav-item"><a class="nav-link" href="addissue.php">Add Issue</a></li>
            <li class="nav-item dropdown"><a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['name']; ?></a>
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

  <main class="post-main">

    <!-- Display error if any -->
    <?php
    if(isset($_SESSION['approved']) && $_SESSION['approved'] == true)
    {
      echo '<p class="successmessage">Issue approved successfully.</p>';
      unset($_SESSION['approved']);
    }
    if($post['approved'] == 1 || $_SESSION['role_type'] == 'superadmin')
    {
      ?>
      <!-- Display the selected issue -->
      <div class="container">
        <div class="card mt-4 mb-2">
          <div class="card-body">
          <div class="d-flex justify-content-between mb-3">
          <p class="card-subtitle text-muted"><?php echo 'Author: '.htmlentities($post['name']).'('.htmlentities($post['username']).')';?></p>
          <p class=" card-subtitle text-muted"><?php echo 'Added on: '.date("F j, Y", strtotime($post['creation_time'])); ?></p>
        </div>
        <p class="titlelabel"><b>Title</b></p>
        <p class="title"><?php echo htmlentities($post['title']); ?></p>
        <p class="descriptionlabel"><b>Description</b></p>
        <p class="description"><?php echo htmlentities($post['description']); ?></p>
        <p class="resolutionlabel"><b>Resolution</b></p>
        <p class="resolution"><?php echo htmlentities($post['resolution']); ?></p>
        <?php
      }
      else
      {
        displayerror('Unauthorised Access');
      }
      ?>

      <!-- Display admin dashboard, edit and approve button for superadmin account -->

      <?php

      // Check if user is a superadmin
      if(isset($_SERVER['HTTP_REFERER']))
      {
        $backlink = htmlspecialchars($_SERVER['HTTP_REFERER']);
      }
      else
      {
        $backlink = htmlspecialchars($_SERVER["PHP_SELF"]."?post_id=".$_GET['post_id']);
      }
      if($_SESSION['role_type'] == 'superadmin')
      {
        echo '<div class="postpanel">';
        if($post['approved'] == 0)
        {
          echo '<form class="d-flex justify-content-center align-items-center"action="approve.php" method="post">
          <input type="hidden" name="post_id" value="'.htmlentities($_GET['post_id']).'">
          <button type="submit" class="w-50 btn bg-secondary text-white">Approve</button>
          </form>';
        }
        // echo '<div class="">';
        echo '<div class="d-flex justify-content-center"><a class="btn bg-secondary text-white mt-2 w-50" href="editpost.php?post_id='.$post['post_id'].'">Edit</a></div>';
        echo '<div class="d-flex justify-content-center"><a class="btn bg-secondary text-white mt-2 w-50" href='.$backlink.'>Back</a>';
        // echo '<div>';
      }
      else
      {
        if(isset($_SERVER['HTTP_REFERER']))
        {
          $backlink = htmlspecialchars($_SERVER['HTTP_REFERER']);
        }
        else
        {
          $backlink = htmlspecialchars($_SERVER["PHP_SELF"]."?post_id=".$_GET['post_id']);
        }
        echo '<div class="postpanel">
        <a class="btn bg-dark text-white justify-content-center" href='.$backlink.'>Back</a>';
      }
      ?>
    </div>
    </div>
    </div>
    </div>
</main>


<script src="http://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
