<!DOCTYPE html>
<html lang="en">

    <?php 
    include('header.php');
    ?>

  <body>
       <style>
        body { font-family: Arial, sans-serif; }
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
        .modal-content { background: white; margin: 5% auto; padding: 20px; width: 50%; }
        .close { cursor: pointer; float: right; }
    </style>
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
        <h1>Student Registration</h1>
        <p class="lead">MCC Event Judging System</p>
      </div>
    </header>
    <div class="container">
      <div class="col-lg-3"></div>
      <div class="col-lg-6">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">Student Registration Form</h3>
          </div>
          <div class="panel-body">
            <form method="POST">
              <table align="center">
                <tr>
                  <td colspan="3"><strong>Student Information</strong><hr /></td>
                </tr>
                <tr>
                  <td>Name:</td>
                  <td colspan="2">
                    <input type="text" name="name" class="form-control" placeholder="Name" required autofocus>
                  </td>
                </tr>
                <tr>
                  <td>Course/Year/Section:</td>
                  <td colspan="2">
                    <input type="text" name="course" class="form-control" placeholder="Course/ Year/ Section" required>
                  </td>
                </tr>
                <tr>
                  <td>Student ID:</td>
                  <td colspan="2">
                    <input type="text" name="student_id" class="form-control" placeholder="Student ID" required>
                  </td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                </tr>
              </table>
                 <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                <label class="form-check-label" for="flexCheckDefault">
                  <a href="#" id="openModal">Terms and condition</a>
                </label>
              </div>
              <div class="btn-group pull-right">
                <a href="student_login.php" type="button" class="btn btn-default">Cancel</a>
                <button name="register" type="submit" class="btn btn-primary">Sign Up</button>
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
      
    <!-- Footer
    ================================================== -->
    <footer class="footer">
      <div class="container">
        <font size="2" class="pull-left"><strong>MCC Event Judging System &middot; 2024 &COPY;</strong> </font> <br />
      </div>
    </footer>      
    <script>
    const modal = document.getElementById("myModal");
    const btn = document.getElementById("openModal");
    const span = document.getElementsByClassName("close")[0];

    btn.onclick = () => modal.style.display = "block";
    span.onclick = () => modal.style.display = "none";
    window.onclick = (event) => { if (event.target === modal) modal.style.display = "none"; };
</script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
    <script src="javascript/jquery1102.min.js"></script>
  </body>
</html>

<?php 
if(isset($_POST['register']))
{
   $name = $_POST['name'];
   $course = $_POST['course'];
   $student_id = $_POST['student_id'];

   // Database connection
   include('dbcon.php');

   $conn->query("INSERT INTO students (name, course, student_id) VALUES ('$name', '$course', '$student_id')");

?>
<script>
  window.location = 'student_login.php';
  alert('Student <?php echo $name; ?> registered successfully!');
</script>
<?php  
} 
?>
