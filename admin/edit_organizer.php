<?php
$request = $_SERVER['REQUEST_URI'];
if (substr($request, -4) == '.php') {
    $new_url = substr($request, 0, -4);
    header("Location: $new_url", true, 301);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

    <?php 
    include('header.php');
     include('session.php');
     ?>
<head>
<link rel="shortcut icon" href="../images/logo copy.png"/>
</head>
  <body>



    <div class="container">
 
  <div class="col-lg-12">
 
 



 <a href="edit_tabulator" class="btn btn-danger"><strong>TABULATOR SETTINGS &raquo;</strong></a>  
 
 <hr />
 
 <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title"><strong>Organizer Settings Panel</strong></h3>
            </div>
            <div class="panel-body">
    
    
    
    
    

            <form method="POST" enctype="multipart/form-data">
    <div class="col-lg-6">
        <?php
        $query = $conn->query("SELECT * FROM organizer WHERE organizer_id='$session_id'") or die(mysql_error());
        while ($row = $query->fetch()) {
        ?>
        <table align="center">
            <tr><td colspan="5"><strong>Basic Information</strong><hr /></td></tr>
            <tr>
                <td>Firstname:<input type="text" name="fname" class="form-control" placeholder="Firstname" value="<?php echo $row['fname']; ?>" required autofocus></td>
                <td>&nbsp;</td>
                <td>Middlename:<input type="text" name="mname" class="form-control" placeholder="Middlename" value="<?php echo $row['mname']; ?>" required></td>
                <td>&nbsp;</td>
                <td>Lastname:<input type="text" name="lname" class="form-control" placeholder="Lastname" value="<?php echo $row['lname']; ?>" required></td>
            </tr>
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr>
                <td>Email:<input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $row['email']; ?>" required></td>
                <td>&nbsp;</td>
                <td>Phone Number:<input type="text" name="pnum" class="form-control" placeholder="Phone Number" value="<?php echo $row['pnum']; ?>" required></td>
                <td>&nbsp;</td>
                <td></td>
            </tr>
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr><td colspan="5"><strong>Company Information</strong><hr /></td></tr>
            <tr>
                <td colspan="5">Company Name:<input type="text" name="cname" class="form-control" placeholder="Company Name" value="<?php echo $row['company_name']; ?>" required></td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td colspan="5">Company Address:<input type="text" name="caddress" class="form-control" placeholder="Company Address" value="<?php echo $row['company_address']; ?>" required></td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td>Telephone:<input type="text" name="ctelephone" class="form-control" placeholder="Company Telephone" value="<?php echo $row['company_telephone']; ?>" required></td>
                <td>&nbsp;</td>
                <td>Email:<input type="text" name="cemail" class="form-control" placeholder="Company Email" value="<?php echo $row['company_email']; ?>" required></td>
                <td>&nbsp;</td>
                <td>Website:<input type="text" name="cwebsite" class="form-control" placeholder="Company Website" value="<?php echo $row['company_website']; ?>" required></td>
            </tr>
        </table>
    </div>
    <div class="col-lg-6">
        <table align="center">
            <tr><td colspan="5">&nbsp; <hr /></td></tr>
            <tr>
                <td colspan="2"><br /><img class="thumbnail" src="../uploads/<?php echo $row['company_logo']; ?>" width="100" height="100" /></td>
                <td colspan="3">Upload Company Logo:<br /><br /><input type="file" name="file" id="img" /></td>
            </tr>
            <tr><td colspan="5">&nbsp;</td></tr>
            <tr><td colspan="5"><strong>Account Security</strong><hr /></td></tr>
            <tr>
                <td>Username:<input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $row['username']; ?>" required></td>
                <td>&nbsp;</td>
                <td>Password:<input id="password" type="password" name="passwordx" class="form-control" placeholder="Password" value="<?php echo $row['password']; ?>" required></td>
                <td>&nbsp;</td>
                <td>Re-type Password:<input id="confirm_password" type="password" name="password2x" class="form-control" placeholder="Re-type Password" value="<?php echo $row['password']; ?>" required></td>
            </tr>
            <tr>
                <td colspan="4"></td>
                <td><span id='message'></span></td>
            </tr>
            <tr><td colspan="5"><strong>Confirmation</strong><hr /></td></tr>
            <tr>
                <td></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>Current Password:<input type="password" name="current_password" class="form-control" placeholder="Current Password" required /></td>
            </tr>
        </table>
        <?php } ?>
    </div>
    <div class="col-lg-12">
        <hr />
        <div class="btn-group pull-right">
            <button name="update" type="submit" class="btn btn-success">Update</button>
            <a href="dashboard" type="button" class="btn btn-default">Cancel</a>
        </div>
    </div>
</form>

  
            </div><!-- end panel body -->
          </div> <!-- end panel -->
  </div><!-- end col-12 -->
  
</div> <!-- end container -->
          
          
   <?php include('footer.php'); ?>


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="javascript/jquery1102.min.js"></script>
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
    
    
    
     <script>
 
    $('#password, #confirm_password').on('keyup', function () {
      if ($('#password').val() == $('#confirm_password').val()) {
        $('#message').html('Matching').css('color', 'green');
      } else 
        $('#message').html('Not Matching').css('color', 'red');
    });
    
    </script>
  

  </body>
</html>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
   // Include database connection file
   include 'dbcon.php';

   // Get form data
   $fname = $_POST['fname'];
   $mname = $_POST['mname'];
   $lname = $_POST['lname'];
   $email = $_POST['email'];
   $pnum = $_POST['pnum'];
   $cname = $_POST['cname'];
   $caddress = $_POST['caddress'];
   $ctelephone = $_POST['ctelephone'];
   $cemail = $_POST['cemail'];
   $cwebsite = $_POST['cwebsite'];
   $username = $_POST['username'];
   $password = $_POST['passwordx'];
   $password2 = $_POST['password2x'];
   $current_password = $_POST['current_password'];

   // Validate passwords
   if ($password != $password2) {
       echo "<script>
           Swal.fire({
               icon: 'error',
               title: 'Error',
               text: 'Passwords do not match.',
           });
       </script>";
       exit;
   }

   // Retrieve current data
   $stmt = $conn->prepare("SELECT * FROM organizer WHERE organizer_id = ? AND password = ?");
   $stmt->execute([$session_id, $current_password]);
   $row = $stmt->fetch();

   if (!$row) {
       echo "<script>
           Swal.fire({
               icon: 'error',
               title: 'Error',
               text: 'Current password is incorrect.',
           });
       </script>";
       exit;
   }

   // Handle file upload for company logo
   $file_name = $row['company_logo']; // Default to existing logo
   if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
       $file_name = $_FILES['file']['name'];
       $file_tmp = $_FILES['file']['tmp_name'];
       $file_dest = '../uploads/' . $file_name;
       move_uploaded_file($file_tmp, $file_dest);
   }

   // Update the database
   $stmt = $conn->prepare("UPDATE organizer SET fname = ?, mname = ?, lname = ?, email = ?, pnum = ?, company_name = ?, company_address = ?, company_telephone = ?, company_email = ?, company_website = ?, username = ?, password = ?, company_logo = ? WHERE organizer_id = ? AND password = ?");
   $stmt->execute([$fname, $mname, $lname, $email, $pnum, $cname, $caddress, $ctelephone, $cemail, $cwebsite, $username, $password, $file_name, $session_id, $current_password]);

   if ($stmt->rowCount() > 0) {
       echo "<script>
           Swal.fire({
               icon: 'success',
               title: 'Success',
               text: 'Record updated successfully.',
           }).then((result) => {
               if (result.isConfirmed) {
                   window.location.href = 'edit_organizer';
               }
           });
       </script>";
   } else {
       echo "<script>
           Swal.fire({
               icon: 'info',
               title: 'Info',
               text: 'No changes were made.',
           });
       </script>";
   }
}

?>