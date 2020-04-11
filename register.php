<?php
require_once("util.php");
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
?>
<!doctype html>
<html lang="en">
<head>
  <title>Register - Knowledge Center</title>
  <!-- <script src="https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js"></script> -->
  <!-- <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script> -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/style2.css">
  <link rel="icon" type="image/png" href="images\favicon.png"><!--Favicon image at the top with title of browser tab-->
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

  <main>
    <section id="registeruser">
      <div class="container mt-3 w-25 border">
        <h4 class="text-center mt-2">Register</h4>
        <!-- Display error if any -->
        <?php
        if(isset($_SESSION['error']))
        {
          displayerror($_SESSION['error']);
          unset($_SESSION['error']);
        }
        ?>
        <form class="form-default" action="adduser.php" method="post" name="register">
          <div class="form-group">
            <label for="name">Name: </label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Name">
          </div>
          <div class="form-group">
            <label for="username">Username: </label>
            <input type="text" name="username" class="form-control" id="username" placeholder="Enter Username">
            <div id="status"></div>
          </div>
          <div class="form-group">
            <label for="password">Password: </label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
          </div>
          <div class="form-group">
            <label for="email">Email: </label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Email Address">
          </div>
          <div class="form-group">
            <label for="role">Please Select a Role: </label>
            <select name="role" id="role" class="form-control">
              <option value="" hidden="true" disabled selected>Role</option>
              <option value="developer">Developer</option>
              <option value="admin">Admin</option>
            </select>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-secondary btn-block">Register</button>
          </div>
          <div class="form-group" >
            <a href="superadmin.php" class="btn btn-secondary btn-block">Cancel</a>
          </div>
        </form>
      </div>
    </section>
  </main>

  <!-- jQuery for form validation -->

  <script>
  $(function() {
    // Initialize form validation on the registration form.
    // It has the name attribute "registration"
    $("form[name='register']").validate({
      // Specify validation rules
      rules: {
        name:
        {
          required: true,
          maxlength: 30
        },
        username: {
          required: true,
          minlength: 5,
          maxlength: 20
        },
        password: {
          required: true,
          minlength: 5,
          maxlength: 20
        },
        email: {
          required: true,
          email: true,
          maxlength: 40
        },
        role: {
          required: true
        }
      },
      // Specify validation error messages
      messages: {
        name: {
          required: "Please provide a name",
          maxlength: "The name must be less than 30 characters long"
        },
        username: {
          required: "Please provide a username",
          minlength: "The username must be at least 5 characters long",
          maxlength: "The username must be less than 20 characters long"
        },
        password: {
          required: "Please provide a password",
          minlength: "The password must be at least 5 characters long",
          maxlength: "The password must be less than 20 characters long"
        },
        email: {
          required: "Please provide an email address",
          email: "Please provide a valid email address",
          maxlenght: "The email address must be less than 40 characters long"
        },
        role: {
          required: "Please select an account role"
        }
      },
      // Make sure the form is submitted to the destination defined
      // in the "action" attribute of the form when valid
      submitHandler: function(form) {
        form.submit();
      }
    });
  });
  $(document).ready(function(){
    // check change event of the text field
    $("#username").keyup(function(){
      // get text username text field value
      var username = $("#username").val();

      // check username name only if length is greater than or equal to 3
      if(username.length >= 5 && username.length <= 20)
      {
        $("#status").html('Checking availability...');
        // check username
        $.post("username-check.php", {username: username}, function(data, status){
          $("#status").html(data);
        });
      }
      else
      {
        $("#status").html("");
      }
    });
  });
  </script>
  <script src="http://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
