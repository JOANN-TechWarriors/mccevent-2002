<?php 
session_start();
include('..//admin/dbcon.php');
date_default_timezone_set('Asia/Manila'); 
?>
<!DOCTYPE html>
<html lang="en">
  
<?php
include_once('header2.php');
?>
<head>
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
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
</style>
</head>
  <body>
   <!-- Navbar
    ================================================== -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
        </div>
      </div>
    </div>
    <!-- Subhead
 ================================================== -->
<header class="jumbotron subhead" id="overview">
  <div class="container">
    <h1 style="font-size: 30px;"> MCC Event Judging System</h1>
    <p class="lead" style="font-size: 20px;">Ready to serve you...</p>
  </div>
</header>

   <form method="POST" action="login.php" >
 <br />  
 <table cellpadding="10" cellspacing="0" border="0" align="center">
 <thead>
 <th align="left" style="background-color: #4976f5; text-indent: 7px; color: white; "><h4> &nbsp;TABULATOR LOGIN</h4></th>
 </thead>
 
 <tr style="background-color: #d7def2;">
 
 <td>
  <h5><i class="icon-user"></i>  USERNAME:</h5>
  <input style="font-size: large; height: 35px !important; text-indent: 7px !important;" class="form-control btn-block" type="text" name="username" placeholder="Username" required="true" autofocus="true" />
 
  <h5><i class="icon-lock"></i>  PASSWORD:</h5>
  <input style="font-size: large; height: 35px !important; text-indent: 7px !important;" class="form-control btn-block" type="password"  name="password" placeholder="Password" required="true" />
  <button style="width: 160px !important;" type="submit" class="btn btn-primary pull-right"><i class="icon-ok"></i> <strong>LOGIN</strong></button> 
 </td>
 </tr>
 </table>
 </form>
  



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
                  window.location.href = "score_sheets.php";
              }
          });
          <?php 
            unset($_SESSION['login_success']);
            endif; 
          ?>
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
    </script>
  </body>
</html>
