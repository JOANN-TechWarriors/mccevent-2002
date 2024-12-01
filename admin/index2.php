<?php
$request = $_SERVER['REQUEST_URI'];
if (substr($request, -4) == '.php') {
    $new_url = substr($request, 0, -4);
    header("Location: $new_url", true, 301);
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
            min-width: 120px;
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
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .btn-primary:disabled {
            background-color: #dc3545;
            border-color: #dc3545;
            opacity: 0.65;
        }

        .recaptcha-container {
            display: none;
            margin-bottom: 20px;
        }

        #login-spinner {
            display: none;
            margin-left: 10px;
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
                    <form id="login-form" class="login-form">
                        <div class="mb-3">
                            <input type="email" class="form-control" name="username" placeholder="Username" required autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="recaptcha-container" id="recaptcha-container">
                            <div class="g-recaptcha" data-sitekey="6LcsOX0qAAAAAMHHt5C_j6v9iH2hM6RUduOCmxqe"></div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <button type="button" id="login-button" class="btn btn-primary px-4">
                                <span>Sign in</span>
                                <span id="login-spinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </button>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#forgot-password-modal">Forgot password?</a>
                        </div>
                        <p class="text-center">Don't have an account? <a href="create_account">Register</a></p>
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
                    <form id="forgot-password-form" action="forgot_password" method="post" autocomplete="off">
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
        // Initialize login attempt counter and timer variables
        let loginAttempts = 0;
        const MAX_ATTEMPTS = 3;
        const LOCKOUT_TIME = 180; // 3 minutes in seconds
        let lockoutTimer = null;
        let remainingTime = 0;

        // Function to disable login button
        function disableLoginButton() {
            const loginButton = document.getElementById("login-button");
            loginButton.disabled = true;
            loginButton.classList.add('opacity-50');
        }

        // Function to enable login button
        function enableLoginButton() {
            const loginButton = document.getElementById("login-button");
            loginButton.disabled = false;
            loginButton.classList.remove('opacity-50');
            loginButton.querySelector('span:not(#login-spinner)').textContent = "Sign in";
            document.getElementById('login-spinner').style.display = 'none';
        }

        // Function to update timer display
        function updateTimerDisplay() {
            const minutes = Math.floor(remainingTime / 60);
            const seconds = remainingTime % 60;
            const loginButton = document.getElementById("login-button");
            loginButton.querySelector('span:not(#login-spinner)').textContent = 
                `Wait ${minutes}:${seconds.toString().padStart(2, '0')}`;
        }

        // Function to show reCAPTCHA
        function showRecaptcha() {
            document.getElementById('recaptcha-container').style.display = 'block';
        }

        // Function to verify reCAPTCHA
        function verifyRecaptcha() {
            const response = grecaptcha.getResponse();
            if (!response) {
                Swal.fire({
                    title: "Error!",
                    text: "Please complete the reCAPTCHA verification",
                    icon: "error"
                });
                return false;
            }
            return true;
        }

        // Function to handle lockout timer
        function startLockoutTimer() {
            remainingTime = LOCKOUT_TIME;
            updateTimerDisplay();
            
            lockoutTimer = setInterval(() => {
                remainingTime--;
                updateTimerDisplay();
                
                if (remainingTime <= 0) {
                    clearInterval(lockoutTimer);
                    loginAttempts = 0;
                    enableLoginButton();
                    showRecaptcha(); // Show reCAPTCHA after lockout period
                }
            }, 1000);
        }

        // Function to show loading state
        function showLoading() {
            const loginButton = document.getElementById("login-button");
            loginButton.disabled = true;
            loginButton.querySelector('span:not(#login-spinner)').textContent = "Signing";
            document.getElementById('login-spinner').style.display = 'inline-block';
        }

        // Function to hide loading state
        function hideLoading() {
            const loginButton = document.getElementById("login-button");
            loginButton.disabled = false;
            loginButton.querySelector('span:not(#login-spinner)').textContent = "Sign in";
            document.getElementById('login-spinner').style.display = 'none';
        }

        // Function to clear form fields
        function clearForm() {
            document.querySelector('input[name="username"]').value = '';
            document.querySelector('input[name="password"]').value = '';
            if (grecaptcha) {
                grecaptcha.reset();
            }
        }

        // Handle login button click
        document.getElementById("login-button").addEventListener("click", function(e) {
            e.preventDefault();
            
            const emailInput = document.querySelector('input[name="username"]');
            const passwordInput = document.querySelector('input[name="password"]');
            
            // Basic validation
            if (!emailInput.value || !passwordInput.value) {
                Swal.fire({
                    title: "Error!",
                    text: "Please fill in all fields",
                    icon: "error"
                });
                return;
            }

            // Check if reCAPTCHA is displayed and verify it
            if (document.getElementById('recaptcha-container').style.display === 'block') {
                if (!verifyRecaptcha()) {
                    return;
                }
            }

            // Check if we're in lockout period
            if (loginAttempts >= MAX_ATTEMPTS) {
                disableLoginButton();
                startLockoutTimer();
                clearForm();
                
                Swal.fire({
                    title: "Account Locked!",
                    text: "Too many failed attempts. Please try again in 3 minutes.",
                    icon: "error"
                });
                return;
            }

            // Show loading state
            showLoading();

            // Create form data
            const formData = new FormData();
            formData.append('username', emailInput.value);
            formData.append('password', passwordInput.value);
            
            // Add reCAPTCHA response if visible
            if (document.getElementById('recaptcha-container').style.display === 'block') {
                formData.append('g-recaptcha-response', grecaptcha.getResponse());
            }

            // Send form data to login.php
            fetch('login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(html => {
                // Hide loading state
                hideLoading();

                // Check if the response contains success redirect
                if (html.includes('window.location = \'dashboard.php\'')) {
                    // Successful login
                    loginAttempts = 0;
                    Swal.fire({
                        title: "Success!",
                        text: "You are successfully logged in!",
                        icon: "success",
                        confirmButtonText: "Ok"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'dashboard';
                        }
                    });
                } else {
                    // Failed login
                    loginAttempts++;
                    
                    // Reset reCAPTCHA if visible
                    if (document.getElementById('recaptcha-container').style.display === 'block') {
                        grecaptcha.reset();
                    }

                    // Show reCAPTCHA after second attempt
                    if (loginAttempts >= 2) {
                        showRecaptcha();
                    }
                    
                    // Extract error message from the response
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;
                    const scriptContent = tempDiv.querySelector('script');
                    
                    if (scriptContent && scriptContent.textContent.includes('Swal.fire')) {
                        // Execute the SweetAlert from the response
                        eval(scriptContent.textContent);
                    } else {
                        // Fallback error message
                        Swal.fire({
                            title: "Error!",
                            text: "Invalid username or password",
                            icon: "error"
                        });
                    }

                    // Clear password field
                    passwordInput.value = '';
                    
                    // Check if we should lock the account
                    if (loginAttempts >= MAX_ATTEMPTS) {
                        disableLoginButton();
                        startLockoutTimer();
                        clearForm();
                    }
                }
            })
            .catch(error => {
                hideLoading();
                Swal.fire({
                    title: "Error!",
                    text: "An error occurred. Please try again later.",
                    icon: "error"
                });
            });
        });

        // Security measures
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