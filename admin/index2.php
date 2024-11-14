<?php
session_start();
require_once 'dbcon.php'; // Database connection file

// Function to verify reCAPTCHA
function verifyCaptcha($recaptchaResponse) {
    $secretKey = "6LcsOX0qAAAAAN5WeH70ZBF3BM5Fd1_zeuOOA-aL";
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => $secretKey,
        'response' => $recaptchaResponse
    );

    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);
    $responseKeys = json_decode($response, true);

    return $responseKeys["success"];
}

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['g-recaptcha-response'])) {
        $captchaResponse = $_POST['g-recaptcha-response'];
        
        if (verifyCaptcha($captchaResponse)) {
            $username = mysqli_real_escape_string($conn, $_POST['username']);
            $password = $_POST['password'];

            $sql = "SELECT * FROM users WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['login_success'] = true;
                    echo json_encode(['success' => true]);
                    exit();
                }
            }
            echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
        } else {
            echo json_encode(['success' => false, 'message' => 'CAPTCHA verification failed']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Please complete the CAPTCHA']);
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCC Event Judging System - Login</title>
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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

        .captcha-container {
            text-align: center;
            padding: 40px;
            background-color: white;
        }

        .captcha-message {
            margin-bottom: 20px;
            color: #dc3545;
            font-weight: bold;
        }

        #login-content {
            display: none;
        }

        .g-recaptcha {
            display: inline-block;
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

        /* Additional styles from original code */
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
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <!-- CAPTCHA verification section -->
            <div id="captcha-section" class="captcha-container">
                <h4 class="mb-4">Verify you're human</h4>
                <p class="captcha-message">Please complete the CAPTCHA to access the login form</p>
                <div class="g-recaptcha" data-sitekey="YOUR_RECAPTCHA_SITE_KEY" data-callback="onCaptchaSuccess"></div>
            </div>

            <!-- Login content (initially hidden) -->
            <div id="login-content">
                <div class="row g-0">
                    <div class="col-md-6 logo-side">
                        <img src="../img/logo.png" alt="MCC Logo" class="img-fluid">
                        <h4 style="font-size: 18px;" class="mb-4">WELCOME TO:</h4>
                        <h4 style="font-size: 20px;" class="mb-5"><strong>MCC Event Judging System</strong></h4>
                    </div>
                    <div class="col-md-6 login-side">
                        <h2 style="font-size: 16px;" class="mb-4">ORGANIZER LOGIN</h2>
                        <form id="login-form" class="login-form">
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
                            <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                        </form>
                    </div>
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
        // reCAPTCHA callback function
        function onCaptchaSuccess(token) {
            document.getElementById('g-recaptcha-response').value = token;
            document.getElementById('captcha-section').style.display = 'none';
            document.getElementById('login-content').style.display = 'block';
        }

        // Login handling
        const loginForm = document.getElementById('login-form');
        const loginButton = document.getElementById('login-button');
        const countdownElement = document.getElementById('countdown');
        const loginStatus = document.getElementById('login-status');

        // Initialize login attempts counter
        let loginAttempts = parseInt(localStorage.getItem('loginAttempts')) || 0;
        let lockoutEndTime = localStorage.getItem('lockoutEndTime');
        let countdownInterval;

        // Check existing lockout
        function checkExistingLockout() {
            if (lockoutEndTime) {
                const now = new Date().getTime();
                if (now < parseInt(lockoutEndTime)) {
                    loginButton.disabled = true;
                    startCountdown(Math.ceil((parseInt(lockoutEndTime) - now) / 1000));
                } else {
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
                countdownElement.textContent = `Disabled for ${minutes}:${seconds.toString().padStart(2, '0')}`;
                countdown--;

                if (countdown < 0) {
                    clearInterval(countdownInterval);
                    resetLockout();
                }
            }, 1000);
        }

        // Handle login attempt
        async function handleLoginAttempt() {
            const formData = new FormData(loginForm);
            
            if (!formData.get('username').trim() || !formData.get('password').trim()) {
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter your username and password.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            try {
                const response = await fetch('login.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    resetLockout();
                    Swal.fire({
                        title: 'Success!',
                        text: 'You are successfully logged in!',
                        icon: 'success'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'dashboard.php';
                        }
                    });
                } else {
                    loginAttempts++;
                    localStorage.setItem('loginAttempts', loginAttempts);

                    if (loginAttempts >= 3) {
                        loginButton.disabled = true;
                        const lockoutDuration = 180;
                        const lockoutEnd = new Date().getTime() + (lockoutDuration * 1000);
                        localStorage.setItem('lockoutEndTime', lockoutEnd);
                        startCountdown(lockoutDuration);
                        
                        document.getElementById('login-content').style.display = 'none';
                        document.getElementById('captcha-section').style.display = 'block';
                        grecaptcha.reset();

                        Swal.fire({
                            title: 'Account Locked!',
                            text: 'Too many failed attempts. Please try again in 3 minutes.',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.message || 'Invalid credentials',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
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