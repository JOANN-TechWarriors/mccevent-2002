 <!DOCTYPE html>
<html lang="en">
  
  <?php
  include('../admin/header2.php');

  ?>

  <body style="background:url(../img/Community-College-Madridejos.jpeg)">    

        <table cellpadding="10" cellspacing="0" border="0" align="center">
        <thead>
        <th align="left" style="background-color: aquamarine; text-indent: 10px; color: black;"><h4> &nbsp;WELCOME</h4></th>
        </thead>

 <tr style="background-color: #fff;">
 
 <td>
 
 
  <h5><i class="icon-user"></i>  JUDGE:</h5>

 
<div id="myGroup" >
<div class="input-group">
       <div class="alert alert-success">
      <form method="POST" action="judge_profile.php" >
            <h4>Judge's Code</h4>
            <br />
          <input id="myInputJC" style="font-size: large; height: 45px !important;" class="form-control btn-block" name="judge_code" type="password" placeholder="Enter Judge's Code" />
          <button style="width: 160px !important;" type="submit" class="btn btn-primary pull-right"><i class="icon-ok"></i> <strong>LOGIN</strong></button>
  
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
        </div>
      </div>
    </div><br><br>
    </table>
    <!--end About judge button -->




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
    
  </body>
</html>