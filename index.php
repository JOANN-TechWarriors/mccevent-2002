<?php
$request = $_SERVER['REQUEST_URI'];
if (substr($request, -4) == '.php') {
    $new_url = substr($request, 0, -4);
    header("Location: $new_url", true, 301);
    exit();
}
?>
<!DOCTYPE html>
<html>
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- site metas -->
      <link rel="shortcut icon" href="../img/logo.png"/>
      <title>Event Judging System</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="css1/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="css1/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="css1/responsive.css">
      <!-- font css -->
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css1/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
      <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
   
   <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: all 0.4s;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        .nav {
            width: 100%;
            height: 65px;
            position: fixed;
            line-height: 65px;
            text-align: center;
            background-color: rgba(6, 6, 7, 0.8);
            z-index: 1000;
            top: 0;
            left: 0;
            display: flex;
            justify-content: space-between;
        }

        .nav .logo {
            float: left;
            width: auto;
            height: 65px;
            padding-left: 1rem;
        }

        .nav .logo a {
            text-decoration: none;
            color: #fff;
            font-size: 25px;
            text-transform: uppercase;
        }

        .nav .logo img {
            height: 40px;
            vertical-align: middle;
        }

        .nav .main_list {
            height: 65px;
            float: right;
            margin-right: 1rem;
        }

        .main_list ul {
            width: 100%;
            height: 65px;
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .main_list ul li {
            position: relative;
            display: inline-block;
            height: 65px;
            padding: 0 1rem;
        }

        .main_list ul li a {
            text-decoration: none;
            color: #fff;
            line-height: 65px;
            text-transform: uppercase;
        }

        .main_list ul li:hover .dropdown {
            display: block;
        }

        .dropdown {
            display: none;
            position: absolute;
            background-color: rgba(6, 6, 7, 0.9);
            min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            right: 0;
        }

        .dropdown a {
            color: #fff;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            line-height: 1.5;
            text-align: left;
        }

        .dropdown a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .media_button {
            display: none;
            position: absolute;
            right: 1rem;
            top: 12px;
            padding: 0.5rem;
            cursor: pointer;
            background: transparent;
            border: none;
        }

        .media_button span {
            width: 32px;
            height: 3px;
            background-color: #fff;
            display: block;
            margin: 6px 0;
            transition: 0.3s;
        }

        .banner_section {
            padding-top: 100px; /* Adjusted to account for fixed navbar */
        }

        .client_section {
            padding: 50px 0;
        }
        
        .client_left img {
            max-width: 400px;
            height: auto;
            object-fit: cover;
            margin-right: 30px;
        }
        
        .client_taital_main {
            display: flex;
            align-items: center;
            gap: 270px;
            padding: 20px;
        }
        
        .client_right {
            flex: 1;
            padding: 20px;
        }
        
        .about_taital {
            margin-bottom: 30px;
            text-align: center;
        }
        
        .carousel-control-prev,
        .carousel-control-next {
            width: 40px;
            height: 40px;
            background: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
        }

        @media screen and (max-width: 768px) {
            .media_button {
                display: block;
            }

            .nav .main_list {
                width: 100%;
                height: 0;
                overflow: hidden;
                position: absolute;
                top: 65px;
                left: 0;
                margin: 0;
                background-color: rgba(6, 6, 7, 0.95);
                transition: height 0.3s ease-in-out;
            }

            .nav .main_list.show_list {
                height: auto;
            }

            .main_list ul {
                flex-direction: column;
                height: auto;
                padding: 1rem 0;
            }

            .main_list ul li {
                width: 100%;
                height: auto;
                padding: 0;
            }

            .main_list ul li a {
                line-height: 45px;
                display: block;
                padding: 0 2rem;
                text-align: left;
            }

            .dropdown {
                position: static;
                width: 100%;
                background-color: rgba(255, 255, 255, 0.1);
                box-shadow: none;
            }

            .dropdown a {
                padding-left: 3rem;
            }

            .client_taital_main {
                flex-direction: column;
                gap: 30px;
            }

            .client_left img {
                max-width: 100%;
                margin-right: 0;
            }
        }

        .fa {
            padding: 10px;
            font-size: 10px;
            width: 8px;
            text-align: center;
            text-decoration: none;
            margin: 5px 5px;
            border-radius: 30%;
        }

        .fa:hover {
            opacity: 0.5;
        }

        button.btn.btn-primary {
            z-index: 1000;
            position: relative;
        }
        /* Banner Section Base Styles */
.banner_section {
    padding-top: 65px; /* Account for fixed navbar */
    position: relative;
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/Community-College-Madridejos.jpeg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    min-height: 640px;
    width: 100%;
    display: flex;
    align-items: center;
}

.banner_taital_main {
    padding: 20px;
    width: 100%;
    max-width: 1200px;
    margin: 0 auto;
}

.banner_taital {
    color: white;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    font-size: 4rem;
    font-weight: bold;
    margin-bottom: 30px;
    line-height: 1.2;
}

.btn_main {
    display: flex;
    gap: 20px;
    margin-top: 30px;
}

/* Responsive Breakpoints */
@media screen and (max-width: 1200px) {
    .banner_taital {
        font-size: 3.5rem;
    }
}

@media screen and (max-width: 992px) {
    .banner_section {
        min-height: 500px;
    }
    
    .banner_taital {
        font-size: 3rem;
    }
}

@media screen and (max-width: 768px) {
    .banner_section {
        min-height: 400px;
    }
    
    .banner_taital {
        font-size: 2.5rem;
    }
    
    .banner_taital_main {
        padding: 15px;
        text-align: center;
    }
    
    .btn_main {
        justify-content: center;
    }
}

@media screen and (max-width: 576px) {
    .banner_section {
        min-height: 300px;
    }
    
    .banner_taital {
        font-size: 5rem;
    }
    
    .banner_taital_main {
        padding: 10px;
    }
}

/* Ensure carousel controls stay visible */
.banner_section .carousel-control-prev,
.banner_section .carousel-control-next {
    width: 40px;
    height: 40px;
    background: rgba(0, 0, 0, 0.5);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
}

/* Ensure content stays within viewport on very small devices */
@media screen and (max-width: 320px) {
    .banner_taital {
        font-size: 1.75rem;
    }
    
    .banner_section {
        min-height: 250px;
    }
}
    </style>
   </head>
   <body style="background-color: lightgray;">
      <nav class="nav">
          <div class="logo">
              <a href="#" style="font-family: impact; color: #1153D0; ">
                  <img src="img/logo.png" style="height: 60px; vertical-align: middle;"> MCC Events
              </a>
          </div>
          <div class="main_list" id="mainListDiv">
              <ul>
                  <li><a href="index">Home</a></li>
                  <li><a href="ongoing">Ongoing</a></li>
                  <li><a href="upcoming">Upcoming</a></li>
                  <li><a href="about">About</a></li>
                  <li><a href="admin/stream/index">Live</a></li>
                  <li>
                      <a href="#login">Login</a>
                      <div class="dropdown">
                          <a href="admin/admin_login">Admin Login</a>
                          <a href="admin/index2">Organizer Login</a>
                          <a href="tabulator/index">Tabulator Login</a>
                          <a href="admin/welcome">Judge Login</a>
                          <a href="student/index">Student Login</a>
                      </div>
                  </li>
              </ul>
          </div>
          <button class="media_button" id="mediaButton">
              <span></span>
              <span></span>
              <span></span>
          </button>
      </nav>

      <!-- banner section start --> 
      <div class="banner_section">
   <div class="container">
      <div id="banner_slider" class="carousel slide" data-ride="carousel">
         <div class="carousel-inner">
            <div class="carousel-item active">
               <div class="banner_taital_main">
                  <h1 class="banner_taital">MCC <br>EVENTS</h1>
                  <div class="btn_main">
                     <div class="about_bt active"><a href="#"></a></div>
                     <div class="callnow_bt"><a href="#"></a></div>
                  </div>
               </div>
            </div>
            <div class="carousel-item active">
               <div class="banner_taital_main">
                  <h1 class="banner_taital">MCC <br>EVENTS</h1>
                  <div class="btn_main">
                     <div class="about_bt active"><a href="#"></a></div>
                     <div class="callnow_bt"><a href="#"></a></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- banner section end -->
<!-- ongoing section start -->
<?php
$host = '127.0.0.1';
    $username = 'u510162695_judging_root';
    $password = '1Judging_root';  // Replace with the actual password
    $dbname = 'u510162695_judging';
    

    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    

// Fetch data
$sql = "SELECT `subevent_id`, `event_name`, `eventdate`, `eventtime`, `place`, `banner`, `view` FROM `sub_event` WHERE 1";
$result = $conn->query($sql);

$subEvents = []; // Initialize as an empty array
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $subEvents[] = $row;
    }
}
$conn->close();
?>
<div class="coffee_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12" style="z-index:-1000;">
                <h1 class="coffee_taital">ONGOING EVENTS</h1>
            </div>
        </div>
    </div>
    <div class="coffee_section_2">
        <div id="main_slider" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
            <?php
        $isActive = true;
        $totalEvents = count($subEvents);
        for ($i = 0; $i < $totalEvents; $i += 3) {
            $activeClass = $isActive ? 'active' : '';
            $isActive = false;
            echo '<div class="carousel-item ' . $activeClass . '">';
            echo '    <div class="container-fluid">';
            echo '        <div class="row">';
            
            for ($j = $i; $j < $i + 3 && $j < $totalEvents; $j++) {
                $event = $subEvents[$j];
                $isPollActive = $event['view'] == 'active'; // Assuming 'activated' is the value for active status
                echo '            <div class="col-lg-4 col-md-6 mb-4">';
                echo '                <div class="coffee_img"><img src="img/' . htmlspecialchars($event['banner']) . '" alt="Event Image"></div>';
                echo '                <div class="coffee_box">';
                echo '                    <h3 class="types_text">' . htmlspecialchars($event['event_name']) . '</h3>';
                echo '                    <p class="looking_text">';
                echo '                        Start Date: ' . htmlspecialchars(date("F j, Y", strtotime($event['eventdate']))) . '<br>';
                echo '                        End Date: ' . htmlspecialchars(date("F j, Y", strtotime($event['eventtime']))) . '<br>';
                echo '                        Location: ' . htmlspecialchars($event['place']) . '</p>';
                echo '<form action="check_student_login.php" method="GET" style="display: inline;">';
                echo '    <input type="hidden" name="event" value="' . htmlspecialchars($event['subevent_id']) . '">';
                echo '    <button type="submit" class="btn btn-primary"' . ($isPollActive ? '' : ' disabled') . '>View</button>';
                echo '</form>';
                echo '                </div>';
                echo '            </div>';
            }
            
            echo '        </div>';
            echo '    </div>';
            echo '</div>';
        }
        ?>


<style>
    button.btn.btn-primary {
    z-index: 1000; /* Adjust if necessary */
    position: relative;
}

</style>
            </div>
            <a class="carousel-control-prev" href="#main_slider" role="button" data-slide="prev">
                <i class="fa fa-arrow-left"></i>
            </a>
            <a class="carousel-control-next" href="#main_slider" role="button" data-slide="next">
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>


<!-- ongoing section end -->
<!-- upcoming section start -->
<?php
// Database connection setup
$host = '127.0.0.1';
	$username = 'u510162695_judging_root';
	$password = '1Judging_root';  // Replace with the actual password
	$dbname = 'u510162695_judging';
	

	$conn = new mysqli($host, $username, $password, $dbname);

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

// Query to fetch upcoming events
$sql = "SELECT `id`, `title`, `start_date`, `end_date`, `banner` FROM `upcoming_events` WHERE 1";
$result = $conn->query($sql);

// Generate HTML for carousel items
$carouselItems = '';
$isActive = true;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $activeClass = $isActive ? 'active' : '';
        $isActive = false;

        $carouselItems .= '
        <div class="carousel-item ' . $activeClass . '">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="about_taital">Upcoming Events</h1>
                </div>
            </div>
            <div class="client_section_2">
                <div class="client_taital_main">
                    <div class="client_left">
                        <img class="d-block w-80" src="img/' . htmlspecialchars($row['banner']) . '" alt="' . htmlspecialchars($row['title']) . '">
                    </div>
                    <div class="client_right">
                        <h3 class="moark_text">' . htmlspecialchars($row["title"]) . '</h3>
                        <p class="client_text">Start Date: ' . htmlspecialchars(date("F j, Y", strtotime($row["start_date"]))) . '<br>End Date: ' . htmlspecialchars(date("F j, Y", strtotime($row["end_date"]))) . '</p>
                    </div>
                </div>
            </div>
        </div>';
    }
} else {
    $carouselItems = '
    <div class="carousel-item active">
        <div class="row">
            <div class="col-md-12">
                <h1 class="about_taital">No Upcoming Events</h1>
            </div>
        </div>
    </div>';
}

$conn->close();
?>

<!-- client section start -->

<div class="client_section layout_padding">
    <div class="container">
        <div id="custom_slider" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?php echo $carouselItems; ?>
            </div>
            <a class="carousel-control-prev" href="#custom_slider" role="button" data-slide="prev">
                <i class="fa fa-arrow-left"></i>
            </a>
            <a class="carousel-control-next" href="#custom_slider" role="button" data-slide="next">
                <i class="fa fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>
<!-- client section end -->
<!-- upcoming section end -->
 
<!-- about section start -->
      </div>
      <div class="about_section layout_padding">
         <div class="container">
            <div class="about_section_2">
               <div class="row">
                  <div class="col-md-6" style="z-index:-1000;"> 
                     <div class="about_taital_box">
                        <h1 class="about_taital">ABOUT</h1>
                        <p class=" about_text" style="text-align:justify;">Madridejos Community College (MCC) is an educational institution that serves the local community in Madridejos, a municipality in the province of Cebu, Philippines. It is dedicated to providing quality education and fostering a supportive learning environment for its students.</p>
                     </div>
                  </div>
                  <div class="col-md-6" style="z-index:-1000;"> 
                     <div class="image_iman"><img src="img/Community-College-Madridejos.jpeg" class="about_img"></div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- about section end -->
      <!-- contact section start -->
      <div class="contact_section layout_padding">
         
         <div class="container-fluid">
            <div class="contact_section_2">
               <div class="row">
                  <div class="map_main">
                     <div class="map-responsive">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3912.9695262114656!2d123.72098687257221!3d11.263650350022909!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a88140310a21a9%3A0xc5b9b94e9c2702db!2sMadridejos%20Community%20College!5e0!3m2!1sen!2sph!4v1720744766843!5m2!1sen!2sph" width="250" height="500" frameborder="0" style="border:0; width: 100%;" allowfullscreen=""></iframe>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- contact section end -->

      <div class="copyright_section">
         <div class="container">
            <div class="row">
               <div class="col-sm-12">
                  <p class="copyright_text"><strong>Event Judging System &COPY; <?= date("Y") ?></strong></p>
               </div>
            </div>
         </div>
      </div>

      <!-- Scripts -->
      <script>
          document.addEventListener('DOMContentLoaded', function() {
              const mediaButton = document.getElementById('mediaButton');
              const mainListDiv = document.getElementById('mainListDiv');
              
              mediaButton.addEventListener('click', function(e) {
                  e.stopPropagation();
                  mainListDiv.classList.toggle('show_list');
                  this.classList.toggle('active');
              });

              // Close menu when clicking outside
              document.addEventListener('click', function(event) {
                  const isClickInsideNav = event.target.closest('.nav');
                  if (!isClickInsideNav && mainListDiv.classList.contains('show_list')) {
                      mainListDiv.classList.remove('show_list');
                      mediaButton.classList.remove('active');
                  }
              });

              // Handle window resize
              window.addEventListener('resize', function() {
                  if (window.innerWidth > 768) {
                      mainListDiv.classList.remove('show_list');
                      mediaButton.classList.remove('active');
                  }
              });
          });
      </script>
    <script>
            // Disable right-click
            document.addEventListener('contextmenu', function (e) {
                e.preventDefault();
            });

            // Disable F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U
            document.onkeydown = function (e) {
                if (
                    e.key === 'F12' ||
                    (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J')) ||
                    (e.ctrlKey && e.key === 'U')
                ) {
                    e.preventDefault();
                }
            };

            // Disable developer tools
            function disableDevTools() {
                if (window.devtools.isOpen) {
                    window.location.href = "about:blank";
                }
            }

            // Check for developer tools every 100ms
            setInterval(disableDevTools, 100);

            // Disable selecting text
            document.onselectstart = function (e) {
                e.preventDefault();
            };
    </script>
      <!-- Your existing scripts -->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
   </body>
</html>