<!DOCTYPE html>
<html lang="en">
<?php 
include('header.php');
include('session.php');

$sub_event_id = $_GET['sub_event_id'];
$se_name = $_GET['se_name'];
$contestant_id = $_GET['contestant_id'];
?>

<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <style>
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
            background-color: #333;
            color: #fff;
            padding-top: 20px;
            transition: all 0.3s;
            overflow: hidden;
            z-index: 1000;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .main {
            margin-left: 250px;
            padding: 20px;
            transition: all 0.3s;
        }

        .main.collapsed {
            margin-left: 80px;
        }

        .container {
            padding: 0 15px;
        }

        .settings-container {
            max-width: 600px;
            margin-left: 0;  /* Align to the left */
            padding: 20px;
        }

        .panel {
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
            margin-bottom: 20px;
        }

        .panel-primary > .panel-heading {
            background-color: #337ab7;
            color: #fff;
            padding: 10px 15px;
            border-radius: 3px 3px 0 0;
        }

        .panel-body {
            padding: 20px;
        }

        .form-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .form-table td {
            padding: 8px 15px;
            vertical-align: top;
            width: 50%;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
            font-size: 14px;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            margin-top: 4px;
        }

        select.form-control {
            height: 36px;
        }

        .btn-container {
            text-align: right;
            margin-top: 20px;
            padding: 0 15px;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            margin-left: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .btn-success {
            background-color: #5cb85c;
            color: white;
        }

        .btn-success:hover {
            background-color: #4cae4c;
        }

        .btn-default {
            background-color: #f0f0f0;
            color: #333;
        }

        .btn-default:hover {
            background-color: #e0e0e0;
        }

        @media (max-width: 768px) {
            .settings-container {
                padding: 10px;
            }

            .form-table, 
            .form-table tbody, 
            .form-table tr {
                display: block;
            }

            .form-table td {
                display: block;
                width: 100%;
                padding: 5px 10px;
            }

            .btn-container {
                text-align: center;
            }
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
        position:absolute;
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

  <div class="main" id="main-content">
        <div class="container">
            <h1 style="font-size: 23px; margin-bottom: 20px;"><?php echo $se_name; ?> Settings</h1>
        
            <div class="settings-container">
                <form method="POST" enctype="multipart/form-data">
                    <input value="<?php echo $sub_event_id; ?>" name="sub_event_id" type="hidden" />
                    <input value="<?php echo $se_name; ?>" name="se_name" type="hidden" />
                    <input value="<?php echo $contestant_id; ?>" name="contestant_id" type="hidden" />

                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Edit Contestant</h3>
                        </div>
                        <div class="panel-body">
                            <table class="form-table">
                                <?php    
                                $cont_query = $conn->query("SELECT * FROM contestants WHERE contestant_id='$contestant_id'") or die(mysql_error());
                                while ($cont_row = $cont_query->fetch()) { ?>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label class="form-label">Contestant no.</label>
                                            <select name="contestant_ctr" class="form-control">
                                                <option><?php echo $cont_row['contestant_ctr']; ?></option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <label class="form-label">Contestant Fullname</label>
                                            <input name="fullname" type="text" class="form-control" value="<?php echo $cont_row['fullname']; ?>" />
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label class="form-label">Upload Photo</label>
                                            <input type="file" name="picture" class="form-control" value="<?php echo $cont_row['Picture']; ?>">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <label class="form-label">Year/Course & Section</label>
                                            <input name="addon" type="text" class="form-control" value="<?php echo $cont_row['AddOn']; ?>" />
                                        </div>
                                    </td>
                                </tr>
                                <?php } ?>
                            </table>
                            <div class="btn-container">
                                <a href="sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id;?>&se_name=<?php echo $se_name;?>" class="btn btn-default">Back</a>
                                <button name="edit_contestant" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
if (isset($_POST['edit_contestant'])) {
  $se_name = $_POST['se_name'];
  $sub_event_id = $_POST['sub_event_id'];
  $contestant_id = $_POST['contestant_id'];
  $contestant_ctr = $_POST['contestant_ctr'];
  $course = $_POST['addon'];
  $fullname = $_POST['fullname'];

  $picture = $_FILES['picture']['name'];

  if (!empty($picture)) {
    $target = '../img/' . basename($picture);
    move_uploaded_file($_FILES['picture']['tmp_name'], $target);
    $sql = "UPDATE contestants SET fullname='$fullname', contestant_ctr='$contestant_ctr', Picture='$picture', AddOn='$course' WHERE contestant_id='$contestant_id'";
  } else {
    $sql = "UPDATE contestants SET fullname='$fullname', contestant_ctr='$contestant_ctr', AddOn='$course' WHERE contestant_id='$contestant_id'";
  }

  $conn->query($sql);
  ?>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
  <script>
    Swal.fire({
      title: 'Updated!',
      text: 'Contestant <?php echo $fullname; ?> updated successfully!',
      icon: 'success'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location = 'sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>';
      }
    });
  </script>
  <?php
}
?>



  <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
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

          // Updated logout confirmation
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
