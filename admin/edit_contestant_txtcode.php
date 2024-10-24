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
      top: 15px;
      right: -0px;
      background-color: transparent;
      color: #fff;
      border: none;
      cursor: pointer;
      transition: all 0.3s;
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
            <li><a href="live_stream.php"><i class="fas fa-camera"></i> <span>LIVE STREAM</span></a></li>

        </ul>
  </div>
  
  <div class="main" id="main-content">
    <div class="container">
      <h1><?php echo $se_name; ?> Settings</h1>
    </div>

    <div class="span15">
      <br />
      <div class="col-md-15">
        <ul class="breadcrumb">
          <li><a href="selection.php">User Selection</a></li>
          <li><a href="home.php">List of Events</a></li>
          <li><a href="sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>"><?php echo $se_name; ?> Settings</a></li>
          <li>Edit Contestant TxtCode</li>
        </ul>
      </div>
    </div>

    <form method="POST">
      <input value="<?php echo $sub_event_id; ?>" name="sub_event_id" type="hidden" />
      <input value="<?php echo $se_name; ?>" name="se_name" type="hidden" />
      <input value="<?php echo $contestant_id; ?>" name="contestant_id" type="hidden" />
      
      <?php    
        $cont_query = $conn->query("SELECT * FROM contestants WHERE contestant_id='$contestant_id'") or die(mysql_error());
        while ($cont_row = $cont_query->fetch()) { 
      ?> 
      <table align="center" style="width: 30% !important;">
        <tr>
          <td>
            <div style="width: 100% !important;" class="panel panel-primary">
              <div class="panel-heading">
                <h3 class="panel-title">Edit Contestant TxtCode</h3>
              </div>
              <div class="panel-body">
                <table align="center">
                  <tr>
                    <td>
                      <strong>Contestant TxtCode:</strong>
                      <br />
                      <input name="txt_code" type="text" class="form-control" placeholder="Enter Text Code" value="<?php echo $cont_row['txt_code']; ?>" />
                    </td>
                  </tr>
                  <tr>
                    <td >&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="right">
                      <a href="sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id;?>&se_name=<?php echo $se_name;?>" class="btn btn-default">Back</a>&nbsp;
                      <button name="edit_contestant" class="btn btn-success">Update</button>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
          </td>
        </tr>
      </table>  
      <?php } ?> 
    </form>
  </div>

<?php 
if (isset($_POST['edit_contestant'])) {
    $se_name = $_POST['se_name'];
    $sub_event_id = $_POST['sub_event_id'];
    $contestant_id = $_POST['contestant_id'];
    $txt_code = $_POST['txt_code'];
  
    $ssquery = $conn->query("SELECT * FROM contestants WHERE txt_code='$txt_code'") or die(mysql_error());
    $ssnum_row = $ssquery->rowCount();
    if ($ssnum_row > 0) {
?>
<script>
  window.location = 'sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>';
  alert('Textcode: <?php echo $txt_code ?> already exists, try another. . . Thanks.');
</script>
<?php 
    } else {
        $conn->query("UPDATE contestants SET txt_code='$txt_code' WHERE contestant_id='$contestant_id'");  
?>
<script>
  window.location = 'sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>';
  alert('Textcode updated successfully!');
</script>
<?php  
    } 
} 
?>

<?php include('footer.php'); ?>
<script src="../assets/js/ie10-viewport-bug-workaround.js"></script>

<script>
    document.getElementById("toggle-btn").addEventListener("click", function () {
        var sidebar = document.getElementById("sidebar");
        var mainContent = document.getElementById("main-content");

        sidebar.classList.toggle("collapsed");
        mainContent.classList.toggle("collapsed");

        var isCollapsed = sidebar.classList.contains("collapsed");
        this.innerHTML = isCollapsed ? "☰" : "☰";
    });
</script>

</body>
</html>
