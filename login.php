<?php
require_once('util.php');
session_start();
if(isset($_SESSION['username']))
{
  header("Location:dashboard.php");
}
?>
<!doctype html>
<html lang="en">
<head>
  <title>Login - Knowledge Center</title>
  <script src="https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/style2.css">
  <link rel="icon" type="image/png" href="images\favicon.png">
</head>
<body>
  <section id="login" style="height: 100vh" class="d-flex align-items-center justify-content-center">
    <div class="w-25">
      <div class="card card-form">
        <div class="card-body">
          <h3 class="text-center">Please login</h3>
          <form action="validate.php" method="post" name="login">
            <div class="form-group">
              <label for="username">Username: </label>
              <input type="text" name="username" class="form-control" id="username" placeholder="Enter Username">
            </div>
            <div class="form-group">
              <label for="password">Password: </label>
              <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-secondary btn-block">Log in</button>
            </div>
          </form>

        </div>
      </div>
    </div>
  </section>

</body>
<!-- jQuery for form validation -->

<script>
$(function() {
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  $("form[name='login']").validate({
    // Specify validation rules
    rules: {
      username: {
        required: true,
        minlength: 5,
        maxlength: 20
      },
      password: {
        required: true,
        minlength: 5,
        maxlength: 20
      }
    },
    // Specify validation error messages
    messages: {
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
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      form.submit();
    }
  });
});

</script>

</body>
</html>
