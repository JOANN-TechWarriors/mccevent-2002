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
            background-color: #e9acb3;
            border-color: #e9acb3;
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

        #attempts-counter {
            font-size: 0.9rem;
            color: #dc3545;
            margin-top: 10px;
            text-align: center;
            display: none;
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
                            <input type="email" class="form-control" name="username" id="username" placeholder="Username" required autofocus>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <button type="button" id="login-button" class="btn btn-primary px-4">Sign in</button>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#forgot-password-modal">Forgot password?</a>
                        </div>
                        <div id="attempts-counter"></div>
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
        // Login attempt tracking variables
        let loginAttempts = 0;
        const MAX_ATTEMPTS = 3;
        const LOCKOUT_TIME = 180000; // 3 minutes in milliseconds
        const loginButton = document.getElementById("login-button");
        const attemptsCounter = document.getElementById("attempts-counter");

        // Function to validate email format
        function isValidEmail(email) {
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailPattern.test(email);
        }

        // Function to show remaining attempts
        function updateAttemptsCounter() {
            if (loginAttempts > 0 && loginAttempts < MAX_ATTEMPTS) {
                attemptsCounter.style.display = 'block';
                attemptsCounter.textContent = `${MAX_ATTEMPTS - loginAttempts} attempts remaining`;
            } else {
                attemptsCounter.style.display = 'none';
            }
        }

        // Function to handle failed login attempts
        function handleFailedAttempt() {
            loginAttempts++;
            updateAttemptsCounter();

            if (loginAttempts >= MAX_ATTEMPTS) {
                loginButton.disabled = true;
                attemptsCounter.style.display = 'none';

                Swal.fire({
                    title: "Account Locked",
                    text: "Too many failed attempts. Please wait 3 minutes before trying again.",
                    icon: "warning",
                    confirmButtonText: "Ok"
                });

                setTimeout(() => {
                    loginButton.disabled = false;
                    loginAttempts = 0;
                    updateAttemptsCounter();
                    Swal.fire({
                        title: "Account Unlocked",
                        text: "You can now try logging in again.",
                        icon: "info",
                        confirmButtonText: "Ok"
                    });
                }, LOCKOUT_TIME);
            } else {
                const remainingAttempts = MAX_ATTEMPTS - loginAttempts;
                Swal.fire({
                    title: "Error!",
                    text: `Invalid username or password. ${remainingAttempts} attempts remaining.`,
                    icon: "error",
                    confirmButtonText: "Ok"
                });
            }
        }

        // Function to validate credentials with the server
        async function checkCredentials(username, password) {
            try {
                const formData = new FormData();
                formData.append('username', username);
                formData.append('password', password);

                const response = await fetch('login.php', {
                    method: 'POST',
                    body: formData
                });

                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }

                const data = await response.json();
                return data.success; // Assuming your PHP returns a JSON with a success boolean
            } catch (error) {
                console.error('Error:', error);
                return false;
            }
        }

        // Login button click handler
        loginButton.addEventListener("click", async function(e) {
            e.preventDefault();
            
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();

            // Validate empty fields
            if (!username || !password) {
                Swal.fire({
                    title: "Error!",
                    text: "Please fill in all fields",
                    icon: "error",
                    confirmButtonText: "Ok"
                });
                return;
            }

            // Validate email format
            if (!isValidEmail(username)) {
                Swal.fire({
                    title: "Error!",
                    text: "Please enter a valid email address",
                    icon: "error",
                    confirmButtonText: "Ok"
                });
                return;
            }

            // Check if button is disabled
            if (this.disabled) {
                Swal.fire({
                    title: "Account Locked",
                    text: "Too many failed attempts. Please wait 3 minutes before trying again.",
                    icon: "warning",
                    confirmButtonText: "Ok"
                });
                return;
            }

            try {
                const isValid = await checkCredentials(username, password);
                
                if (isValid) {
                    loginAttempts = 0;
                    updateAttemptsCounter();
                    Swal.fire({
                        title: "Success!",
                        text: "You are successfully logged in!",
                        icon: "success",
                        confirmButtonText: "Ok"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById("login-form").submit();
                        }
                    });
                } else {
                    handleFailedAttempt();
                }
            } catch (error) {
                console.error('Login error:', error);
                Swal.fire({
                    title: "Error!",
                    text: "An error occurred during login. Please try again.",
                    icon: "error",
                    confirmButtonText: "Ok"
                });
            }
        });

        // Clear email function for forgot password modal
        function clearEmail() {
            document.getElementById("forgot-password-form").reset();
        }

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

        // PHP Success message handler
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
    </script>
</body>
</html>