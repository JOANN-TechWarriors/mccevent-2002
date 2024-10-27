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
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        /* Navbar Styles */
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
            height: 60px;
            vertical-align: middle;
        }

        /* Main Event Carousel Styles */
        #mainEventCarousel {
            width: 100%;
            height: calc(100vh - 65px);
            margin-top: 65px;
            position: relative;
            overflow: hidden;
        }

        #mainEventCarousel .carousel-inner {
            height: 100%;
        }

        #mainEventCarousel .carousel-item {
            height: 100%;
            background-color: #000;
        }

        #mainEventCarousel .carousel-item img {
            width: 100%;
            height: 90%;
            object-fit: cover;
            opacity: 0.9;
        }

        #mainEventCarousel .carousel-caption {
            background: rgba(0, 0, 0, 0.6);
            padding: 20px;
            border-radius: 8px;
            max-width: 800px;
            margin: 0 auto;
            left: 50%;
            transform: translateX(-50%);
            bottom: 20%;
            text-align: center;
        }

        #mainEventCarousel .carousel-caption h5 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 600;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            color: white;
        }

        #mainEventCarousel .carousel-caption p {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 0.5rem;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
            color: white;
        }

        #mainEventCarousel .description {
            max-height: 150px;
            overflow-y: auto;
            margin-bottom: 1rem;
        }

        #mainEventCarousel .carousel-control-prev,
        #mainEventCarousel .carousel-control-next {
            width: 5%;
            opacity: 0.7;
            z-index: 100;
        }

        #mainEventCarousel .carousel-control-prev:hover,
        #mainEventCarousel .carousel-control-next:hover {
            opacity: 1;
        }

        #mainEventCarousel .carousel-control-prev-icon,
        #mainEventCarousel .carousel-control-next-icon {
            width: 30px;
            height: 30px;
        }

        /* Responsive Design */
        @media screen and (max-width: 1200px) {
            #mainEventCarousel .carousel-caption {
                max-width: 80%;
                bottom: 15%;
            }

            #mainEventCarousel .carousel-caption h5 {
                font-size: 2rem;
            }
        }

        @media screen and (max-width: 992px) {
            #mainEventCarousel {
                height: calc(80vh - 65px);
            }

            #mainEventCarousel .carousel-caption {
                bottom: 10%;
                padding: 15px;
            }

            #mainEventCarousel .carousel-caption h5 {
                font-size: 1.8rem;
            }

            #mainEventCarousel .carousel-caption p {
                font-size: 1rem;
            }

            #mainEventCarousel .description {
                max-height: 120px;
            }
        }

        @media screen and (max-width: 768px) {
            #mainEventCarousel {
                height: calc(70vh - 65px);
            }

            #mainEventCarousel .carousel-caption {
                position: relative;
                background: rgba(0, 0, 0, 0.8);
                margin-top: -120px;
                padding: 15px;
                width: 90%;
            }

            #mainEventCarousel .carousel-caption h5 {
                font-size: 1.5rem;
            }

            #mainEventCarousel .description {
                max-height: 100px;
            }

            #mainEventCarousel .carousel-control-prev,
            #mainEventCarousel .carousel-control-next {
                width: 10%;
            }
        }

        @media screen and (max-width: 576px) {
            #mainEventCarousel {
                height: calc(60vh - 65px);
            }

            #mainEventCarousel .carousel-caption {
                margin-top: -100px;
                padding: 10px;
            }

            #mainEventCarousel .carousel-caption h5 {
                font-size: 1.2rem;
                margin-bottom: 0.5rem;
            }

            #mainEventCarousel .carousel-caption p {
                font-size: 0.9rem;
                line-height: 1.4;
            }

            #mainEventCarousel .description {
                max-height: 80px;
            }
        }

        @media screen and (max-width: 380px) {
            #mainEventCarousel {
                height: calc(50vh - 65px);
            }

            #mainEventCarousel .carousel-caption {
                margin-top: -80px;
            }

            #mainEventCarousel .carousel-caption h5 {
                font-size: 1.1rem;
            }

            #mainEventCarousel .carousel-caption p {
                font-size: 0.8rem;
            }

            #mainEventCarousel .description {
                max-height: 60px;
            }
        }
    </style>
   <body style="background-color: lightgray;">
      <nav class="nav">
          <div class="logo">
              <a href="#" style="font-family: impact; color: #1153D0;">
                  <img src="img/logo.png" style="height: 60px; vertical-align: middle;"> MCC Event
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
                          <a href="admin/index2.php">Organizer Login</a>
                          <a href="tabulator/index.php">Tabulator Login</a>
                          <a href="admin/welcome.php">Judge Login</a>
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
                            <h5><?= htmlspecialchars($event['event_name']) ?></h5>
                            <p class="description"><?= nl2br(htmlspecialchars($event['description'])) ?></p>
                            <p>
                                <?= htmlspecialchars(date("F j, Y", strtotime($event['date_start']))) ?> - 
                                <?= htmlspecialchars(date("F j, Y", strtotime($event['date_end']))) ?><br>
                                <?= htmlspecialchars($event['place']) ?>
                            </p>
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
        // Initialize carousel
        $(document).ready(function() {
            $('#mainEventCarousel').carousel({
                interval: 5000, // Change slides every 5 seconds
                pause: 'hover' // Pause on mouse hover
            });
        });
    </script>
      
    <script>
    document.getElementById('mediaButton').addEventListener('click', function() {
        document.getElementById('mainListDiv').classList.toggle('show_list');
    });
    </script>
    
   </body>
</html>