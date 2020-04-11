<?php
require_once('util.php');
session_start();
if(isset($_SESSION['username']))
{
  header("Location:dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login - BugTracker</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style2.css">
    <link rel="icon" type="image/png" href="images\favicon.png">
    <title>Document</title>
</head>
<body>
    <section id = "showcase">
        <div id = "showcase-content" class = "h-100">
            <div class = "container h-100">
                <div class="row align-items-center justify-content-center h-100">
                    <div class = "col-md-6  d-none d-md-block text-light">
                        <h1>Tackle <strong>bugs</strong> the smarter way</h1>
                        <div class="d-flex">
                            <div class="p-4 align-self-start">
                                <i class="fas fa-check fa-2x"></i>
                            </div>
                            <div class="p-4 align-self-end text-light">
                                <h5>Add new issues to resolve.</h5>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="p-4 align-self-start">
                                <i class="fas fa-check fa-2x"></i>
                            </div>
                            <div class="p-4 align-self-end text-light">
                                <h5>Send e-mails to project manager for a solution.</h5>
                            </div>
                        </div>
                        <div class="d-flex">
                            <div class="p-4 align-self-start">
                                <i class="fas fa-check fa-2x"></i>
                            </div>
                            <div class="p-4 align-self-end text-light">
                                <h5>Document  and save results for future reference.</h5>
                            </div>
                        </div> 
                    </div>
                    <div class = "col-md-6">        
                        <div class="card card-form">
                            <div class="card-body">
                                <h3 class="text-center text-muted">Login to get started</h3>
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
                                        <button type="submit" class="btn btn-secondary btn-block">LOG IN</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

<script>

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
    //Add a 'errormessage' class to the error label
    errorClass: "errormessage",

    //Remove 'errormessage' class to input field as jquery validate plugin adds 'errormessage' class to both label and the input field
    highlight: function(element, errorClass){
        $(element).removeClass(errorClass);
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      form.submit();
    }
  });


</script>
</body>
</html>

