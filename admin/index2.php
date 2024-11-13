
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCC Event Judging System - Login</title>
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url(../img/Community-College-Madridejos.jpeg);
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-container {
            background-color: #ffffff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
            max-width: 700px;
            margin: 40px auto;
        }

        .logo-side {
            background-color: #dc3545;  /* Bootstrap's red color */
            color: white;
            padding: 40px;
            text-align: center;
            min-height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .logo-side img {
            max-width: 200px;
            margin-bottom: 20px;
        }

        .login-side {
            background-color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form input {
            height: 40px;
            font-size: 1rem;
            padding-left: 1rem;
            margin-bottom: 1.5rem;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        .login-form button {
            height: 45px;
            font-size: 1.1rem;
            border-radius: 8px;
        }

        .social-login {
            margin-top: 2rem;
            text-align: center;
        }

        .btn-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin: 0 5px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .form-control {
            border: 1px solid #ced4da;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        .btn-primary {
            background-color: #dc3545;
            border-color: #dc3545;
            padding: 10px 30px;
        }

        .btn-primary:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        a {
            color: #dc3545;
            text-decoration: none;
        }

        a:hover {
            color: #c82333;
            text-decoration: underline;
        }

        h2, h4 {
            margin-bottom: 20px;
        }

        .countdown {
            margin-top: 10px;
            font-size: 14px;
            font-weight: bold;
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <div class="row g-0">
                <div class="col-md-6 logo-side">
                    <img src="../img/logo.png" alt="MCC Logo" class="img-fluid">
                    <h4 style="font-size: 18px;" class="mb-4">WELCOME TO:</h4>
                    <h4 style="font-size: 20px;" class="mb-5"><strong>MCC Event Judging System</strong></h4>
                </div>
                <div class="col-md-6 login-side">
                    <h2 style="font-size: 16px;" class="mb-4">ORGANIZER LOGIN</h2>
                    <form id="login-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="login-form">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <button type="submit" class="btn btn-primary px-4">Sign in</button>
                                <span id="countdown" class="countdown"></span>
                            </div>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#forgot-password-modal">Forgot password?</a>
                        </div>
                        <p class="text-center">Don't have an account? <a href="create_account.php">Register</a></p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
    <div class="modal fade" id="forgot-password-modal" tabindex="-1" aria-labelledby="forgot-password-modal-label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="forgot-password-modal-label">Forgot Password?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="clearEmail()"></button>
                </div>
                <div class="modal-body">
                    <form id="forgot-password-form" action="forgot_password.php" method="post" autocomplete="off">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="send">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Get the login form and button
        const loginForm = document.getElementById('login-form');

        // Handle the login success case
        window.onload = function() {
            if (typeof <?php echo isset($_SESSION['login_success']) && $_SESSION['login_success'] == true ? 'true' : 'false'; ?> !== 'undefined' && <?php echo isset($_SESSION['login_success']) && $_SESSION['login_success'] == true ? 'true' : 'false'; ?>) {
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
            }
        };

        // Clear the email input in the forgot password modal
        function clearEmail() {
            document.getElementById("forgot-password-form").reset();
        }

        // Disable right-click, F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });

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