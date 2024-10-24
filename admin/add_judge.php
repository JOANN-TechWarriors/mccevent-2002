 

<!DOCTYPE html>
<html lang="en">
  
  <?php 
  include('header.php');
    include('session.php');
    
    
    $sub_event_id=$_GET['sub_event_id'];
    $se_name=$_GET['se_name'];
     
     
  ?>
  
<head>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
/*  
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
    } */

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
<!-- Header -->
<div class="header">
    <div>
        <button class="toggle-btn" id="toggle-btn-mobile"><i class="fas fa-bars"></i></button>
    </div>
  </div>
<div class="main" id="main-content">
  <div class="container">
    <h1><?php echo $se_name; ?> Settings</h1>
  </div>


<div class="container">

<div class="span12">



                <br />
                <div class="col-md-10">
                    <ul class="breadcrumb">
                    
                        <li><a href="selection.php">Dashboard</a></li>
                    
                        <li><a href="home.php">List of Events</a></li>
                        
                        <li><a href="sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>"><?php echo $se_name; ?> Settings</a></li>
                        
                        <li>Add Judge</li>
                        
                    </ul>
                </div>
                

   <form method="POST">
   <input value="<?php echo $sub_event_id; ?>" name="sub_event_id" type="hidden" />
 <input value="<?php echo $se_name; ?>" name="se_name" type="hidden" />
 
  
<table align="center" style="width: 40% !important;">
 <tr>
 <td>
 

 <div style="width: 100% !important;" class="panel panel-primary">
 
            <div class="panel-heading">
              <h3 class="panel-title">Add Judge</h3>
            </div>
 
 


 
     <div class="panel-body">
 
   <table align="center">
  
 
   <tr>
    
   <td>
   <strong>Judge no. :&nbsp;&nbsp;&nbsp;</strong><br />
   <select name="judge_ctr" class="form-control">
   

                    <?php 
                    
                    $n1=0;
                    
                    while($n1<4)
                    { 
                        $n1++;
                     
                    
                    $cont_query = $conn->query("SELECT * FROM judges WHERE judge_ctr='$n1' AND subevent_id='$sub_event_id'") or die(mysql_error());
                   
            
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
   <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
   <td>
    <strong>Judge Fullname:</strong> <br />
   <input name="fullname" placeholder="Enter Judge Name" type="text" class="form-control" required="true" /></td>
   </tr>
  
  <tr>
  <td colspan="3">&nbsp;</td>
  </tr>
  
  <tr>
  <td colspan="3" align="right"><a href="sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id;?>&se_name=<?php echo $se_name;?>" class="btn btn-default">Back</a>&nbsp;<button name="add_judge" class="btn btn-primary">Save</button></td>
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

if(isset($_POST['add_judge']))
{
    
function randomcode() {
$var = "abcdefghijkmnopqrstuvwxyz0123456789";
srand((double)microtime()*1000000);
$i = 0;
$code = '' ;
while ($i <= 5) {
$num = rand() % 33;
$tmp = substr($var, $num, 1);
$code = $code . $tmp;
$i++;
}
return $code;
}
    
$se_name=$_POST['se_name'];
$sub_event_id=$_POST['sub_event_id'];
$judge_ctr=$_POST['judge_ctr'];
$fullname=$_POST['fullname'];
$code=randomcode();

   /* judges */
   
    $conn->query("insert into judges(fullname,subevent_id,judge_ctr,code)values('$fullname','$sub_event_id','$judge_ctr','$code')");
   
  
 ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    Swal.fire({
        title: 'Success',
        text: 'Judge <?php echo $fullname; ?> added successfully!',
        icon: 'success'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = 'sub_event_details_edit.php?sub_event_id=<?php echo $sub_event_id; ?>&se_name=<?php echo $se_name; ?>';
        }
    });
</script>

<?php  
 
 
} ?>
  
<?php include('footer.php'); ?>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<!--     <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
    <script>
    document.getElementById("toggle-btn").addEventListener("click", function () {
      var sidebar = document.getElementById("sidebar");
      var mainContent = document.getElementById("main-content");

      sidebar.classList.toggle("collapsed");
      mainContent.classList.toggle("collapsed");
    });
  </script> -->
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
