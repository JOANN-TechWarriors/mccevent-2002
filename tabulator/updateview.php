<?php

   include('header2.php');
    include('..//admin/session.php');
    
    $get_sid=$_GET['sid'];
    
    
    $conn->query("update sub_event set view='deactivated'");
    
    
    $conn->query("update sub_event set view='activated' where subevent_id='$get_sid'");
   
  
 ?>
 
 
<script>
window.location = '..//admin/view.php';
</script>
 