<?php 
session_start();
// Connect to database
$host = '127.0.0.1';
$username = 'u510162695_judging_root';
$password = '1Judging_root';  
$dbname = 'u510162695_judging';

$conn = new mysqli($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
date_default_timezone_set('Asia/Manila'); 

$msg = "";
if (isset($_POST['admin_login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $check = "SELECT * FROM admin WHERE username = '$user'";
    $result = mysqli_query($conn, $check);
    $row = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) > 0 ) {
        $hashed_pass = $row['password'];
        if (!password_verify($pass, $hashed_pass)) {
            $msg = "<center><span class='badge bg-danger text-light' style='padding: 6px;'>Incorrect Password!</span></center>";
        } else {         
            $_SESSION['admin_login'] = true;
            $_SESSION['admin_id'] = $row['id'];
            header('location: admin_dashboard.php');
        }
    } else {
        $msg = "<center><span class='badge bg-danger text-light' style='padding: 6px;'>Admin doesn't exist!</span></center>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include_once('header2.php'); ?>
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <style>
        body {
            background: url(../img/Community-College-Madridejos.jpeg) no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .main-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 30px;
            margin: 20px auto;
            width: 80%;
            max-width: 1200px;
            display: flex;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .left-section {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-right: 2px solid #eee;
        }

        .right-section {
            flex: 1;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo-container img {
            width: 200px;
            height: auto;
            margin-bottom: 20px;
        }

        .title-container {
            text-align: center;
        }

        .title-container h3 {
            color: #333;
            margin-bottom: 10px;
        }

        .title-container h2 {
            color: #1a73e8;
            font-weight: bold;
        }

        .login-form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        }

        .login-header {
            background-color: aquamarine;
            color: black;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group h5 {
            margin-bottom: 8px;
            color: #333;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #1a73e8;
            outline: none;
        }

        .btn-primary {
            background-color: #1a73e8;
            border: none;
            padding: 12px 30px;
            border-radius: 5px;
            font-weight: bold;
            width: 100%;
            margin-top: 10px;
        }

        .btn-primary:hover {
            background-color: #1557b0;
        }

        .alert {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Left Section -->
        <div class="left-section">
            <div class="logo-container">
                <img src="../img/logo.png" alt="MCC Logo">
            </div>
            <div class="title-container">
                <h3>WELCOME TO:</h3>
                <h2>MCC Event Judging System</h2>
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <div class="login-form">
                <div class="login-header">
                    <h4>ADMIN LOGIN</h4>
                </div>
                <?= $msg; ?>
                <form id="login-form" method="POST">
                    <div class="form-group">
                        <h5><i class="icon-user"></i> USERNAME:</h5>
                        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
                    </div>
                    <div class="form-group">
                        <h5><i class="icon-lock"></i> PASSWORD:</h5>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                    </div>
                    <button type="submit" name="admin_login" class="btn btn-primary">
                        <i class="icon-ok"></i> <strong>LOGIN</strong>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="..//assets/js/jquery.js"></script>
    <script src="..//assets/js/bootstrap-transition.js"></script>
    <script src="..//assets/js/bootstrap-alert.js"></script>
    <script src="..//assets/js/bootstrap-modal.js"></script>
    <script src="..//assets/js/bootstrap-dropdown.js"></script>
    <script src="..//assets/js/bootstrap-scrollspy.js"></script>
    <script src="..//assets/js/bootstrap-tab.js"></script>
    <script src="..//assets/js/bootstrap-tooltip.js"></script>
    <script src="..//assets/js/bootstrap-popover.js"></script>
    <script src="..//assets/js/bootstrap-button.js"></script>
    <script src="..//assets/js/bootstrap-collapse.js"></script>
    <script src="..//assets/js/bootstrap-carousel.js"></script>
    <script src="..//assets/js/bootstrap-typeahead.js"></script>
    <script src="..//assets/js/bootstrap-affix.js"></script>
    <script src="..//assets/js/holder/holder.js"></script>
    <script src="..//assets/js/google-code-prettify/prettify.js"></script>
    <script src="..//assets/js/application.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        window.onload = function() {
            <?php if(isset($_SESSION['login_success']) && $_SESSION['login_success'] == true): ?>
                Swal.fire({
                    title: "Success!",
                    text: "You are Successfully logged in!",
                    icon: "success"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "dashboard.php";
                    }
                });
                <?php unset($_SESSION['login_success']); ?>
            <?php endif; ?>
        };

        // Hide the alert after 3 seconds
        setTimeout(function(){
            var alert = document.querySelector('.alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 3000);

        eventDefault();
        };
    </script>
</body>
</html>