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
   <style>
    /* Basic Reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        transition: all 0.4s;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    }

    body {
        padding-top: 65px; /* Add padding to account for fixed navbar */
    }

    /* Navigation Bar Base Styles */
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
    }

    .container {
        width: 90%;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 100%;
    }

    /* Logo Styles */
    .nav .logo {
        height: 65px;
        display: flex;
        align-items: center;
    }

    .nav .logo a {
        text-decoration: none;
        color: #fff;
        font-size: 25px;
        text-transform: uppercase;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .nav .logo img {
        height: 40px;
        vertical-align: middle;
    }

    /* Main Navigation List */
    .nav .main_list {
        height: 65px;
        display: flex;
        align-items: center;
    }

    .main_list ul {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        gap: 20px;
    }

    .main_list ul li {
        position: relative;
    }

    .main_list ul li a {
        text-decoration: none;
        color: #fff;
        text-transform: uppercase;
        font-size: 14px;
        padding: 0 15px;
        display: block;
        transition: color 0.3s ease;
    }

    .main_list ul li a:hover {
        color: #1153D0;
    }

    /* Dropdown Menu */
    .dropdown {
        display: none;
        position: absolute;
        background-color: rgba(6, 6, 7, 0.9);
        min-width: 200px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        z-index: 1001;
        top: 100%;
        right: 0;
        border-radius: 4px;
    }

    .dropdown a {
        color: #fff;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
        line-height: 1.5;
        text-align: left;
        font-size: 14px;
    }

    .dropdown a:hover {
        background-color: rgba(17, 83, 208, 0.2);
        color: #1153D0;
    }

    .main_list ul li:hover .dropdown {
        display: block;
    }

    /* Mobile Menu Button */
    .media_button {
        display: none;
        background: transparent;
        border: none;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
    }

    .media_button span {
        display: block;
        width: 30px;
        height: 2px;
        background-color: #fff;
        margin: 6px 0;
        transition: 0.3s;
    }

    /* Responsive Design */
    @media screen and (max-width: 768px) {
        .media_button {
            display: block;
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
        }

        .nav .main_list {
            position: absolute;
            top: 65px;
            left: 0;
            width: 100%;
            height: 0;
            background-color: rgba(6, 6, 7, 0.95);
            overflow: hidden;
            transition: height 0.3s ease-in-out;
        }

        .nav .main_list.show_list {
            height: auto;
        }

        .main_list ul {
            flex-direction: column;
            width: 100%;
            gap: 0;
            padding: 0;
        }

        .main_list ul li {
            width: 100%;
            text-align: center;
        }

        .main_list ul li a {
            padding: 15px;
            line-height: 1;
        }

        .dropdown {
            position: static;
            width: 100%;
            background-color: rgba(17, 83, 208, 0.1);
            box-shadow: none;
        }

        .dropdown a {
            padding: 12px 30px;
        }

        /* Hamburger Animation */
        .media_button.active span:nth-child(1) {
            transform: rotate(-45deg) translate(-5px, 6px);
        }

        .media_button.active span:nth-child(2) {
            opacity: 0;
        }

        .media_button.active span:nth-child(3) {
            transform: rotate(45deg) translate(-5px, -6px);
        }
    }

    /* Additional Utility Classes */
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
    </style>
</head>
<body>
    <nav class="nav">
        <div class="container">
            <div class="logo">
                <a href="#" style="font-family: impact; color: #1153D0;">
                    <img src="img/logo.png" alt="MCC Event Logo"> MCC Event
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
                            <a href="judge/index.php">Judge Login</a>
                            <a href="student/index.php">Student Login</a>
                        </div>
                    </li>
                </ul>
            </div>
            <button class="media_button" id="mediaButton">
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
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const mediaButton = document.querySelector('.media_button');
        const mainList = document.querySelector('.main_list');

        mediaButton.addEventListener('click', function() {
            mainList.classList.toggle('show_list');
            this.classList.toggle('active');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = mainList.contains(event.target) || mediaButton.contains(event.target);
            
            if (!isClickInside && mainList.classList.contains('show_list')) {
                mainList.classList.remove('show_list');
                mediaButton.classList.remove('active');
            }
        });

        // Close menu when window is resized above mobile breakpoint
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                mainList.classList.remove('show_list');
                mediaButton.classList.remove('active');
            }
        });
    });

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
    </script>
   </body>
</html>