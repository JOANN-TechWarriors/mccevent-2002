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
    position: relative;
}

#mainEventCarousel .carousel-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.9;
}

#mainEventCarousel .carousel-caption {
    background: rgba(0, 0, 0, 0.7);
    padding: 20px;
    border-radius: 8px;
    width: 90%;
    max-width: 800px;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: 20%;
    text-align: center;
    display: block !important; /* Force display */
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

/* Large devices (desktops, less than 1200px) */
@media screen and (max-width: 1200px) {
    #mainEventCarousel .carousel-caption {
        width: 80%;
        bottom: 15%;
    }

    #mainEventCarousel .carousel-caption h5 {
        font-size: 2rem;
    }
}

/* Medium devices (tablets, less than 992px) */
@media screen and (max-width: 992px) {
    #mainEventCarousel {
        height: calc(80vh - 65px);
    }

    #mainEventCarousel .carousel-caption {
        width: 90%;
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

/* Small devices (landscape phones, less than 768px) */
@media screen and (max-width: 768px) {
    #mainEventCarousel {
        height: calc(70vh - 65px);
    }

    #mainEventCarousel .carousel-caption {
        width: 95%;
        bottom: 5%;
        padding: 12px;
    }

    #mainEventCarousel .carousel-caption h5 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    #mainEventCarousel .carousel-caption p {
        font-size: 0.9rem;
        line-height: 1.4;
    }

    #mainEventCarousel .description {
        max-height: 100px;
    }
}

/* Extra small devices (phones, less than 576px) */
@media screen and (max-width: 576px) {
    #mainEventCarousel {
        height: calc(60vh - 65px);
    }

    #mainEventCarousel .carousel-caption {
        width: 100%;
        bottom: 0;
        padding: 10px;
        border-radius: 0;
        background: rgba(0, 0, 0, 0.8);
    }

    #mainEventCarousel .carousel-caption h5 {
        font-size: 1.2rem;
    }

    #mainEventCarousel .carousel-caption p {
        font-size: 0.85rem;
        line-height: 1.3;
    }

    #mainEventCarousel .description {
        max-height: 80px;
    }
}

/* Very small devices (small phones, less than 380px) */
@media screen and (max-width: 380px) {
    #mainEventCarousel {
        height: calc(50vh - 65px);
    }

    #mainEventCarousel .carousel-caption {
        padding: 8px;
    }

    #mainEventCarousel .carousel-caption h5 {
        font-size: 1.1rem;
        margin-bottom: 0.3rem;
    }

    #mainEventCarousel .carousel-caption p {
        font-size: 0.8rem;
        line-height: 1.2;
        margin-bottom: 0.3rem;
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
                  <img src="img/logo.png" style="height: 30px; vertical-align: middle;"> MCC Events
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
    
   </body>
</html>
<?php
    // ==============================
    // Security Headers
    // ==============================

    // Content Security Policy: Restricts sources for content, scripts, and frames
    header("Content-Security-Policy: default-src 'self'; script-src 'self' https://trusted-scripts.com; frame-ancestors 'none';");
    header("Content-Security-Policy: script-src 'self'; object-src 'none';");

    // Prevent clickjacking by disallowing framing
    header("X-Frame-Options: DENY");

    // Enforce HTTPS using Strict-Transport-Security
    header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");

    // Prevent MIME type sniffing
    header("X-Content-Type-Options: nosniff");

    // Enable basic XSS protection for older browsers
    header("X-XSS-Protection: 1; mode=block");

    // Control referrer information sent with requests
    header("Referrer-Policy: no-referrer-when-downgrade");

    // Restrict usage of certain browser features and APIs
    header("Permissions-Policy: geolocation=(), camera=(), microphone=(), payment=()");



    // ==============================
    // Redirect HTTP to HTTPS
    // ==============================
    if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
        header("Location: https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        exit();
    }

    // ==============================
    // Secure Session Cookie Settings
    // ==============================
    ini_set('session.cookie_secure', '1');          // Enforces HTTPS-only session cookies
    ini_set('session.cookie_httponly', '1');        // Prevents JavaScript access to session cookies
    ini_set('session.cookie_samesite', 'Strict');   // Mitigates CSRF by limiting cross-site cookie usage

    // Start a session securely
    session_start();                                

    // ==============================
    // Anti-XXE: Secure XML Parsing
    // ==============================

    // Disable loading of external entities to prevent XXE attacks
    libxml_disable_entity_loader(true);

    // Suppress libxml errors to allow custom handling
    libxml_use_internal_errors(true);

    /**
     * Securely parses XML strings to prevent XXE vulnerabilities.
     *
     * @param string $xmlString The XML input as a string.
     * @return DOMDocument The parsed DOMDocument object.
     * @throws Exception If parsing fails.
     */
    function parseXMLSecurely($xmlString) {
        $dom = new DOMDocument();

        // Load the XML string securely
        if (!$dom->loadXML($xmlString, LIBXML_NOENT | LIBXML_DTDLOAD | LIBXML_DTDATTR | LIBXML_NOCDATA)) {
            throw new Exception('Error loading XML');
        }

        return $dom;
    }

    // ==============================
    // Example Usage
    // ==============================
    try {
        $xmlString = '<root><element>Sample</element></root>'; // Replace with actual XML input
        $dom = parseXMLSecurely($xmlString);

        // Continue processing $dom...
        echo " ";
    } catch (Exception $e) {
        // Handle XML processing errors securely
        echo 'Error processing XML: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    }
    ?>
    <script type="text/javascript">
        // Disable right-click with an alert
        document.addEventListener('contextmenu', function(event) {
            event.preventDefault();
            alert("Right-click is disabled on this page.");
        });

        // Disable F12 key and Inspect Element keyboard shortcuts with alerts
        document.onkeydown = function(e) {
            // F12
            if (e.key === "F12") {
                alert("F12 (DevTools) is disabled.");
                e.preventDefault(); // Prevent default action
                return false;
            }

            // Ctrl + Shift + I (Inspect)
            if (e.ctrlKey && e.shiftKey && e.key === "I") {
                alert("Inspect Element is disabled.");
                e.preventDefault();
                return false;
            }

            // Ctrl + Shift + J (Console)
            if (e.ctrlKey && e.shiftKey && e.key === "J") {
                alert("Console is disabled.");
                e.preventDefault();
                return false;
            }


            // Ctrl + U or Ctrl + u (View Source)
            if (e.ctrlKey && (e.key === "U" || e.key === "u" || e.keyCode === 85)) {
                alert("Viewing page source is disabled.");
                e.preventDefault();
                return false;
            }
        };
    </script>

    <script>
        (function() {
    const detectDevToolsAdvanced = () => {
        // Detect if the console is open by triggering a breakpoint
        const start = new Date();
        debugger; // This will trigger when dev tools are open
        const end = new Date();
        if (end - start > 100) {
        document.body.innerHTML = "<h1>Unauthorized Access</h1><p>Developer tools are not allowed on this page.</p>";
        document.body.style.textAlign = "center";
        document.body.style.paddingTop = "20%";
        document.body.style.backgroundColor = "#fff";
        document.body.style.color = "#000";
        }
    };

    setInterval(detectDevToolsAdvanced, 500); // Continuously monitor
    })();


    const blockedAgents = ["Cyberfox", "Kali"];
    if (navigator.userAgent.includes(blockedAgents)) {
    document.body.innerHTML = "<h1>Access Denied</h1><p>Your browser is not supported.</p>";
    }


    if (window.__proto__.toString() !== "[object Window]") {
    alert("Unauthorized modification detected.");
    window.location.href = "https://www.bible-knowledge.com/wp-content/uploads/battle-verses-against-demonic-attacks.jpg";
    }

    </script>
    <?php
    $disallowedUserAgents = [
        "BurpSuite", 
        "Cyberfox", 
        "OWASP ZAP", 
        "PostmanRuntime"
    ];

    if (preg_match("/(" . implode("|", $disallowedUserAgents) . ")/i", $_SERVER['HTTP_USER_AGENT'])) {
        http_response_code(403);
        exit("Unauthorized access");
    }
    ?>