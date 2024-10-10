<!DOCTYPE html>
<html lang="en">

<?php
include('header2.php');
include('session.php');
?>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        .sidebar-heading {
            text-align: center;
            padding: 10px 0;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            background-color: #333;
            color: #fff;
            padding-top: 60px;
            transition: all 0.3s;
            overflow: hidden;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar .toggle-btn {
            position: absolute;
            top: 15px;
            right: -0px;
            background-color: transparent;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }

        .sidebar .toggle-btn i {
            font-size: 18px;
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
            padding: 10px;
            transition: all 0.3s;
            font-size: 15px;
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

        .sidebar.collapsed ul li a i {
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
        }

        .sidebar ul li a:hover {
            background-color: #555;
        }
        .header{
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

        .header .profile-dropdown img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            cursor: pointer;
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
        .main {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }

        .main.collapsed {
            margin-left: 80px;
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

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main {
                margin-left: 0;
            }
        }
    </style>
</head>

<body>

<div class="sidebar" id="sidebar">
        <button class="toggle-btn" id="toggle-btn">☰</button>
        <div class="sidebar-heading">
            <img src="../img/logo.png" alt="Logo">
            <div>Event Judging System</div>
        </div>
        <ul>
            <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> <span>DASHBOARD</span></a></li>
            <li><a href="home.php"><i class="fas fa-calendar-check"></i> <span>ONGOING EVENTS</span></a></li>
            <li><a href="upcoming_events.php"><i class="fas fa-calendar-alt"></i> <span>UPCOMING EVENTS</span></a></li>
            <li><a href="score_sheets.php"><i class="fas fa-clipboard-list"></i> <span>SCORE SHEETS</span></a></li>
            <li><a href="rev_main_event.php"><i class="fas fa-chart-line"></i> <span>DATA REVIEWS</span></a></li>
        </ul>
    </div>
    <!-- Header -->
    <div class="header">
        <div>
            <!-- Add any left-aligned content here if needed -->
        </div>
        <div class="profile-dropdown">
           <div style="font-size:small;"> <?php echo $name; ?></div>
            <div class="dropdown-menu">
                <a href="edit_organizer.php"> Account Settings</a>
                <a href="#" id="logout"><i class="fas fa-sign-out-alt"></i> <span>LOGOUT</span></a>
            </div>
        </div>
    </div>
    
    <!-- Main content -->
    <div class="main" id="main-content">
        <div class="container">
            <h1>Score Sheets</h1>
        </div>

        <div class="span15">
            <br />
            <div class="col-md-15">
                <ul class="breadcrumb">
                    <li>
                        <a href="dashboard.php">Dashboard</a> /
                    </li>
                    <li>
                        <a href="home.php">Ongoing Events</a> /
                    </li>
                    <li>
                        <a href="upcoming_events.php">Upcoming Events</a> /
                    </li>
                    <li>Score Sheets</li>
                </ul>
            </div>
        </div>

<?php
    
    $sy_query = $conn->query("select * FROM main_event where organizer_id='$session_id' AND status='activated'") or die(mysql_error());
    while ($sy_row = $sy_query->fetch()) 
    { ?>
    
    <tr>
    <td>
           
    <?php 
     
    $sy=$sy_row['sy'];
    $MEidxxx=$sy_row['mainevent_id'];
      
              $event_query = $conn->query("select * from main_event where mainevent_id='$MEidxxx' AND status='activated'") or die(mysql_error());
            while ($event_row = $event_query->fetch()) 
            { ?>
           
               <button class="accordion"><strong><?php echo $event_row['event_name']; ?></strong></button> 
                  <?php }   ?>
                  
             <div class="panel">
             
             
             <table class="table table-striped">
              
              <thead>
            <th>Event Name</th>
            
            <th>View Score Sheet - Select Judge</th>
              </thead>
              
              <tbody>
             <?php   
              $s_event_query = $conn->query("select * from sub_event where mainevent_id='$MEidxxx'") or die(mysql_error());
            while ($s_event_row = $s_event_query->fetch()) 
            { 
                $se_id=$s_event_row['subevent_id'];
                ?>
         <tr>
         <td>
         <div class="nav-collapse collapse">
  <ul class="nav">
    <li>
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><strong><?php echo $s_event_row['event_name']; ?></strong> <span class="caret"></span>
      </a>
      <ul class="dropdown-menu" role="menu">
        <li>
          <a title="Go to live viewing of this Sub-Event scores." target="_blank" href="updateview.php?sid=<?php echo $se_id; ?>">Live View</a> 
        </li>
        
        <?php if($s_event_row['txtpoll_status'] == "active") { ?>
          <li>
            <a title="Go to live viewing of this Sub-Event Text Poll." target="_blank" href="updateBlankTxtview.php?sid=<?php echo $se_id; ?>">Text Poll Live View</a> 
          </li>
          
          <li>
            <a title="Go to live viewing of this Sub-Event Text Poll Data." target="_blank" href="txt_pollData.php?sid=<?php echo $se_id; ?>">TP - Text Code</a> 
          </li>
        <?php } ?>
      </ul>
    </li>
  </ul>
</div>

         </td>
         <td>
     <br>
         <?php   
              $judge_query = $conn->query("select * from judges where subevent_id='$se_id' order by judge_ctr") or die(mysql_error());
            while ($judge_row = $judge_query->fetch()) 
            { ?>
         
         <a style="margin-top: 4px !important;" title="click to rank contestant score's for this judge" target="_blank" href="view_score_sheet.php?event_id=<?php echo $se_id ; ?>&judge_id=<?php echo $judge_row['judge_id']; ?>" class="btn btn-info"><i class="icon icon-tasks"></i> <?php echo $judge_row['judge_ctr']; ?>. <?php echo $judge_row['fullname']; ?></a>
          <?php } ?>
     
         </td>
         
         <td width="128">
            <a title="click to set points deductions" target="_blank" href="deductScores.php?event_id=<?php echo $se_id ; ?>" class="btn btn-danger"><i class="icon icon-minus-sign"></i></a>
    
            <a title="click to set final result for this sub-event" target="_blank" href="result_title.php?event_id=<?php echo $se_id ; ?>" class="btn btn-primary"><i class="icon icon-star"></i></a>
            
            <a title="click to print results" target="_blank" href="result_sheet.php?event_id=<?php echo $se_id ; ?>" class="btn btn-primary"><i class="icon icon-print"></i></a>
     
         </td>
         
         </tr>
         <?php } ?>
         
         
                </tbody>
         
              </table>
            </br  >
            <hr />  
            
            </div>
              
           
            
            
            </td>
          </tr>
            
            
            <?php } ?>     
              
             </table>
            
            </section>
     
     
          </div>
        </div>
    
      </div>

      <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
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

    <script>
       
        document.getElementById("toggle-btn").addEventListener("click", function () {
            var sidebar = document.getElementById("sidebar");
            var mainContent = document.getElementById("main-content");

            sidebar.classList.toggle("collapsed");
            mainContent.classList.toggle("collapsed");

            var isCollapsed = sidebar.classList.contains("collapsed");
            this.innerHTML = isCollapsed ? "☰" : "☰";
        });

        var acc = document.getElementsByClassName("accordion");
        for (var i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function () {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.maxHeight) {
                    panel.style.maxHeight = null;
                } else {
                    panel.style.maxHeight = panel.scrollHeight + "px";
                }
            });
        }
        document.getElementById('logout').addEventListener('click', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to log out?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to logout.php
                    window.location.href = '..//index.php';
                }
            });
        });
    </script>
</body>
</html>
