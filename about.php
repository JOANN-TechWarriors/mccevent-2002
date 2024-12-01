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
    <!-- Other meta tags and links -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">



      <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            transition: all 0.4s;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

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

        .about_section {
            padding-top: 100px; /* Added to account for fixed navbar */
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

           /* Banner Section Base Styles */
.banner_section {
    padding-top: 65px; /* Account for fixed navbar */
    position: relative;
    background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('img/Community-College-Madridejos.jpeg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    min-height: 400px;
    width: 100%;
    display: flex;
    align-items: center;
}

.banner_taital_main {
    padding: 20px;
    width: 100%;
    max-width: 1000px;
    margin: 0 auto;
}

.banner_taital {
    color: white;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    font-size: 4rem;
    font-weight: bold;
    margin-bottom: 30px;
    line-height: 1.2;
}
/* Responsive Breakpoints */
@media screen and (max-width: 1200px) {
    .banner_taital {
        font-size: 3.5rem;
    }
}

@media screen and (max-width: 992px) {
    .banner_section {
        min-height: 500px;
    }
    
    .banner_taital {
        font-size: 3rem;
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
        }
      </style>
   </head>
   <body style="background-color: lightgray;">
      <!-- Updated Navigation Bar -->
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
!-- banner section start --> 
<div class="banner_section">
   <div class="container">
      <div id="banner_slider" class="carousel slide" data-ride="carousel">
         <div class="carousel-inner">
            <div class="carousel-item active">
               <div class="banner_taital_main">
                  <div class="container h-75">
                     <div 
                        class="row h-100 align-items-center justify-content-center text-center" 
                        style="height: 100vh; position: relative;">
                        <!-- Adjusted text container -->
                        <div 
                           class="col-lg-10 align-self-center"  
                           style="background: #0000002e; padding: 20px; border-radius: 10px; margin-top: 0; margin-bottom: 0;">
                           <h1 
                              class="text-uppercase text-white font-weight-bold" 
                              style="font-size: 4rem; line-height: 1.2;">
                              About Us
                           </h1>
                           <hr 
                            class="divider my-4" 
                            style="width: 50%; height: 3px; background: lightblue; border: none; margin: 0 auto;" />
                        
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- banner section end -->

      <!-- header section end -->
      <!-- about section start -->
      <div class="about_section layout_padding" style="background: #f8f9fa;">
    <section class="page-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto text-center">
                    <h2 class="about_title mb-3">Welcome to MCC Events</h2>
                    <p class="about_text mb-5">
                        The Madridejos Community College (MCC) Events is your partner in transforming school events. 
                        Our platform streamlines event management with automated judging, live streaming, and audience interaction, 
                        fostering transparency, engagement, and community connection.
                    </p>
                    
                   <h3 class="about_subtitle mb-3">What We Offer:</h3>
<ul class="offer_list mb-5">
    <li>
        <i class="fa fa-check-circle offer_icon"></i> 
        Efficient event organization with real-time updates
    </li>
    <li>
        <i class="fa fa-check-circle offer_icon"></i> 
        Transparent and accurate judging processes
    </li>
    <li>
        <i class="fa fa-check-circle offer_icon"></i> 
        Interactive features like live streaming and audience engagement
    </li>
</ul>
                    <p class="about_text mb-4">
                        Join us in creating memorable and engaging MCC events!
                    </p>
                    
                    <!-- Optional Read More Button -->
                    <!-- <div class="readmore_btn mt-4"><a href="#">Read More</a></div> -->
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .about_section {
        padding: 3rem 0;
        background: #f8f9fa;
    }

    .about_title {
        font-size: 2rem;
        font-weight: 600;
        color:#495057;
    }

    .about_text {
        font-size: 1.5rem;
        color: #495057;
        line-height: 2;
    }

    .about_subtitle {
        font-size: 2rem;
        font-weight: 600;
        color: #495057;
    }
    .offer_list {
        list-style: none;
        padding: 0;
    }

    .offer_list li {
        font-size: 1.1rem;
        color: #343a40;
        margin: 10px 0;
        display: flex;
        align-items: center;
        line-height: 1.6;
    }

    .offer_icon {
        font-size: 1.3rem;
        color: #ffc107;
        margin-right: 10px;
    }

    .offer_list li:hover .offer_icon {
        color: #e0a800;
    }

    .offer_list li:hover {
        color: #495057;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .about_subtitle {
            font-size: 1.5rem;
        }

        .offer_list li {
            font-size: 1rem;
        }

        .offer_icon {
            font-size: 1.1rem;
        }
    }

    
</style>



      <!-- about section end -->
<!-- Your footer content -->
<footer class="footer py-4">
    <div class="container">
        <div class="row text-center text-md-left">
            <!-- Quick Links Section -->
            <div class="col-md-6 mb-4 mt-3">
                <h4 class="text-white">Quick Links</h4>
                <ul class="quick-links list-unstyled">
                    <li><a href="#about"><span class="arrow"> &gt; </span>About Us</a></li>
                    <li><a href="#faqs"><span class="arrow"> &gt; </span>FAQs</a></li>
                    <li><a href="#contact"><span class="arrow"> &gt; </span>Contact Us</a></li>
                    <li><a href="#privacy"><span class="arrow"> &gt; </span>Privacy Policy</a></li>
                    <li><a href="#terms"><span class="arrow"> &gt; </span>Terms and Condition</a></li>
                </ul>
            </div>

            <!-- Contact Section -->
            <div class="col-md-6 mb-4 text-md-right mt-3">
                <h4 class="text-white">Contact Us</h4>
                <p class="text-muted mb-2">
                    <i class="fa fa-phone mr-2"></i>+639453278882
                </p>
                <p class="text-muted mb-2">
                    <i class="fa fa-envelope mr-2"></i>
                    <a href="mailto:joannrebamonte@gmail.com" class="contact-link">joannrebamonte@gmail.com</a>
                </p>
                <div class="social-icons mt-2">
                    <a href="#" class="mr-3"><i class="fa fa-facebook-square fa-lg"></i></a>
                    <a href="#" class="mr-3"><i class="fa fa-twitter-square fa-lg"></i></a>
                    <a href="#" class="mr-3"><i class="fa fa-instagram fa-lg"></i></a>
                    <a href="#" class="mr-3"><i class="fa fa-linkedin-square fa-lg"></i></a> <!-- LinkedIn added -->
                    <a href="#" class="mr-3"><i class="fa fa-youtube-square fa-lg"></i></a> <!-- YouTube added -->
                </div>
            </div>
        </div>
        
</footer>

<style>
    .footer {
        background: #212529 !important;
        color: #f8f9fa;
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    .footer h4 {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }

    .footer p, .footer a {
        font-size: 1rem;
        color: #adb5bd;
    }

    .contact-link {
        color: #ffc107 !important;
        text-decoration: none;
    }

    .contact-link:hover {
        text-decoration: underline;
    }

    .quick-links {
        list-style: none;
        padding: 0;
    }

    .quick-links li {
        margin-bottom: 0.5rem;
    }

    .quick-links a {
        color: #ffc107;
        text-decoration: none;
    }

    .quick-links a:hover {
        text-decoration: underline;
    }

    .quick-links .arrow {
        color: white;
    }

    .social-icons a {
        color: #ffc107;
        text-decoration: none;
        transition: color 0.3s;
        font-size: 1.5rem;
    }

    .social-icons a:hover {
        color: #e0a800;
    }

    @media (max-width: 768px) {
        .footer {
            text-align: center;
        }

        .text-md-left, .text-md-right {
            text-align: center !important;
        }

        .social-icons {
            justify-content: center;
        }
    }
</style>



    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" crossorigin="anonymous"></script>

      <!-- copyright section start -->
      <div class="copyright_section">
         <div class="container">
            <div class="row">
               <div class="col-sm-12 ">
                  <p class="copyright_text"><strong>&COPY; <?= date("Y") ?> MCC Events. All Rights Reserved. </strong></p>
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
        // Mobile menu toggle
        document.getElementById('mediaButton').addEventListener('click', function() {
            document.getElementById('mainListDiv').classList.toggle('show_list');
        });

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
