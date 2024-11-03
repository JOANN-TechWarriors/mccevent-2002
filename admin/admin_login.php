<?php 
session_start();
// Connect to database
$host = '127.0.0.1';
$username = 'u510162695_judging_root';
$password = '1Judging_root';
$dbname = 'u510162695_judging';

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
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
            $msg = "<div class='alert alert-danger'>Incorrect Password!</div>";
        } else {         
            $_SESSION['admin_login'] = true;
            $_SESSION['admin_id'] = $row['id'];
            header('location: admin_dashboard.php');
        }
    } else {
        $msg = "<div class='alert alert-danger'>Admin doesn't exist!</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCC Event Judging System - Admin Login</title>
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url(../img/Community-College-Madridejos.jpeg) no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .main-container {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            margin: 50px auto;
            max-width: 500px;
            min-height: 400px;
        }

        .login-section {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            border: 2px solid #dc3545;
        }

        .login-form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
        }

        .login-form h4 {
            color: #dc3545;
            text-align: center;
            font-weight: bold;
            padding: 10px;
            border-bottom: 2px solid #dc3545;
            margin-bottom: 30px;
        }

        .form-control {
            height: 45px;
            font-size: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #dc3545;
        }

        .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
        }

        .btn-login {
            width: 100%;
            height: 45px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 8px;
            background-color: #dc3545;
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }

        .form-label {
            color: #dc3545;
            font-weight: 500;
        }

        .bi {
            margin-right: 8px;
            color: #dc3545;
        }

        @media (max-width: 768px) {
            .main-container {
                margin: 20px;
            }
        }
    </style>
</head>
<body>
<div class="container">
        <div class="main-container">
            <div class="row">
                <div class="col-12">
                    <div class="login-section">
                        <div class="login-form">
                            <h4 class="mb-4">ADMIN LOGIN</h4>
                            <form method="POST" id="login-form">
                                <div class="mb-3">
                                    <label for="username" class="form-label">
                                        <i class="bi bi-person"></i> Username
                                    </label>
                                    <input type="text" class="form-control" id="username" name="username" 
                                           placeholder="Enter your username" required autofocus>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="password" class="form-label">
                                        <i class="bi bi-lock"></i> Password
                                    </label>
                                    <input type="password" class="form-control" id="password" name="password" 
                                           placeholder="Enter your password" required>
                                </div>
                                
                                <button type="submit" name="admin_login" class="btn btn-login">
                                    <i class="bi bi-box-arrow-in-right"></i> LOGIN
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Success message handling
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

        // Security measures
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        document.onkeydown = function(e) {
            if (e.key === 'F12' || 
                (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J')) || 
                (e.ctrlKey && e.key === 'U')) {
                e.preventDefault();
            }
        };

        document.onselectstart = function(e) {
            e.preventDefault();
        };

        // Hide alert after 3 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.display = 'none';
            });
        }, 3000);
    </script>
</body>
</html>