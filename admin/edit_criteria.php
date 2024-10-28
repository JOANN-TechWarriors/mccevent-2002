<!DOCTYPE html>
<html lang="en">
  
<?php 
include('header.php');
include('session.php');
    
$sub_event_id = $_GET['sub_event_id'];
$se_name = $_GET['se_name'];
$crit_id = $_GET['crit_id'];

// Handle form submission
if(isset($_POST['edit_crit'])) {
    // Get form data
    $criteria = $_POST['criteria'];
    $percentage = $_POST['percentage'];
    $crit_ctr = $_POST['crit_ctr'];
    $sub_event_id = $_POST['sub_event_id'];
    
    try {
        // Begin transaction
        $conn->beginTransaction();
        
        // Check if the new counter number already exists for a different criteria
        $check_query = $conn->prepare("SELECT * FROM criteria WHERE criteria_ctr = ? AND subevent_id = ? AND criteria_id != ?");
        $check_query->execute([$crit_ctr, $sub_event_id, $crit_id]);
        
        if($check_query->rowCount() > 0) {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Criteria number already exists!'
                });
            </script>";
        } else {
            // Update the criteria
            $update_query = $conn->prepare("UPDATE criteria SET 
                criteria = ?,
                percentage = ?,
                criteria_ctr = ?
                WHERE criteria_id = ?");
                
            $result = $update_query->execute([
                $criteria,
                $percentage,
                $crit_ctr,
                $crit_id
            ]);
            
            if($result) {
                $conn->commit();
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Criteria updated successfully!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'sub_event_details_edit.php?sub_event_id=" . $sub_event_id . "&se_name=" . urlencode($se_name) . "';
                        }
                    });
                </script>";
            } else {
                $conn->rollBack();
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update criteria. Please try again.'
                    });
                </script>";
            }
        }
    } catch(PDOException $e) {
        $conn->rollBack();
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Database error occurred. Please try again.'
            });
        </script>";
    }
}
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
        .criteria-form {
            width: 100%;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 25px;
        }

        .form-group {
            flex: 1 1 250px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #007bff;
            outline: none;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23555' viewBox='0 0 16 16'%3E%3Cpath d='M8 11L3 6h10l-5 5z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 30px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 30px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-default {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            color: #333;
        }

        .btn-success {
            background-color: #28a745;
            color: #fff;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.collapsed {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;
                padding: 15px;
            }

            .form-row {
                flex-direction: column;
                gap: 15px;
            }

            .form-group {
                flex: 1 1 100%;
            }

            .form-actions {
                flex-direction: column-reverse;
            }

            .btn {
                width: 100%;
            }

            .header {
                padding: 10px 15px;
            }

            h1 {
                font-size: 20px;
                margin-bottom: 20px;
            }
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
                        <div class="criteria-form">
                            <?php    
                            $crit_query = $conn->query("SELECT * FROM criteria WHERE criteria_id='$crit_id'") or die(mysql_error());
                            while ($crit_row = $crit_query->fetch()) { 
                            ?>
                            <div class="form-row">
                                <div class="form-group">
                                    <label>Criteria no.</label>
                                    <select name="crit_ctr" class="form-control btn-block" required style="text-indent: 10px !important;">
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

                                <div class="form-group">
                                    <label>Criteria</label>
                                    <input name="criteria" type="text" class="form-control" value="<?php echo $crit_row['criteria']; ?>" required />
                                </div>

                                <div class="form-group">
                                    <label>Percentage</label>
                                    <select name="percentage" class="form-control btn-block" required style="text-indent: 7px !important;">
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
                                <button type="submit" name="edit_crit" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
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