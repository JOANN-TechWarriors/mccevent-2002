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
            $msg = "<div class='alert alert-danger'>Incorrect Username or Password!</div>";
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
            max-width: 800px;
            min-height: 400px;
            overflow: hidden;
        }

        .logo-section {
            background-color: #DC3545;
            padding: 40px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100%;
            border-radius: 15px 0 0 15px;
            color: white;
        }

        .logo-img {
            max-width: 200px;
            margin-bottom: 30px;
        }

        .system-title {
            margin-top: 20px;
        }

        .welcome-text {
            color: white;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .system-name {
            color: white;
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        .login-section {
            padding: 40px;
            border-radius: 0 15px 15px 0;
            height: 100%;
        }

        .login-form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .form-label {
            color: #333;
            font-weight: 500;
        }

        .form-control {
            border: 1px solid #ced4da;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
            height: auto;
        }

        .form-control:focus {
            border-color: #DC3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .btn-login {
            background-color: #DC3545;
            border-color: #DC3545;
            padding: 12px;
            width: 100%;
            font-weight: 500;
            margin-top: 20px;
            text-transform: uppercase;
        }

        .btn-login:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .register-link {
            text-align: center;
            margin-top: 20px;
        }

        .register-link a {
            color: #DC3545;
            text-decoration: none;
        }

        .register-link a:hover {
            color: #c82333;
            text-decoration: underline;
        }

        .alert {
            margin-bottom: 20px;
            text-align: center;
        }

        @media (max-width: 768px) {
            .main-container {
                margin: 20px;
            }
            
            .logo-section {
                border-radius: 15px 15px 0 0;
                padding: 20px;
            }
            
            .login-section {
                border-radius: 0 0 15px 15px;
            }
            
            .logo-img {
                max-width: 150px;
            }
            
            .system-name {
                font-size: 20px;
            }
        }
    </style>
</head>
<body>
    <br><br>
    <div class="container">
        <div class="main-container">
            <div class="row g-0">
                <!-- Logo and Title Section -->
                <div class="col-md-6">
                    <div class="logo-section">
                        <img src="../img/logo.png" alt="MCC Logo" class="logo-img">
                        <div class="system-title">
                            <h4 style="font-size: 18px;">WELCOME TO:</h4>
                            <h3 style="font-size: 20px;"><strong>MCC Event Judging System</strong></h3>
                        </div>
                    </div>
                </div>
                
                <!-- Login Form Section -->
                <div class="col-md-6">
                    <div class="login-section">
                        <div class="login-form">
                                <h4 style="font-size: 16px;" class="mb-4">ADMIN LOGIN</h4>
                            <?php echo $msg; ?>
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
                                
                                <button type="submit" name="admin_login" class="btn btn-primary btn-login">
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

        
    </script>
</body>
</html>