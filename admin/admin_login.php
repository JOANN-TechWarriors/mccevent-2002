<?php 
session_start();
// Connect to database
$host = '127.0.0.1';
$username = 'u510162695_judging_root';
$password = '1Judging_root';  // Replace with the actual password
$dbname = 'u510162695_judging';


$conn = new mysqli($host, $username, $password, $dbname);


// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
date_default_timezone_set('Asia/Manila'); 

// :host=127.0.0.1;
// port=3306;
// dbname=u510162695_judging', 
// 'u510162695_judging_root',
//  '1Judging_root'
// $pass = 'mccevents_admin';
// $hash = password_hash($pass, PASSWORD_DEFAULT);

// $admin = "INSERT INTO admin (username, password) VALUES ('administrator', '$hash')";
// $result = $conn->query($admin);

// if ($result) {
//    echo "Added successfully!";
// }else{
//     echo "Waley!";
// }
$msg = "";
if (isset($_POST['admin_login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $check = "SELECT * FROM admin WHERE username = '$user'";
    $result = mysqli_query($conn, $check);
    $row = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) > 0 ) {
        $hashed_pass = $row['password'];
        if (!password_verify($pass, $hashed_pass)) {
            $msg = "<center><span class='badge bg-danger text-light' style='padding: 6px;'>Incorrect Password!</span></center>";
        }else {         
            $_SESSION['admin_login'] = true;
            $_SESSION['admin_id'] = $row['id'];
            header('location: admin_dashboard.php');
        }
    }else{
            $msg = "<center><span class='badge bg-danger text-light' style='padding: 6px;'>Admin doesn't exist!</span></center>";
    }
}


?>
<!DOCTYPE html>
<html lang="en">
  
<?php
include_once('header2.php');
?>
<head>
<link rel="shortcut icon" href="../images/logo copy.png"/>

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
  width: 300px; /* Adjust the width as needed */
  height: auto; /* Maintain aspect ratio */
  margin-top: 100px; /* Add space below the logo */
}

.motto {
  margin-top: 20px; /* Add space above the motto */
  margin-right: 100px; /* Add space to the left */
}

.form-container {
  width: 400%; /* Adjust the width as needed */
  max-width: 600px;
  margin: 2 auto;
}

thead th {
  background-color: aquamarine;
  text-indent: 10px;
  font-size: 14px; /* Adjust the font size as needed */
  padding: 10px; /* Adjust the padding as needed */
}
</style>
</head>
<body id="login" style="background:url(../img/Community-College-Madridejos.jpeg)">  

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
                        <h2><p><strong>MCC Event Judging System</strong></p></h2>                      
                        </div>                      
                      </div>              
                    </div>                    
              </div>  
            
        </div>
      </div>

      <div class="span6">
        <div class="pull-left">
                <div id="home" >
        <div class="overlay">
          <div class="form-container">
            <form id="login-form" method="POST">
             <br /> 
             <br/>
             <br/> 
             <table cellpadding="50" cellspacing="40"  align="center">
             <thead>
             <th align="left" style="background-color: aquamarine; text-indent: 10px; color: black; "><h4>ADMIN LOGIN</h4></th>
             </thead>
             <tr style="background-color: #fff;">
             <td>
              <?=$msg;?>
              <h5><i class="icon-user"></i>  USERNAME:</h5>
              <input style="font-size: large; height: 35px !important; text-indent: 7px !important;" class="form-control btn-block" type="text" name="username" placeholder="Username" required="true" autofocus="true" />
             
              <h5><i class="icon-lock"></i>  PASSWORD:</h5>
              <input style="font-size: large; height: 35px !important; text-indent: 7px !important;" class="form-control btn-block" type="password"  name="password" placeholder="Password" required="true" />
                <br />
              <button type="submit" name="admin_login" style="width: 150px !important;" type="button" class="btn btn-primary pull-right"><i class="icon-ok"></i> <strong>LOGIN</strong></button>
              
              
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

<script>
document.getElementById('forgot-password-form').addEventListener('submit', function(e) {
  e.preventDefault();
  
  var email = document.getElementById('email').value;
  var messageDiv = document.getElementById('forgot-password-message');
  
  // AJAX request to forgot_password.php
  fetch('forgot_password.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: 'email=' + encodeURIComponent(email)
  })
  .then(response => response.json())
  .then(data => {
    messageDiv.style.display = 'block';
    messageDiv.textContent = data.message;
    messageDiv.className = data.success ? 'alert alert-success' : 'alert alert-danger';
    
    if (data.success) {
      setTimeout(function() {
        $('#forgot-password-modal').modal('hide');
      }, 3000);
    }
  })
  .catch(error => {
    console.error('Error:', error);
    messageDiv.style.display = 'block';
    messageDiv.textContent = 'An error occurred. Please try again.';
    messageDiv.className = 'alert alert-danger';
  });
});

function clearEmail() {
  document.getElementById('email').value = '';
  document.getElementById('forgot-password-message').style.display = 'none';
}

$('#forgot-password-modal').on('hidden.bs.modal', function () {
  clearEmail();
});
</script>

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
window.onload = function() {
    <?php if(isset($_SESSION['login_success']) && $_SESSION['login_success'] == true): ?>
        Swal.fire({
            title: "Success!",
            text: "You are Successfully logged in!",
            icon: "success"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "dashboard.php";
            }
        });
        <?php unset($_SESSION['login_success']); ?>
    <?php endif; ?>
};

window.uni_modal = function($title = '' , $url='',$size=""){
    start_load()
    $.ajax({
        url:$url,
        error:err=>{
            console.log()
            alert("An error occurred")
        },
        success:function(resp){
            if(resp){
                $('#uni_modal .modal-title').html($title)
                $('#uni_modal .modal-body').html(resp)
                if($size != ''){
                    $('#uni_modal .modal-dialog').addClass($size)
                }else{
                    $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md")
                }
                $('#uni_modal').modal({
                  show:true,
                  backdrop:'static',
                  keyboard:false,
                  focus:true
                })
                end_load()
            }
        }
    })
}

function clearEmail() {
    document.getElementById("forgot-password-form").reset();
}

// Hide the alert after 3 seconds
setTimeout(function(){
    var alert = document.querySelector('.alert');
    if (alert) {
        alert.style.display = 'none';
    }
}, 3000);

document.getElementById("login-button").addEventListener("click", function() {
    Swal.fire({
        title: "Success!",
        text: "You are successfully logged in!",
        icon: "success",
        confirmButtonText: "Ok",
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("login-form").submit();
        }
    });
});
</script>
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
</body>
</html>