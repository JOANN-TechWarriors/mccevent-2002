<!DOCTYPE html>
<html lang="en">
  
  <?php 
    include('header2.php');
    include('session.php');

    $mainevent_id=$_POST['main_event_id'];

    $mainevent_query = $conn->query("SELECT * FROM main_event where mainevent_id='$mainevent_id'") or die(mysql_error());
    while ($mainevent_row = $mainevent_query->fetch()) {
        $m_event_name=$mainevent_row['event_name'];
    } 
  ?>
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
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
    }

    .sidebar.collapsed {
        width: 80px;
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
    <button class="toggle-btn" id="toggle-btn"><i class="fas fa-bars"></i></button>
    <div class="sidebar-heading">
      <img src="../img/logo.png" alt="Logo">
      <div>Event Judging System</div>
    </div>
    <ul>
      <li><a href="../tabulator/score_sheets.php"><i class="fas fa-clipboard-list"></i> <span>SCORE SHEETS</span></a></li>
      <li><a href="rev_main_event.php"><i class="fas fa-chart-line"></i> <span>DATA REVIEWS</span></a></li>
    </ul>
  </div>

        <!-- Header -->
        <div class="header">
        <div>
            <!-- Add any left-aligned content here if needed -->
        </div>
        <div class="profile-dropdown">
           <div style="font-size:small;"> <?php echo $tabname ;?></div>
            <div class="dropdown-menu">
                <a href="#" id="logout"><i class="fas fa-sign-out-alt"></i> <span>Sign out</span></a>
            </div>
        </div>
    </div>

  <!-- Subhead -->
  <div class="main" id="main-content"> 
    <div class="container">
      <h1 style="font-size:35px;">Data Reviews</h1>
    </div>
    
    <br />
    <div class="col-md-12">
      <ul class="breadcrumb">
        <li><a href="rev_main_event.php">DR: Main Event List</strong></i></a> / </li>
        <li>DR: Main Event <i><strong><?php echo $m_event_name; ?></strong></i> - Event List</li>
      </ul>
    </div>
    
    <br />
    <div class="col-lg-1"></div>
    <div class="col-lg-10">
      <form method="POST" target="_self" action="review_search.php">
        <input style="font-size: large; height: 45px !important; text-indent: 7px !important;" class="form-control btn-block" name="txtsearch" placeholder="Enter a keyword and search..." />  
        <br />
        <button class="btn btn-info pull-right" style="width: 150px !important;"><i class="icon-search"></i> <strong>SEARCH</strong></button> 
      </form>
    </div>
    <div class="col-lg-1"></div>

    <div class="col-lg-3"></div>
    <div class="col-lg-6">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 class="panel-title"><?php echo $m_event_name; ?> Event List</h3>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <th>Sub-Event</th>
              <th>Actions</th>
            </thead>
            <tbody>
              <?php    
                $subevent_query = $conn->query("SELECT * FROM sub_event where mainevent_id='$mainevent_id'") or die(mysql_error());
                while ($subevent_row = $subevent_query->fetch()) { ?>
                <tr>
                  <td><?php echo $subevent_row['event_name']; ?></td>
                  <td width="90">
                    <a title="click to view event details" target="_blank" href="review_result.php?mainevent_id=<?php echo $mainevent_id; ?>&sub_event_id=<?php echo $subevent_row['subevent_id']; ?>" class="btn btn-primary"><i class="icon-folder-open"></i></a>
                    <a target="_blank" title="click to print event result" href="review_se_result.php?mainevent_id=<?php echo $mainevent_id; ?>&sub_event_id=<?php echo $subevent_row['subevent_id']; ?>" class="btn btn-info"><i class="icon-print"></i></a> 
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-3"></div>
  </div>

  <?php include("footer.php") ?>
    
  <!-- Le javascript -->
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
  <!-- SweetAlert JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
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

    document.getElementById("toggle-btn").addEventListener("click", function () {
      var sidebar = document.getElementById("sidebar");
      var mainContent = document.getElementById("main-content");

      sidebar.classList.toggle("collapsed");
      mainContent.classList.toggle("collapsed");
    });
  </script>
</body>
</html>
