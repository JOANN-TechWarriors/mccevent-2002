<?php 
session_start();
include('../admin/dbcon.php');
date_default_timezone_set('Asia/Manila'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCC Event Judging System - Login</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert2 -->
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                        url(../img/Community-College-Madridejos.jpeg) center/cover no-repeat;
            min-height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .main-container {
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 800px;
            margin: 2rem auto;
            display: flex;
        }

        .left-side {
            background-color: #dc3545;
            color: white;
            padding: 2rem;
            width: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .right-side {
            background-color: white;
            padding: 2rem;
            width: 50%;
        }

        .logo {
            width: 200px;
            height: auto;
            margin-bottom: 1.5rem;
        }

        .welcome-text {
            margin-bottom: 0.5rem;
            font-size: 1.2rem;
        }

        .system-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
        }

        .login-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 2rem;
            color: #333;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .btn-login {
            width: 100%;
            padding: 0.75rem;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-login:hover {
            background-color: #c82333;
        }

        .forgot-password {
            color: #dc3545;
            text-decoration: none;
            font-size: 0.9rem;
            margin-top: 1rem;
            display: block;
            text-align: right;
        }

        .register-link {
            text-align: center;
            margin-top: 1.5rem;
        }

        .register-link a {
            color: #dc3545;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
                margin: 1rem;
            }

            .left-side, .right-side {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="main-container">
            <!-- Left Side -->
            <div class="left-side">
                <img src="../img/logo.png" alt="MCC Logo" class="logo">
                <div class="welcome-text">WELCOME TO:</div>
                <div class="system-title">MCC Event Judging System</div>
            </div>

            <!-- Right Side -->
            <div class="right-side">
                <h2 class="login-title">TABULATOR LOGIN</h2>
                <form>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn-login">Sign in</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Login button click handler
        document.getElementById("login-button").addEventListener("click", function() {
            Swal.fire({
                title: "Success!",
                text: "You are successfully logged in!",
                icon: "success",
                confirmButtonText: "Ok",
                confirmButtonColor: '#14b8a6'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("login-form").submit();
                }
            });
        });

        // Show success message on successful login
        window.onload = function() {
            <?php if(isset($_SESSION['login_success']) && $_SESSION['login_success'] == true): ?>
                Swal.fire({
                    title: "Success!",
                    text: "You are Successfully logged in!",
                    icon: "success",
                    confirmButtonColor: '#14b8a6'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "dashboard.php";
                    }
                });
                <?php unset($_SESSION['login_success']); ?>
            <?php endif; ?>
        };

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

        // Hide the alert after 3 seconds
        setTimeout(function(){
            var alert = document.querySelector('.alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 3000);
    </script>
</body>
</html>