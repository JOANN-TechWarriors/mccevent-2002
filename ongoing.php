<!DOCTYPE html>
<html>
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
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
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- font css -->
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css1/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
   </head>
   <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: all 0.4s;
        }

        .nav {
            width: 100%;
            height: 65px;
            position: fixed;
            line-height: 65px;
            text-align: center;
            background-color: rgba(6, 6, 7, 0.8);
            z-index: 1000;
        }

        .nav div.logo {
            float: left;
            width: auto;
            padding-left: 1rem;
        }

        .nav div.logo a {
            text-decoration: none;
            color: #fff;
            font-size: 1.5rem;
            text-transform: uppercase;
        }

        .nav div.logo a:hover {
            color: #c0c0c0;
        }

        .nav div.main_list {
            float: right;
            padding-right: 1rem;
        }

        .nav div.main_list ul {
            width: 100%;
            height: 65px;
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav div.main_list ul li {
            padding: 0;
            padding-right: 3rem;
            position: relative;
        }

        .nav div.main_list ul li a {
            text-decoration: none;
            color: #fff;
            line-height: 65px;
            text-transform: uppercase;
            font-size: 14px;
            font-weight: 500;
        }

        .nav div.main_list ul li a:hover {
            color: #c0c0c0;
        }

        .nav div.media_button {
            width: 40px;
            height: 40px;
            background-color: transparent;
            position: absolute;
            right: 15px;
            top: 12px;
            display: none;
            cursor: pointer;
        }

        .nav div.media_button button.main_media_button {
            width: 100%;
            height: 100%;
            background-color: transparent;
            outline: 0;
            border: none;
            cursor: pointer;
        }

        .nav div.media_button button.main_media_button span {
            width: 98%;
            height: 2px;
            display: block;
            background-color: #fff;
            margin-top: 9px;
            margin-bottom: 10px;
            transition: 0.3s ease;
        }

        /* Dropdown styling */
        .dropdown {
            display: none;
            position: absolute;
            background: rgba(6, 6, 7, 0.95);
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            border-radius: 4px;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            padding: 8px 0;
            z-index: 1001;
        }

        .dropdown::before {
            content: '';
            position: absolute;
            top: -8px;
            left: 50%;
            transform: translateX(-50%);
            border-width: 0 8px 8px 8px;
            border-style: solid;
            border-color: transparent transparent rgba(6, 6, 7, 0.95) transparent;
        }

        .dropdown a {
            color: white !important;
            padding: 12px 20px !important;
            text-decoration: none;
            display: block;
            line-height: 1.5 !important;
            font-size: 14px !important;
            text-transform: none !important;
            transition: all 0.3s ease;
            text-align: left;
        }

        .dropdown a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            padding-left: 25px !important;
        }

        /* Active states */
        .show-dropdown {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateX(-50%) translateY(-10px); }
            to { opacity: 1; transform: translateX(-50%) translateY(0); }
        }

        /* Mobile responsive styles */
        @media screen and (max-width: 768px) {
            .nav div.logo {
                margin-left: 15px;
            }

            .nav div.main_list {
                width: 100%;
                height: 0;
                overflow: hidden;
                position: absolute;
                top: 65px;
                left: 0;
                background-color: rgba(6, 6, 7, 0.95);
                transition: height 0.3s ease;
            }

            .nav div.show_list {
                height: auto;
            }

            .nav div.main_list ul {
                flex-direction: column;
                width: 100%;
                height: auto;
                padding: 20px 0;
            }

            .nav div.main_list ul li {
                width: 100%;
                padding: 0;
            }

            .nav div.main_list ul li a {
                line-height: 50px;
                width: 100%;
                height: 50px;
                display: block;
                padding: 0 20px;
                text-align: left;
            }

            .nav div.media_button {
                display: block;
            }

            /* Mobile dropdown */
            .dropdown {
                position: static;
                transform: none;
                left: 0;
                width: 100%;
                border-radius: 0;
                box-shadow: none;
                background-color: rgba(255, 255, 255, 0.05);
            }

            .dropdown::before {
                display: none;
            }

            .dropdown a {
                padding: 12px 30px !important;
            }

            .show-dropdown {
                animation: none;
            }

            /* Hamburger animation */
            .nav div.media_button button.active span:nth-child(1) {
                transform: rotate(45deg) translate(8px, 8px);
            }

            .nav div.media_button button.active span:nth-child(2) {
                opacity: 0;
            }

            .nav div.media_button button.active span:nth-child(3) {
                transform: rotate(-45deg) translate(7px, -7px);
            }
        }

        /* Prevent content from going under navbar */
        body {
            padding-top: 65px;
        }

        .home{
            background-size: cover;
            background-position: center;
            height: 100vh;
        }
        @media screen and (min-width: 768px) and (max-width: 1024px) {
            .container{
                margin: 0;
            }
        }
        @media screen and (max-width:768px) {
            .container{
                margin: 0;
            }
            .nav div.logo{
                margin-left: 15px;
            }
            .nav div.main_list{
                width: 100%;
                margin-top: 65px;
                height: 0px;
                overflow: hidden;
            }
            .nav div.show_list{
                height: 200px;
            }
            .nav div.main_list ul{
                flex-direction: column;
                width: 100%;
                height: 200px;
                top: 80px;
                right: 0;
                left: 0;
            }
            .nav div.main_list ul li{
                width: 100%;
                height: 40px;
                background-color:rgba(6, 6, 7, 0.8);
            }
            .nav div.main_list ul li a{
                text-align: center;
                line-height: 40px;
                width: 100%;
                height: 40px;
                display: table;
            }
            .nav div.media_button{
                display: block;
            }
        }
        .main_list ul {
            list-style-type: none;
            padding: 0;
        }

        .main_list ul li {
            display: inline-block;
            position: relative;
        }

        .main_list ul li a {
            text-decoration: none;
            padding: 10px;
            color: #000;
        }

        .main_list ul li:hover .dropdown {
            display: block;
        }
        /* Main Event Carousel styles */
        #mainEventCarousel {
            width: 100%;
            height: 100vh; /* 50% of the viewport height */
            overflow: hidden;
        }

        #mainEventCarousel .carousel-inner,
        #mainEventCarousel .carousel-item {
            height: 100%;
        }

        #mainEventCarousel .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* This maintains aspect ratio */
        }

        #mainEventCarousel .carousel-caption {
            bottom: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 5px;
        }

        .dropdown {
            display: none;
            position: absolute;
            background-color: black;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown a:hover {
            background-color: #333;
            color:red;
        }
    </style>
   <body>
   <nav class="nav">
        <div class="logo">
            <a href="#" style="font-family: impact; color: #1153D0;">
                <img src="img/logo.png" style="height: 40px; vertical-align: middle;"> MCC Event
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
                    <a href="#" id="loginDropdown">Login</a>
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
        <div class="media_button" id="mediaButton">
            <button class="main_media_button">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>
      <!-- header section end -->

      <!-- Mainevent section start  -->
      <?php
// Database connection using PDO
$conn = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u510162695_judging', 'u510162695_judging_root', '1Judging_root');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Get current date
$currentDate = date('Y-m-d');

// Query to fetch ongoing and activated events
$sql = "SELECT mainevent_id, event_name, description, date_start, date_end, place, banner 
        FROM main_event 
        WHERE :currentDate BETWEEN date_start AND date_end AND status = 'activated'";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':currentDate', $currentDate);
$stmt->execute();

// Fetch events
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div id="mainEventCarousel" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
    <?php if (count($events) > 0) : ?>
      <?php foreach ($events as $index => $event) : ?>
        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
          <img class="d-block w-100" src="img/<?= htmlspecialchars($event['banner']) ?>" alt="<?= htmlspecialchars($event['event_name']) ?>">
          <div class="carousel-caption d-none d-md-block">
            <h5 style="color:white; font-size: large;"><?= htmlspecialchars($event['event_name']) ?></h5>
            <p class="description"><?= nl2br(htmlspecialchars($event['description'])) ?></p>
            <p><?= htmlspecialchars(date("F j, Y", strtotime($event['date_start']))) ?> - <?= htmlspecialchars(date("F j, Y", strtotime($event['date_end']))) ?><br><?= htmlspecialchars($event['place']) ?></p>
          </div>
        </div>
      <?php endforeach; ?>
    <?php else : ?>
      <div class="carousel-item active">
        <img class="d-block w-100" src="img/default.jpg" alt="No events">
        <div class="carousel-caption d-none d-md-block">
          <h5>No Events</h5>
          <p>There are no ongoing events at the moment.</p>
        </div>
      </div>
    <?php endif; ?>
  </div>
  <a class="carousel-control-prev" href="#mainEventCarousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#mainEventCarousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

<?php
$conn = null; // Close the database connection
?>





<!-- Mainevent section end -->

     <!-- ongoing section start -->
<?php
// Database connection
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
                echo '                    <form action="poll/index.php" method="GET" style="display: inline;">';
                echo '                        <input type="hidden" name="event" value="' . htmlspecialchars($event['subevent_id']) . '">';
                echo '                        <button type="submit" class="btn btn-primary"' . ($isPollActive ? '' : ' disabled') . '>View</button>';
                echo '                    </form>';
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
      
      <!-- copyright section start -->
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
      <!-- Javascript files-->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
      <!-- Required JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get elements
            const mediaButton = document.getElementById('mediaButton');
            const mainListDiv = document.getElementById('mainListDiv');
            const mediaButtonSpans = mediaButton.querySelector('button');
            const loginDropdown = document.getElementById('loginDropdown');
            const dropdown = document.querySelector('.dropdown');
            let isDropdownOpen = false;

            // Mobile menu toggle
            mediaButton.addEventListener('click', function() {
                mainListDiv.classList.toggle('show_list');
                mediaButtonSpans.classList.toggle('active');
                
                // Close dropdown if menu is closing
                if (!mainListDiv.classList.contains('show_list')) {
                    dropdown.classList.remove('show-dropdown');
                    isDropdownOpen = false;
                }
            });

            // Login dropdown toggle
            loginDropdown.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                isDropdownOpen = !isDropdownOpen;
                dropdown.classList.toggle('show-dropdown');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!dropdown.contains(e.target) && !loginDropdown.contains(e.target)) {
                    dropdown.classList.remove('show-dropdown');
                    isDropdownOpen = false;
                }
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    mainListDiv.classList.remove('show_list');
                    mediaButtonSpans.classList.remove('active');
                    if (!isDropdownOpen) {
                        dropdown.classList.remove('show-dropdown');
                    }
                }
            });

            // Prevent dropdown from closing when clicking inside it
            dropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
   </body>
</html>