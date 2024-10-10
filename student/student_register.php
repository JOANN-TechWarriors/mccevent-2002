<!DOCTYPE html>
<html lang="en">

<?php 
include('../admin/header.php');
?>
 <style>
        body { font-family: Arial, sans-serif; }
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
        .modal-content { background: white; margin: 5% auto; padding: 20px; width: 50%; max-height: 500px; overflow: scroll; }
        .close { cursor: pointer; float: right; }
    </style>
<div class="container">
   <div class="col-lg-3">   </div>
   <div class="col-lg-6">
      <br><br>
      <div class="panel panel-danger">
         <div class="panel-heading">
            <h3 class="panel-title"><strong>STUDENT REGISTRATION FORM</strong></h3>
         </div>
         <div class="panel-body">
            <form method="POST">
               <table align="center">
                  <tr><td colspan="5"><strong>Basic Information</strong><hr /></td></tr>
                  <tr>
                     <td>
                        <strong>Firstname:</strong>
                        <input type="text" name="fname" class="form-control" placeholder="Firstname" aria-describedby="basic-addon1" required autofocus>
                     </td>
                     <td>&nbsp;</td>
                     <td>
                        <strong>Middlename:</strong>
                        <input type="text" name="mname" class="form-control" placeholder="Middlename" aria-describedby="basic-addon1" required>
                     </td>
                     <td>&nbsp;</td>
                     <td>
                        <strong>Lastname:</strong>
                        <input type="text" name="lname" class="form-control" placeholder="Lastname" aria-describedby="basic-addon1" required>
                     </td>
                  </tr>
                  <tr><td colspan="5">&nbsp;</td></tr>
                  <tr>
                     <td>
                        <strong>Course:</strong>
                        <input type="text" name="course" class="form-control" placeholder="Course" aria-describedby="basic-addon1" required>
                     </td>
                     <td>&nbsp;</td>
                     <td colspan="3">
                        <strong>Student ID #:</strong>
                        <input type="text" name="student_id" class="form-control" placeholder="ID #" aria-describedby="basic-addon1" required>
                     </td>
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
                  <button name="register" type="submit" class="btn btn-primary">Register</button>
                  <a href="index.php" type="button" class="btn btn-default">Cancel</a>
               </div>
            </form>
         </div><!-- end panel body -->
      </div> <!-- end panel -->
   </div><!-- end col-6 -->
   <div class="col-lg-3">  </div>
</div> <!-- end container -->

 <div id="myModal" class="modal">
      <div class="modal-content">
          <span class="close">&times;</span>
          <p>
         <b>TERMS AND CONDITIONS <br>
Welcome to MCC Event Judging. By using our website and services, you agree to the following terms ad conditions.</b>
<br>
<br>
1. Account Creation:<br>
   - Only enrolled students can create accounts<br>
   - Accurate information required<br>
   - Users responsible for account security<br>
   - One account per student<br>
2. Voting Rules:<br>
   - Only registered users can vote<br>
   - Voting within specified periods<br>
   - Fair and unbiased voting required<br>
   - One vote per category per event<br>
   - Votes cannot be changed after submission<br>
3. Code of Conduct:<br>
   - Respectful behavior mandatory<br>
   - Manipulation of voting system prohibited<br>
   - Appropriate content only<br>
4. Data Privacy:<br>
   - Personal information collected and stored<br>
   - Data used for event management and system improvement<br>
   - Institution commits to data protection<br>
5. System Integrity:<br>
   - Administrators can monitor activities<br>
   - Accounts may be suspended for violations<br>
   - Results can be audited and votes disqualified if terms are violated<br>
6. Modifications:<br>
   - Terms and system may be updated<br>
   - Users will be notified of significant changes<br>
7. Liability:<br>
   - No guarantee of continuous system availability<br>
   - Institution not liable for result errors<br>
8. Agreement:<br>
   - Using the system implies acceptance of these terms<br>
By creating an account, you agreed by the terms and conditions.<br>
          </p>
      </div>
    </div>



     <script>
    const modal = document.getElementById("myModal");
    const btn = document.getElementById("openModal");
    const span = document.getElementsByClassName("close")[0];

    btn.onclick = () => modal.style.display = "block";
    span.onclick = () => modal.style.display = "none";
    window.onclick = (event) => { if (event.target === modal) modal.style.display = "none"; };
</script>

   
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="javascript/jquery1102.min.js"></script>
<script src="../assets/js/ie10-viewport-bug-workaround.js"></script>

<?php 
if(isset($_POST['register'])) {
   $fname = htmlspecialchars($_POST['fname']);
   $mname = htmlspecialchars($_POST['mname']);
   $lname = htmlspecialchars($_POST['lname']);
   $course = htmlspecialchars($_POST['course']);
   $student_id = htmlspecialchars($_POST['student_id']);

   // Database connection
   include('../admin/dbcon.php');

   $sql = "SELECT * FROM student WHERE student_id='$student_id'";
   $result = $conn->query($sql);
   $count = $result->fetchColumn();

   if ($count > 0) {
      echo "<script>
                  alert('Student ID is already registered!');
                </script>";
   }else{
      $stmt = $conn->prepare("INSERT INTO student (student_id, fname, mname, lname, course) VALUES (:student_id, :fname, :mname, :lname, :course)");
   
      $stmt->bindParam(':student_id', $student_id);
      $stmt->bindParam(':fname', $fname);
      $stmt->bindParam(':mname', $mname);
      $stmt->bindParam(':lname', $lname);
      $stmt->bindParam(':course', $course);
      
      if($stmt->execute()) {
          echo "<script>
                  alert('Student $fname $lname registered successfully!');
                  window.location = 'index.php';
                </script>";
      } else {
          echo "<script>
                  alert('Error: Could not register student.');
                </script>";
      }
   
      $stmt->close();
      $conn->close();
   }
}
?>
</body>
</html>
