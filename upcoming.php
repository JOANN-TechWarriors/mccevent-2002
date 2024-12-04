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
   
   <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: all 0.4s;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        /* Navigation Styles */
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

        /* Carousel Styles */
        .client_section {
            padding: 90px 0 50px 0; /* Increased top padding to account for fixed navbar */
        }

        .client_section_2 {
            width: 100%;
            float: left;
            padding: 20px;
        }

        .client_taital_main {
            display: flex;
            align-items: center;
            gap: 300px;
            padding: 20px;
        }

        .client_left img {
            max-width: 400px;
            height: auto;
            object-fit: cover;
        }

        .client_right {
            flex: 1;
            padding: 20px;
        }

        .about_taital {
            font-size: 40px;
            color: #1f1f1f;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
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

        /* Copyright Section */
        .copyright_section {
            width: 100%;
            float: left;
            background-color: #f01c1c;
            height: auto;
            padding: 20px 0;
        }

        .copyright_text {
            width: 100%;
            float: left;
            color: #fff;
            text-align: center;
            font-size: 16px;
            margin: 0;
        }

        /* Responsive Styles */
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
            }

            .client_left img {
                max-width: 100%;
            }
        }
    </style>
   </head>
   <body>
      <!-- Navigation Section -->
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

      <!-- Upcoming Events Section -->
      <?php
        // Database connection setup
        $host = '127.0.0.1';
        $username = 'u510162695_judging_root';
        $password = '1Judging_root';
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

      <!-- Carousel Section -->
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

      <!-- Copyright Section -->
      <div class="copyright_section">
         <div class="container">
            <div class="row">
               <div class="col-sm-12">
                  <p class="copyright_text"><strong>Event Judging System &copy; <?= date("Y") ?></strong></p>
               </div>
            </div>
         </div>
      </div>

      <!-- Javascript files -->
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
      
      <!-- Navigation Toggle Script -->
      <script>
          const mediaButton = document.getElementById('mediaButton');
          const mainListDiv = document.getElementById('mainListDiv');

          mediaButton.addEventListener('click', function() {
              mainListDiv.classList.toggle('show_list');
              mediaButton.classList.toggle('active');
          });
      </script>

<script>
    // Security measures
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