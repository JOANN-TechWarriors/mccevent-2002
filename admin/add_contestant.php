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
include('header.php');
include('session.php');

$sub_event_id=$_GET['sub_event_id'];
$se_name=$_GET['se_name'];
?>

<head>
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Previous styles remain the same until .container */
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
            min-height: 100vh; /* Ensures the body takes at least the full viewport height */
            width: 100vw;      /* Ensures full width */
            overflow-y: auto;  /* Enables vertical scrolling */
            overflow-x: hidden; /* Prevents horizontal scrolling if content overflows */
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
                margin-left: 250px; /* Space for the sidebar */
                padding: 20px;
                transition: margin-left 0.3s ease; /* Smooth transition for main content */
            }

            .main.collapsed {
                margin-left: 0; /* No space for sidebar when collapsed */
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
            <li><a href="dashboard"><i class="fas fa-tachometer-alt"></i> <span>DASHBOARD</span></a></li>
            <li><a href="home"><i class="fas fa-calendar-check"></i> <span>ONGOING EVENTS</span></a></li>
            <li><a href="upcoming_events"><i class="fas fa-calendar-alt"></i> <span>UPCOMING EVENTS</span></a></li>
            <li><a href="live_stream"><i class="fas fa-camera"></i> <span>LIVE STREAM</span></a></li>
        </ul>
    </div>

    <div class="header">
            <div>
                <button class="toggle-btn" id="toggle-btn-mobile"><i class="fas fa-bars"></i></button>
            </div>
            <div class="profile-dropdown">
                <div style="font-size:small;"><?php echo $name; ?></div>
                <div class="dropdown-menu">
                    <a href="edit_organizer">Account Settings</a>
                    <a href="logout"><i class="fas fa-sign-out-alt"></i> <span>Sign out</span></a>
                </div>
            </div>
      </div>

    <div class="main" id="main-content">
        <div class="container">
            <h1 style="font-size: 20px;"><?php echo $se_name; ?> Settings</h1>
            
            <div class="breadcrumb">
                <li><a href="dashboard">Dashboard</a></li>
                <li><a href="home">List of Events</a></li>
                <li><a href="sub_event_details_edit?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>"><?php echo $se_name; ?> Settings</a></li>
                <li>Add Contestant</li>
            </div>

            <div class="form-container">
                <div class="panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">Add Contestant</h3>
                    </div>
                    <div class="panel-body">
                        <form method="POST" enctype="multipart/form-data">
                            <input value="<?php echo $sub_event_id; ?>" name="sub_event_id" type="hidden" />
                            <input value="<?php echo $se_name; ?>" name="se_name" type="hidden" />

                            <div class="form-grid">
                                <div class="form-group">
                                    <label><strong>Contestant no. :</strong></label>
                                    <select name="contestant_ctr" class="form-control">
                                        <?php 
                                        $n1=0;
                                        while($n1<12) { 
                                            $n1++;
                                            $cont_query = $conn->query("SELECT * FROM contestants WHERE contestant_ctr='$n1' AND subevent_id='$sub_event_id'") or die(mysql_error());
                                            if($cont_query->rowCount()>0) {
                                                
                                            } else {
                                                echo "<option>".$n1."</option>";
                                            }
                                        } 
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label><strong>Contestant Name:</strong></label>
                                    <input name="fullname" placeholder="Enter Name" type="text" class="form-control" required="true" />
                                </div>

                                <div class="form-group">
                                    <label><strong>Upload Photo:</strong></label>
                                    <input type="file" name="picture" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label><strong>Year/Course & Section</strong></label>
                                    <input name="addon" placeholder="Enter Course" type="text" class="form-control" required="true" />
                                </div>
                            </div>

                            <div class="form-buttons">
                                <a href="sub_event_details_edit?sub_event_id=<?php echo $sub_event_id;?>&se_name=<?php echo $se_name;?>" class="btn btn-default">Back</a>
                                <button name="add_contestant" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php 
    if(isset($_POST['add_contestant'])) {
        $se_name=$_POST['se_name'];
        $sub_event_id=$_POST['sub_event_id'];
        $contestant_ctr=$_POST['contestant_ctr'];
        $picture=$_POST['picture'];
        $fullname=$_POST['fullname'];
        $course=$_POST['addon'];
        $picture=$_FILES['picture']['name'];
        $target = 'img/'.basename($picture);
        
        $conn->query("insert into contestants(fullname,subevent_id,contestant_ctr,picture,AddOn)VALUES('$fullname','$sub_event_id','$contestant_ctr','$picture', '$course' )");
        move_uploaded_file($_FILES['picture']['tmp_name'],$target);
    ?>
        <script>
            window.location = 'sub_event_details_edit?sub_event_id=<?php echo $sub_event_id;?>&se_name=<?php echo $se_name;?>';
            alert('Contestant <?php echo $fullname; ?> added successfully!');
        </script>
    <?php  
    } 
    ?>

<center><?php include("footer.php") ?></center>

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