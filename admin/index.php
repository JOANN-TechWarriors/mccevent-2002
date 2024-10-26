<?php 
session_start();
include('dbcon.php');
date_default_timezone_set('Asia/Manila'); 
?>
<!DOCTYPE html>
<html lang="en">
  
<?php
include_once('header2.php');
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCC Event Judging System</title>
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .alert {
            font-size: 14px;
            padding: 8px 12px;
            text-align: center;
            margin: 10px;
            max-width: 600px;
            position: fixed;
            top: 40px;
            right: 20px;
            z-index: 9999;
        }

        .login-container {
            display: flex;
            min-height: 100vh;
            background: url(../img/Community-College-Madridejos.jpeg);
            background-size: cover;
            background-position: center;
        }

        .login-box {
            display: flex;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin: auto;
            width: 90%;
            max-width: 1200px;
            overflow: hidden;
        }

        .logo-section {
            flex: 1;
            background: linear-gradient(to bottom right, #f0f7ff, white);
            padding: 2rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .form-section {
            flex: 1;
            padding: 2rem;
        }

        .logo-image {
            width: 300px;
            height: auto;
            margin-bottom: 2rem;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group input {
            width: 100%;
            padding: 10px 40px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        .input-group i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-login:hover {
            background-color: #2980b9;
        }

        .links {
            text-align: center;
            margin-top: 1rem;
        }

        .links a {
            color: #3498db;
            text-decoration: none;
        }

        .links a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .login-box {
                flex-direction: column;
            }
            
            .logo-section, .form-section {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <!-- Logo Section -->
            <div class="logo-section">
                <img class="logo-image" src="../img/logo.png" alt="MCC Logo">
                <div>
                    <h3 style="color: #666; font-size: 1.2rem; margin-bottom: 0.5rem;">WELCOME TO:</h3>
                    <h2 style="color: #333; font-size: 1.8rem; font-weight: bold;">MCC Event Judging System</h2>
                </div>
            </div>

            <!-- Form Section -->
            <div class="form-section">
                <h2 style="color: #333; font-size: 1.5rem; font-weight: bold; margin-bottom: 2rem;">ORGANIZER LOGIN</h2>
                
                <form id="login-form" method="POST" action="login.php">
                    <div class="input-group">
                        <i class="fas fa-user"></i>
                        <input type="email" name="username" required placeholder="Username" 
                               style="height: 45px;">
                    </div>

                    <div class="input-group">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" required placeholder="Password" 
                               style="height: 45px;">
                    </div>

                    <div style="margin-bottom: 1rem;">
                        <a href="#" data-toggle="modal" data-target="#forgot-password-modal" 
                           style="color: #3498db; text-decoration: none;">
                            Forgot password?
                        </a>
                    </div>

                    <button type="button" id="login-button" class="btn-login">
                        <i class="fas fa-sign-in-alt"></i> Sign in
                    </button>

                    <div class="links">
                        <p>Don't have an account? 
                            <a href="create_account.php">Register here</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal (Keeping your original modal) -->
    <div class="modal fade" id="forgot-password-modal" tabindex="-1" role="dialog" aria-labelledby="forgot-password-modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgot-password-modal-label">Forgot Password?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="clearEmail()">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="forgot-password-form" action="forgot_password.php" method="post" autocomplete="off">
                        <div class="form-group">
                            <label for="email">Email address:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3" name="send">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Keeping your original scripts -->
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap-transition.js"></script>
    <script src="../assets/js/bootstrap-alert.js"></script>
    <script src="../assets/js/bootstrap-modal.js"></script>
    <script src="../assets/js/bootstrap-dropdown.js"></script>
    <script src="../assets/js/bootstrap-scrollspy.js"></script>
    <script src="../assets/js/bootstrap-tab.js"></script>
    <script src="../assets/js/bootstrap-tooltip.js"></script>
    <script src="../assets/js/bootstrap-popover.js"></script>
    <script src="../assets/js/bootstrap-button.js"></script>
    <script src="../assets/js/bootstrap-collapse.js"></script>
    <script src="../assets/js/bootstrap-carousel.js"></script>
    <script src="../assets/js/bootstrap-typeahead.js"></script>
    <script src="../assets/js/bootstrap-affix.js"></script>
    <script src="../assets/js/holder/holder.js"></script>
    <script src="../assets/js/google-code-prettify/prettify.js"></script>
    <script src="../assets/js/application.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Keeping all your original JavaScript
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

        document.getElementById("login-button").addEventListener("click", function() {
            Swal.fire({
                title: "Success!",
                text: "You are successfully logged in!",
                icon: "success",
                confirmButtonText: "Ok",
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("login-form").submit();
                }
            });
        });

        function clearEmail() {
            document.getElementById("forgot-password-form").reset();
        }

        setTimeout(function(){
            var alert = document.querySelector('.alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 3000);

        
    </script>
</body>
</html>