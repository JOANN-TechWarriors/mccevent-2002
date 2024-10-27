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
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">
      </head>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: all 0.4s;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: lightgray;
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
            color: #1153D0;
            font-family: impact;
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

        /* Main Event Carousel Styles */
        #mainEventCarousel {
            width: 100%;
            height: calc(100vh - 65px);
            margin-top: 65px;
            position: relative;
            overflow: hidden;
        }

        #mainEventCarousel .carousel-inner,
        #mainEventCarousel .carousel-item {
            height: 100%;
            width: 100%;
        }

        #mainEventCarousel .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        #mainEventCarousel .carousel-caption {
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 8px;
            max-width: 800px;
            margin: 0 auto;
            left: 50%;
            transform: translateX(-50%);
            bottom: 20px;
        }

        #mainEventCarousel .carousel-caption h5 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            font-weight: 600;
            color: white;
        }

        #mainEventCarousel .carousel-caption p {
            font-size: 1rem;
            line-height: 1.5;
            margin-bottom: 0.5rem;
        }

        /* Ongoing Events Section */
        .coffee_section {
            padding: 50px 0;
            position: relative;
            z-index: 1;
        }

        .coffee_taital {
            text-align: center;
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .coffee_section_2 {
            margin-top: 30px;
        }

        .coffee_img img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 8px;
        }

        .coffee_box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-top: -30px;
            position: relative;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .types_text {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .looking_text {
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        /* Control Buttons */
        .carousel-control-prev,
        .carousel-control-next {
            width: 10%;
            opacity: 0.8;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 50%;
        }

        /* Mobile Menu Button */
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

        /* Footer */
        .copyright_section {
            background-color: #000000;
            padding: 20px 0;
            color: white;
            text-align: center;
        }

        .copyright_text {
            margin: 0;
            color: white;
        }

        /* Responsive Styles */
        @media screen and (max-width: 1200px) {
            #mainEventCarousel .carousel-caption {
                max-width: 80%;
            }
            
            #mainEventCarousel .carousel-caption h5 {
                font-size: 1.5rem;
            }
        }

        @media screen and (max-width: 992px) {
            #mainEventCarousel {
                height: 70vh;
            }
            
            #mainEventCarousel .carousel-caption h5 {
                font-size: 1.3rem;
            }

            .coffee_taital {
                font-size: 2rem;
            }
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

            #mainEventCarousel {
                height: 60vh;
            }
            
            #mainEventCarousel .carousel-caption {
                position: relative;
                background: rgba(0, 0, 0, 0.8);
                max-width: 100%;
                margin: 0;
                left: 0;
                transform: none;
                border-radius: 0;
            }
            
            #mainEventCarousel .carousel-caption h5 {
                font-size: 1.2rem;
                margin-bottom: 0.5rem;
            }
            
            #mainEventCarousel .carousel-caption p {
                font-size: 0.9rem;
                margin-bottom: 0.3rem;
            }

            .coffee_taital {
                font-size: 1.8rem;
            }
        }

        @media screen and (max-width: 576px) {
            #mainEventCarousel {
                height: 50vh;
            }
            
            #mainEventCarousel .carousel-caption {
                padding: 15px;
            }
            
            #mainEventCarousel .carousel-caption h5 {
                font-size: 1.1rem;
            }
            
            #mainEventCarousel .carousel-caption p {
                font-size: 0.8rem;
            }

            .coffee_taital {
                font-size: 1.5rem;
            }

            .types_text {
                font-size: 1.1rem;
            }

            .looking_text {
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="nav">
        <div class="logo">
            <a href="#">
                <img src="img/logo.png" alt="Logo"> MCC Event
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

    <!-- Main Event Carousel -->
    <div id="mainEventCarousel" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <!-- PHP generated carousel items will go here -->
            <div class="carousel-item active">
                <img src="img/default.jpg" class="d-block w-100" alt="Default Event">
                <div class="carousel-caption d-md-block">
                    <h5>Welcome to MCC Events</h5>
                    <p>Discover our upcoming and ongoing events</p>
                </div>
            </div>
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
                    <!-- PHP generated event items will go here -->
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

    <!-- Footer -->
    <div class="copyright_section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <p class="copyright_text">
                        <strong>Event Judging System &copy; <?php echo date("Y"); ?></strong>
                    </p>
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
        document.getElementById('mainListDiv').classList.toggle('show_list');
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