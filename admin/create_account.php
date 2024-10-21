<!DOCTYPE html>
<html lang="en">

<?php 
include('header.php');
// Include your database connection
include('dbcon.php'); // Make sure this file contains the $conn variable and the connection logic.
?>
<head>    
  <link rel="shortcut icon" href="../images/logo copy.png"/>
  <!-- Add SweetAlert CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
</head>
<body>
<style>
    body { font-family: Arial, sans-serif; }
    .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
    .modal-content { background: white; margin: 5% auto; padding: 20px; width: 50%; }
    .close { cursor: pointer; float: right; }
</style>
<div class="container">
  <div class="col-lg-3"></div>
  <div class="col-lg-6">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Event Organizer Registration Form</h3>
      </div>
      <div class="panel-body">
        <form method="POST">
          <table align="center">
            <tr><td colspan="5"><strong>Basic Information</strong><hr /></td></tr>
            <tr>
              <td>
                Firstname:
                <input type="text" name="fname" class="form-control" placeholder="Firstname" aria-describedby="basic-addon1" required autofocus>
              </td>
              <td>&nbsp;</td>
              <td>
                Middlename:
                <input type="text" name="mname" class="form-control" placeholder="Middlename" aria-describedby="basic-addon1" required>
              </td>
              <td>&nbsp;</td>
              <td>
                Lastname:
                <input type="text" name="lname" class="form-control" placeholder="Lastname" aria-describedby="basic-addon1" required>
              </td>
            </tr>
            
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr><td colspan="5"><strong>Account Security</strong><hr /></td></tr>
            <tr>
              <td>
                Username:
                <input type="text" name="username" class="form-control" placeholder="Username" aria-describedby="basic-addon1" required>
              </td>
              <td>&nbsp;</td>
              <td>
                Password:
                <input id="password" type="password" name="password" class="form-control" placeholder="Password" aria-describedby="basic-addon1" required>
              </td>
              <td>&nbsp;</td>
              <td>
                Re-type Password:
                <input id="confirm_password" type="password" name="password2" class="form-control" placeholder="Re-type Password" aria-describedby="basic-addon1" required>
              </td>
            </tr>
            
            <tr>
              <td colspan="4">&nbsp;</td>
              <td><span id='message'></span></td>
            </tr>
          </table>
          <br />
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
            <label class="form-check-label" for="flexCheckDefault">
              <a href="#" id="openModal">Terms and condition</a>
            </label>
          </div>
          <div class="btn-group pull-right">
            <a href="index.php" type="button" class="btn btn-default">Cancel</a>
            <button name="register" type="submit" class="btn btn-primary">Register</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col-lg-3"></div>
</div>
      
<div id="myModal" class="modal">
  <div class="modal-content">
      <span class="close">&times;</span>
      <p>
      <b> TERMS AND CONDITIONS<br>
      Welcome to MCC Event Judging.<br>
       By using our website and services, you agree to the following terms ad conditions. </b><br>
      <br>
      1. Account Creation: Provide accurate information and maintain account security.<br>
      2. System Usage: Use only for MCC event judging; no unlawful or harmful activities.<br>
      3. Data Management: Obtain necessary consents, comply with data protection laws, and maintain confidentiality.<br>
      4. Event Management: Ensure fair event setups and provide clear guidelines to judges.<br>
      5. Intellectual Property: Respect MCC's ownership of system content and materials.<br>
      6. Updates: System may be modified; users must use the latest version.<br>
      7. Termination: MCC can terminate accounts for violations or at their discretion.<br>
      8. Liability: System provided "as is" with no warranties; MCC not liable for certain damages.<br>
      9. Changes to Terms: Terms may be modified; continued use implies acceptance.<br>
      10. Governing Law: Terms governed by laws of the specified jurisdiction.<br>
      By creating an account, you acknowledge that you have read, understood, and agree to be bound by these terms and conditions.<br>
      </p>
  </div>
</div>

<!-- Footer -->
<footer class="footer">
  <div class="container">
    <font size="2" class="pull-left"><strong>Event Judging System &middot; 2023 &COPY;</strong></font>
  </div>
</footer>      

<!-- Add SweetAlert JS before other scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>

<!-- Other scripts -->
<script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
<script src="javascript/jquery1102.min.js"></script>

<script>
const modal = document.getElementById("myModal");
const btn = document.getElementById("openModal");
const span = document.getElementsByClassName("close")[0];

btn.onclick = () => modal.style.display = "block";
span.onclick = () => modal.style.display = "none";
window.onclick = (event) => { if (event.target === modal) modal.style.display = "none"; };

$('#password, #confirm_password').on('keyup', function () {
  if ($('#password').val() == $('#confirm_password').val()) {
    $('#message').html('Matching').css('color', 'green');
  } else {
    $('#message').html('Not Matching').css('color', 'red');
  }
});
</script>

<?php 
if (isset($_POST['register'])) {
   $fname = htmlspecialchars($_POST['fname']);
   $mname = htmlspecialchars($_POST['mname']);  
   $lname = htmlspecialchars($_POST['lname']);  
   $username = htmlspecialchars($_POST['username']);  
   $password = htmlspecialchars($_POST['password']);  
   $password2 = htmlspecialchars($_POST['password2']);  
  
   if ($password == $password2) {
     $stmt = $conn->prepare("INSERT INTO organizer (fname, mname, lname, username, password, access, status) VALUES (?, ?, ?, ?, ?, 'Organizer', 'offline')");
     $stmt->bind_param("sssss", $fname, $mname, $lname, $username, $password);
     
     if ($stmt->execute()) {
       $stmt->close();
       echo "
         <script>
           Swal.fire({
             icon: 'success',
             title: 'Registration Successful',
             text: 'Organizer " . $fname . " " . $mname . " " . $lname . " registered successfully!',
             confirmButtonText: 'OK'
           }).then((result) => {
             if (result.isConfirmed) {
               window.location = 'index.php';
             }
           });
         </script>
       ";
     } else {
       echo "
         <script>
           Swal.fire({
             icon: 'error',
             title: 'Registration Failed',
             text: 'An error occurred while registering the organizer. Please try again.',
             confirmButtonText: 'OK'
           });
         </script>
       ";
     }
   } else {
     echo "
       <script>
         Swal.fire({
           icon: 'error',
           title: 'Password Mismatch',
           text: 'Organizer " . $fname . " " . $mname . " " . $lname . " registration cannot be done. Password and Re-typed password did not match.',
           confirmButtonText: 'OK'
         });
       </script>
     ";
   }
}
?>

</body>
</html>