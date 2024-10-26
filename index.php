<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../img/logo.png"/>
    <title>Event Judging System</title>
    
    <!-- Existing CSS links -->
    <link rel="stylesheet" type="text/css" href="css1/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css1/style.css">
    <link rel="stylesheet" href="css1/responsive.css">
    <link rel="icon" href="images/fevicon.png" type="image/gif" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css1/jquery.mCustomScrollbar.min.css">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: all 0.4s;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            padding-top: 70px; /* Space for fixed navbar */
        }

        /* Navigation Styles */
        .nav {
            width: 100%;
            height: 70px;
            position: fixed;
            line-height: 70px;
            background-color: rgba(6, 6, 7, 0.9);
            z-index: 1000;
            top: 0;
            left: 0;
            transition: all 0.4s ease;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .nav .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100%;
        }

        .nav .logo {
            display: flex;
            align-items: center;
            height: 100%;
        }

        .nav .logo a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #fff;
            font-family: impact;
            font-size: 24px;
            transition: color 0.3s ease;
        }

        .nav .logo img {
            height: 40px;
            margin-right: 10px;
        }

        .nav .main_list {
            display: flex;
            align-items: center;
        }

        .nav .main_list ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav .main_list ul li {
            position: relative;
            margin: 0 5px;
        }

        .nav .main_list ul li a {
            text-decoration: none;
            color: #fff;
            padding: 10px 15px;
            display: block;
            font-size: 16px;
            transition: all 0.3s ease;
            text-transform: uppercase;
            font-weight: 500;
        }

        .nav .main_list ul li a:hover {
            color: #1153D0;
            background-color: rgba(255,255,255,0.1);
            border-radius: 4px;
        }

        /* Dropdown Menu */
        .dropdown {
            display: none;
            position: absolute;
            background-color: rgba(6, 6, 7, 0.95);
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            border-radius: 4px;
            overflow: hidden;
            z-index: 1001;
        }

        .dropdown a {
            color: #fff !important;
            padding: 12px 20px !important;
            font-size: 14px !important;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .dropdown a:hover {
            background-color: #1153D0 !important;
            color: #fff !important;
        }

        .nav .main_list ul li:hover .dropdown {
            display: block;
        }

        /* Mobile Menu Button */
        .nav .media_button {
            display: none;
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            padding: 10px;
        }

        .nav .media_button button.main_media_button {
            width: 30px;
            height: 25px;
            background-color: transparent;
            border: none;
            cursor: pointer;
            outline: none;
            position: relative;
        }

        .nav .media_button button.main_media_button span {
            width: 100%;
            height: 2px;
            background-color: #fff;
            display: block;
            position: absolute;
            transition: all 0.3s ease;
        }

        .nav .media_button button.main_media_button span:nth-child(1) {
            top: 0;
        }

        .nav .media_button button.main_media_button span:nth-child(2) {
            top: 50%;
            transform: translateY(-50%);
        }

        .nav .media_button button.main_media_button span:nth-child(3) {
            bottom: 0;
        }

        .nav .media_button button.active span:nth-child(1) {
            transform: rotate(45deg);
            top: 11px;
        }

        .nav .media_button button.active span:nth-child(2) {
            opacity: 0;
        }

        .nav .media_button button.active span:nth-child(3) {
            transform: rotate(-45deg);
            bottom: 11px;
        }

        /* Responsive Styles */
        @media screen and (max-width: 768px) {
            .nav .media_button {
                display: block;
            }

            .nav .main_list {
                position: fixed;
                top: 70px;
                left: 0;
                width: 100%;
                height: 0;
                background-color: rgba(6, 6, 7, 0.95);
                overflow: hidden;
                transition: all 0.3s ease;
            }

            .nav .main_list.show_list {
                height: auto;
            }

            .nav .main_list ul {
                flex-direction: column;
                width: 100%;
            }

            .nav .main_list ul li {
                width: 100%;
                margin: 0;
            }

            .nav .main_list ul li a {
                text-align: center;
                padding: 15px;
                border-bottom: 1px solid rgba(255,255,255,0.1);
            }

            .dropdown {
                position: static;
                width: 100%;
                display: none;
            }

            .nav .main_list ul li:hover .dropdown {
                display: none;
            }

            .nav .main_list ul li.show_dropdown .dropdown {
                display: block;
            }
        }

        /* Existing styles for other sections */
        .coffee_section {
            padding: 50px 0;
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
    </style>
</head>
<body style="background-color: lightgray;">
    <!-- Navigation -->
    <nav class="nav">
        <div class="container">
            <div class="logo">
                <a href="#">
                    <img src="img/logo.png" alt="MCC Logo">
                    <span style="color: #1153D0;">MCC Event</span>
                </a>
            </div>
            <div class="main_list" id="mainListDiv">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="ongoing.php">Ongoing</a></li>
                    <li><a href="upcoming.php">Upcoming</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="admin/stream/index.php">Live</a></li>
                    <li>
                        <a href="#login">Login</a>
                        <div class="dropdown">
                            <a href="admin/admin_login.php">Admin Login</a>
                            <a href="admin/index.php">Organizer Login</a>
                            <a href="tabulator/index.php">Tabulator Login</a>
                            <a href="admin/welcome.php">Judge Login</a>
                            <a href="student/index.php">Student Login</a>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="media_button">
                <button class="main_media_button">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Your existing content sections -->
    <div class="banner_section layout_padding">
       <div class="container">
      <div id="banner_slider" class="carousel slide" data-ride="carousel">
         <div class="carousel-inner">
            <div class="carousel-item active">
               <div class="row">
                  <div class="col-md-12" style="z-index:-1000;">
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
            <div class="carousel-item">
               <div class="row">
                  <div class="col-md-12">
                     <div class="banner_taital_main" style="z-index:-1000;">
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
   </div>
    </div>

    <!-- Ongoing Events Section -->
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

    <!-- About Section -->
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

    <!-- Contact Section -->
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

    <!-- Footer -->
    <div class="copyright_section">
        <div class="container">
            <div class="row">
               <div class="col-sm-12">
                  <p class="copyright_text"><strong> Event Judging  System &COPY; <?= date("Y") ?>  </strong></p>
               </div>
            </div>
         </div>
      </div>
      <!-- copyright section end -->

    <!-- Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/plugin.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/custom.js"></script>
    
    <!-- Navigation JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mediaButton = document.querySelector('.main_media_button');
            const mainList = document.querySelector('.main_list');
            const navItems = document.querySelectorAll('.main_list ul li');

            // Toggle mobile menu
            mediaButton.addEventListener('click', function() {
                this.classList.toggle('active');
                mainList.classList.toggle('show_list');
            });

            // Handle dropdown on mobile
            navItems.forEach(item => {
                if (item.querySelector('.dropdown')) {
                    item.addEventListener('click', function(e) {
                        if (window.innerWidth <= 768) {
                            e.preventDefault();
                            this.classList.toggle('show_dropdown');
                        }
                    });
                }
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.nav')) {
                    mediaButton.classList.remove('active');
                    mainList.classList.remove('show_list');
                    navItems.forEach(item => item.classList.remove('show_dropdown'));
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    mediaButton.classList.remove('active');
                    mainList.classList.remove('show_list');
                    navItems.forEach(item => item.classList.remove('show_dropdown'));
                }
            });

            // Add scroll event for navbar transparency
            window.addEventListener('scroll', function() {
                const nav = document.querySelector('.nav');
                if (window.scrollY > 100) {
                    nav.style.backgroundColor = 'rgba(6, 6, 7, 0.95)';
                } else {
                    nav.style.backgroundColor = 'rgba(6, 6, 7, 0.9)';
                }
            });
        });
    </script>
</body>
</html>