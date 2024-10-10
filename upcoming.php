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
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: all 0.4s;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        }
        .container{
            margin-left: 5%;
            margin-right: 5%;
        }
        .nav{
            width: 100%;
            height: 65px;
            position: fixed;
            line-height: 65px;
            text-align: center;
            background-color: rgba(6, 6, 7, 0.8);
            z-index: 1000;
        }
        .nav div.logo{
            width: 180px;
            height: 10px;
            position: absolute;
        }
        .nav div.logo a{
            text-decoration: none;
            color: #fff;
            font-size: 25px;
            text-transform: uppercase;
        }
        .nav div.logo a:hover {
            color: #c0c0c0;
        }
        .nav div.main_list{
            width: 600px;
            height: 65px;
            float: right;
        }
        .nav div.main_list ul{
            width:100%;
            height: 65px;
            display: flex;
            list-style: none;
        }
        .nav div.main_list ul li{
            width: 120px;
            height: 65px;
        }
        .nav div.main_list ul li a{
            text-decoration: none;
            color: #fff;
            line-height: 65px;
            text-transform: uppercase;
        }
        .nav div.main_list ul li a:hover{
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
        }
        .nav div.media_button button.main_media_button {
            width: 100%;
            height: 100%;
            background-color: transparent;;
            outline: 0;
            border: none;
            cursor: pointer;
        }
        .nav div.media_button button.main_media_button span{
            width: 98%;
            height: 1px;
            display: block;
            background-color: #fff;
            margin-top: 9px;
            margin-bottom: 10px;
        }
        .nav div.media_button button.main_media_button:hover span:nth-of-type(1){
            transform: rotateY(180deg);
            transition: all 0.5s;
            background-color: #c0c0c0;
        }
        .nav div.media_button button.main_media_button:hover span:nth-of-type(2){
            transform: rotateY(180deg);
            transition: all 0.4s;
            background-color: #c0c0c0;
        }
        .nav div.media_button button.main_media_button:hover span:nth-of-type(3){
            transform: rotateY(180deg);
            transition: all 0.3s;
            background-color: #c0c0c0;
        }
        .nav div.media_button button.active span:nth-of-type(1) {
            transform: rotate3d(0, 0, 1, 45deg);
            position: absolute;
            margin: 0;
        }
        .nav div.media_button button.active span:nth-of-type(2) {
            display: none;
        }
        .nav div.media_button button.active span:nth-of-type(3) {
            transform: rotate3d(0, 0, 1, -45deg);
            position: absolute;
            margin: 0;
        }
        .nav div.media_button button.active:hover span:nth-of-type(1) {
            transform: rotate3d(0, 0, 1, 20deg);
        }
        .nav div.media_button button.active:hover span:nth-of-type(3) {
            transform: rotate3d(0, 0, 1, -20deg);
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
    <div class="container">
        <div class="logo">
            <a href="#" style="font-family: impact; color: #1153D0;">
                <img src="img/logo.png" style="height: 40px;  vertical-align: middle;"> MCC Event
            </a>
             <span class="text-light"MCC>
        </div>
        <div class="main_list" id="mainListDiv">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="ongoing.php">Ongoing</a></li>
            <li><a href="upcoming.php">Upcoming</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="blog.php">Live</a></li>
            <li>
                <a href="#login">Login</a>
                <div class="dropdown">
                    <a href="admin/admin_login.php">Admin Login</a>
                    <a href="admin/index.php">Organizer Login</a>
                    <a href="tabulator/index.php">Tabulator Login</a>
                    <a href="judge/index.php">Judge Login</a>
                </div>
            </li>
        </ul>
    </div>
        <div class="media_button">
            <button class="main_media_button" id="mediaButton">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>
</nav>
      <!-- header section end -->


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
            <br><br><br>
        </div>
    </div>
</div>
<!-- client section end -->
<!-- upcoming section end -->

<!-- Add the necessary Bootstrap and jQuery scripts -->
<script src="path/to/jquery.js"></script>
<script src="path/to/bootstrap.js"></script>

      <!-- upcoming section end -->
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
