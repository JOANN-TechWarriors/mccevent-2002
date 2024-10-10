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
    }

    .sidebar.collapsed {
      width: 80px;
    }

    .sidebar .toggle-btn {
      position: absolute;
      top: 10px;
      right: -2px;
      background-color: transparent;
      color: #fff;
      border: none;
      cursor: pointer;
      transition: all 0.3s;
      font-size: 20px;
    }

    .sidebar .toggle-btn i {
      font-size: 18px;
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
      padding: 10px;
      border-bottom: 1px solid #555;
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
      transition: margin 0.3s;
    }

    .sidebar.collapsed ul li a i {
      margin-right: 0;
    }

    .sidebar ul li a span {
      display: inline-block;
      transition: opacity 0.3s;
    }

    .sidebar.collapsed ul li a span {
      opacity: 0;
      width: 0;
      overflow: hidden;
    }

    .sidebar ul li a:hover {
      background-color: #555;
    }

    .main {
      margin-left: 250px;
      padding: 20px;
      transition: all 0.3s;
    }

    .main.collapsed {
      margin-left: 80px;
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 100%;
        height: auto;
        position: relative;
      }

      .main {
        margin-left: 0;
      }
    }
  </style>
</head>

<body>
  <div class="sidebar" id="sidebar">
    <button class="toggle-btn" id="toggle-btn">☰</button>
    <div class="sidebar-heading">
      <img src="../img/logo.png" alt="Logo">
      <div>Event Judging System</div>
    </div>
    <ul>
      <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> <span>DASHBOARD</span></a></li>
      <li><a href="home.php"><i class="fas fa-calendar-check"></i> <span>ONGOING EVENTS</span></a></li>
      <li><a href="upcoming_events.php"><i class="fas fa-calendar-alt"></i> <span>UPCOMING EVENTS</span></a></li>
      <li><a href="score_sheets.php"><i class="fas fa-clipboard-list"></i> <span>SCORE SHEETS</span></a></li>
      <li><a href="rev_main_event.php"><i class="fas fa-chart-line"></i> <span>DATA REVIEWS</span></a></li>
      <li><a href="#" id="logout"><i class="fas fa-sign-out-alt"></i> <span>LOGOUT</span></a></li>
    </ul>
  </div>

  <div class="main" id="main-content">
    <div class="container">
      <h1 style="font-size: 23px;"><?php echo $se_name; ?> Settings</h1>
    </div>
    <br><br><br>
    <div class="container">
      <form method="POST" enctype="multipart/form-data">
        <input value="<?php echo $sub_event_id; ?>" name="sub_event_id" type="hidden" />
        <input value="<?php echo $se_name; ?>" name="se_name" type="hidden" />
        <input value="<?php echo $contestant_id; ?>" name="contestant_id" type="hidden" />

        <div class="col-lg-3"></div>
        <div class="col-lg-6">
          <div class="panel panel-primary">
            <div class="panel-heading">
              <h3 class="panel-title">Edit Contestant</h3>
            </div>
            <div class="panel-body">
              <table align="center">
                <?php    
                $cont_query = $conn->query("SELECT * FROM contestants WHERE contestant_id='$contestant_id'") or die(mysql_error());
                while ($cont_row = $cont_query->fetch()) { ?>
                <tr>
                  <td>
                    Contestant no. <br />
                    <select name="contestant_ctr" class="form-control">
                      <option><?php echo $cont_row['contestant_ctr']; ?></option>
                    </select>
                  </td>
                  <td>&nbsp;</td>
                  <td>
                    Contestant Fullname <br />
                    <input name="fullname" type="text" class="form-control" value="<?php echo $cont_row['fullname']; ?>" />
                  </td>
                </tr>
                
                <tr>
                <td>
                  <strong>Upload Photo:</strong> <br />
                  <input type="file" name="picture" value="<?php echo $cont_row['Picture']; ?>">
                  <div id="wrapper">
                  </div>
                </td>
                <td>&nbsp;</td>
                  <td>
                  Year/Course & Section<br />
                <input name="addon" type="text" class="form-control" value="<?php echo $cont_row['AddOn']; ?>" />
                </td>
                </tr>
                <?php } ?>
                <tr>
                  <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="3" align="right">
                    <a href="sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id;?>&se_name=<?php echo $se_name;?>" class="btn btn-default">Back</a>
                    <button name="edit_contestant" class="btn btn-success">Update</button>
                  </td>
                </tr>
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg-3"></div>
      </form>
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


  </div>

  <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.16/dist/sweetalert2.all.min.js"></script>
  <script>
    document.getElementById("toggle-btn").addEventListener("click", function () {
      var sidebar = document.getElementById("sidebar");
      var mainContent = document.getElementById("main-content");

      sidebar.classList.toggle("collapsed");
      mainContent.classList.toggle("collapsed");
    });
  </script>
</body>
</html>
