<?php
$request = $_SERVER['REQUEST_URI'];
if (substr($request, -4) == '.php') {
    $new_url = substr($request, 0, -4);
    header("Location: $new_url", true, 301);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<?php
include('header2.php');
include('..//admin/session.php');
?>

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
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
                display: block;
            }

            .main {
                margin-left: 0;
                transition: margin-left 0.3s ease;
            }

            .sidebar.collapsed {
                transform: translateX(0);
            }

            .sidebar .toggle-btn {
                display: block;
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
            <li><a href="score_sheets"><i class="fas fa-clipboard-list"></i> <span>SCORE SHEETS</span></a></li>
            <li><a href="../admin/rev_main_event"><i class="fas fa-chart-line"></i> <span>DATA REVIEWS</span></a></li>
            <li><a href="#"><i class="fas fa-chart-line"></i> <span>Activity Logs</span></a></li>
        </ul>
    </div>

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

    <div class="main" id="main-content">
        <div class="container">
            <h1 style="font-size: 35px;">Score Sheets</h1>
        </div>

        <br><br>
        <?php
        $sy_query = $conn->query("select * FROM main_event where organizer_id='$session_id' AND status='activated'") or die(mysql_error());
        while ($sy_row = $sy_query->fetch()) {
        ?>
            <tr>
                <td>
                    <?php
                    $sy = $sy_row['sy'];
                    $MEidxxx = $sy_row['mainevent_id'];

                    $event_query = $conn->query("select * from main_event where mainevent_id='$MEidxxx' AND status='activated'") or die(mysql_error());
                    while ($event_row = $event_query->fetch()) {
                    ?>
                        <button class="accordion"><strong><?php echo $event_row['event_name']; ?></strong></button>
                    <?php }  ?>

                    <div class="panel">
                        <table class="table table-striped">
                            <thead>
                                <th>Event Name</th>
                                <th>View Score Sheet - Select Judge</th>
                            </thead>
                            <tbody>
                                <?php
                                $s_event_query = $conn->query("select * from sub_event where mainevent_id='$MEidxxx'") or die(mysql_error());
                                while ($s_event_row = $s_event_query->fetch()) {
                                    $se_id = $s_event_row['subevent_id'];
                                ?>
                                    <tr>
                                        <td>
                                            <div class="nav-collapse collapse">
                                                <ul class="nav">
                                                    <li>
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                                            <strong><?php echo $s_event_row['event_name']; ?></strong> <span class="caret"></span>
                                                        </a>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li>
                                                                <a title="Go to live viewing of this Sub-Event scores." target="_blank" href="updateview.php?sid=<?php echo $se_id; ?>">Live View</a>
                                                            </li>

                                                            <?php if ($s_event_row['txtpoll_status'] == "active") { ?>
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
                                            while ($judge_row = $judge_query->fetch()) {
                                            ?>
                                                <a style="margin-top: 4px !important;" title="click to rank contestant score's for this judge" target="_blank" href="view_score_sheet?event_id=<?php echo $se_id; ?>&judge_id=<?php echo $judge_row['judge_id']; ?>" class="btn btn-info">
                                                    <i class="icon icon-tasks"></i> <?php echo $judge_row['judge_ctr']; ?>. <?php echo $judge_row['fullname']; ?>
                                                </a>
                                            <?php } ?>
                                        </td>
                                        <td width="128">
                                            <a title="click to set points deductions" target="_blank" href="deductScores?event_id=<?php echo $se_id; ?>" class="btn btn-danger">
                                                <i class="icon icon-minus-sign"></i>
                                            </a>

                                            <a title="click to set final result for this sub-event" target="_blank" href="result_title?event_id=<?php echo $se_id; ?>" class="btn btn-primary">
                                                <i class="icon icon-star"></i>
                                            </a>

                                            <a title="click to print results" href="javascript:void(0);" onclick="handlePrint(<?php echo $se_id; ?>)" class="btn btn-primary">
                                                <i class="icon icon-print"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        </br>
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
        // Logout functionality
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
                    window.location.href = '..//index';
                }
            });
        });

        // Print handling function
        function handlePrint(eventId) {
            // Create a new window for the print content
            const printWindow = window.open(`result_sheet?event_id=${eventId}`, '_blank');
            
            // Wait for the content to load before triggering print
            printWindow.onload = function() {
                // Add a small delay to ensure styles are loaded
                setTimeout(function() {
                    printWindow.print();
                    
                    // Optional: Close the window after printing
                    // Uncomment the next line if you want the window to close automatically
                    // printWindow.close();
                }, 500);
            };
        }
        
        // Accordion functionality
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
