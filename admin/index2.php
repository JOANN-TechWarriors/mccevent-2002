<?php 
session_start();
include('dbcon.php');
date_default_timezone_set('Asia/Manila'); 
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
                        
                        <h3><p>WELCOME&nbsp;&nbsp;TO :</p></h3>
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
            <form id="login-form" method="POST" action="login.php" >
             <br /> 
             <br/>
             <br/> 
             <table cellpadding="50" cellspacing="40"  align="center">
             <thead>
             <th align="left" style="background-color: aquamarine; text-indent: 10px; color: black; "><h4>ORGANIZER</h4></th>
             </thead>
             
             <tr style="background-color: #fff;">
             
             <td>
              <h5><i class="icon-user"></i>  USERNAME:</h5>
              <input style="font-size: large; height: 35px !important; text-indent: 7px !important;" class="form-control btn-block" type="email" name="username" placeholder="Username" required="true" autofocus="true" />
             
              <h5><i class="icon-lock"></i>  PASSWORD:</h5>
              <input style="font-size: large; height: 35px !important; text-indent: 7px !important;" class="form-control btn-block" type="password"  name="password" placeholder="Password" required="true" />
            <br /><strong><a data-toggle="modal" data-target="#forgot-password-modal">Forgot password?</a></strong><br />
            <h6>If you have no account, pls</h6>
              <button id="login-button" style="width: 150px !important;" type="button" class="btn btn-primary pull-right"><i class="icon-ok"></i> <strong>Sign in</strong></button>
              
              <strong><a href="create_account.php">Register &raquo;</a></strong> &nbsp;&nbsp;&nbsp;<br><br>
              
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
   
   <div class="modal fade" id="forgot-password-modal" tabindex="-1" role="dialog" aria-labelledby="forgot-password-modal-label" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forgot-password-modal-label">Forgot Password?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="clearEmail()">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="forgot-password-form" action="forgot_password.php" method="post" autocomplete="off">
          <div class="form-group">
            <label for="email">Email address:</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <button type="submit" class="btn btn-primary mt-3" name="send" >Reset Password</button>
        </form>
      </div>
    </div>
  </div>
</div>

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
