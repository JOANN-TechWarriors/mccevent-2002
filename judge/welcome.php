<!DOCTYPE html>
<html lang="en">

<?php
include('header2.php');
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
    width: 300px; /* Adjust the width as needed */
    height: auto; /* Maintain aspect ratio */
    margin-top: 100px; /* Add space below the logo */
  }

  .motto {
    margin-top: 20px; /* Add space above the motto */
    margin-right: 100px; /* Add space to the left */
  }

  .form-container {
    width: 100%; /* Adjust the width as needed */
    max-width: 600px;
    margin: 0 auto;
  }

  thead th {
    background-color: aquamarine;
    text-indent: 10px;
    font-size: 14px; /* Adjust the font size as needed */
    padding: 10px; /* Adjust the padding as needed */
  }
</style>

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
          <div id="home">
            <div class="overlay">
              <div class="form-container">
                <form id="login-form" method="POST" action="judge_panel.php">
                  <br />
                  <br />
                  <br />
                  <table cellpadding="50" cellspacing="40" align="center">
                    <thead>
                      <th align="left" style="background-color: aquamarine; text-indent: 10px; color: black;">
                        <h4>JUDGE LOGIN</h4>
                      </th>
                    </thead>
                    <tr style="background-color: #fff;">
                      <td>
                        <h5><i class="icon-user"></i> JUDGE'S CODE:</h5>
                        <input id="myInputJC" style="font-size: large; height: 35px !important; text-indent: 7px !important;" class="form-control btn-block" name="judge_code" type="password" placeholder="Enter Judge's Code" required="true" />
                        <button id="login-button" style="width: 100px !important;" type="button" class="btn btn-primary pull-right"><i class="icon-ok"></i> <strong>ENTER</strong></button>
                        <p><input style="padding-top: 0px !important; margin-top: 0px !important;" type="checkbox" onclick="myFunctionJC()" /> <strong>Show Code</strong></p>
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

  

  <!-- Le javascript -->
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
    document.getElementById("login-button").addEventListener("click", function() {
      Swal.fire({
        title: "Success!",
        text: "Entered succeccfully!",
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
