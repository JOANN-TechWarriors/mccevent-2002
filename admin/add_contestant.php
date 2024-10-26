<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include('header.php');
    include('session.php');
    
    $sub_event_id=$_GET['sub_event_id'];
    $se_name=$_GET['se_name'];
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            width: 100%;
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 15px;
        }

        /* Table Styles */
        .criteria-table {
            width: 100%;
            max-width: 800px;
            margin: 20px 0;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .criteria-table td {
            padding: 15px;
            vertical-align: top;
        }

        .panel {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .panel-heading {
            background: #007bff;
            color: #fff;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }

        .panel-title {
            margin: 0;
            font-size: 18px;
        }

        .panel-body {
            padding: 20px;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            margin: 5px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        .btn-success {
            background: #28a745;
            color: #fff;
        }

        .btn-default {
            background: #6c757d;
            color: #fff;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .criteria-table {
                margin: 10px auto;
            }

            .criteria-table td {
                display: block;
                width: 100%;
                padding: 10px;
            }

            .panel {
                margin: 10px;
            }

            .form-control {
                margin: 5px 0;
            }

            .btn {
                width: 100%;
                margin: 5px 0;
            }
        }

        /* Breadcrumb Styles */
        .breadcrumb {
            list-style: none;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .breadcrumb li {
            display: inline;
            margin-right: 5px;
        }

        .breadcrumb li:after {
            content: '>';
            margin-left: 5px;
            color: #6c757d;
        }

        .breadcrumb li:last-child:after {
            content: '';
        }

        .breadcrumb a {
            color: #007bff;
            text-decoration: none;
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
        }

        .sidebar ul li a:hover {
            background-color: #1a1a2e;
        }

        .main {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .main.collapsed {
            margin-left: 0;
        }

        .header {
            background-color: #f8f9fa;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
        }

        /* Updated form container styles */
        .form-container {
            max-width: 600px;
            margin: 0;  /* Remove auto margin */
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .container {
            padding: 20px;
            max-width: none;
        }

        .breadcrumb {
            display: flex;
            flex-wrap: wrap;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
            list-style: none;
            background-color: #e9ecef;
            border-radius: 0.25rem;
            width: fit-content;
        }

        .breadcrumb li {
            display: flex;
            align-items: center;
        }

        .breadcrumb li + li::before {
            content: "/";
            padding: 0 0.5rem;
        }

        .breadcrumb a {
            color: #007bff;
            text-decoration: none;
        }

        .panel {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .panel-heading {
            background-color: #007bff;
            color: white;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }

        .panel-title {
            margin: 0;
            font-size: 18px;
        }

        .panel-body {
            padding: 20px;
        }

        /* Updated form grid for left alignment */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(200px, 300px)); /* Two columns with max width */
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-control {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .btn-default {
            background-color: #6c757d;
            color: white;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }

        /* Updated media queries */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main {
                margin-left: 0;
            }

            .sidebar.collapsed {
                transform: translateX(0);
            }

            .form-grid {
                grid-template-columns: 1fr; /* Single column on mobile */
            }

            .form-container {
                padding: 10px;
            }
        }

        @media (max-width: 576px) {
            .form-container {
                padding: 10px;
            }

            .breadcrumb {
                font-size: 14px;
            }

            .panel-heading {
                padding: 10px;
            }

            .panel-body {
                padding: 15px;
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
    </div>

    <div class="main" id="main-content">
        <div class="container">
            <h1><?php echo $se_name; ?> Settings</h1>
            
            <div class="col-md-10">
                <ul class="breadcrumb">
                    <li><a href="selection.php">Dashboard</a></li>
                    <li><a href="home.php">List of Events</a></li>
                    <li><a href="sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>"><?php echo $se_name; ?> Settings</a></li>
                    <li>Add Criteria</li>
                </ul>
            </div>

            <form method="POST">
                <input value="<?php echo $sub_event_id; ?>" name="sub_event_id" type="hidden" />
                <input value="<?php echo $se_name; ?>" name="se_name" type="hidden" />
                
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Add Criteria</h3>
                    </div>
                    <div class="panel-body">
                        <table class="criteria-table">
                            <tr>
                                <td>
                                    <strong>Criteria no. :</strong>
                                    <select name="crit_ctr" class="form-control">
                                        <?php 
                                        $n1=0;
                                        while($n1<8) { 
                                            $n1++;
                                            $cont_query = $conn->query("SELECT * FROM criteria WHERE criteria_ctr='$n1' AND subevent_id='$sub_event_id'") or die(mysql_error());
                                            if($cont_query->rowCount()>0) {
                                            } else {
                                                echo "<option>".$n1."</option>";
                                            }
                                        } 
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <strong>Criteria:</strong>
                                    <input name="criteria" type="text" class="form-control" placeholder="Criteria Description" />
                                </td>
                                <td>
                                    <strong>Percentage:</strong>
                                    <select name="percentage" class="form-control">
                                        <?php
                                        $n5=0;
                                        while($n5<100) {
                                            $n5=$n5+5;
                                            echo "<option>$n5</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right;">
                                    <a href="sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id;?>&se_name=<?php echo $se_name;?>" class="btn btn-default">Back</a>
                                    <button name="add_crit" class="btn btn-success">Save</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include('footer.php'); ?>

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
        });
    </script>
</body>
</html>