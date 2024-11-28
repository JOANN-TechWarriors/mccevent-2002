<?php
$request = $_SERVER['REQUEST_URI'];
if (substr($request, -4) == '.php') {
    $new_url = substr($request, 0, -4);
    header("Location: $new_url", true, 301);
    exit();
}
?>

<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('location: admin_login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<?php


// Connect to database
$host = '127.0.0.1';
$username = 'u510162695_judging_root';
$password = '1Judging_root';  // Replace with the actual password
$dbname = 'u510162695_judging';


$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="theme-color" content="#3e454c">
    <link rel="shortcut icon" href="../images/logo copy.png" />
    <title>Event Judging System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <!-- SweetAlert CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="../css/datatables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #fff;
        margin: 0;
        padding: 0;
        min-height: 100vh;
        /* Ensures the body takes at least the full viewport height */
        width: 100vw;
        /* Ensures full width */
        overflow-y: auto;
        /* Enables vertical scrolling */
        overflow-x: hidden;
        /* Prevents horizontal scrolling if content overflows */
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
        /* Ensure the sidebar is above the main content */
    }

    .sidebar.collapsed {
        transform: translateX(-100%);
        /* Move sidebar off-screen when collapsed */
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

            transform: translateX(-100%);
            /* Hide sidebar off-screen */
            display: block;
            /* Show sidebar when collapsed */
        }

        .main {
            margin-left: 0;
            /* No space for sidebar on mobile */
            transition: margin-left 0.3s ease;
            /* Smooth transition for main content */
        }

        .sidebar.collapsed {
            transform: translateX(0);
            /* Show sidebar when expanded */
        }

        .sidebar .toggle-btn {
            display: block;
            /* Show toggle button on mobile */
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

    .timeline {
        position: relative;
        margin: 20px 0;
        padding: 0;
        list-style: none;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 20px;
        padding-left: 40px;
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 20px;
        width: 2px;
        height: 100%;
        background-color: #ddd;
    }

    .timeline-date {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .timeline-content {
        display: flex;
        align-items: center;
    }

    .timeline-icon {
        margin-right: 10px;
        color: #007bff;
    }

    .timeline-details {
        background-color: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
            <li><a href="admin_dashboard"><i class="fas fa-tachometer-alt"></i> <span>DASHBOARD</span></a></li>
            <li><a href="account_request"><i class="fas fa-clipboard-list"></i> <span>ACCOUNT REQUEST</span></a>
            <li><a href="admin_logs"><i class="fas fa-clipboard-list"></i> <span>ACCOUNT LOGS</span></a></li>
            </li>
        </ul>
    </div>

    <!-- Header -->
    <div class="header">
        <div>
            <button class="toggle-btn" id="toggle-btn-mobile"><i class="fas fa-bars"></i></button>
        </div>
        <div class="profile-dropdown">
            <div style="font-size:small;"> Ayres Santillan Ilustrisimo </div>
            <div class="dropdown-menu">
                <a href="admin_logout"><i class="fas fa-sign-out-alt"></i> <span>Sign out</span></a>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="main" id="main">
        <h1>Account Logs</h1>
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-date">2023-10-01</div>
                <div class="timeline-content">
                    <div class="timeline-icon"><i class="fas fa-check-circle"></i></div>
                    <div class="timeline-details">User logged in successfully.</div>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-date">2023-10-02</div>
                <div class="timeline-content">
                    <div class="timeline-icon"><i class="fas fa-exclamation-circle"></i></div>
                    <div class="timeline-details">Failed login attempt.</div>
                </div>
            </div>
            <!-- Add more timeline items as needed -->
        </div>
    </div>
    </div>

    </div>


    <center><?php include('..//admin/footer.php') ?></center>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- SweetAlert JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Chart.js JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/datatables.min.js"></script>


    <script>
    $(document).ready(function() {
        var print = $('#printable').DataTable({
            buttons: ['copy', 'csv', 'excel', 'pdf', 'print']
        });


        print.buttons().container()
            .appendTo('#printable_wrapper .col-md-6:eq(0)');

    });

    document.getElementById('studentid').addEventListener('input', function(event) {
        let input = event.target.value.replace(/\D/g, ''); // Remove non-digit characters
        if (input.length > 8) {
            input = input.slice(0, 8); // Limit to 8 digits
        }
        if (input.length > 4) {
            input = input.slice(0, 4) + '-' + input.slice(4); // Insert dash after 4 digits
        }
        event.target.value = input;
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
    </script>

    <script>
    $(document).ready(function() {
        $('#importForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: 'import_excel.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    var res = JSON.parse(response);
                    Swal.fire({
                        title: res.status === 'success' ? 'Success' : (res
                            .status === 'warning' ? 'Warning' : 'Error'),
                        text: res.message,
                        icon: res.status,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        if (res.status === 'success' || res.status === 'warning') {
                            window.location.href =
                                'account_request?filter_user_type=Student';
                        }
                    });
                }
            });
        });

        $('#addForm').on('submit', function(e) {
            e.preventDefault();
            var formData = $(this).serialize();

            $.ajax({
                url: 'insert_student.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    var res = JSON.parse(response);
                    Swal.fire({
                        title: res.status === 'success' ? 'Success' : 'Error',
                        text: res.message,
                        icon: res.status,
                        confirmButtonText: 'OK'
                    }).then(() => {
                        if (res.status === 'success') {
                            window.location.href =
                                'account_request.php?filter_user_type=Student';
                        }
                    });
                }
            });
        });
    });
    </script>
</body>

</html>