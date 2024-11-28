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
    <!-- Include SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
</head>
<body style="background-color: lightgray;">

<div class="container">
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
        <a href="edit_organizer" class="btn btn-primary"><strong>ORGANIZER SETTINGS &raquo;</strong></a>
        <hr />
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title"><strong>Tabulator Settings Panel</strong></h3>
            </div>
            <div class="panel-body">
                <form method="POST" enctype="multipart/form-data"> 
                    <?php 
                    $query = $conn->query("select * from organizer where org_id='$session_id'") or die(mysql_error());
                    if($query->rowCount() > 0) {
                        while ($row = $query->fetch()) { 
                    ?>
                    <table align="center">
                        <tr><td colspan="5"><strong>Basic Information</strong><hr /></td></tr>
                        <tr>
                            <td>
                                Firstname:
                                <input type="text" name="fname" class="form-control" placeholder="Firstname" value="<?php echo $row['fname']; ?>" aria-describedby="basic-addon1" required autofocus>
                            </td>
                            <td>&nbsp;</td>
                            <td>
                                Middlename:
                                <input type="text" name="mname" class="form-control" placeholder="Middlename" value="<?php echo $row['mname']; ?>" aria-describedby="basic-addon1" required autofocus>
                            </td>
                            <td>&nbsp;</td>
                            <td>
                                Lastname:
                                <input type="text" name="lname" class="form-control" placeholder="Lastname" value="<?php echo $row['lname']; ?>" aria-describedby="basic-addon1" required autofocus>
                            </td>
                        </tr>
                        <tr><td colspan="5">&nbsp;</td></tr>
                        <tr><td colspan="5"><strong>Account Security</strong><hr /></td></tr>
                        <tr>
                            <td>
                                Username:
                                <input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $row['username']; ?>" aria-describedby="basic-addon1" required autofocus>
                            </td>
                            <td>&nbsp;</td>
                            <td>
                                New Password:
                                <input id="password" type="password" name="passwordx" class="form-control" placeholder="Password" value="<?php echo $row['password']; ?>" aria-describedby="basic-addon1" required autofocus>
                            </td>
                            <td>&nbsp;</td>
                            <td>
                                Re-type Password:
                                <input id="confirm_password" type="password" name="password2x" class="form-control" placeholder="Re-type Password" value="<?php echo $row['password']; ?>" aria-describedby="basic-addon1" required autofocus>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4"></td>
                            <td><span id='message'></span></td>
                        </tr>
                        <tr><td colspan="5">&nbsp;</td></tr>
                        <tr><td colspan="5"><strong>Confirmation</strong><hr /></td></tr>
                        <tr>
                            <td colspan="5">
                                Tabulator Current Password:
                                <input type="password" name="tab_password" class="form-control" placeholder="Tabulator Current Password" aria-describedby="basic-addon1" required autofocus>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                Organizer Current Password:
                                <input type="password" name="org_password" class="form-control" placeholder="Organizer Current Password" aria-describedby="basic-addon1" required autofocus>
                            </td>
                        </tr>
                    </table>
                    <div class="col-lg-12">
                        <hr />
                        <div class="btn-group pull-right">
                            <button name="update" type="submit" class="btn btn-success">Update</button>
                            <a href="dashboard" type="button" class="btn btn-default">Cancel</a>
                        </div>
                    </div> 
                    </form>
                    <?php 
                        }
                    } else {
                    ?>
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
                                    <input type="text" name="mname" class="form-control" placeholder="Middlename" aria-describedby="basic-addon1" required autofocus>
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    Lastname:
                                    <input type="text" name="lname" class="form-control" placeholder="Lastname" aria-describedby="basic-addon1" required autofocus>
                                </td>
                            </tr>
                            <tr><td colspan="5">&nbsp;</td></tr>
                            <tr><td colspan="5"><strong>Account Security</strong><hr /></td></tr>
                            <tr>
                                <td>
                                    Username:
                                    <input type="text" name="username" class="form-control" placeholder="Username" aria-describedby="basic-addon1" required autofocus>
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    Password:
                                    <input id="password" type="password" name="passwordx" class="form-control" placeholder="Password" aria-describedby="basic-addon1" required autofocus>
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    Re-type Password:
                                    <input id="confirm_password" type="password" name="password2" class="form-control" placeholder="Re-type Password" aria-describedby="basic-addon1" required autofocus>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td><span id='message'></span></td>
                            </tr> 
                            <tr><td colspan="5">&nbsp;</td></tr>
                            <tr><td colspan="5"><strong>Confirmation</strong><hr /></td></tr>
                            <tr>
                                <td colspan="5">
                                    Organizer Password:
                                    <input type="password" name="org_password" class="form-control" placeholder="Password" aria-describedby="basic-addon1" required autofocus>
                                </td>
                            </tr>
                        </table>
                        <br />
                        <div class="btn-group pull-right">
                            <button name="add_tabulator" type="submit" class="btn btn-primary">ADD</button>
                            <a href="edit_organizer" type="button" class="btn btn-default">CANCEL</a>
                        </div>
                    </form>
                    <?php } ?>
                </div><!-- end panel body -->
            </div> <!-- end panel -->
        </div><!-- end col-6 -->
        <div class="col-lg-3"></div>
    </div> <!-- end container -->
          
    <?php include('footer.php'); ?>

    <!-- Include SweetAlert JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
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
if(isset($_POST['add_tabulator'])) {
    $fname = $_POST['fname']; 
    $mname = $_POST['mname'];  
    $lname = $_POST['lname'];  
    $username = $_POST['username'];  
    $password = $_POST['passwordx'];  
    $password2 = $_POST['password2'];  
    $org_password = $_POST['org_password']; 
   
    if($password == $password2) {
        if($org_password == $check_pass) {
            $org_query = $conn->query("SELECT * FROM organizer WHERE password='$org_password' AND access='Organizer'");
            $org_row = $org_query->fetch();
            $org_num_row = $org_query->rowcount();
            if($org_num_row > 0) { 
                $active_sub_event = $org_row['active_sub_event'];
                $conn->query("INSERT INTO organizer(fname,mname,lname,username,password,org_id,access,status)
                              VALUES('$fname','$mname','$lname','$username','$password','$session_id','Tabulator','offline')");
                echo "<script>
                swal({
                    title: 'Success!',
                    text: '$fname $mname $lname Successfully Added.',
                    type: 'success',
                    confirmButtonText: 'OK'
                }, function() {
                    window.location = 'edit_tabulator';
                });
                </script>";
            } else {
                echo "<script>
                swal({
                    title: 'Error!',
                    text: 'Confirmation Password error... Please contact event organizer.',
                    type: 'error',
                    confirmButtonText: 'OK'
                });
                </script>";
            }
        }
    } else {
        echo "<script>
        swal({
            title: 'Error!',
            text: 'Tabulator $fname $mname $lname registration cannot be done. Password and Re-typed password did not match.',
            type: 'error',
            confirmButtonText: 'OK'
        });
        </script>";
    }
}

if(isset($_POST['update'])) {
    // Add your update logic here
    // After successful update
    echo "<script>
    swal({
        title: 'Success!',
        text: '$fname $mname $lname Updated Successfully.',
        type: 'success',
        confirmButtonText: 'OK'
    }, function() {
        window.location = 'edit_tabulator';
    });
    </script>";
}
?>