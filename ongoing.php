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
      
      <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        .nav {
            width: 100%;
            height: 65px;
            position: fixed;
            background-color: rgba(6, 6, 7, 0.8);
            z-index: 1000;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 100%;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo a {
            text-decoration: none;
            color: #1153D0;
            font-family: impact;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo img {
            height: 40px;
        }

        .main_list {
            display: flex;
            align-items: center;
        }

        .main_list ul {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .main_list ul li {
            position: relative;
            margin-left: 20px;
        }

        .main_list ul li a {
            text-decoration: none;
            color: #fff;
            text-transform: uppercase;
            font-size: 14px;
            transition: color 0.3s;
        }

        .main_list ul li a:hover {
            color: #c0c0c0;
        }

        .dropdown {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: rgba(6, 6, 7, 0.9);
            min-width: 160px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }

        .dropdown a {
            padding: 12px 16px;
            display: block;
            color: #fff;
            font-size: 14px;
        }

        .dropdown a:hover {
            background-color: rgba(255,255,255,0.1);
        }

        .main_list ul li:hover .dropdown {
            display: block;
        }

        .media_button {
            display: none;
        }

        /* Main Event Carousel styles */
        #mainEventCarousel {
            width: 100%;
            height: 100vh;
            overflow: hidden;
            margin-top: 65px; /* Add margin to account for fixed navbar */
        }

        #mainEventCarousel .carousel-inner,
        #mainEventCarousel .carousel-item {
            height: 100%;
        }

        #mainEventCarousel .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #mainEventCarousel .carousel-caption {
            bottom: 20px;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 5px;
        }

        /* Coffee section styles */
        .coffee_section {
            padding: 50px 0;
        }

        .coffee_section .coffee_taital {
            text-align: center;
            margin-bottom: 40px;
        }

        .coffee_box {
            padding: 20px;
            text-align: center;
        }

        .coffee_img img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        /* Copyright section */
        .copyright_section {
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 20px 0;
        }

        @media screen and (max-width: 768px) {
            .media_button {
                display: block;
                position: relative;
                cursor: pointer;
                width: 30px;
                height: 25px;
                margin-right: 15px;
            }

            .media_button span {
                width: 100%;
                height: 2px;
                background-color: #fff;
                display: block;
                position: absolute;
                transition: 0.3s;
            }

            .media_button span:nth-child(1) { top: 0; }
            .media_button span:nth-child(2) { top: 50%; transform: translateY(-50%); }
            .media_button span:nth-child(3) { bottom: 0; }

            .media_button.active span:nth-child(1) { 
                transform: rotate(45deg); 
                top: 50%;
            }
            .media_button.active span:nth-child(2) { 
                opacity: 0;
            }
            .media_button.active span:nth-child(3) { 
                transform: rotate(-45deg); 
                bottom: 50%;
            }

            .main_list {
                position: absolute;
                top: 65px;
                left: 0;
                width: 100%;
                background-color: rgba(6, 6, 7, 0.9);
                display: none;
                padding: 20px 0;
            }

            .main_list.show_list {
                display: block;
            }

            .main_list ul {
                flex-direction: column;
                width: 100%;
            }

            .main_list ul li {
                margin: 0;
                width: 100%;
                text-align: center;
            }

            .main_list ul li a {
                padding: 15px 0;
                display: block;
            }

            .dropdown {
                position: static;
                display: none;
                width: 100%;
                background-color: rgba(0,0,0,0.2);
            }

            .main_list ul li:hover .dropdown {
                display: none;
            }

            .main_list ul li.active .dropdown {
                display: block;
            }

            /* Adjust carousel height for mobile */
            #mainEventCarousel {
                height: 50vh;
            }
        }
      </style>
   </head>
   <body>
      <!-- Navigation -->
      <nav class="nav">
          <div class="container">
              <div class="logo">
                  <a href="#">
                      <img src="img/logo.png" alt="MCC Logo">
                      <span>MCC Event</span>
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
              <div class="media_button" id="mediaButton">
                  <span></span>
                  <span></span>
                  <span></span>
              </div>
          </div>
      </nav>

      <!-- Main Event Carousel -->
      <div id="mainEventCarousel" class="carousel slide" data-ride="carousel">
          <div class="carousel-inner">
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

              if (count($events) > 0) {
                  foreach ($events as $index => $event) {
                      echo '<div class="carousel-item ' . ($index === 0 ? 'active' : '') . '">';
                      echo '<img class="d-block w-100" src="img/' . htmlspecialchars($event['banner']) . '" alt="' . htmlspecialchars($event['event_name']) . '">';
                      echo '<div class="carousel-caption d-none d-md-block">';
                      echo '<h5 style="color:white; font-size: large;">' . htmlspecialchars($event['event_name']) . '</h5>';
                      echo '<p class="description">' . nl2br(htmlspecialchars($event['description'])) . '</p>';
                      echo '<p>' . htmlspecialchars(date("F j, Y", strtotime($event['date_start']))) . ' - ' . 
                           htmlspecialchars(date("F j, Y", strtotime($event['date_end']))) . '<br>' . 
                           htmlspecialchars($event['place']) . '</p>';
                      echo '</div></div>';
                  }
              } else {
                  echo '<div class="carousel-item active">';
                  echo '<img class="d-block w-100" src="img/default.jpg" alt="No events">';
                  echo '<div class="carousel-caption d-none d-md-block">';
                  echo '<h5>No Events</h5>';
                  echo '<p>There are no ongoing events at the moment.</p>';
                  echo '</div></div>';
              }
              ?>
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
        document.getElementById('mediaButton').addEventListener('click', function() {
            this.classList.toggle('active');
            document.getElementById('mainListDiv').classList.toggle('show_list');
        });

        // Handle dropdown on mobile
        if (window.innerWidth <= 768) {
            document.querySelectorAll('.main_list ul li').forEach(item => {
                if (item.querySelector('.dropdown')) {
                    item.addEventListener('click', function(e) {
                        if (e.target.tagName === 'A' && e.target.nextElementSibling) {
                            e.preventDefault();
                            this.classList.toggle('active');
                        }
                    });
                }
            });
        }

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            const menu = document.getElementById('mainListDiv');
            const button = document.getElementById('mediaButton');
            if (!menu.contains(e.target) && !button.contains(e.target) && menu.classList.contains('show_list')) {
                menu.classList.remove('show_list');
                button.classList.remove('active');
            }
        });
    </script>
      
   </body>
</html>