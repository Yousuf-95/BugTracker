<?php

// Start session, import database and util files and check for user login

session_start();
require_once("dbconnect.php");

if(isset($_GET['auth_id']))
{
  $dbconnection = new dbconnector;
  $dbconnection->connect();
  $result = $dbconnection->getunapproved($_GET['auth_id']);
  $post = $result->fetch_array(MYSQLI_ASSOC);
  $num_rows = $result->num_rows;
}
else
{
  $num_rows = 0;
}
?>

 <!Doctype html>
 <html>
 <head>
   <title>Review Issue - AIS Knowledge Base</title>
   <link rel="stylesheet" href="css\style.css">
   <link rel="icon" type="image/png" href="images\favicon.png">
 </head>
 <body>
   <header>
     <div class="logo">
         <a href="dashboard.php" class="logo-link"><p>AIS Knowledge Base </p></a>
     </div>

     <!-- Nav bar -->

             <nav class="searchres-bar">
                 <ul class="nav-list">
                   <li>
                     <form class="searchform searchform-nav" action="search.php" method="get">
                         <div class="form-group">
                             <input type="text" name="query" class="searchbox searchbox-nav" id="username" placeholder="Search..." <?php if(isset($_GET['query'])) {echo 'value="'.$_GET['query'].'"';}?>>
                             <button type="submit" class="btn btn-secondary searchbtn searchbtn-nav">Search</button>
                         </div>
                     </form>
                   </li>
                     <li><a class = "nav-darklnk" href="addissue.php"><button type="submit" class="nav-btn">Add Issue</a></li>
                     <?php
                     if(isset($_SESSION['username']))
                     {
                     echo '<li>
                       <div class="dropdown">
                         <button type="submit" class="nav-btn">'.$_SESSION['name'].'</button>
                         <div class="dropdown-content">
                         <a href="logout.php">Logout</a>
                         </div>
                       </div>
                     </li>';
                    }
                     ?>
                 </ul>
             </nav>
   </header>


 <main class="post-main">

   <!-- Display success message on approval  -->
   <?php
   if(isset($_SESSION['approved']) && $_SESSION['approved'] == true)
   {
     echo '<div class="postcontainer">
           <div class="successmessage">Issue approved successfully.</div>
           </div>';
     unset($_SESSION['approved']);
   }

   // Display form

   elseif($num_rows > 0)
   {
     echo '<div class="postcontainer">';
     if(isset($_SESSION['success']))
     {
       echo '<p class="successmessage">'.$_SESSION['success'].'</p>';
       unset($_SESSION['success']);
     }
     echo '<div class="post-details">
          <p class="author">Author: '.htmlentities($post['name']).'('.htmlentities($post['username']).')</p>
          <p class="posttime">Added on: '.date("F j, Y", strtotime($post['creation_time'])).'</p>
          </div>';
          echo  '<p class="titlelabel"><b>Title</b></p>
            <p class="title">'.htmlentities($post['title']).'</p>
            <p class="descriptionlabel"><b>Description</b></p>
            <p class="description">'.htmlentities($post['description']).'</p>
            <p class="resolutionlabel"><b>Resolution</b></p>
            <p class="resolution">'.htmlentities($post['resolution']).'</p>
          </div>
          <div class="postpanel">
            <form action="approve.php" method="post">
              <input type="hidden" name="auth_id" value="'.htmlentities($_GET['auth_id']).'">
              <button type="submit" class="nav-btn btn2">Approve</button>
            </form>
            <a class="btn2link" href="editpost.php?auth_id='.$_GET['auth_id'].'"><button type="submit" class="nav-btn btn2 btn2">Edit</button></a>
            </div>';
    }
    else
    {
      echo '<div class="postcontainer">
            <p class="errormessage">Issue already approved or does not exist.</p>
            </div>';
    }
    ?>
 </main>
 </body>
 </html>
