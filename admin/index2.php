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
            background-color: #dc3545;
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

        .btn-primary:disabled {
            background-color: #e9a2a9;
            border-color: #e9a2a9;
            cursor: not-allowed;
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
            display: block;
        }

        .login-status {
            margin-top: 10px;
            text-align: center;
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
                    <form id="login-form" method="POST" action="login.php" class="login-form">
                        <div class="mb-3">
                            <input type="email" class="form-control" name="username" placeholder="Username" required autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <button type="button" id="login-button" class="btn btn-primary px-4">Sign in</button>
                                <span id="countdown" class="countdown"></span>
                            </div>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#forgot-password-modal">Forgot password?</a>
                        </div>
                        <p class="text-center">Don't have an account? <a href="create_account.php">Register</a></p>
                        <div id="login-status" class="login-status"></div>
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
        const loginButton = document.getElementById('login-button');
        const countdownElement = document.getElementById('countdown');
        const loginStatus = document.getElementById('login-status');

        // Initialize login attempts counter
        let loginAttempts = parseInt(localStorage.getItem('loginAttempts')) || 0;
        let lockoutEndTime = localStorage.getItem('lockoutEndTime');
        let countdownInterval;

        // Check if there's an existing lockout
        function checkExistingLockout() {
            if (lockoutEndTime) {
                const now = new Date().getTime();
                if (now < parseInt(lockoutEndTime)) {
                    // Lock is still active
                    loginButton.disabled = true;
                    startCountdown(Math.ceil((parseInt(lockoutEndTime) - now) / 1000));
                } else {
                    // Lock has expired
                    resetLockout();
                }
            }
        }

        // Reset lockout state
        function resetLockout() {
            loginAttempts = 0;
            localStorage.setItem('loginAttempts', loginAttempts);
            localStorage.removeItem('lockoutEndTime');
            loginButton.disabled = false;
            countdownElement.textContent = '';
            if (countdownInterval) {
                clearInterval(countdownInterval);
            }
        }

        // Start countdown timer
        function startCountdown(duration) {
            let countdown = duration;
            if (countdownInterval) {
                clearInterval(countdownInterval);
            }
            
            countdownInterval = setInterval(() => {
                const minutes = Math.floor(countdown / 60);
                const seconds = countdown % 60;
                countdownElement.textContent = `Disabled for ${minutes}:${seconds.toString().padStart(3, '0')}`;
                countdown--;

                if (countdown < 0) {
                    clearInterval(countdownInterval);
                    resetLockout();
                }
            }, 1000);
        }

        // Handle login attempt
        function handleLoginAttempt() {
            const username = loginForm.elements.username.value;
            const password = loginForm.elements.password.value;

            if (username.trim() === '' || password.trim() === '') {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter your username and password.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            loginAttempts++;
            localStorage.setItem('loginAttempts', loginAttempts);

            if (loginAttempts >= 3) {
                // Lock out for 2 minutes
                loginButton.disabled = true;
                const lockoutDuration = 120; // 2 minutes in seconds
                const lockoutEnd = new Date().getTime() + (lockoutDuration * 1000);
                localStorage.setItem('lockoutEndTime', lockoutEnd);
                startCountdown(lockoutDuration);
                
                Swal.fire({
                    title: 'Account Locked!',
                    text: 'Too many failed attempts. Please try again in 2 minutes.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
            } else {
                // Submit the form
                loginForm.submit();
            }
        }

        // Add event listeners
        loginButton.addEventListener('click', handleLoginAttempt);

        // Check for existing lockout on page load
        document.addEventListener('DOMContentLoaded', checkExistingLockout);

        // Clear lockout state when login is successful
        window.onload = function() {
            if (typeof <?php echo isset($_SESSION['login_success']) && $_SESSION['login_success'] == true ? 'true' : 'false'; ?> !== 'undefined' && <?php echo isset($_SESSION['login_success']) && $_SESSION['login_success'] == true ? 'true' : 'false'; ?>) {
                resetLockout();
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
    </script>
</body>
</html>