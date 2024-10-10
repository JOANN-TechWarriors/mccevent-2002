<?php 
session_start();
include('../admin/dbcon.php');
date_default_timezone_set('Asia/Manila'); 

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];

    try {
        // Prepare and execute the query
        $stmt = $conn->prepare("SELECT * FROM student WHERE student_id = :student_id");
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch();
        
        if ($stmt->rowCount() > 0) {
            if ($row['request_status'] == '') {
                $_SESSION['login_error'] = "Sorry, Your account is not yet approve by the admin";
            } elseif($row['request_status'] == 'Approved'){
                 // Student exists, start session
                $_SESSION['student_id'] = $student_id;
                $_SESSION['login_success'] = true;
                // Redirect to the login page to trigger JavaScript
                header("Location: index.php");
                exit();
            }
        } else {
            $_SESSION['login_error'] = "Invalid Student ID";
        }
    } catch(PDOException $e) {
        $_SESSION['login_error'] = "Database error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<?php
include_once('../admin/header2.php');
?>
<style>
  .alert {
    font-size: 14px;
    padding: 8px 12px;
    text-align: center;
    margin: 10px;
    max-width: 600px;
    position: fixed;
    top: 40px;
    right: 20px;
    z-index: 9999;
  }

  .logo-small {
    width: 300px; 
    height: auto; 
    margin-top: 100px; 
  }

  .motto {
    margin-top: 20px; 
    margin-right: 100px; 
  }

  .form-container {
    width: 400%; 
    max-width: 600px;
    margin: 2 auto;
  }

  thead th {
    background-color: aquamarine;
    text-indent: 10px;
    font-size: 14px; 
    padding: 10px;
  }
</style>


<body id="login" style="background:url(../img/Community-College-Madridejos.jpeg)">
<?php
if (isset($_SESSION['login_error'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['login_error'] . '</div>';
    unset($_SESSION['login_error']);
}
?>

<div class="container">
  <div class="row-fluid">
    <div class="span6">
      <div class="title_index">
        <div class="row-fluid">
          <div class="span12"></div>
          <div class="row-fluid">
            <div class="span10">
              <img class="index_logo logo-small" src="../img/logo.png">
            </div>
            <div class="span12">
              <div class="motto">
                <h3><p>WELCOME&nbsp;&nbsp;TO:</p></h3>
                <h2><p><strong>MCC Event Judging Systems</strong></p></h2>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br><br><br><br>
    <div class="span6">
      <div class="pull-left">
        <div id="home">
          <div class="overlay">
            <div class="form-container">
            <form method="POST" action="">
                <br />
                <table cellpadding="10" cellspacing="0" border="0" align="center">
                  <thead>
                    <th align="left" style="background-color: aquamarine; text-indent: 10px; color: black;">
                      <h4> &nbsp;STUDENT LOGIN</h4>
                    </th>
                  </thead>
                  <tr style="background-color: #fff;">
                    <td>
                      <h5><i class="icon-user"></i> STUDENT ID:</h5>
                      &nbsp;
                      <input style="font-size: large; height: 35px !important; text-indent: 7px !important;" class="form-control btn-block" type="text" name="student_id" placeholder="Student ID #" required="true" autofocus="true" />
                      <br />
                      &nbsp;
                      <button style="width: 160px !important;" type="submit" class="btn btn-primary pull-right"><i class="icon-ok"></i> <strong>LOGIN</strong></button>
                      &nbsp;
                      <strong><a href="student_register.php">Sign Up</a></strong> &nbsp;&nbsp;&nbsp;<br><br>
                    </td>
                  </tr>
                </table>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script src="..//assets/js/jquery.js"></script>
<script src="..//assets/js/bootstrap-transition.js"></script>
<script src="..//assets/js/bootstrap-alert.js"></script>
<script src="..//assets/js/bootstrap-modal.js"></script>
<script src="..//assets/js/bootstrap-dropdown.js"></script>
<script src="..//assets/js/bootstrap-scrollspy.js"></script>
<script src="..//assets/js/bootstrap-tab.js"></script>
<script src="..//assets/js/bootstrap-tooltip.js"></script>
<script src="..//assets/js/bootstrap-popover.js"></script>
<script src="..//assets/js/bootstrap-button.js"></script>
<script src="..//assets/js/bootstrap-collapse.js"></script>
<script src="..//assets/js/bootstrap-carousel.js"></script>
<script src="..//assets/js/bootstrap-typeahead.js"></script>
<script src="..//assets/js/bootstrap-affix.js"></script>
<script src="..//assets/js/holder/holder.js"></script>
<script src="..//assets/js/google-code-prettify/prettify.js"></script>
<script src="..//assets/js/application.js"></script>
<script>
// Disable right-click
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });

        // Disable F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U
        document.onkeydown = function (e) {
            if (
                e.key === 'F12' ||
                (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J')) ||
                (e.ctrlKey && e.key === 'U')
            ) {
                e.preventDefault();
            }
        };

        // Disable developer tools
        function disableDevTools() {
            if (window.devtools.isOpen) {
                window.location.href = "about:blank";
            }
        }

        // Check for developer tools every 100ms
        setInterval(disableDevTools, 100);

        // Disable selecting text
        document.onselectstart = function (e) {
            e.preventDefault();
        };
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
      <?php if (isset($_SESSION['login_success']) && $_SESSION['login_success'] === true): ?>
        Swal.fire({
          ititle: "Success!",
        text: "You are successfully logged in!",
        icon: "success",
        confirmButtonText: "Ok",
        }).then(() => {
          window.location.href = '../index.php'; // Redirect after alert
        });
        <?php unset($_SESSION['login_success']); ?> // Clear the session variable
      <?php endif; ?>
    });
  </script>
</body>
</html>
<!--  -->
        <!-- title: "Success!",
        text: "You are successfully logged in!",
        icon: "success",
        confirmButtonText: "Ok", -->

