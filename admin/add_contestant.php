 

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
      <img src="logo.png" alt="Logo">
      <div>Event Judging System</div>
    </div>
    <ul>
            <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> <span>DASHBOARD</span></a></li>
            <li><a href="home.php"><i class="fas fa-calendar-check"></i> <span>ONGOING EVENTS</span></a></li>
            <li><a href="upcoming_events.php"><i class="fas fa-calendar-alt"></i> <span>UPCOMING EVENTS</span></a></li>
            <li><a href="live.php"><i class="fas fa-camera"></i> <span>LIVE</span></a></li>

        </ul>
  </div>

  <div class="main" id="main-content">
  <div class="container">
    <h1 style="font-size: 20px;"><?php echo $se_name; ?> Settings</h1>
  </div>


<div class="container">

<div class="span12">



                <br />
                <div class="col-md-10">
                    <ul class="breadcrumb">
                    
                        <li><a href="dashboard.php">Dashboard</a></li>
                    
                        <li><a href="home.php">List of Events</a></li>
                        
                        <li><a href="sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>"><?php echo $se_name; ?> Settings</a></li>
                        
                        <li>Add Contestant</li>
                        
                    </ul>
                </div>
                <br><br><br><br>
                

   <form method="POST" enctype="multipart/form-data">
   <input value="<?php echo $sub_event_id; ?>" name="sub_event_id" type="hidden" />
 <input value="<?php echo $se_name; ?>" name="se_name" type="hidden" />
 
  
   
   
   
   <table align="center" style="width: 40% !important;">
 <tr>
 <td>
 

 <div style="width: 100% !important;" class="panel panel-primary">
 
 
            <div class="panel-heading">
              <h3 class="panel-title">Add Contestant</h3>
            </div>
 
 


 
     <div class="panel-body">
 
   <table align="center">
  
 
   <tr>
    
   <td>
   <strong>Contestant no. :</strong> <br />
   <select name="contestant_ctr" class="form-control">
   
   
                    <?php 
                    
                    $n1=0;
                    
                    while($n1<12)
                    { 
                        $n1++;
                     
                    
                    $cont_query = $conn->query("SELECT * FROM contestants WHERE contestant_ctr='$n1' AND subevent_id='$sub_event_id'") or die(mysql_error());
                   
            
                    if($cont_query->rowCount()>0)
                    {
                        
                    }
                    else
                    {
                        echo "<option>".$n1."</option>";
                    }
                      
                    } 
                    
                    ?>
                    
                    
    
   </select></td>
   <td>&nbsp;&nbsp;&nbsp;</td>
   <td>
    <strong>Contestant Name:</strong> <br />
    
   <input name="fullname" placeholder="Enter Name" type="text" class="form-control" required="true" /></td>
   </tr>

   
   <td>
   
    <strong>Upload Photo:</strong> <br />
    <input type="file" name="picture">
   <div id="wrapper">
       <!specify the encoding type of the form using the enctype attribute >
   </div>
   <td>&nbsp;</td>
                  <td>
                  Year/Course & Section<br />
                  <input name="addon" placeholder="Enter Course" type="text" class="form-control" required="true" /></td>
                </td>
   <tr>
  <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
  <td colspan="3" align="right"><a href="sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id;?>&se_name=<?php echo $se_name;?>" class="btn btn-default">Back</a>&nbsp;<button name="add_contestant" class="btn btn-primary">Save</button></td>
  </tr>
  
  </table>
 </form>
</div>
 
          </div>
 </td>
 </tr>
 </table> 
 
 
          </div>
          
    </div>      
<?php 

if(isset($_POST['add_contestant']))
{
    
    $se_name=$_POST['se_name'];
    $sub_event_id=$_POST['sub_event_id'];
    $contestant_ctr=$_POST['contestant_ctr'];
    $picture=$_POST['picture'];
    $fullname=$_POST['fullname'];
    $course=$_POST['addon'];
    $picture=$_FILES['picture']['name'];
    $target = 'img/'.basename($picture);
    
  
   /* contestants */
   
    $conn->query("insert into contestants(fullname,subevent_id,contestant_ctr,picture, 
    AddOn)VALUES('$fullname','$sub_event_id','$contestant_ctr','$picture', '$course' )");
   move_uploaded_file($_FILES['picture']['tmp_name'],$target);
  
 ?>
<script>
			                                      
			      								window.location = 'sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id;?>&se_name=<?php echo $se_name;?>';
			      							   	alert('Contestant <?php echo $fullname; ?>  added successfully!');						
			      								</script>
<?php  
 
 
} ?>
  <div>
<?php include('footer.php'); ?>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
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
