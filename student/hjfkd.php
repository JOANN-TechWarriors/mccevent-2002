<!DOCTYPE html>
<html lang="en">

    <?php 
    include('../admin/header.php');
    ?>

  <body>

      <div class="container">
        <h1>Student Registration</h1>
      </div>
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
                  <td>Student ID #:</td>
                  <td colspan="2">
                    <input type="text" name="student_id" class="form-control" placeholder="Student ID" required>
                  </td>
                </tr>
                <tr>
                  <td colspan="3">&nbsp;</td>
                </tr>
              </table>
              <div class="btn-group pull-right">
                <a href="student_login.php" type="button" class="btn btn-default">Cancel</a>
                <button name="register" type="submit" class="btn btn-primary">Register</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-3"></div>
    </div>
    
    <!-- Footer
    ================================================== -->
    <footer class="footer">
      <div class="container">
        <font size="2" class="pull-left"><strong>MCC Event Judging System &middot; 2023 &COPY;</strong> </font> <br />
      </div>
    </footer>      

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
