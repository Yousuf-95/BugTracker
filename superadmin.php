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
if($_SESSION['role_type'] != 'superadmin')
{
  echo "<strong>Unauthorised Access</strong>";
  die();
}

// Get all posts and users from databse

$dbconnection = new dbconnector;
$dbconnection->connect();
$allposts = $dbconnection->getallPosts();
$userlist = $dbconnection->getUsers();
?>
<!Doctype html>
<html>
<head>
  <title>Super-Admin Dashboard - BugTracker</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

<!-- Tabs for unapproved, approved and users -->

  <main class="dash-main">
    <div class="container1">
    <ul class="tabs mt-3">

<!-- Approved posts tab -->

        <li class="tab">
          <input type="radio" name="tabs" checked="checked" id="tab1" />
          <label for="tab1">Approved Posts</label>
          <div id="tab-content1" class="content">
              <?php
              if(isset($_SESSION['success']))
              {
                // if($_SESSION['success'] == 'RecordDeleted')
                  echo '<div class = message><b>'.$_SESSION['success'].'</b></div>';
                  unset($_SESSION['success']);
                }
              ?>
              <table class="table table-sm table-striped">
                <thead class="thead-dark">
                <tr>
                  <th class="text-center">User</th>
                  <th class="text-center">Date</th>
                  <th class="text-center">Issue Title</th>
                  <th class="text-center">Description</th>
                  <th class="text-center">Action</th>
                </tr>
              </thead>
                <?php
                $found = 0;
                foreach($allposts as $post){
                  if($post['approved'] == 1)
                  {
                    $found++;
                    echo "<tr><td  data-label='Name'>";
                    echo htmlentities($post['name']);
                    echo "</td><td nowrap data-label='Date' >";
                    echo (htmlentities (date('d-m-Y', strtotime($post['creation_time']))));
                    echo ("</td><td data-label='Title   ' >");
                    echo (htmlentities($post['title']));
                    echo ("</td><td data-label='Description   ' >");
                    echo (htmlentities($post['description']));
                    echo ("</td><td>");
                    ?>
                    <label class="dropdown bg-secondary rounded">
                        <div class=" btn dropdown-toggle text-white" data-toggle="dropdown">
                          Action
                        </div>
                        <ul class="dropdown-menu">
                          <li><?php echo('<a  class="dropdown-item" href="post.php?post_id='.$post['post_id'].'">View</a>'); ?> </li>
                          <li><?php echo('<a  class="dropdown-item" href="editpost.php?post_id='.$post['post_id'].'">Edit</a>'); ?> </li>
                          <li><?php echo('<a  class="dropdown-item" href="delete.php?post_id='.$post['post_id'].'">Delete</a>'); ?> </li>
                        </ul>
                      </label>
                    <?php
                    echo("</td></tr>\n");
                  }
                }
                if(!$found)
                {
                  echo "<tr><td class='text-center' colspan='5'>No Issues Found</td></tr>";
                }
                ?>
              </table>
          </div>
        </li>

<!-- Unapproved posts tab -->

<li class="tab">
  <input type="radio" name="tabs" id="tab2" />
  <label for="tab2">Unapproved Posts</label>
  <div id="tab-content2" class="content">
      <?php
      if(isset($_SESSION['success']))
      {
        // if($_SESSION['success'] == 'RecordDeleted')
          echo '<div class = message><b>'.$_SESSION['success'].'</b></div>';
          unset($_SESSION['success']);
        }
      ?>
      <table class="table table-sm table-striped">
        <thead class="thead-dark">
        <tr>
          <th class="text-center">User</th>
          <th class="text-center">Date</th>
          <th class="text-center">Issue Title</th>
          <th class="text-center">Description</th>
          <th class="text-center">Action</th>
        </tr>
      </thead>
        <?php
        $found = 0;
        foreach($allposts as $post){
          if($post['approved'] == 0)
          {
            $found++;
            echo "<tr><td data-label='Name' class='text-left'>";
            echo htmlentities($post['name']);
            echo "</td><td data-label='Date' class='text-left'>";
            echo (htmlentities (date('d-m-Y', strtotime($post['creation_time']))));
            echo ("</td><td data-label='Title'class='text-left'>");
            echo (htmlentities($post['title']));
            echo ("</td><td data-label='Description'class='text-left'>");
            echo (htmlentities($post['description']));
            echo ("</td><td class='text-left'>");
            ?>
            <label class="dropdown bg-secondary rounded">
                <div class=" btn dropdown-toggle text-white" data-toggle="dropdown">
                  Action
                </div>
                <ul class="dropdown-menu">
                  <li><?php echo('<a  class="dropdown-item" href="post.php?post_id='.$post['post_id'].'">View</a>'); ?> </li>
                  <li><?php echo('<a  class="dropdown-item" href="editpost.php?post_id='.$post['post_id'].'">Edit</a>'); ?> </li>
                  <li><?php echo('<a  class="dropdown-item" href="delete.php?post_id='.$post['post_id'].'">Delete</a>'); ?> </li>
                </ul>
              </label>
            <?php
            echo("</td></tr>\n");
          }
        }
        if(!$found)
        {
          echo "<tr><td class='text-center' colspan='5'>No Issues Found</td></tr>";
        }
        ?>
      </table>
  </div>
</li>


<!-- User management tab -->

        <li class="tab">
          <input type="radio" name="tabs" id="tab3" />
          <label for="tab3">User Management</label>
          <div id="tab-content3" class="content">
            <div class="table-link">
              <a href="register.php"><button type="submit" class="btn mb-1 text-white bg-secondary rounded">Add New User</button></a>
            </div>
              <table class="table table-sm table-striped">
                <thead class="thead-dark">
                <tr>
                  <th>User ID</th>
                  <th>Name</th>
                  <th>Username</th>
                  <th>Password</th>
                  <th>Role</th>
                  <th>Action</th>
                </tr>
              </thead>
                <?php
                $found = 0;
                foreach($userlist as $user){
                    $found++;
                    echo "<tr><td data-label='UserID'>";
                    echo htmlentities($user['id']);
                    echo "</td><td data-label='Name'>";
                    echo htmlentities($user['name']);
                    echo "</td><td data-label='Username'>";
                    echo htmlentities($user['username']);
                    echo "</td><td data-label='Password'>";
                    echo("<span class='font-weight-bold'>*********</span>");

                    echo "</td><td data-label='Role Type'>";
                    echo htmlentities($user['role_type']);
                    echo "</td><td>";
                    ?>
                    <label class="dropdown bg-secondary rounded">
                        <div class="btn dropdown-toggle text-white" data-toggle="dropdown">
                          Action
                        </div>
                        <ul class="dropdown-menu">
                          <li><?php echo('<a class="dropdown-item" href="edituser.php?id='.$user['id'].'">Edit</a>'); ?> </li>
                          <li><?php echo('<a class="dropdown-item "href="deleteuser.php?id='.$user['id'].'">Delete</a>'); ?> </li>

                        </ul>
                      </label>
                    <?php
                    echo("</td></tr>");
                }
                if(!$found)
                {
                  echo "<tr><td class='text-center' colspan='6'>No Users Found</td></tr>";
                }
                ?>
              </table>
          </div>
        </li>

      </ul>
    </div>
  </main>


  <script>
  $(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.css("text-security") == "disc")
  {
    input.css("-webkit-text-security", "none");
    input.css("-moz-text-security", "none");
  }
  else {
    {
      input.css("-webkit-text-security", "disc");
      input.css("-moz-text-security", "disc");
    }
  }
  });
  </script>
  <script src="http://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
