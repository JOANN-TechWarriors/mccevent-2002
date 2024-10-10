<?php 
include('dbcon.php');
date_default_timezone_set('Asia/Manila'); 
?>
<!DOCTYPE html>
<html lang="en">
<?php
include_once('header2.php');
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
</style>

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
      <h1> MCC Event Judging System</h1>
      <p class="lead">Ready to serve you...</p>
    </div>
  </header>

  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
        </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <div class="container">

    <!-- About EJS Modal -->
    <div class="modal fade" id="about-modal" tabindex="-1" role="dialog" aria-labelledby="Login" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title" id="Login">About MCC Event Judging System</h4>
          </div>
          <div class="modal-body">
            <table align="center">
              <tr>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right">Developer:</td>
                <td><strong> Christian Paul L. Salvado</strong> - Software and Web Developer</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right">Email:</td>
                <td><strong> salvadochristianpaul5@gmail.com</strong></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right">Mobile Number:</td>
                <td><strong> +639385974999</strong></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td align="right">Website:</td>
                <td><a href="www.bee4ten.ml" target="_blank"><strong> www.bee4ten.ml</strong></a></td>
              </tr>
            </table>
            <br />
            <p>Check my website or get in touch with me for more informations and system supports. All rights reserved 2023 &COPY;</p>
            <hr />
            <p class="text-center text-muted"><button class="btn btn-default" data-dismiss="modal" aria-hidden="true"><strong>Close</strong></button></p>
          </div>
        </div>
      </div>
    </div>
    <!-- END About EJS Modal -->

    <!-- Student Login Form -->
    <form method="POST" action="student_login.php">
      <br />
      <table cellpadding="10" cellspacing="0" border="0" align="center">
        <thead>
          <th align="left" style="background-color: #4976f5; text-indent: 7px; color: white;">
            <h4> &nbsp;STUDENT LOGIN</h4>
          </th>
        </thead>
        <tr style="background-color: #d7def2;">
          <td>
            <h5><i class="icon-user"></i> STUDENT ID:</h5>
            <input style="font-size: large; height: 35px !important; text-indent: 7px !important;" class="form-control btn-block" type="text" name="student_id" placeholder="Student ID" required="true" autofocus="true" />
            <br /><strong><a data-toggle="modal" data-target="#forgot-password-modal">Forgot password?</a></strong><br />
            <h6>if you have no account, pls</h6>
            <button style="width: 160px !important;" type="submit" class="btn btn-primary pull-right"><i class="icon-ok"></i> <strong>LOGIN</strong></button>

            <strong>Register <a href="student_register.php">here &raquo;</a></strong> &nbsp;&nbsp;&nbsp;<br><br>
          </td>
        </tr>
      </table>
    </form>

    <!-- Student Registration Form -->
    <form method="POST" action="student_register.php">
      <br />
      <table cellpadding="10" cellspacing="0" border="0" align="center">
        <thead>
          <th align="left" style="background-color: #4976f5; text-indent: 7px; color: white;">
            <h4> &nbsp;STUDENT REGISTRATION</h4>
          </th>
        </thead>
        <tr style="background-color: #d7def2;">
          <td>
            <h5><i class="icon-user"></i> NAME:</h5>
            <input style="font-size: large; height: 35px !important; text-indent: 7px !important;" class="form-control btn-block" type="text" name="name" placeholder="Name" required="true" autofocus="true" />
            <h5><i class="icon-book"></i> COURSE WITH YEAR AND SECTION:</h5>
            <input style="font-size: large; height: 35px !important; text-indent: 7px !important;" class="form-control btn-block" type="text" name="course" placeholder="Course with Year and Section" required="true" autofocus="true" />
            <h5><i class="icon-id-badge"></i> STUDENT ID:</h5>
            <input style="font-size: large; height: 35px !important; text-indent: 7px !important;" class="form-control btn-block" type="text" name="student_id" placeholder="Student ID" required="true" autofocus="true" />
            <button style="width: 160px !important;" type="submit" class="btn btn-primary pull-right"><i class="icon-ok"></i> <strong>REGISTER</strong></button>
          </td>
        </tr>
      </table>
    </form>

    <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" style="display: none;">
      <div class="toast-header">
        <strong class="toast-title">Title</strong>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="toast-body">
        Body
      </div>
    </div>

    <!-- Footer
    ================================================== -->
    <footer class="footer">
      <div class="container">
        <font size="2" class="" align="center"><strong>Event Judging System &middot; 2023 &COPY; </strong></font> <br />
      </div>
    </footer>

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->

    <script src="..//assets/js/jquery.js"></script>
    <script src="..//assets/js/bootstrap-transition.js"></script>
    <script src="..//assets/js/bootstrap-alert.js"></script>
    <script src="..//assets/js/bootstrap-modal.js"></script>
    <script src="..//assets/js/bootstrap-dropdown.js"></script>
    <script src="../assets/js/bootstrap-scrollspy.js"></script>
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
      window.uni_modal = function($title = '', $url = '', $size = "") {
        start_load()
        $.ajax({
          url: $url,
          error: err => {
            console.log()
            alert("An error occured")
          },
          success: function(resp) {
            if (resp) {
              $('#uni_modal .modal-title').html($title)
              $('#uni_modal .modal-body').html(resp)
              if ($size != '') {
                $('#uni_modal .modal-dialog').addClass($size)
              } else {
                $('#uni_modal .modal-dialog').removeAttr("class").addClass("modal-dialog modal-md")
              }
              $('#uni_modal').modal({
                show: true,
                backdrop: 'static',
                keyboard: false,
                focus: true
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
      setTimeout(function() {
        var alert = document.querySelector('.alert');
        if (alert) {
          alert.style.display = 'none';
        }
      }, 3000);
    </script>
</body>
</html>
