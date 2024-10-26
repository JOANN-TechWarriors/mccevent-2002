<!DOCTYPE html>
<html lang="en">
  
  <?php 
  include('header.php');
    include('session.php');
    
    
    $sub_event_id=$_GET['sub_event_id'];
    $se_name=$_GET['se_name'];
    $crit_id=$_GET['crit_id'];
     
  ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Judging System - Criteria Settings</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            width: 100vw;
            overflow-x: hidden;
        }

        /* Sidebar styles */
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

        .sidebar-heading {
            text-align: center;
            padding: 10px 0;
            margin-bottom: 20px;
        }

        .sidebar-heading img {
            max-width: 100px;
            height: auto;
            margin-bottom: 10px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 10px 20px;
        }

        .sidebar ul li a {
            color: #fff;
            text-decoration: none;
            display: flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar ul li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Header styles */
        .header {
            background-color: #f8f9fa;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: relative;
            z-index: 900;
        }

        .profile-dropdown {
            position: relative;
        }

        .profile-dropdown .dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-radius: 4px;
            padding: 8px 0;
            display: none;
            min-width: 150px;
        }

        .profile-dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu a {
            display: block;
            padding: 8px 15px;
            color: #333;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .dropdown-menu a:hover {
            background-color: #f5f5f5;
        }

        /* Main content styles */
        .main {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        .main.collapsed {
            margin-left: 0;
        }

        .settings-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            margin-bottom: 30px;
            color: #333;
            font-size: 24px;
        }

        /* Panel styles */
        .panel-primary {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .panel-heading {
            background: #007bff;
            color: #fff;
            padding: 15px 20px;
        }

        .panel-title {
            margin: 0;
            font-size: 18px;
            font-weight: 500;
        }

        .panel-body {
            padding: 25px;
        }

        /* Form styles */
       /* Updated and new form styles */
    .criteria-form {
        width: 100%;
        overflow-x: visible; /* Ensure dropdowns aren't cut */
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 30px; /* Increased gap for better spacing */
        margin-bottom: 25px;
        width: 100%;
    }

    .form-group {
        flex: 1;
        min-width: 200px; /* Ensure minimum width */
        max-width: 100%; /* Allow full width on small screens */
        position: relative; /* For dropdown positioning */
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-weight: 500;
        white-space: nowrap; /* Prevent label wrapping */
    }

    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        transition: border-color 0.3s;
        height: 40px; /* Consistent height */
        background-color: #fff;
    }

    /* Specific styles for different input types */
    input.form-control {
        min-width: 200px; /* Minimum width for text inputs */
    }

    select.form-control {
        min-width: 120px; /* Minimum width for dropdowns */
        padding-right: 30px; /* Space for dropdown arrow */
        cursor: pointer;
    }

    /* Panel body padding adjustment */
    .panel-body {
        padding: 25px;
        overflow: visible; /* Ensure dropdowns aren't cut */
    }

    /* Container adjustments */
    .settings-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        overflow: visible; /* Ensure dropdowns aren't cut */
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            width: 100%;
        }

        .form-control {
            width: 100%;
            min-width: unset;
        }

        .panel-body {
            padding: 15px;
        }
    }

    /* Additional styles for better form layout */
    .criteria-number {
        flex: 0 0 150px; /* Fixed width for criteria number */
    }

    .criteria-name {
        flex: 1 1 300px; /* Flexible width for criteria name */
    }

    .criteria-percentage {
        flex: 0 0 150px; /* Fixed width for percentage */
    }

    /* Ensure dropdown menus are visible */
    select.form-control {
        position: relative;
        z-index: 1;
    }

    /* Better focus states */
    .form-control:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 0 2px rgba(0,123,255,0.25);
    }

    /* Container for the entire form section */
    .form-container {
        width: 100%;
        max-width: 1000px; /* Limit maximum width */
        margin: 0 auto;
        padding: 0 15px;
    }

    /* Button container adjustments */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 30px;
        padding: 0 15px;
    }

    .btn {
        min-width: 100px; /* Ensure buttons have minimum width */
        padding: 10px 20px;
    }
    </style>
</head>
<body>
    <!-- Sidebar -->
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

    <!-- Main Content -->
    <div class="main" id="main-content">
    <div class="settings-container">
        <h1><?php echo $se_name; ?> Settings</h1>
        
        <form method="POST">
            <input value="<?php echo $sub_event_id; ?>" name="sub_event_id" type="hidden" />
            <input value="<?php echo $se_name; ?>" name="se_name" type="hidden" />
            <input value="<?php echo $crit_id; ?>" name="crit_id" type="hidden" />

            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Criteria</h3>
                </div>
                <div class="panel-body">
                    <div class="form-container">
                        <div class="criteria-form">
                            <?php    
                            $crit_query = $conn->query("SELECT * FROM criteria WHERE criteria_id='$crit_id'") or die(mysql_error());
                            while ($crit_row = $crit_query->fetch()) { 
                            ?>
                            <div class="form-row">
                                <div class="form-group criteria-number">
                                    <label>Criteria no.</label>
                                    <select name="crit_ctr" class="form-control">
                                        <option value="<?php echo $crit_row['criteria_ctr']; ?>"><?php echo $crit_row['criteria_ctr']; ?></option>
                                        <?php 
                                        $n1=0;
                                        while($n1<8) { 
                                            $n1++;
                                            $cont_query = $conn->query("SELECT * FROM criteria WHERE criteria_ctr='$n1' AND subevent_id='$sub_event_id'") or die(mysql_error());
                                            if($cont_query->rowCount()>0) {
                                                // Skip if exists
                                            } else {
                                                echo "<option value='".$n1."'>".$n1."</option>";
                                            }
                                        } 
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group criteria-name">
                                    <label>Criteria</label>
                                    <input name="criteria" type="text" class="form-control" value="<?php echo htmlspecialchars($crit_row['criteria']); ?>" />
                                </div>

                                <div class="form-group criteria-percentage">
                                    <label>Percentage</label>
                                    <select name="percentage" class="form-control">
                                        <option value="<?php echo $crit_row['percentage']; ?>"><?php echo $crit_row['percentage']; ?></option>
                                        <?php
                                        $n5=-5;
                                        while($n5<100) { 
                                            $n5=$n5+5;
                                        ?>
                                        <option value="<?php echo $n5; ?>"><?php echo $n5; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>

                            <div class="form-actions">
                                <a href="sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id;?>&se_name=<?php echo $se_name;?>" class="btn btn-default">Back</a>
                                <button name="edit_crit" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

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

            // Logout confirmation
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
</body>
</html>