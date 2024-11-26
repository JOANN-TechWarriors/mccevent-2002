<!DOCTYPE html>
<html lang="en">

<?php 
  include('header2.php');
    include('session.php');
    
    
    $sub_event_id=$_GET['sub_event_id'];
    $se_name=$_GET['se_name'];
    
    
$se_query = $conn->query("select * from sub_event where subevent_id = '$sub_event_id'");
$se_row = $se_query->fetch();
     
  ?>
  <head>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
       /* Modal Background */
    .modal {
        display: none;
        /* Hidden by default */

    }
    body {
        font-family: Arial, sans-serif;
        background-color: #fff;
        margin: 0;
        padding: 0;
        min-height: 100vh; /* Ensures the body takes at least the full viewport height */
        width: 100vw;      /* Ensures full width */
        overflow-y: auto;  /* Enables vertical scrolling */
        overflow-x: hidden; /* Prevents horizontal scrolling if content overflows */
}

    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 250px;
        background-color: #27293d;
        color: #fff;
        padding-top: 20px;
        transition: all 0.3s;
        overflow: hidden;
        z-index: 1000; /* Ensure the sidebar is above the main content */
      }
    

      .sidebar.collapsed {
    transform: translateX(-100%); /* Move sidebar off-screen when collapsed */
    }


    .sidebar .toggle-btn {
        position: absolute;
        top: 10px;
        right: 18px;
        background-color: transparent;
        color: #fff;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }

    .sidebar .toggle-btn i {
        font-size: 20px;
    }

    .sidebar-heading {
        text-align: center;
        padding: 10px 0;
        font-size: 18px;
        margin-bottom: 10px;
    }

    .sidebar-heading img {
        max-width: 100px;
        max-height: 100px;
    }

    .sidebar ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .sidebar ul li {
        padding: 15px 20px;
        transition: all 0.3s;
    }

    .sidebar ul li a {
      color: #fff;
      text-decoration: none;
      display: flex;
      align-items: center;
    }
    .sidebar ul li a i {
        margin-right: 10px;
        transition: margin 0.3s;
    }

/*     .sidebar.collapsed ul li a i {
        margin-right: 0;
    }

    .sidebar ul li a span {
        display: inline-block;
        transition: opacity 0.3s;
    }

    .sidebar.collapsed ul li a span {
        opacity: 0;
        width: 0;
        overflow: hidden;
    } */

    .sidebar ul li a:hover {
        background-color: #1a1a2e;
    }

        .content {
            margin-left: 260px;
            padding: 20px;
        }

        button.accordion {
            background-color: #eee;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
        }

        button.accordion.active,
        button.accordion:hover {
            background-color: #ddd;
        }

        button.accordion:after {
            content: '\002B';
            color: #777;
            font-weight: bold;
            float: right;
            margin-left: 5px;
        }

        button.accordion.active:after {
            content: "\2212";
        }

        div.panel {
            padding: 0 18px;
            background-color: white;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.2s ease-out;
        }

        .main {
        margin-left: 250px; /* Space for the sidebar */
        padding: 20px;
        transition: margin-left 0.3s ease; /* Smooth transition for main content */
        }

        .main.collapsed {
        margin-left: 0; /* No space for sidebar when collapsed */
        }

        .header {
        background-color: #f8f9fa;
        padding: 10px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #ddd;
        }

        .header .profile-dropdown {
        position: relative;
        display: inline-block;
        }
        .header .profile-dropdown .dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        background-color: #fff;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
        overflow: hidden;
        z-index: 1000;
      }

      .header .profile-dropdown:hover .dropdown-menu {
          display: block;
      }

      .header .profile-dropdown .dropdown-menu a {
          display: block;
          padding: 10px;
          color: #333;
          text-decoration: none;
      }

      .header .profile-dropdown .dropdown-menu a:hover {
          background-color: #f1f1f1;
      }


      @media (max-width: 768px) {
          .sidebar {
              position: absolute;
              width: 250px;
            
              transform: translateX(-100%); /* Hide sidebar off-screen */
              display: block; /* Show sidebar when collapsed */
          }

          .main {
              margin-left: 0; /* No space for sidebar on mobile */
              transition: margin-left 0.3s ease; /* Smooth transition for main content */
          }

          .sidebar.collapsed {
              transform: translateX(0); /* Show sidebar when expanded */
          }

          .sidebar .toggle-btn {
              display: block; /* Show toggle button on mobile */
          }
      }

      @media (max-width: 576px) {
          .sidebar-heading {
              font-size: 14px;
          }

          .sidebar ul li a {
              font-size: 14px;
          }

          .header {
              padding: 5px 10px;
          }

          .header .profile-dropdown img {
              width: 30px;
              height: 30px;
          }
        }

        /* Table Container */
          .table-container {
              margin: 20px;
              overflow-x: auto;
              width: calc(100% - 40px); /* Account for margins */
              box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
              border-radius: 8px;
              background-color: white;
          }

          /* Table Styles */
          .table-responsive {
              width: 100%;
              min-width: 800px; /* Ensure minimum width for content */
              border-collapse: collapse;
              background-color: white;
          }

          /* Header Styles */
          .table-responsive thead {
              background-color: #f8f9fa;
              position: sticky;
              top: 0;
              z-index: 1;
          }

          .table-responsive th {
              padding: 15px;
              text-align: left;
              font-weight: 600;
              font-size: 14px;
              color: #333;
              border-bottom: 2px solid #dee2e6;
              white-space: nowrap;
              background-color: #f8f9fa; /* Needed for sticky header */
          }

          /* Cell Styles */
          .table-responsive td {
              padding: 12px 15px;
              border-bottom: 1px solid #dee2e6;
              font-size: 14px;
              vertical-align: middle;
          }

          /* Column Widths */
          .table-responsive td:nth-child(1) { /* Check to Select */
              width: 115px;
              min-width: 115px;
          }

          .table-responsive td:nth-child(2) { /* No. */
              width: 60px;
              min-width: 60px;
          }

          .table-responsive td:nth-child(3) { /* Picture */
              width: 80px;
              min-width: 80px;
          }

          .table-responsive td:nth-child(6) { /* Actions */
              width: 80px;
              min-width: 80px;
          }

          /* Image Styles */
          .table-responsive td img {
              max-width: 50px;
              height: auto;
              display: block;
          }

          /* Hover Effects */
          .table-responsive tbody tr:hover {
              background-color: #f8f9fa;
          }

          /* Button Styles */
          .btn {
              padding: 6px 12px;
              border-radius: 4px;
              font-size: 14px;
              line-height: 1.5;
              text-decoration: none;
              display: inline-block;
          }

          /* Responsive Adjustments */
          @media screen and (max-width: 768px) {
              .table-container {
                  margin: 10px;
                  width: calc(100% - 20px);
                  border-radius: 6px;
              }

              .btn {
                  padding: 4px 8px;
                  font-size: 12px;
              }

              /* Password input field */
              input[type="password"] {
                  width: 100%;
                  max-width: 200px;
                  margin-bottom: 10px;
                  padding: 6px;
                  border: 1px solid #dee2e6;
                  border-radius: 4px;
              }
          }

          /* Print Styles */
          @media print {
              .table-container {
                  box-shadow: none;
                  margin: 0;
              }

              .table-responsive {
                  min-width: 100%;
              }

              .btn {
                  display: none;
              }
          }
  </style>
</head>

<body>
  <div class="sidebar" id="sidebar">
    <button class="toggle-btn" id="toggle-btn"><i class="fas fa-bars"></i></button>
    <div class="sidebar-heading">
        <img src="../img/logo.png" alt="Logo">
        <div>Event Judging System</div>
    </div>
    <ul>
      <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> <span>DASHBOARD</span></a></li>
      <li><a href="home.php"><i class="fas fa-calendar-check"></i> <span>ONGOING EVENTS</span></a></li>
      <li><a href="upcoming_events.php"><i class="fas fa-calendar-alt"></i> <span>UPCOMING EVENTS</span></a></li>
      <li><a href="live_stream.php"><i class="fas fa-camera"></i> <span>LIVE STREAM</span></a></li>

    </ul>
  </div>

<!-- Header -->
    <div class="header">
            <div>
                <button class="toggle-btn" id="toggle-btn-mobile"><i class="fas fa-bars"></i></button>
            </div>
            <div class="profile-dropdown">
                <div style="font-size:small;"><?php echo $name; ?></div>
                <div class="dropdown-menu">
                    <a href="edit_organizer.php">Account Settings</a>
                    <a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span>Sign out</span></a>
                </div>
            </div>
      </div>

<div class="main" id="main-content">
    <div class="container">
      <h1>
        <?php echo $se_name; ?> Settings
      </h1>
    </div>


  <div class="container">
    <div class="span15">

      <br />
      <div class="col-md-10">
        <ul class="breadcrumb">

          <li><a href="dashboard.php">Dashboard</a> / </li>

          <li><a href="home.php">Ongoing Events</a> / </li>

          <li>
            <?php echo $se_name; ?> Settings
          </li>

        </ul>
      </div>

  
      <form method="POST">
        <input value="<?php echo $sub_event_id; ?>" name="sub_event_id" type="hidden" />


        <hr />

        <div id="myGroup">


          <a class="btn btn-info" style="margin-bottom: 4px !important;" data-toggle="collapse"
            data-target="#contestant" data-parent="#myGroup"><i class="icon-chevron-right"></i>
            <strong>CONTESTANT</strong></a>

          <a class="btn btn-info" style="margin-bottom: 4px !important;" data-toggle="collapse" data-target="#judges"
            data-parent="#myGroup"><i class="icon-chevron-right"></i> <strong>JUDGE</strong></a>

          <a class="btn btn-info" style="margin-bottom: 4px !important;" data-toggle="collapse" data-target="#criteria"
            data-parent="#myGroup"><i class="icon-chevron-right"></i> <strong>CRITERIA</strong></a>
          <a class="btn btn-info" style="margin-bottom: 4px !important;" data-toggle="collapse" data-target="#textpoll" data-parent="#myGroup"><i class="icon-chevron-right"></i> <strong>VOTE POLL</strong></a>  

          <div style="border: 0px;" class="accordion-group">

          <div class="collapse indent" id="contestant" >
                <section id="download-bootstrap" style="width:100%;">
                    <div class="page-header">
                    <h1>Contestant's Settings 
                    &nbsp;<a title="Click to add new Contestant for this Event" href="add_contestant.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name;?>" class="btn btn-primary"><i class="icon icon-plus"></i></a> 
                    </h1>
                    </div>
                    
                    <div class="table-container">
                    <table class="table-responsive">
                             
                                    <thead>
                                    <th>Check to Select</th>
                                    <th>No.</th>
                                    <th>Picture</th>
                                    <th>Name</th>
                                    <th>Course, Year & Section</th>
                                    <th>Actions</th>
                                    </thead>
                                    <form method="POST">
                                    
                                    <tbody>
                                       <?php    
                                       	$cont_query = $conn->query("SELECT * FROM contestants WHERE subevent_id='$sub_event_id' order by contestant_ctr") or die(mysql_error());
                                        while ($cont_row = $cont_query->fetch()) 
                                            { 
                                                $cont_id=$cont_row['contestant_id'];
                                              
                                                ?>
                                                
                                    <tr>
                                      
                                    <td width="115">
                                        
                                    <input name="selector[]" type="checkbox" value="<?php echo $cont_id; ?>" title="Check to select <?php echo $cont_row['fullname']; ?> "/></td>
                                    
                                    <td width="10"><?php echo $cont_row['contestant_ctr']; ?></td>
                                    <td><img width="50" src="../img/<?php echo $cont_row['Picture']; ?>" /></td>
                                    <td><?php echo $cont_row['fullname']; ?></td>
                                    <td><?php echo $cont_row['AddOn']; ?></td>
                                    <td width="10"><a title="Click to edit <?php echo $cont_row['fullname']; ?>  datas" href="edit_contestant.php?contestant_id=<?php echo $cont_row['contestant_id'];?>&sub_event_id=<?php echo $sub_event_id;?>&se_name=<?php echo $se_name;?>" class="btn btn-success"><i class="icon icon-pencil"></i></a></td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                       
                                    <td colspan="4">
                                    <input required="true" type="password" placeholder="Organizer Password" name="org_pass" />
                                    <input type="hidden" name="sub_event_id" value="<?php echo $sub_event_id; ?>" />
                                    <input type="hidden" name="se_name" value="<?php echo $se_name; ?>" />
                                    
                                    <button title="Click to delete selected row(s)" type="submit" class="btn btn-danger" name="delete_cont" ><i class="icon icon-trash"></i></button> 
                                     
                                    </td>
                                    </tr>
                                    </tbody>
                                    
                                    </form>
                                    
                            </table>
             </div>
        </section>
                </div>

            <div class="collapse indent" id="judges" >
              <section id="download-bootstrap" >
                <div class="page-header">
                  <h1>Judge's Settings
                    &nbsp;<a title="Click to add new Judge for this Event"
                      href="add_judge.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name;?>"
                      class="btn btn-primary"><i class="icon icon-plus"></i></a>
                    &nbsp;<a title="Click to print Judge's Code for this Event" target="_blank"
                      title="Click to print judges code"
                      href="print_judges.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name;?>"
                      class="btn btn-info"><i class="icon icon-print"></i></a></h1>
                </div>
                <div class="table-container">
                <table class="table-responsive">
                  <thead>
                    <th>Check to Select</th>
                    <th>No.</th>
                    <th>Code</th>
                    <th>Fullname</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </thead>
                  <form method="POST">
                    <tbody>
                      <?php    
   	$judge_query = $conn->query("SELECT * FROM judges WHERE subevent_id='$sub_event_id' order by judge_ctr") or die(mysql_error());
    while ($judge_row = $judge_query->fetch()) 
        { 
            $jxx_id=$judge_row['judge_id'];
            ?>
                      <tr>
                        <td width="115"><input name="selector[]" type="checkbox" value="<?php echo $jxx_id;  ?>"
                            title="Check to select <?php echo $judge_row['fullname']; ?>" /></td>
                        <td width="10">
                          <?php echo $judge_row['judge_ctr']; ?>
                        </td>
                        <td>
                          <?php echo $judge_row['code']; ?>
                        </td>
                        <td>
                          <?php echo $judge_row['fullname']; ?>
                        </td>
                        <td>
                          <?php echo $judge_row['jtype']; ?>
                        </td>
                        <td width="10"><a title="Click to edit <?php echo $judge_row['fullname']; ?> datas"
                            href="edit_judge.php?judge_id=<?php echo $jxx_id;?>&sub_event_id=<?php echo $sub_event_id;?>&se_name=<?php echo $se_name;?>"
                            class="btn btn-success"><i class="icon icon-pencil"></i></a>

                        </td>
                      </tr>

                      <?php } ?>
                      <tr>
                        <td colspan="6">
                          <input required="true" type="password" placeholder="Organizer Password" name="org_pass" />
                          <input type="hidden" name="sub_event_id" value="<?php echo $sub_event_id; ?>" />
                          <input type="hidden" name="se_name" value="<?php echo $se_name; ?>" />

                          <button title="Click to delete selected row(s)" type="submit" class="btn btn-danger"
                            name="delete_judge"><i class="icon icon-trash"></i></button>
                        </td>
                      </tr>
                </table>
                </td>

                </tr>
                </tbody>
      </form>
      </table>
        </div>
      </section>
    </div>

    <div class="collapse indent" id="criteria">
      <section id="download-bootstrap">
        <div class="page-header">
          <h1>Criteria's Settings &nbsp;<a title="Click to add new Criteria for this Event"
              href="add_criteria.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name;?>"
              class="btn btn-primary"><i class="icon icon-plus"></i></a></h1>
        </div>
        <div class="table-container">
        <table class="table-responsive">
          <thead>
            <th>Check to Select</th>
            <th>No.</th>
            <th>Criteria</th>
            <th>Percentage</th>
            <th>Actions</th>
          </thead>
          <form method="POST">
            <tbody>
              <?php    
  $percnt=0;
   	$crit_query = $conn->query("SELECT * FROM criteria WHERE subevent_id='$sub_event_id'") or die(mysql_error());
    while ($crit_row = $crit_query->fetch()) 
        { $percnt=$percnt+$crit_row['percentage'];
            $crit_id=$crit_row['criteria_id'];
            ?>
              <tr>
                <td width="115"><input name="selector[]" type="checkbox" value="<?php echo $crit_id; ?>"
                    title="Check to select <?php echo $crit_row['criteria']; ?>" /></td>
                <td width="10">
                  <?php echo $crit_row['criteria_ctr']; ?>
                </td>
                <td>
                  <?php echo $crit_row['criteria']; ?>
                </td>
                <td width="10">
                  <?php echo $crit_row['percentage']; ?>
                </td>
                <td width="10"><a title="Click to edit Criteria: <?php echo $crit_row['criteria']; ?> datas"
                    href="edit_criteria.php?crit_id=<?php echo $crit_id;?>&sub_event_id=<?php echo $sub_event_id;?>&se_name=<?php echo $se_name;?>"
                    class="btn btn-success"><i class="icon icon-pencil"></i></a></td>
              </tr>
              <?php } ?>

              <tr>

                <?php
      if($percnt<100)
      { ?>
                <td colspan="3">
                  <div class="alert alert-danger pull-right">

                    <strong>The Total Percentage is under 100%.</strong>
                  </div>
                </td>
                <td colspan="2">
                  <div class="alert alert-danger">

                    <strong>
                      <?php  echo $percnt; ?>%
                    </strong>
                  </div>
                </td>

                <?php } ?>

                <?php
      if($percnt>100)
      { ?>
                <td colspan="3">
                  <div class="alert alert-danger pull-right">

                    <strong>The Total Percentage is over 100%.</strong>
                  </div>
                </td>
                <td colspan="2">
                  <div class="alert alert-danger">

                    <strong>
                      <?php  echo $percnt; ?>%
                    </strong>
                  </div>

                </td>

                <?php } ?>


                <?php
      if($percnt==100)
      { ?>
                <td colspan="3"><strong class="pull-right">TOTAL</strong></td>
                <td colspan="2">
                  <span style="font-size: 15px !important;" class="badge badge-info">
                    <?php  echo $percnt; ?> %
                  </span>
                </td>

                <?php } ?>
              </tr>


              <tr>
                <td colspan="5">
                  <input required="true" type="password" placeholder="Organizer Password" name="org_pass" />
                  <input type="hidden" name="sub_event_id" value="<?php echo $sub_event_id; ?>" />
                  <input type="hidden" name="se_name" value="<?php echo $se_name; ?>" />
                  <button title="Click to delete selected row(s)" type="submit" class="btn btn-danger"
                    name="delete_crit"><i class="icon icon-trash"></i></button>
                </td>
              </tr>
            </tbody>
          </form>
        </table>
      </div>
      </section>
    </div>
    <div class="collapse indent" id="textpoll" style="width:900px;">
                 <section id="download-bootstrap" >
          <div class="page-header">
            <h1>Vote Poll Settings</h1>
          </div>
  <?php
 
  if($se_row['txtpoll_status']=="active"){ ?> 
           
 <td colspan="5"> 
 <form method="POST">
 <input value="<?php echo $sub_event_id; ?>" name="sub_event_id" type="hidden" />
 <input value="<?php echo $se_row['txtpoll_status']; ?>" name="tp_status" type="hidden" />
  <div class="btn-group pull-left">
  
  <button name="activate_textpoll" type="submit" class="btn btn-default" title="Click to deactivate event textpoll">Deactivate</button>
  <a type="button" class="btn btn-success" title="Event textpoll is activated">&nbsp;</a>
</div>
  &nbsp;<a class="btn btn-primary" href="updateTxtview.php?sid=<?php echo $sub_event_id; ?>" target="_blank" title="Click to view textpoll votes">Live View Result</a>
  &nbsp;<a class="btn btn-primary" href="updateBlankTxtview.php?sid=<?php echo $sub_event_id; ?>" target="_blank" title="Click to view textpoll votes">Live View</a>
  &nbsp;<a class="btn btn-primary" href="..//poll/index.php?event=<?php echo $sub_event_id; ?>" target="_blank" title="Click to view textpoll votes">View Vote Poll</a>
 </form>
 
 </td>
 </tr>

  </tbody>

  <?php }
 else
 { ?>
      <form method="POST">
       <input value="<?php echo $sub_event_id; ?>" name="sub_event_id" type="hidden" />
       <input value="<?php echo $se_row['txtpoll_status']; ?>" name="tp_status" type="hidden" />
        <div class="btn-group pull-left">
  <a type="button" class="btn btn-danger" title="Event textpoll is deactivated">&nbsp;</a>
  <button name="activate_textpoll" type="submit" class="btn btn-default" title="Click to activate event textpoll">Activate</button>
</div>
        <br />
         <br />
          <br />
      </form>
      
      
 <?php } ?>
 </section> 
                </div>


  </div>

  </div>
  </form>
  </div>
  </div>
  </div>

  <?php
 if (isset($_POST['activate_textpoll']))
{

$sub_event_id=$_POST['sub_event_id'];
$tp_status=$_POST['tp_status'];
 
if ($tp_status == "active") {
  $conn->query("UPDATE sub_event SET txtpoll_status='deactive', txtpollview='deactive', view='deactive' WHERE subevent_id='$sub_event_id'");
  ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script>
      Swal.fire({
          title: 'Success',
          text: 'Votepoll Deactivated',
          icon: 'success'
      }).then((result) => {
          if (result.isConfirmed) {
              window.location = 'sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>';
          }
      });
  </script>
  <?php
} else {
  $conn->query("UPDATE sub_event SET txtpoll_status='active', txtpollview='active', view='active' WHERE subevent_id='$sub_event_id'");
  ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script>
      Swal.fire({
          title: 'Success',
          text: 'Votepoll Activated',
          icon: 'success'
      }).then((result) => {
          if (result.isConfirmed) {
              window.location = 'sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>';
          }
      });
  </script>
  <?php
}}
?>


  <?php 

if(isset($_POST['save_settings']))
{
     
    $sub_event_id=$_POST['sub_event_id'];
    
 /* contestants */
 
   $con1_name=$_POST['con1'];
   if($con1_name=="")
   {
    
   }
   else
   {
     $conn->query("insert into contestants(fullname,subevent_id,contestant_ctr)values('$con1_name','$sub_event_id','1')");
   }
  
   
   $con2_name=$_POST['con2'];
   if($con2_name=="")
   {
    
   }
   else
   {
    $conn->query("insert into contestants(fullname,subevent_id,contestant_ctr)values('$con2_name','$sub_event_id','2')");
   }
   
   
   $con3_name=$_POST['con3'];
   if($con3_name=="")
   {
    
   }
   else
   {
     $conn->query("insert into contestants(fullname,subevent_id,contestant_ctr)values('$con3_name','$sub_event_id','3')");
   }
  
   
   $con4_name=$_POST['con4'];
   if($con4_name=="")
   {
    
   }
   else
   {
    $conn->query("insert into contestants(fullname,subevent_id,contestant_ctr)values('$con4_name','$sub_event_id','4')");
   }
   
   
   $con5_name=$_POST['con5'];
   if($con5_name=="")
   {
    
   }
   else
   {
    $conn->query("insert into contestants(fullname,subevent_id,contestant_ctr)values('$con5_name','$sub_event_id','5')");
   }
   
   
   $con6_name=$_POST['con6'];
   if($con6_name=="")
   {
    
   }
   else
   {
    $conn->query("insert into contestants(fullname,subevent_id,contestant_ctr)values('$con6_name','$sub_event_id','6')");
   }
   
   
   $con7_name=$_POST['con7'];
   if($con7_name=="")
   {
    
   }
   else
   {
    $conn->query("insert into contestants(fullname,subevent_id,contestant_ctr)values('$con7_name','$sub_event_id','7')");
   }
   
   
   $con8_name=$_POST['con8'];
   if($con8_name=="")
   {
    
   }
   else
   {
    $conn->query("insert into contestants(fullname,subevent_id,contestant_ctr)values('$con8_name','$sub_event_id','8')");
   }
   
   
   $con9_name=$_POST['con9'];
   if($con9_name=="")
   {
    
   }
   else
   {
    $conn->query("insert into contestants(fullname,subevent_id,contestant_ctr)values('$con9_name','$sub_event_id','9')");
   }  
   
   $con10_name=$_POST['con10'];
   if($con10_name=="")
   {
    
   }
   else
   {
    $conn->query("insert into contestants(fullname,subevent_id,contestant_ctr)values('$con10_name','$sub_event_id','10')");
   }
   
 /* end contestants */
   

   /* judges */
    $j1_name=$_POST['jud1'];
   if($j1_name=="")
   {
    
   }
   else
   {
    $conn->query("insert into judges(fullname,subevent_id,judge_ctr)values('$j1_name','$sub_event_id','1')");
   }
   
   
   $j2_name=$_POST['jud2'];
   if($j2_name=="")
   {
    
   }
   else
   {
    $conn->query("insert into judges(fullname,subevent_id,judge_ctr)values('$j2_name','$sub_event_id','2')");
   }
   
   
   $j3_name=$_POST['jud3'];
   if($j3_name=="")
   {
    
   }
   else
   {
    $conn->query("insert into judges(fullname,subevent_id,judge_ctr)values('$j3_name','$sub_event_id','3')");
   }
   
   
   $j4_name=$_POST['jud4'];
   if($j4_name=="")
   {
    
   }
   else
   {
    $conn->query("insert into judges(fullname,subevent_id,judge_ctr)values('$j4_name','$sub_event_id','4')");
   }
   
   
   $j5_name=$_POST['jud5'];
   if($j5_name=="")
   {
    
   }
   else
   {
    $conn->query("insert into judges(fullname,subevent_id,judge_ctr)values('$j5_name','$sub_event_id','5')");
   }
   
   
   $j6_name=$_POST['j6'];
   if($j6_name=="")
   {
    
   }
   else
   {
    $conn->query("insert into judges(fullname,subevent_id,judge_ctr)values('$j6_name','$sub_event_id','6')");
   }
   
   
   $j7_name=$_POST['j7'];
   if($j7_name=="")
   {
    
   }
   else
   {
    $conn->query("insert into judges(fullname,subevent_id,judge_ctr)values('$j7_name','$sub_event_id','7')");
   }
   
   
   $j8_name=$_POST['j8'];
   if($j8_name=="")
   {
    
   }
   else
   {
    $conn->query("insert into judges(fullname,subevent_id,judge_ctr)values('$j8_name','$sub_event_id','8')");
   }
   
   
   $j9_name=$_POST['j9'];
   if($j9_name=="")
   {
    
   }
   else
   {
    $conn->query("insert into judges(fullname,subevent_id,judge_ctr)values('$j9_name','$sub_event_id','9')");
   }
   
   
   $j10_name=$_POST['j10'];
   if($j10_name=="")
   {
    
   }
   else
   {
    $conn->query("insert into judges(fullname,subevent_id,judge_ctr)values('$j10_name','$sub_event_id','10')");
   }
 /* judges */
 
 
  /* criteria */
   $c1_name=$_POST['crit1']; 
    $cp1=$_POST['cp1'];
  if($c1_name!="" or $cp1>0)
    {
      $conn->query("insert into criteria(criteria,subevent_id,percentage,criteria_ctr)values('$c1_name','$sub_event_id','$cp1','1')"); 
    }
    
    
       $c2_name=$_POST['crit2']; 
    $cp2=$_POST['cp2'];
   if($c2_name!="" or $cp1>0)
    {
      $conn->query("insert into criteria(criteria,subevent_id,percentage,criteria_ctr)values('$c2_name','$sub_event_id','$cp2','2')"); 
    }
    
    
       $c3_name=$_POST['crit3']; 
    $cp3=$_POST['cp3'];
    if($c3_name!="" or $cp3>0)
    {
      $conn->query("insert into criteria(criteria,subevent_id,percentage,criteria_ctr)values('$c3_name','$sub_event_id','$cp3','3')"); 
    }
    
    
       $c4_name=$_POST['crit4']; 
    $cp4=$_POST['cp4'];
   if($c4_name!="" or $cp4>0)
    {
      $conn->query("insert into criteria(criteria,subevent_id,percentage,criteria_ctr)values('$c4_name','$sub_event_id','$cp4','4')"); 
    }
    
    
       $c5_name=$_POST['crit5']; 
    $cp5=$_POST['cp5'];
    if($c5_name!="" or $cp5>0)
    {
      $conn->query("insert into criteria(criteria,subevent_id,percentage,criteria_ctr)values('$c5_name','$sub_event_id','$cp5','5')"); 
    }
    
    
       $c6_name=$_POST['crit6']; 
    $cp6=$_POST['cp6'];
    if($c6_name!="" or $cp6>0)
    {
      $conn->query("insert into criteria(criteria,subevent_id,percentage,criteria_ctr)values('$c6_name','$sub_event_id','$cp6','6')"); 
    }
    
    
       $c7_name=$_POST['crit7']; 
    $cp7=$_POST['cp7'];
   if($c7_name!="" or $cp7>0)
    {
      $conn->query("insert into criteria(criteria,subevent_id,percentage,criteria_ctr)values('$c7_name','$sub_event_id','$cp7','7')"); 
    }
    
    
       $c8_name=$_POST['crit8']; 
    $cp8=$_POST['cp8'];
    if($c8_name!="" or $cp8>0)
    {
      $conn->query("insert into criteria(criteria,subevent_id,percentage,criteria_ctr)values('$c8_name','$sub_event_id','$cp8','8')"); 
    }
    
    
       $c9_name=$_POST['crit9']; 
    $cp9=$_POST['cp9'];
   if($c9_name!="" or $cp9>0)
    {
      $conn->query("insert into criteria(criteria,subevent_id,percentage,criteria_ctr)values('$c9_name','$sub_event_id','$cp9','9')"); 
    }
    
    
       $c10_name=$_POST['crit10']; 
    $cp10=$_POST['cp10'];
    if($c10_name!="" or $cp10>0)
    {
      $conn->query("insert into criteria(criteria,subevent_id,percentage,criteria_ctr)values('$c10_name','$sub_event_id','$cp10','10')"); 
    }
    /* end criteria */
   
 ?>
  <script>

    window.location = 'home.php';
    alert('Organizer <?php echo $fname." ".$mname." ".$lname; ?> registered successfully!');						
  </script>
  <?php  
 
 
} ?>


<?php
if (isset($_POST['delete_cont'])) {

    $org_pass = $_POST['org_pass'];
    $sub_event_id = $_POST['sub_event_id'];
    $se_name = $_POST['se_name'];

    if ($check_pass == $org_pass) {
        $id = $_POST['selector'];
        $N = count($id);
        for ($i = 0; $i < $N; $i++) {
            $conn->query("DELETE FROM contestants WHERE contestant_id='$id[$i]'");
            $conn->query("DELETE FROM sub_results WHERE contestant_id='$id[$i]'");
        }
        ?>
        <script>
            Swal.fire({
                title: 'Success!',
                text: 'Contestant(s) successfully deleted.',
                icon: 'success',
                onClose: () => {
                    window.location = 'sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>';
                }
            });
        </script>
        <?php
    } else {
        ?>
        <script>
            Swal.fire({
                title: 'Error!',
                text: 'Confirmation password is invalid!',
                icon: 'error',
                onClose: () => {
                    window.location = 'sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>';
                }
            });
        </script>
        <?php
    }
}
?>

<?php
if (isset($_POST['delete_judge'])) {

    $org_pass = $_POST['org_pass'];
    $sub_event_id = $_POST['sub_event_id'];
    $se_name = $_POST['se_name'];

    // Assume $check_pass contains the correct organizer password
    // Perform your password check here
    if ($check_pass == $org_pass) {
        $id = $_POST['selector'];
        $N = count($id);
        for ($i = 0; $i < $N; $i++) {
            $conn->query("DELETE FROM judges WHERE judge_id='$id[$i]'");
            $conn->query("DELETE FROM sub_results WHERE judge_id='$id[$i]'");
        }
        echo '<script>
            Swal.fire({
                title: "Deleted!",
                text: "Judge(s) successfully deleted.",
                icon: "success"
            }).then(function() {
                window.location = "sub_event_details_edit.php?sub_event_id=' . $sub_event_id . '&se_name=' . $se_name . '";
            });
        </script>';
    } else {
        echo '<script>
            Swal.fire({
                title: "Error!",
                text: "Confirmation password is invalid!",
                icon: "error"
            }).then(function() {
                window.location = "sub_event_details_edit.php?sub_event_id=' . $sub_event_id . '&se_name=' . $se_name . '";
            });
        </script>';
    }
}
?>

<?php
if (isset($_POST['delete_crit'])) {

    $org_pass = $_POST['org_pass'];
    $sub_event_id = $_POST['sub_event_id'];
    $se_name = $_POST['se_name'];

    if ($check_pass == $org_pass) {
        $id = $_POST['selector'];
        $N = count($id);
        for ($i = 0; $i < $N; $i++) {
            $conn->query("DELETE FROM criteria WHERE criteria_id='$id[$i]'");
        }
        ?>
        <script>
            Swal.fire({
                title: 'Success!',
                text: 'Criteria(s) successfully deleted.',
                icon: 'success',
                onClose: () => {
                    window.location = 'sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>';
                }
            });
        </script>
        <?php
    } else {
        ?>
        <script>
            Swal.fire({
                title: 'Error!',
                text: 'Confirmation password is invalid!',
                icon: 'error',
                onClose: () => {
                    window.location = 'sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>';
                }
            });
        </script>
        <?php
    }
}
?>

  <script>
document.addEventListener("DOMContentLoaded", function() {
    const toggleButtons = document.querySelectorAll(".toggle-btn");
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.querySelector(".main");

    toggleButtons.forEach(button => {
        button.addEventListener("click", function() {
            // Toggle the collapsed class on sidebar
            sidebar.classList.toggle("collapsed");
            // Toggle the collapsed class on main content
            mainContent.classList.toggle("collapsed");
        });
    });
});

</script>

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

</body>
</html>