<!DOCTYPE html>
<html lang="en">
  
  <?php 
  include('header.php');
  include('session.php');
    
  $sub_event_id=$_GET['sub_event_id'];
  $se_name=$_GET['se_name'];
  $judge_id=$_GET['judge_id'];
  ?>
  <head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            width: 100vw;
            overflow-y: auto;
            overflow-x: hidden;
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
            z-index: 1000;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
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
            margin-bottom: 10px;
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
            width: 20px;
            text-align: center;
        }

        .sidebar ul li:hover {
            background-color: #1a1a2e;
        }

        .main {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }

        .main.collapsed {
            margin-left: 80px;
        }

        .header {
            background-color: #fff;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .header .profile-dropdown {
            position: relative;
            display: inline-block;
            padding: 8px 15px;
            cursor: pointer;
        }

        .header .profile-dropdown:hover {
            background-color: #f8f9fa;
            border-radius: 4px;
        }

        .header .profile-dropdown .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            min-width: 180px;
            z-index: 1000;
        }

        .header .profile-dropdown:hover .dropdown-menu {
            display: block;
        }

        .header .profile-dropdown .dropdown-menu a {
            display: block;
            padding: 10px 15px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.2s;
        }

        .header .profile-dropdown .dropdown-menu a:hover {
            background-color: #f1f1f1;
        }

        /* Improved Edit Form Styles */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .container h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #337ab7;
        }

        .edit-form-container {
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .panel-primary {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 20px;
            background-color: #fff;
        }

        .panel-heading {
            background-color: #337ab7;
            color: white;
            padding: 15px 20px;
            border-radius: 7px 7px 0 0;
            display: flex;
            align-items: center;
        }

        .panel-title {
            margin: 0;
            font-size: 18px;
            font-weight: 500;
        }

        .panel-body {
            padding: 25px;
        }

        /* Improved Table Styles */
        .edit-table {
            width: 100%;
            margin: 0 auto;
        }

        .table-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
            align-items: flex-start;
        }

        .table-cell {
            flex: 1;
            padding: 0 10px;
            margin-bottom: 20px;
            min-width: 200px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 14px;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            border: 1px solid #ced4da;
            border-radius: 4px;
            transition: all 0.2s ease-in-out;
        }

        .form-control:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.15);
        }

        select.form-control {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            padding-right: 2.5rem;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 25px;
            padding: 0;
        }

        .btn {
            padding: 10px 20px;
            font-size: 14px;
            font-weight: 500;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 100px;
        }

        .btn-default {
            color: #333;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
        }

        .btn-success {
            color: #fff;
            background-color: #28a745;
            border: 1px solid #28a745;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .btn-default:hover {
            background-color: #e2e6ea;
            border-color: #dae0e5;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .edit-form-container {
                padding: 15px;
                margin: 10px;
            }

            .table-row {
                margin: 0;
            }

            .table-cell {
                flex: 0 0 100%;
                padding: 0;
                margin-bottom: 15px;
            }

            .button-group {
                flex-direction: column;
                gap: 8px;
            }

            .btn {
                width: 100%;
                margin: 0;
            }

            .main {
                margin-left: 0;
                padding: 10px;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .header {
                padding: 10px;
            }

            .container h1 {
                font-size: 20px;
                margin-bottom: 15px;
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
            <h1><?php echo $se_name; ?> Settings</h1>
            
            <div class="edit-form-container">
                <form method="POST">
                    <input value="<?php echo $sub_event_id; ?>" name="sub_event_id" type="hidden" />
                    <input value="<?php echo $se_name; ?>" name="se_name" type="hidden" />
                    <input value="<?php echo $judge_id; ?>" name="judge_id" type="hidden" />
                    
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Edit Judge</h3>
                        </div>
                        <div class="panel-body">
                            <div class="edit-table">
                                <?php    
                                $judge_query = $conn->query("SELECT * FROM judges WHERE judge_id='$judge_id'") or die(mysql_error());
                                while ($judge_row = $judge_query->fetch()) { 
                                ?>
                                <div class="table-row">
                                    <div class="table-cell">
                                        <label class="form-label">Judge no.</label>
                                        <select name="judge_ctr" class="form-control">
                                            <option><?php echo $judge_row['judge_ctr']; ?></option>
                                            <?php 
                                            $n1=0;
                                            while($n1<4) { 
                                                $n1++;
                                                $cont_query = $conn->query("SELECT * FROM judges WHERE judge_ctr='$n1' AND subevent_id='$sub_event_id'") or die(mysql_error());
                                                if($cont_query->rowCount()>0) {
                                                } else {
                                                    echo "<option>".$n1."</option>";
                                                }
                                            } 
                                            ?>
                                        </select>
                                    </div>
                                    <div class="table-cell">
                                        <label class="form-label">Judge Fullname</label>
                                        <input name="fullname" type="text" class="form-control" value="<?php echo $judge_row['fullname']; ?>" />
                                    </div>
                                    <div class="table-cell">
                                        <label class="form-label">Type</label>
                                        <select class="form-control" name="jtype">
                                            <option><?php echo $judge_row['jtype']; ?></option>
                                            <option>Chairman</option>
                                        </select>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            
                            <div class="button-group">
                                <a href="sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id;?>&se_name=<?php echo $se_name;?>" class="btn btn-default">Back</a>
                                <button name="edit_judge" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php 
    if(isset($_POST['edit_judge'])) {
        $se_name=$_POST['se_name'];
        $sub_event_id=$_POST['sub_event_id'];
        $judge_id=$_POST['judge_id'];
        $judge_ctr=$_POST['judge_ctr'];
        $fullname=$_POST['fullname'];
        $jtype=$_POST['jtype'];
      
        $conn->query("update judges set fullname='$fullname',judge_ctr='$judge_ctr', jtype='$jtype' where judge_id='$judge_id'");
    ?>
        <script>                                      
            window.location = 'sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id;?>&se_name=<?php echo $se_name;?>';
            alert('Judge <?php echo $fullname; ?> updated successfully!');						
        </script>
    <?php  
    } 
    ?>
  
    <?php include('footer.php'); ?>

    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggleButtons = document.querySelectorAll(".toggle-btn");
            const sidebar = document.getElementById("sidebar");
            const mainContent = document.querySelector(".main");

            toggleButtons.forEach(button => {
                button.addEventListener("click", function() {
                    sidebar.classList.toggle("collapsed");
                    mainContent.classList.toggle("collapsed");
                });
            });

            const logoutLink = document.querySelector('a[href="logout.php"]');
            if (logoutLink) {
                logoutLink.addEventListener('click', function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: 'Are you sure you want to log out?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'logout.php';
                        }
                    });
                });
            }
        });
    </script>
  </body>
</html>