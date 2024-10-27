<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event Judging System</title>
    <link rel="shortcut icon" href="../img/logo.png"/>
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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: all 0.4s;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            padding-top: 70px; /* Add padding to prevent content from being hidden under fixed navbar */
        }

        /* Navbar Styles */
        .navbar {
            background-color: rgba(6, 6, 7, 0.9);
            padding: 0.5rem 1rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .navbar-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            text-decoration: none;
            font-family: Impact, sans-serif;
            color: #1153D0;
        }

        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }

        .navbar-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .navbar-links a {
            color: white;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 0.9rem;
            transition: color 0.3s;
            padding: 0.5rem 1rem;
        }

        .navbar-links a:hover {
            color: #c0c0c0;
        }

        /* Dropdown Styles */
        .dropdown {
            position: relative;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: rgba(6, 6, 7, 0.9);
            min-width: 200px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            padding: 12px 16px;
            display: block;
            color: white;
            text-transform: none;
        }

        .dropdown-content a:hover {
            background-color: rgba(255,255,255,0.1);
        }

        /* Mobile Menu Button */
        .navbar-toggle {
            display: none;
            flex-direction: column;
            gap: 6px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 4px;
        }

        .navbar-toggle span {
            width: 25px;
            height: 2px;
            background-color: white;
            transition: 0.3s;
        }

        /* Carousel Styles */
        #mainEventCarousel {
            margin-top: 20px;
        }

        .carousel-item img {
            width: 100%;
            height: 70vh;
            object-fit: cover;
        }

        .carousel-caption {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 5px;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .navbar-toggle {
                display: flex;
            }

            .navbar-links {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                flex-direction: column;
                background-color: rgba(6, 6, 7, 0.9);
                padding: 1rem;
                gap: 1rem;
            }

            .navbar-links.active {
                display: flex;
            }

            .dropdown-content {
                position: static;
                width: 100%;
                background-color: rgba(255,255,255,0.1);
            }

            .navbar-links a {
                width: 100%;
                text-align: left;
            }
        }

        /* Social Icons */
        .fa {
            padding: 10px;
            font-size: 10px;
            width: 8px;
            text-align: center;
            text-decoration: none;
            margin: 5px;
            border-radius: 30%;
        }

        .fa:hover {
            opacity: 0.5;
        }

        /* Footer Styles */
        .copyright_section {
            background-color: #252525;
            color: white;
            text-align: center;
            padding: 20px 0;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="#" class="navbar-brand">
                <img src="img/logo.png" alt="MCC Event Logo">
                MCC Event
            </a>
            <button class="navbar-toggle" onclick="toggleMenu()">
                <span></span>
                <span></span>
                <span></span>
            </button>
            <div class="navbar-links" id="navbarLinks">
                <a href="index.php">Home</a>
                <a href="ongoing.php">Ongoing</a>
                <a href="upcoming.php">Upcoming</a>
                <a href="about.php">About</a>
                <a href="admin/stream/index.php">Live</a>
                <div class="dropdown">
                    <a href="#login">Login</a>
                    <div class="dropdown-content">
                        <a href="admin/admin_login.php">Admin Login</a>
                        <a href="admin/index2.php">Organizer Login</a>
                        <a href="tabulator/index.php">Tabulator Login</a>
                        <a href="judge/index.php">Judge Login</a>
                        <a href="student/index2.php">Student Login</a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Event Carousel -->
    <div id="mainEventCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <?php if (count($events) > 0) : ?>
                <?php foreach ($events as $index => $event) : ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <img class="d-block w-100" src="img/<?= htmlspecialchars($event['banner']) ?>" alt="<?= htmlspecialchars($event['event_name']) ?>">
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?= htmlspecialchars($event['event_name']) ?></h5>
                            <p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
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

    <!-- Ongoing Events Section -->
    <div class="coffee_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
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
        // Toggle mobile menu
        function toggleMenu() {
            const navbarLinks = document.getElementById('navbarLinks');
            navbarLinks.classList.toggle('active');
        }

        // Security measures
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });

        document.onkeydown = function (e) {
            if (
                e.key === 'F12' ||
                (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J')) ||
                (e.ctrlKey && e.key === 'U')
            ) {
                e.preventDefault();
            }
        };

        document.onselectstart = function (e) {
            e.preventDefault();
        };
    </script>
   </body>
</html>