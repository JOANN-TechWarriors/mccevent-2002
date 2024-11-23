<?php 
include('header.php');
include('session.php');
    
$sub_event_id = $_GET['sub_event_id'];
$se_name = $_GET['se_name'];

// Handle form submission
if(isset($_POST['add_crit'])) {
    try {
        // Get form data
        $criteria_ctr = $_POST['crit_ctr'];
        $criteria = $_POST['criteria'];
        $percentage = $_POST['percentage'];
        $sub_event_id = $_POST['sub_event_id'];
        
        // Validate total percentage doesn't exceed 100%
        $stmt = $conn->prepare("SELECT SUM(percentage) as total FROM criteria WHERE subevent_id = ?");
        $stmt->execute([$sub_event_id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $current_total = $result['total'] ?? 0;
        
        if(($current_total + $percentage) > 100) {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Total percentage cannot exceed 100%',
                    confirmButtonColor: '#3085d6'
                });
            </script>";
        } else {
            // Insert new criteria
            $stmt = $conn->prepare("INSERT INTO criteria (criteria_ctr, criteria, percentage, subevent_id) VALUES (?, ?, ?, ?)");
            $stmt->execute([$criteria_ctr, $criteria, $percentage, $sub_event_id]);
            
            // Redirect back to sub event details page with success message
            $se_name = $_POST['se_name'];
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Criteria added successfully!',
                    confirmButtonColor: '#3085d6'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'sub_event_details_edit.php?sub_event_id=" . $sub_event_id . "&se_name=" . urlencode($se_name) . "';
                    }
                });
            </script>";
        }
    } catch(PDOException $e) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Database error occurred: " . addslashes($e->getMessage()) . "',
                confirmButtonColor: '#3085d6'
            });
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Criteria - <?php echo htmlspecialchars($se_name); ?></title>
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
            width: 100vw;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 15px;
        }

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
            margin: 0 5px;
        }

        .btn-success {
            background: #28a745;
            color: #fff;
        }

        .btn-default {
            background: #6c757d;
            color: #fff;
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

            .criteria-table td {
                display: block;
                width: 100%;
            }

            .btn {
                width: 100%;
                margin: 5px 0;
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
            <div style="font-size:small;"><?php echo htmlspecialchars($name); ?></div>
            <div class="dropdown-menu">
                <a href="edit_organizer.php">Account Settings</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span>Sign out</span></a>
            </div>
        </div>
    </div>

    <div class="main" id="main-content">
        <div class="container">
            <h1><?php echo htmlspecialchars($se_name); ?> Settings</h1>
            
            <div class="col-md-10">
                <ul class="breadcrumb">
                    <li><a href="selection.php">Dashboard</a></li>
                    <li><a href="home.php">List of Events</a></li>
                    <li><a href="sub_event_details_edit.php?sub_event_id=<?php echo urlencode($sub_event_id); ?>&se_name=<?php echo urlencode($se_name); ?>"><?php echo htmlspecialchars($se_name); ?> Settings</a></li>
                    <li>Add Criteria</li>
                </ul>
            </div>

            <form method="POST" onsubmit="return validateForm()">
                <input value="<?php echo htmlspecialchars($sub_event_id); ?>" name="sub_event_id" type="hidden" />
                <input value="<?php echo htmlspecialchars($se_name); ?>" name="se_name" type="hidden" />
                
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Add Criteria</h3>
                    </div>
                    <div class="panel-body">
                        <table class="criteria-table">
                            <tr>
                                <td>
                                    <strong>Criteria no. :</strong>
                                    <select name="crit_ctr" class="form-control" required>
                                        <?php 
                                        $n1=0;
                                        while($n1<8) { 
                                            $n1++;
                                            $cont_query = $conn->prepare("SELECT * FROM criteria WHERE criteria_ctr=? AND subevent_id=?");
                                            $cont_query->execute([$n1, $sub_event_id]);
                                            if($cont_query->rowCount() > 0) {
                                                continue;
                                            }
                                            echo "<option value='" . htmlspecialchars($n1) . "'>" . htmlspecialchars($n1) . "</option>";
                                        } 
                                        ?>
                                    </select>
                                </td>
                                <td>
                                    <strong>Criteria:</strong>
                                    <input name="criteria" type="text" class="form-control" placeholder="Criteria Description" required />
                                </td>
                                <td>
                                    <strong>Percentage:</strong>
                                    <select name="percentage" class="form-control" required>
                                        <?php
                                        $n5=0;
                                        while($n5<100) {
                                            $n5=$n5+5;
                                            echo "<option value='" . htmlspecialchars($n5) . "'>" . htmlspecialchars($n5) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align: right;">
                                    <a href="sub_event_details_edit.php?sub_event_id=<?php echo urlencode($sub_event_id); ?>&se_name=<?php echo urlencode($se_name); ?>" class="btn btn-default">Back</a>
                                    <button type="submit" name="add_crit" class="btn btn-success">Save</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle sidebar functionality
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

        // Form validation
        function validateForm() {
            const criteriaDesc = document.querySelector('input[name="criteria"]').value.trim();
            if (!criteriaDesc) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Please enter a criteria description',
                    confirmButtonColor: '#3085d6'
                });
                return false;
            }
            return true;
        }
    </script>

    <center><?php include("footer.php") ?></center>
</body>
</html>