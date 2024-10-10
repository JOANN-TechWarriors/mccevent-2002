<?php
// Load database connection
include('dbcon.php');
include('header2.php');

// Check if required URL parameters are present
if(!isset($_GET['email']) || !isset($_GET['token'])) {
    // Redirect to error 404 page
    header('HTTP/1.0 404 Not Found');
    include('error_404.php');
    exit();
  }

// Get email address and token from URL parameters
$email = $_GET['email'];
$token = $_GET['token'];

// Verify password reset token
$query = $conn->prepare("SELECT * FROM organizer WHERE email=:email AND reset_token=:token AND reset_expires > NOW()");
$query->execute(array(':email' => $email, ':token' => $token));
$user = $query->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "The reset token has expired. Please request a new password reset.";
    exit();
}

// Process password reset form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $password = $_POST['password'];
  $confirm_password = $_POST['confirm_password'];

  if ($password !== $confirm_password) {
    echo '<script>alert("Passwords do not match.");</script>';
  } else {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Update user's password in the database
    $query = $conn->prepare("UPDATE organizer SET password=:password, reset_token=NULL, reset_expires=NULL WHERE email=:email");
    $query->execute(array(':password' => $password, ':email' => $email));

    if ($query) {
        // Password updated successfully
        echo '<div class="alert alert-success" role="alert">Password reset successfully.</div>';
        header('Event Judging System');
        include('index.php');
        exit();
    } else {
        // Password update failed
        echo '<div class="alert alert-success" role="alert">Password reset failed.</div>';
            // Redirect to login page
        header('Event Judging System');
        include('index.php');
        exit();
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en">

  <body>
    <!-- Navbar
    ================================================== -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
       
            
        </div>
      </div>
    </div>
<header class="jumbotron subhead" id="overview">
  <div class="container">
    <h1>Account Reset Password</h1>
    <p class="lead">Event Judging System</p>
  </div>
</header>
    <div class="container">

  <div class="col-lg-3">
 
  </div>
  <div class="col-lg-6">
 <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Reset Password</h3>
            </div>
            <div class="panel-body">
            
   <form action="<?php echo $_SERVER['PHP_SELF'] . '?email=' . $email . '&token=' . $token; ?>" method="POST">
   
   
        
       
        
    <table align="center">
     <tr><td colspan="5">&nbsp;</td></tr>
     <tr><td colspan="5"><strong>Account Security</strong><hr /></td></tr>
     <tr>
    <td>
    New Password:
    <input id="password" type="password" name="password" class="form-control" placeholder="New Password" aria-describedby="basic-addon1" required="true" autofocus="true" />
 </td>
    <td>&nbsp;</td>
    <td>
    Confirm Password:
    <input id="confirm_password" type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" aria-describedby="basic-addon1" required="true" autofocus="true" />
 </td>
    </tr>
    
    <tr>
    <td colspan="4">&nbsp;</td>
    <td><span id='message'></span></td>
    </tr>
    
    
    </table>
 <br />
       <div class="btn-group pull-right">
  <a href="index.php" type="button" class="btn btn-default">Cancel</a>
  <button name="register" type="submit" class="btn btn-primary">Reset</button>
   </form>
</div>
 
    
            </div>
          </div>
  </div>
  <div class="col-lg-3">
 
  </div>
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" style="display: none;">
            <div class="toast-header">
                <strong class="toast-title">Title</strong>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                Body
            </div>
        </div>
          </div>
          
          
    <!-- Footer
    ================================================== -->
    <footer class="footer">
      <div class="container">
 
        <font size="2" class="pull-left"><strong>Event Judging System &middot; 2022 &COPY;</strong> </font> <br />
       
      </div>
    </footer>      
   


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
    <script src="javascript/jquery1102.min.js"></script>

<script>
    const toast = document.querySelector('.toast');

//Function to update the details of the toast
function updateToast(title, body, type) {
    const toastTitle = toast.querySelector('.toast-title');
    const toastBody = toast.querySelector('.toast-body');
    const toastHeader = toast.querySelector('.toast-header');

    // Change the title
    toastTitle.innerText = title;

    // Change the body
    toastBody.innerText = body;

    // Change the background color of the header based on the type
    if (type === 'success') {
        toastHeader.style.backgroundColor = '#28a745';
    } else if (type === 'warning') {
        toastHeader.style.backgroundColor = '#ffc107';
    } else if (type === 'error') {
        toastHeader.style.backgroundColor = '#dc3545';
    }
}
</script>
  </body>
</html>

 

