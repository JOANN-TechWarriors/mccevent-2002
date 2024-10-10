<?php 
session_start();
include('../admin/dbcon.php');
date_default_timezone_set('Asia/Manila'); 
?>
<!DOCTYPE html>
<html lang="en">

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
                <h2><p><strong>MCC Event Judging System</strong></p></h2>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br><br><br><br>
    <table cellpadding="10" cellspacing="0" border="0" align="center">
        <thead>
 <th align="left" style="background-color: #4976f5; text-indent: 7px; color: white; "><h4> &nbsp;WELCOME</h4></th>
 </thead>

 <tr style="background-color: #d7def2;">
 
 <td>
 
 
  <h5><i class="icon-user"></i>  JUDGE:</h5>

 
<div id="myGroup" >


<div class="input-group">
       <div class="alert alert-success">
      <form method="POST" action="judge_profile.php" >
            <h4>Judge's Code</h4>
            <br />
          <input id="myInputJC" style="font-size: large; height: 45px !important;" class="form-control btn-block" name="judge_code" type="password" placeholder="Enter Judge's Code" />
          <button style="width: 160px !important;" type="submit" class="btn btn-primary pull-right"><i class="icon-ok"></i> <strong>Enter</strong></button>
  
            <p><input style="padding-top: 0px !important; margin-top: 0px !important;" type="checkbox" onclick="myFunctionJC()"/> <strong>Show Code</strong></p>
                                     
                                    <script>
                                    function myFunctionJC() {
                                        var x = document.getElementById("myInputJC");
                                        if (x.type === "password") {
                                            x.type = "text";
                                        } else {
                                            x.type = "password";
                                        }
                                    }
        
        </script>
        <form>
 </table>
        </div>
      </div>
    </div><br><br>
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
</body>
</html>
