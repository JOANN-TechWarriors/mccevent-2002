<?php 
include('session.php');
include('header2.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Judging System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <style>
        /* General Styles */
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

        /* Sidebar Styles */
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

        /* Main Content Styles */
        .main {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        .main.collapsed {
            margin-left: 0;
        }

        /* Header Styles */
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

        /* Table Styles */
        .table {
            width: 100%;
            margin-bottom: 1rem;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 12px;
            border: 1px solid #dee2e6;
        }

        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        @media print {
      .sidebar, .header, .no-print {
        display: none !important;
      }
      .main {
        margin-left: 0 !important;
        padding: 0 !important;
      }

            /* Reset layout for printing */
            body {
                margin: 0;
                padding: 15px;
                background: white;
            }

            .main {
                margin: 0 !important;
                padding: 0 !important;
                width: 100% !important;
            }

            /* Table print styles */
            .table {
                width: 100% !important;
                margin-bottom: 20px !important;
                page-break-inside: auto !important;
            }

            .table th,
            .table td {
                background-color: white !important;
                border: 1px solid #000 !important;
                padding: 8px !important;
                text-align: left !important;
            }

            .table thead {
                display: table-header-group !important;
            }

            .table tbody {
                display: table-row-group !important;
            }

            .table tr {
                page-break-inside: avoid !important;
                page-break-after: auto !important;
            }

            /* Force background colors and images to print */
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            /* Ensure proper page breaks */
            h1, h2, h3, h4, h5, h6 {
                page-break-after: avoid !important;
            }

            img {
                page-break-inside: avoid !important;
            }

            .page-break-before {
                page-break-before: always !important;
            }

            .page-break-after {
                page-break-after: always !important;
            }
        }

        /* Responsive Styles */
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
        }

        @media (max-width: 576px) {
            .sidebar-heading {
                font-size: 14px;
            }

            .table th,
            .table td {
                padding: 8px;
                font-size: 14px;
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
            <li><a href="../tabulator/score_sheets.php"><i class="fas fa-clipboard-list"></i> <span>SCORE SHEETS</span></a></li>
            <li><a href="../tabulator/rev_main_event.php"><i class="fas fa-chart-line"></i> <span>DATA REVIEWS</span></a></li>
        </ul>
    </div>

    <!-- Header -->
    <div class="header">
        <div>
            <button class="toggle-btn" id="toggle-btn-mobile"><i class="fas fa-bars"></i></button>
        </div>
        <div class="profile-dropdown">
            <div style="font-size:small;"><?php echo $tabname; ?></div>
            <div class="dropdown-menu">
                <a href="#" id="logout"><i class="fas fa-sign-out-alt"></i> <span>Sign out</span></a>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main" id="main-content">
        <div class="container">
            <h1 style="font-size:35px;">Data Reviews</h1>
        </div>

        <div class="span15">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="../tabulator/score_sheets.php">Score Sheets</a> /</li>
                    <li>Data Reviews</li>
                </ul>
            </div>
        </div>

        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <form method="POST" target="_self" action="review_search.php">
                <input style="font-size: large; height: 45px !important; text-indent: 7px !important;" 
                       class="form-control btn-block" name="txtsearch" 
                       placeholder="Enter a keyword and search..." />
                <br />
                <button class="btn btn-info pull-right" style="width: 150px !important;">
                    <i class="icon-search"></i> <strong>SEARCH</strong>
                </button>
            </form>
        </div>
        <div class="col-lg-1"></div>

        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title">Select Main Event</h4>
                </div>
                <div class="panel-body">
                    <form method="POST" action="rev_sub_event.php">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Event Name</th>
                                    <th colspan="2"><center>Action</center></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php    
                                $mainevent_query = $conn->query("SELECT * FROM main_event") or die(mysql_error());
                                while ($mainevent_row = $mainevent_query->fetch()) { ?>
                                    <tr>
                                        <td width="10" align="center">
                                            <input type="radio" name="main_event_id" 
                                                   value="<?php echo $mainevent_row['mainevent_id']; ?>" 
                                                   required="true" />
                                        </td>
                                        <td><?php echo $mainevent_row['event_name']; ?></td>
                                        <td width="10">
                                            <a target="_blank" title="click to print summary result" 
                                               href="summary_results.php?main_event_id=<?php echo $mainevent_row['mainevent_id']; ?>" 
                                               class="btn btn-warning"><i class="icon-list"></i></a>
                                        </td>
                                        <td width="10">
                                            <a title="click to print event result" 
                                               class="btn btn-info print-result" 
                                               data-event-id="<?php echo $mainevent_row['mainevent_id']; ?>">
                                                <i class="icon-print"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td colspan="4">
                                        <?php if($mainevent_query->rowCount() > 0){ ?>
                                            <button class="btn btn-info pull-right" style="width: 200px !important;">
                                                <strong>NEXT</strong> <i class="icon-chevron-right"></i>
                                            </button>
                                        <?php } else { ?>
                                            <div class="alert alert-warning">
                                                <h3>NO EVENTS TO DISPLAY... PLEASE ADD AN EVENT 
                                                    <a href="home.php">HERE &raquo;</a>
                                                </h3>
                                            </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3"></div>
    </div>

    <?php include("footer.php") ?>

    <!-- Scripts -->
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap-transition.js"></script>
    <script src="../assets/js/bootstrap-alert.js"></script>
    <script src="../assets/js/bootstrap-modal.js"></script>
    <script src="../assets/js/bootstrap-dropdown.js"></script>
    <script src="../assets/js/bootstrap-scrollspy.js"></script>
    <script src="../assets/js/bootstrap-tab.js"></script>
    <script src="../assets/js/bootstrap-tooltip.js"></script>
    <script src="../assets/js/bootstrap-popover.js"></script>
    <script src="../assets/js/bootstrap-button.js"></script>
    <script src="../assets/js/bootstrap-collapse.js"></script>
    <script src="../assets/js/bootstrap-carousel.js"></script>
    <script src="../assets/js/bootstrap-typeahead.js"></script>
    <script src="../assets/js/bootstrap-affix.js"></script>
    <script src="../assets/js/holder/holder.js"></script>
    <script src="../assets/js/google-code-prettify/prettify.js"></script>
    <script src="../assets/js/application.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // Logout confirmation
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
                window.location.href = '..//index.php';
            }
        });
    });
  </script>
  <script>
    document.querySelectorAll('.print-result').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const eventId = this.getAttribute('data-event-id');
            
            // Open in new window with specific size
            const printWindow = window.open(
                `print_all_results.php?main_event_id=${eventId}`,
                '_blank',
                'width=2000,height=800'
            );

            printWindow.onload = function() {
                // Add small delay to ensure content is fully loaded
                setTimeout(() => {
                    // Trigger print dialog
                    printWindow.print();

                    // Optional: Close window after printing
                    printWindow.onafterprint = function() {
                        printWindow.close();
                    };
                }, 1000);
            };
        });
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
</body>
</html>