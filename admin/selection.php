<!DOCTYPE html>
<html lang="en">
  
  <?php 
  include('header2.php');
    include('session.php');
  ?>

 

  <body>
 
<!-- Navbar
    ================================================ -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <ul class="nav">

          <li  class="active">
                <a href="dashboard.php">DASHBOARD</a>
              </li>


   <li>
   <a href="home.php"><strong>LIST OF EVENTS</strong></a>
 </li>

 <li>
   <a href="score_sheets.php">SCORE SHEETS</a>
 </li>
 

  <li>
     <a href="rev_main_event.php">DATA REVIEWS</a>
 </li>

 
 
 
   <li class="dropdown">
     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">MY ACCOUNTS<span class="caret"></span></a>
     <ul class="dropdown-menu" role="menu">

 
 <li>
     <a target="_blank" href="edit_organizer.php">Settings</a>
 </li>

 <li>
   <a href="logout.php">Logout <?php echo $name; ?></a>
 </li>
 
 
       </ul>
       </li>

</ul>
          <div class="nav-collapse collapse">
            <ul class="nav">

             <li>
                <a title="Click to logout user" href="logout.php" style="margin-left: 290px;">User: <b><?php echo $name; ?></b> - <i>logout</i></a>
              </li>
 
            </ul>
          </div>
        </div>
      </div>
    </div>
    
    
<header class="jumbotron subhead" id="overview">
  <div class="container">
    <h1>User</h1>
    <p class="lead">Event Judging System</p>
  </div>
</header>
 
 <div class="container">
 
 <hr />
 
 <div id="myGroup">

    
     <ul class="breadcrumb">
                    
                        <li><a href="home.php">List of Events</a> / </li>
                    
                        <li></li>
                        
                         
                        
                    </ul>
                    <table style="width: 100% !important;" align="center">
 
                            <tr>
                                               
                            <td>
                            
                           
                            
                            <div id="addMEcollapse" class="panel-collapse collapse">   
                                    
                                 <form method="POST">
                                 
                                
                                 
                                <table align="center" class="table table-bordered" id="example">
                                    
                                    <thead>
                                    <th>
                                    <h4><strong>ADD MAIN EVENT</strong>
                                    <a data-toggle="collapse" class="btn btn-default pull-right" href="#addMEcollapse" title="Click to add Main Event"><i class="icon-remove"></i> CANCEL</a>
                                    </h4>
                                    </th>
                                    </thead>
                           
                                <tr>
                                <td>
                              
                                <strong>Event #:</strong><br />
 
                                <input name="sy" class="form-control btn-block" style="text-indent: 5px !important; height: 30px !important;" type="number" placeholder="Start" required="true"/>
                                 <br /> 

                                 <strong>Event Name:</strong><br />
                                 <input type="text" name="main_event" class="form-control btn-block" style="text-indent: 5px !important; height: 30px !important;" placeholder="Event Name" required="true"/>
                                 <br />
                                 
                                 
                          
                                  <strong>Date Start:</strong><br />
                                  <div class="container">
                                         
                                         <input type="date" id="demo" min="2022-12-12" class="form-control btn-block" required="true">

                                         </div>
                                  <strong>Date End:</strong><br />
                                  <div class="container">
                                         
                                         <input type="date" id="demo" min="2022-12-12" class="form-control btn-block" required="true">

                                         </div>
                                  <strong>Time Start:</strong><br />
                                  <div class="container">
                                         
                                         <input type="time" name="event_time" type="text" required="true" placeholder="hh:mm" class="form-control btn-block">

                                         </div>

                                   

                                  <strong>Venue:</strong><br />
                                  <textarea name="place" type="text" class="form-control btn-block" style="text-indent: 10px !important;" placeholder="Event Venue" required="true" rows="2"></textarea>
                                  <br />
                           
                                 
                                 <div class="modal-footer">
                                 <button title="Clear form" type="reset" class="btn btn-default"><i class="icon-ban-circle"></i> <strong>RESET</strong></button>
                                 <button title="Click to save" name="create" type="submit" class="btn btn-primary"><i class="icon-ok"></i> <strong>SAVE</strong></button> 
                                  
                                 </div>
             
                                  </td>
                                  </tr>
                                  </table>
                                  </form>
                                  </div>
                     
                            <a style="margin-bottom: 10px !important;" data-toggle="collapse" class="btn btn-info pull-right" href="#addMEcollapse" title="Click to add Main Event"><i class="icon icon-plus"></i> <strong>MAIN EVENT</strong></a> 
                          
                            </td>
                            </tr>
                            
                            
                            
                            
            
<?php   
$sy_query = $conn->query("select DISTINCT sy FROM main_event where organizer_id='$session_id'") or die(mysql_error());
while ($sy_row = $sy_query->fetch()) 
{
            
$sy=$sy_row['sy'];
 
$MEctrQuery = $conn->query("select * FROM main_event where sy='$sy'") or die(mysql_error());
$MECtr = $MEctrQuery->rowCount();  ?>

    
 
<tr>

<td>
 
                        
                        
                        <a  data-toggle="collapse" href="#MainEvents<?php echo $sy; ?>" style="text-align: left !important; text-indent: 7px !important" class="btn btn-warning btn-block"><i class="icon icon-folder-close"></i><?php echo $sy; ?> <span class="badge badge-info pull-right" style="margin-right: 7px !important;"><strong><?php if($MECtr>0 AND $MECtr<2){echo $MECtr." Event";} elseif($MECtr>1){ echo $MECtr." Events";}else{ echo "0 Event";} ; ?></strong> </span> </a>
 
       
                
                        <div class="panel-collapse collapse" id="MainEvents<?php echo $sy; ?>"> 
                        
                        <br />
                        
                        <table align="right" style="width: 97% !important;" id="example">
 
       
                        <?php
                        
                        $myME_ctr=0;
                          
                        $event_query = $conn->query("select * from main_event where organizer_id='$session_id' AND sy='$sy'") or die(mysql_error());
                        while ($event_row = $event_query->fetch()) 
                       
                        {
                        
                        
                        
                        $myME_ctr++;
                         
                        $main_event_id=$event_row['mainevent_id'];
                        
                        
                        $SEctrQuery = $conn->query("select * FROM sub_event where mainevent_id='$main_event_id'") or die(mysql_error());
                        $SECtr = $SEctrQuery->rowCount();

                        ?>  
                        
                        <tr>
                        <td colspan="3">
                                   
                        <!-- view events feature -->
                                  
                        <?php
                        if($event_row['status']=="deactivated") { ?>
                                    
                        <a style="text-align: left !important; text-indent:7px !important;" data-toggle="collapse" class="btn btn-default btn-block" title="Complete Event name: <?php echo $event_row['event_name']; ?>. This Main Event is deactivated" href="#collapse2<?php echo $main_event_id; ?>"><?php echo $myME_ctr.". ".substr($event_row['event_name'], 0, 22); ?><span class="badge badge-default pull-right" style="margin-right: 7px !important;"><?php if($SECtr>0 AND $SECtr<2){echo $SECtr." Sub-Event";} elseif($SECtr>1){ echo $SECtr." Sub-Events";}else{ echo "0 Sub-Event";} ; ?></span></a>
                        
                        <?php } else { ?>
                        
                        <a title="Complete Event name: <?php echo $event_row['event_name']; ?>" style="text-align: left !important; text-indent:7px !important;" data-toggle="collapse" class="btn btn-info btn-block" href="#collapse2<?php echo $main_event_id; ?>"><?php echo $myME_ctr.". ".substr($event_row['event_name'], 0, 22); ?><span class="badge badge-warning pull-right" style="margin-right: 7px !important;"><strong><?php if($SECtr>0 AND $SECtr<2){echo $SECtr." Sub-Event";} elseif($SECtr>1){ echo $SECtr." Sub-Events";}else{ echo "0 Sub-Event";} ; ?></strong></span></a>
                        
                        <?php }?>
 
                        </td>
                        
    
                        
                        </tr>
                        
           
           
           
                        <tr>
                        
                        <td colspan="3">
     
                                    <!-- start of List of sub-events -->
                                                
                                    
                                     
                                    <div id="collapse2<?php echo $main_event_id; ?>" class="panel-collapse collapse"> 
                 
                                    <table align="right" style="width: 97% !important;" id="example">
                                    
                                    
                                    <tr>
                                    
                                    <td colspan="3">
                                   
    <div id="myGroup<?php echo $main_event_id; ?>">
    
    <?php if($event_row['status']=="deactivated") { ?>
    
    <a class="btn btn-default"><i class="icon-list"></i></a>
    
    <?php } else { ?>
    
    <a class="btn btn-info" data-toggle="collapse" data-target="#listSubEvents<?php echo $main_event_id; ?>" data-parent="#myGroup<?php echo $main_event_id; ?>"><i class="icon-list"></i></a>
      
    <?php }?>
 
    <?php if($event_row['status']=="activated") { ?>
    
    <a data-toggle="collapse" data-target="#ActivateDeactivate<?php echo $main_event_id; ?>" data-parent="#myGroup<?php echo $main_event_id; ?>" class="btn btn-warning" title="Click to deactivate <?php echo $event_row['event_name']; ?>. Current Status is: Activated" data-toggle="collapse" data-target="#keys" data-parent="#myGroup<?php echo $main_event_id; ?>"><i class="icon icon-eye-open"></i></a>
 
    <?php }else{ if($event_row['status']=="deactivated"){ ?>
    
    <a data-toggle="collapse" data-target="#ActivateDeactivate<?php echo $main_event_id; ?>" data-parent="#myGroup<?php echo $main_event_id; ?>" class="btn btn-danger" title="Click to activate <?php echo $event_row['event_name']; ?>. Current Status is: Deactivated" data-toggle="collapse" data-target="#keys" data-parent="#myGroup<?php echo $main_event_id; ?>"><i class="icon icon-eye-close"></i></a>
    
    <?php }} ?>
                        
    <?php if($event_row['status']=="deactivated") { ?>
    
    <a class="btn btn-default"><i class="icon-plus"></i></a>
    <a class="btn btn-default"><i class="icon-pencil"></i></a>
    <a class="btn default"><i class="icon-trash"></i></a>
    <a class="btn btn-default" title="Click to print data of Main Event: <?php echo $event_row['event_name']; ?>" href="print_all_results.php?main_event_id=<?php echo $main_event_id; ?>" data-toggle="collapse" data-target="#edit" data-parent="#myGroup<?php echo $main_event_id; ?>"><i class="icon-print"></i></a>
    
    <?php } else { ?>
    
    <a class="btn btn-primary" data-toggle="collapse" data-target="#addSubEvents<?php echo $main_event_id; ?>" data-parent="#myGroup<?php echo $main_event_id; ?>"><i class="icon-plus"></i></a>
    <a class="btn btn-success" data-toggle="collapse" data-target="#editEvent<?php echo $main_event_id; ?>" data-parent="#myGroup<?php echo $main_event_id; ?>"><i class="icon-pencil"></i></a>
    <a class="btn btn-danger" data-toggle="collapse" data-target="#deleteEvent<?php echo $main_event_id; ?>" data-parent="#myGroup<?php echo $main_event_id; ?>"><i class="icon-remove"></i></a>
    <a target="_blank" class="btn btn-default" title="Click to print data of Main Event: <?php echo $event_row['event_name']; ?>" href="print_all_results.php?main_event_id=<?php echo $main_event_id; ?>" data-toggle="collapse" data-target="#edit" data-parent="#myGroup<?php echo $main_event_id; ?>"><i class="icon-print"></i></a>
          
    <?php }?>
    
    <br />
                                
        <div style="border: 0px !important;" class="accordion-group">
                
                <div class="collapse indent" id="listSubEvents<?php echo $main_event_id; ?>">
                                    
                                    <h4>List of Events</h4>
                                    <table align="center" class="table table-bordered" id="example">
                                    
                                    <thead>
                                    
                                    <th><strong>Event Title</strong></th>
                                    
                                    <th><center><strong>Status</strong></center></th>
                                    <th><center><strong>Actions</strong></center></th>
                                    </thead>
                            
                                    <?php
                                    $se_ctr=0;
                                    $sub_event_query = $conn->query("select * from sub_event where mainevent_id='$main_event_id'") or die(mysql_error());
                                    while ($sub_event_row = $sub_event_query->fetch()) 
                                    { 
                                    $se_ctr++;
                                    $sub_event_id=$sub_event_row['subevent_id'];   ?>
                                         
                                    <tr>
                            
                                    <td>
                                    <strong><?php echo $se_ctr.". ".$sub_event_row['event_name']; ?></strong>
                                    
                                    <div id="editMEcollapse<?php echo $sub_event_row['subevent_id']; ?>" class="panel-collapse collapse">
                                    
                                    <div class="pull-right">
                                    <table class="table table-bordered">
                                    
                                    <tr>
                                    <td><h4>Edit Event Title</h4></td>
                                    </tr>
                                    <tr>
                                    <td>
                                    
                                    <form method="POST">
                                    <input type="hidden" name="sub_event_id" value="<?php echo $sub_event_row['subevent_id']; ?>" />
                                    <input type="hidden" name="se_name" value="<?php echo $sub_event_row['event_name']; ?>" />
                                    <input name="se_new_name" type="text" placeholder="Enter Sub-Event Title" value="<?php echo $sub_event_row['event_name']; ?>" />
                                    <br />
                                    <button style="margin-right: 5px !important;" name="edit_se" class="btn btn-success pull-right"><i class="icon-ok"></i> <strong>UPDATE</strong></button>
                                    </form>
                                    
                                    </td>
                                    </tr>
                                    </table>
                                    
                                    </div>
                                    
                                    </div>
                                    
                                    <?php 

                                    if(isset($_POST['edit_se']))
                                    {
                                        
                                        $se_name=$_POST['se_name'];
                                        $sub_event_id=$_POST['sub_event_id'];
                                        $se_new_name=$_POST['se_new_name'];
                                       
                                      
                                       /* contestants */
                                       
                                        $conn->query("update sub_event set event_name='$se_new_name' where subevent_id='$sub_event_id'");
                                       
                                      
                                     ?>
                                     
                                    <script>		                                      
                                    window.location = 'home.php';
                                    alert('Sub-Event title: <?php echo $se_name." was changed to: ".$se_new_name; ?> successfully!');						
                                    </script>
                                    
                                    <?php  
                                     
                                     
                                    } ?>
                                    
                                    <br />
                                    
                                    <div id="deleteMEcollapse<?php echo $sub_event_row['subevent_id']; ?>" class="panel-collapse collapse">
                                    
                                    <div class="pull-right">
                                    
                                    <table class="table table-bordered">
                                    
                                    <tr>
                                    <td><h4>Delete Event</h4></td>
                                    </tr>
                                    <tr>
                                    <td>
                                    
                                    <?php 
                                    $place_query = $conn->query("select * from sub_results where subevent_id='$sub_event_id'") or die(mysql_error());
                                    if($place_query->rowCount()==0)
                                    { ?>
                                    
                                    <form method="POST">
                                    
                                    <input type="hidden" name="sub_event_id" value="<?php echo $sub_event_row['subevent_id']; ?>" />
                                    <input type="hidden" name="se_name" value="<?php echo $sub_event_row['event_name']; ?>" />
                  
                                    <input id="myInput" name="entered_pass" type="password" placeholder="Enter Organizer's Password" />
                                    <br />
                                    <p><input style="padding-top: 0px !important; margin-top: 0px !important;" type="checkbox" onclick="myFunctionDSE()"/> <strong>Show Password</strong></p>
                                    
                                    
                                    <script>
                                    function myFunctionDSE() {
                                        var x = document.getElementById("myInput");
                                        if (x.type === "password") {
                                            x.type = "text";
                                        } else {
                                            x.type = "password";
                                        }
                                    }
                                    </script>

                                   
                                    <br />
                                    <button style="margin-right: 5px !important;" name="deleteSubEvent" class="btn btn-danger pull-right"><i class="icon-ok"></i> <strong>DELETE</strong></button>
                                    </form>
                                    
                                    <?php } else { ?>
                                    <div class="alert alert-warning">
                                    <h3>Cannot delete Event. There are saved data for this Sub-Event.</h3>
                                    </div>
                                    
                                    <?php } ?>
                                    
                                    
                                    </td>
                                    </tr>
                                    </table>
                                    
                                    </div>
                                    
                                    </div>
                                    
                                    
                                    <?php
                                    
                                    if(isset($_POST['deleteSubEvent']))
                                    {
                                    
                                    $sub_event_id=$_POST['sub_event_id'];
                                    $entered_pass=$_POST['entered_pass'];
                                    $se_name=$_POST['se_name'];
                  
                                    if($check_pass==$entered_pass)
                                    {
                                   
                                            $conn->query("delete from sub_event where subevent_id='$sub_event_id'"); 
                                            
                                            $conn->query("delete from contestants where subevent_id='$sub_event_id'"); 
                                            
                                            $conn->query("delete from criteria where subevent_id='$sub_event_id'"); 
                                             
                                            $conn->query("delete from judges where subevent_id='$sub_event_id'"); 
                               
                                        ?>
                                 
                                            
                                        <script>
                                        window.location = 'home.php';
                                        alert('Sub-Event: <?php echo $se_name; ?> and its related data deleted successfully. . .');						
                                        </script> 
                                        
                                         
                                           <?php } else { ?>
                                            
                                        <script>
                                        window.location = 'home.php';
                                        alert('Bad Password! Try Again');						
                                        </script>   
                                            
                                                
                                           <?php } }  ?>
   
   
                                    </td>
                                     
                                    <?php
                                    if($sub_event_row['status']=="activated")
                                    { ?>
                                         
                                    <td width="10"><center><strong><i style="color: green;">Active</i></strong></center></td>
                                        
                                    <td width="175">
                                    <center>
                                    
                                    <a title="Click to Deactivate <?php echo $sub_event_row['event_name'];?>. Current Status: Active" target="_blank" onclick="javascript: setTimeout(window.close, 10);" href="sub_event_stat_update.php?status=<?php echo $sub_event_row['status']; ?>&se_name=<?php echo $sub_event_row['event_name']; ?>&sub_event_id=<?php echo $sub_event_row['subevent_id']; ?>" class="btn btn-danger"><i class="icon icon-off"></i></a>
                                          
                                    <a title="Click to view <?php echo $sub_event_row['event_name'];?> Data and Settings" href="sub_event_details.php?sub_event_id=<?php echo $sub_event_row['subevent_id']; ?>&se_name=<?php echo $sub_event_row['event_name']; ?>" class="btn btn-primary"><i class="icon icon-cog"></i></a>
                                    
                                    
                                    <a title="Click to edit <?php echo $sub_event_row['event_name'];?>'s Title" data-toggle="collapse" data-target="#editMEcollapse<?php echo $sub_event_row['subevent_id']; ?>" class="btn btn-success"><i class="icon icon-pencil"></i></a>
                                    
                                 
                            
                                    <a data-toggle="collapse" data-target="#deleteMEcollapse<?php echo $sub_event_row['subevent_id']; ?>" title="Click to delete <?php echo $sub_event_row['event_name'];?>." class="btn btn-danger"><i class="icon icon-trash"></i></a>
                                     
                                    </center>
                                    </td>
                                         
                                    <?php }else{  ?>
                                             
                                    <td width="10"><center><strong><i>Inactive</i></strong></center></td>  
                                        
                                    <td width="175">
                                    <center>
                                    <a title="Click to Activate <?php echo $sub_event_row['event_name'];?>. Current Status: Deactive" target="_blank" onclick="javascript: setTimeout(window.close, 10);" href="sub_event_stat_update.php?status=<?php echo $sub_event_row['status']; ?>&se_name=<?php echo $sub_event_row['event_name']; ?>&sub_event_id=<?php echo $sub_event_row['subevent_id'];?>" class="btn btn-success"><i class="icon icon-off"></i></a>
                                    <a class="btn btn-default"><i class="icon icon-cog"></i></a>
                                    <a class="btn btn-default"><i class="icon icon-pencil"></i></a>
                                    <a class="btn btn-default"><i class="icon icon-trash"></i></a>
                                    
                                    </center>
                                    </td>
                                         
                                    <?php } ?>
                                        
                                    </tr>
                                        
                                    <?php } if($se_ctr>0){ ?>
                          
                                     
                                    <?php } else{ ?>
                                    
                                    <tr>
                                    <td colspan="3">
                                    <div class="alert alert-warning">
                                    <h3>
                                    No data to display. Add Event <a href="#" data-toggle="collapse" data-target="#addSubEvents<?php echo $main_event_id; ?>" data-parent="#myGroup<?php echo $main_event_id; ?>"> here &raquo;</a>
                                    </h3>
                                    </div>
                                    </td>
                                    </tr>   
                                            
                                    <?php }?>
                                    </table>
                
                
                </div>
                
                <div class="collapse" id="ActivateDeactivate<?php echo $main_event_id; ?>">
                
                <?php if($event_row['status']=="activated") { ?>
                <h4>Deactivate Event <i><?php echo $event_row['event_name']; ?></i>?</h4>
                <?php }else{ if($event_row['status']=="deactivated"){ ?>
                <h4>Activate Event <i><?php echo $event_row['event_name']; ?></i>?</h4>
                <?php }} ?>
    
                
                    <table align="center" class="table table-bordered" id="example">
                    <tr>
                    <td>
                    
                      <form method="POST">
      
                      <input name="status" type="hidden" value="<?php echo $event_row['status']; ?>" />
                      <input name="main_event_id" type="hidden" value="<?php echo $main_event_id; ?>" />
                      <input name="ma_name" type="hidden" value="<?php echo $event_row['event_name']; ?>" />
                       
                       
                       
                       <?php 
                       if($event_row['status']=="activated")
                       { ?>
                       
                       
                        <div class="modal-body">
                        <strong>Confirmation Password</strong>:<br />
                        <input placeholder="Enter Organizer's Password" name="check_pass" class="form-control btn-block" style="text-indent: 7px !important; height: 30px !important;" type="password" required="true"/> 
                        </div>
                                    
                        <div class="modal-footer">
                        <button  class="btn btn-danger" name="activation" ><i class="icon icon-eye-close"></i> <strong>DEACTIVATE</strong></button> 
                        </div>
                  
                       
                       <?php
                       }
                       else
                       { 
                         if($event_row['status']=="deactivated")
                         {
                        ?>
                        
                        <div class="modal-body">
                        <strong>Confirmation Password</strong>:<br />
                        <input placeholder="Enter Organizer's Password" name="check_pass" class="form-control btn-block" style="text-indent: 7px !important; height: 30px !important;" type="password" required="true"/> 
                        </div>
                        
                        <div class="modal-footer">
                        <button  class="btn btn-success" name="activation" ><i class="icon icon-eye-open"></i> <strong>ACTIVATE</strong></button> 
                        </div>
                              
                               
                        <?php }  } ?>
                                  
                        </form>
                        
                    </td>
                    </tr>
                    </table>
                    
                </div>
                
                <div class="collapse indent" id="addSubEvents<?php echo $main_event_id; ?>">
                
                                      <!-- ADD Sub-Events -->
                                      
                                      <h4>Add Events</h4>
                                      <table align="center" class="table table-bordered" id="example">
                                      <tr>
                                      <td>
                                      
                                      <form method="POST">
                                      
                                      <input name="main_event_id" type="hidden" value="<?php echo $main_event_id; ?>" />
               
                                       


                                      <strong>Event Title</strong>:<br />
                                      <input placeholder="Enter Event title" name="sub_event_name" class="form-control btn-block" style="text-indent: 7px !important; height: 30px !important;" type="text" required="true"/> 
                                      <br />
                                     
                                    
                                      <strong>Date Start</strong>:<br />
                                      <div class="container">
                                         
                                         <input type="date" id="demo" min="2022-12-12" class="form-control btn-block" required="true">

                                         </div>
                                         <strong>Date End</strong>:<br />
                                      <div class="container">
                                         
                                         <input type="date" id="demo" min="2022-12-12" class="form-control btn-block" required="true">

                                         </div>
                                         
                                      
                                      <strong>Time Start</strong>:<br />
                                      <div class="container">
                                         
                                         <input type="time" name="event_time" type="text" required="true" placeholder="hh:mm" class="form-control btn-block">

                                         </div>
                                      
                                      <strong>Venue</strong>:<br />
                                      <textarea placeholder="Enter Event Venue" rows="2" name="event_place" class="form-control btn-block" style="text-indent: 7px !important;" required="true"></textarea>
                                      <br />
                                      
                                      
                                      <div class="modal-footer">
                                        <button type="reset" class="btn btn-default"><i class="icon-ban-circle"></i> <strong>RESET</strong></button>
                                        <button name="add_event" class="btn btn-primary"><i class="icon-ok"></i> <strong>SAVE</strong></button>
                                      </div>
                                      </form>
                                      
                                      </td>
                                      </tr>
                                      </table>
                                      
                                      <!-- End of ADD Sub-Events -->
                                      
                </div>
        
                <div class="collapse indent" id="editEvent<?php echo $main_event_id; ?>">
                
                                     <!-- start of edit of main events -->
                                     
                                      <h4>Edit Event Details</h4>
                                      <table align="center" class="table table-bordered" id="example">
                                      <tr>
                                      <td>
                                      
                                      <form method="POST">
      
      
                                      <?php   
                                          $edit_event_query = $conn->query("select * from main_event where organizer_id='$session_id' and mainevent_id='$main_event_id'") or die(mysql_error());
                                		while ($edit_event_row = $edit_event_query->fetch()) 
                                        {
                                            $edit_mainevent_id=$edit_event_row['mainevent_id'];
                                           
                                             
                                            ?>  
                                      
                                      
                                        <input name="main_event_id" type="hidden" value="<?php echo $edit_mainevent_id; ?>" />
                                      
                                        <strong>Event Name:</strong><br />  
                                        <input placeholder="Enter Event title" name="sub_event_name" class="form-control btn-block" style="text-indent: 7px !important; height: 30px !important;" type="text" required="true"/> 
                                      <br />
                                        
                                        <strong>Date Start:</strong><br /> 
                                        <div class="container">
                                         
                                         <input type="date" id="demo" min="2022-12-12" class="form-control btn-block" required="true">

                                         </div>
                                        
                                        
                                        <strong>Date End:</strong><br /> 
                                        <div class="container">
                                         
                                         <input type="date" id="demo" min="2022-12-12" class="form-control btn-block" required="true">

                                         </div>
                                         <strong>Time Start</strong>:<br />
                                      <div class="container">
                                         
                                         <input type="time" name="event_time" type="text" required="true" placeholder="hh:mm" class="form-control btn-block">

                                         </div>

                                        <strong>Venue:</strong><br /> 
                                        <textarea placeholder="Enter Event Venue" rows="2" name="event_place" class="form-control btn-block" style="text-indent: 7px !important;" required="true"></textarea>
                                      <br />
                                     
                                      
                                      <?php } ?>
                               
                                      <div class="modal-footer">
                                        <button name="edit_event" class="btn btn-success"><i class="icon-ok"></i> <strong>UPDATE</strong></button>
                                      </div>
                                      
                                      </form>
                                      
                                      </td>
                                      </tr>
                                      </table>
       
                  
                                    <!-- end of edit of main events -->
                </div>
        
                <div class="collapse" id="deleteEvent<?php echo $main_event_id; ?>">
                    
                    <h4>Delete Event <i><?php echo $event_row['event_name']; ?></i>?</h4>
                    
                    
                    <?php 
                    $place_query = $conn->query("select * from sub_results where mainevent_id='$main_event_id'") or die(mysql_error());
                    if($place_query->rowCount()==0)
                    { ?>
                                    
                     <table align="center" class="table table-bordered" id="example">
                    <tr>
                    <td>
                    
                      <form method="POST">
      
                 
                      <input name="main_event_id" type="hidden" value="<?php echo $main_event_id; ?>" />
                      <input name="ma_name" type="hidden" value="<?php echo $event_row['event_name']; ?>" />
 
                        <div class="modal-body">
                        <strong>Confirmation Password</strong>:<br />
                        <input placeholder="Enter Organizer's Password" name="entered_pass" class="form-control btn-block" style="text-indent: 7px !important; height: 30px !important;" type="password" required="true"/> 
                        </div>
                        
                        <div class="modal-footer">
                        <button  class="btn btn-danger" name="deleteEvent" ><i class="icon-trash"></i> <strong>DELETE</strong></button> 
                        </div>
                              
                               
                       
                                  
                        </form>
                        
                        </td>
                        </tr>
                        </table>
                                    
                                    <?php } else { ?>
                                    <div class="alert alert-warning">
                                    <h3>Cannot delete event. There are saved data for this event.</h3>
                                    </div>
                                    
                                    <?php } ?>
                 
                </div>
                
        </div>
        
    </div>
                                    </td>
                         
  
                                    </tr>
                            
                                    </table>
 
                                    </div>
                                          
                                    
                                     
                                    <!-- End of List of events -->
                             
   
                        </td>
                        </tr>
                        
                        <?php  } ?>
      
                        </table>
                                 
                        </div>
 
 </td>
 </tr>
 
 
  <?php  }  ?>
 
  </table>                        
         
  
           
            <div style="border: 0px;" class="accordion-group">
 
                <br /> 
 
              <div class="collapse indent" id="organizer">
              
             
  <div class="input-group">
  
                <div class="alert alert-info">
                
 <form method="POST">
    <input type="hidden" name="sender_id" value="<?php echo $session_id; ?>"  />
     <input type="hidden" name="recipient_id" value="<?php echo $contact_id ?>"  />
     <input class="form-control" name="check_pass" type="hidden" value="<?php echo $check_pass; ?>" />
      
      <h4>Organizer's Password</h4>
            <br />
       <input id="myInputOP" style="font-size: large; height: 45px !important;" class="form-control btn-block" name="user_password" type="password" placeholder="Enter Organizer's Password" />
       <p><input style="padding-top: 0px !important; margin-top: 0px !important;" type="checkbox" onclick="myFunctionOP()"/> <strong>Show Password</strong></p>
                                    
                                    
                                    <script>
                                    function myFunctionOP() {
                                        var x = document.getElementById("myInputOP");
                                        if (x.type === "password") {
                                            x.type = "text";
                                        } else {
                                            x.type = "password";
                                        }
                                    }
                                    </script>
       <div class="pull-right">
         <button class="btn btn-default" type="reset"><i class="icon-ban-circle"></i> <strong>CLEAR</strong></button>&nbsp;
         <button name="org_panel" class="btn btn-primary" title="Click to proceed to Event Organizer Panel"><i class="icon-ok"></i> <strong>LOGIN</strong></button>
     </div>
         </form>
    <br />
    </div>
    </div> 

 
               </div>
             
             
             
             
             
              <div class="collapse indent" id="judge">
             
                  <?php 
    $ame_query = $conn->query("SELECT * FROM main_event WHERE organizer_id = '$session_id' AND status='activated'");
    
            if($ame_query->rowCount()<=0)
            { ?>
             
               <div class="alert alert-warning"><h3><strong>NO ACTIVE EVENT</strong></h3></div>
            <?php }
            else
            {
                $ase_query = $conn->query("SELECT * FROM sub_event WHERE organizer_id = '$session_id' AND status='activated'");
                if($ase_query->rowCount()<=0)
            { ?>
            
                <div class="alert alert-warning"><h3><strong>NO ACTIVE SUB-EVENT</strong></h3></div>
           <?php }
            else
            {
                
            ?>
 
      
       <div class="input-group">
       <div class="alert alert-success">
      <form method="POST" action="judge_profile.php" >
            <h4>Judge's Code</h4>
            <br />
          <input id="myInputJC" style="font-size: large; height: 45px !important;" class="form-control btn-block" name="judge_code" type="password" placeholder="Enter Judge's Code" />
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
       
       <div class="pull-right">
         <button class="btn btn-default" type="reset"><i class="icon-ban-circle"></i> <strong>CLEAR</strong></button>&nbsp;
         <button name="org_panel" class="btn btn-primary" title="Click to proceed to Judging Panel"><i class="icon-ok"></i> <strong>LOGIN</strong></button>
     </div>
 
 
 </form>
        <br />
           </div>   
           
           
    </div> 
    
            
                
            <?php } } ?>
                
              </div>
              
              
           
           
     
            </div>
            
            
</div>

 
 
</div>
 
          
          
 <?php 

if(isset($_POST['org_panel']))
{
    
    $check_pass=$_POST['check_pass'];
    $user_password=$_POST['user_password'];
    
  if($check_pass==$user_password) 
  {
   ?>
            <script>
            window.open('home.php');
            window.location = 'home.php';
            </script>
<?php   
  }
  else
  {
    ?>
                <script>
                window.location = 'home.php';
                alert('wrong pass');						
                </script>
<?php  
  } } ?>  

  
  <?php include('footer.php'); ?>
 
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
