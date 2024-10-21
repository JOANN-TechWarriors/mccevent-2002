<!DOCTYPE html>
<html lang="en">
<?php 
    include('session.php');

  ?>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<meta name="theme-color" content="#3e454c">
<link rel="shortcut icon" href="../images/logo copy.png"/>
<title>Event Judging System</title> 
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
<!-- SweetAlert CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #fff;
        margin: 0;
        padding: 0;
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
        transition: all 0.3s;
    }

    .main.collapsed {
        margin-left: 80px;
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

        .chart-container {
            height: 300px;
        }
    }

    .chart-container {
        position: relative;
        height: 400px;
        width: 100%;
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
            <li><a href="live.php"><i class="fas fa-camera"></i> <span>LIVE</span></a></li>
        </ul>
    </div>
  </div>

    <!-- Header -->
    <div class="header">
        <div>
            <button class="toggle-btn" id="toggle-btn-mobile"><i class="fas fa-bars"></i></button>
        </div>
        <div class="profile-dropdown">
           <div style="font-size:small;"> <?php echo $name; ?></div>
            <div class="dropdown-menu">
                <a href="edit_organizer.php"> Account Settings</a>
                <a href="logout.php" ><i class="fas fa-sign-out-alt"></i> <span>Sign out</span></a>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="main" id="main">
        <h1 style="font-size: 35px;">Dashboard</h1>
        <!-- Event Cards -->
         <br><br>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card bg-gradient-info text-black" style="background-color: #e3f7fd;">
                    <div class="card-body">
                        <h4 class="font-weight-normal mb-3" style="font-size: 20px;">Ongoing Events</h4>
                        <?php 
                             $database = mysqli_connect('127.0.0.1', 'u510162695_judging_root', '1Judging_root', 'u510162695_judging');
                            // Assuming $session_id contains the current organizer's ID
                            $organizer_id = $session_id; 

                            $sql = "SELECT COUNT(*) FROM sub_event WHERE organizer_id = ?";
                            $stmt = mysqli_prepare($database, $sql);
                            mysqli_stmt_bind_param($stmt, "i", $organizer_id);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $ongoing_events);
                            mysqli_stmt_fetch($stmt);
                            mysqli_stmt_close($stmt);
                        ?>
                        <h2 class="mb-4"><?php echo $ongoing_events; ?></h2>
                        <a class="btn btn-primary btn-sm" href="home.php">View Details</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card bg-gradient-info text-black" style="background-color: #b0ffc3;">
                    <div class="card-body">
                        <h4 class="font-weight-normal mb-3" style="font-size: 20px;">Upcoming Events</h4>
                        <?php 
                            $database = mysqli_connect('127.0.0.1', 'u510162695_judging_root', '1Judging_root', 'u510162695_judging');
                            // Assuming $session_id contains the current organizer's ID
                            $organizer_id = $session_id;

                            $currentDate = date("Y-m-d");

                            $sql = "SELECT COUNT(*) FROM upcoming_events WHERE DATE(start_date) > ? AND organizer_id = ?";
                            $stmt = mysqli_prepare($database, $sql);
                            mysqli_stmt_bind_param($stmt, "si", $currentDate, $organizer_id);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $upcoming_events);
                            mysqli_stmt_fetch($stmt);
                            mysqli_stmt_close($stmt);
                        ?>
                        <h2 class="mb-4"><?php echo $upcoming_events; ?></h2>
                        <a class="btn btn-success btn-sm" href="">View Events</a>
                    </div>
                </div>
            </div>
        </div>
       <!-- Charts -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="font-weight-normal mb-3" style="font-size:20px;">Events Overview</h4>
                    <div class="chart-container">
                        <canvas id="eventsPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
            <div class="card-body">
                <h4 class="font-weight-normal mb-3" style="font-size:20px;">Event Statistics</h4>
                <div class="chart-container">
                    <canvas id="eventsBarChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php include('..//admin/footer.php') ?>
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- SweetAlert JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Chart.js JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
  
    // Pie Chart
    var ctxPie = document.getElementById('eventsPieChart').getContext('2d');
    var eventsPieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['Ongoing Events', 'Upcoming Events'],
            datasets: [{
                label: '# of Events',
                data: [<?php echo $ongoing_events; ?>, <?php echo $upcoming_events; ?>],
                backgroundColor: [
                    'rgba(255, 0, 0, 0.4)',
                    'rgba(1, 254, 1, 0.6)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            },
            maintainAspectRatio: false
        }
    });

    // Bar Chart
    var ctxBar = document.getElementById('eventsBarChart').getContext('2d');
    var eventsBarChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Ongoing Events', 'Upcoming Events'],
            datasets: [{
                label: 'Number of Events',
                data: [<?php echo $ongoing_events; ?>, <?php echo $upcoming_events; ?>],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            return tooltipItem.label + ': ' + tooltipItem.raw;
                        }
                    }
                }
            },
            scales: {
                y: {
                    ticks: {
                        beginAtZero: true,
                        precision: 0  // Ensure the y-axis labels are whole numbers
                    }
                }
            },
            maintainAspectRatio: false
        }
    });
</script>
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
<!-- Optional JavaScript -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
