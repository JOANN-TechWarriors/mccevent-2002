<?php 
session_start();
include('../admin/dbcon.php');
date_default_timezone_set('Asia/Manila'); 

// Initialize attempts if not set
if (!isset($_SESSION['login_attempts'])) {
    $_SESSION['login_attempts'] = 0;
}
if (!isset($_SESSION['lockout_time'])) {
    $_SESSION['lockout_time'] = 0;
}

// Clear previous login attempts if lockout time has passed
if ($_SESSION['lockout_time'] < time()) {
    $_SESSION['login_attempts'] = 0;
    $_SESSION['lockout_time'] = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCC Event Judging System - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <style>
        .bg-custom {
            background: url(../img/Community-College-Madridejos.jpeg) center/cover no-repeat;
        }
        
        .no-select {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        .bg-mcc-red {
            background-color: #DC3545;
        }

        .disabled-button {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
</head>

<body class="bg-custom no-select">
    <div class="min-h-screen flex items-center justify-center p-6 bg-black/50">
        <div class="w-full max-w-4xl bg-white rounded-lg shadow-2xl overflow-hidden flex flex-col md:flex-row fade-in">
            <!-- Left Side - Logo and Title -->
            <div class="w-full md:w-1/2 bg-mcc-red p-8 flex flex-col items-center justify-center text-white">
                <img src="../img/logo.png" alt="MCC Logo" class="w-48 h-auto mb-6">
                <div class="text-center space-y-3">
                    <h3 class="text-xl font-light">WELCOME TO:</h3>
                    <h2 class="text-2xl font-bold">MCC Event Judging System</h2>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full md:w-1/2 bg-white p-8">
                <div class="w-full max-w-md mx-auto">
                    <div class="mb-8">
                        <h4 class="text-xl font-bold text-gray-800">ORGANIZER LOGIN</h4>
                        <p id="attempts-left" class="text-sm text-gray-600 mt-2">Attempts remaining: <?php echo 3 - $_SESSION['login_attempts']; ?></p>
                        <p id="lockout-timer" class="text-sm text-red-600 mt-2 <?php echo ($_SESSION['lockout_time'] > time()) ? '' : 'hidden'; ?>"></p>
                    </div>

                    <form id="login-form" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                            <input 
                                type="text" 
                                name="username" 
                                id="username"
                                required 
                                autofocus
                                class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                                placeholder="Enter your username"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <input 
                                type="password" 
                                name="password" 
                                id="password"
                                required
                                class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                                placeholder="Enter your password"
                            >
                        </div>

                        <button 
                            type="button" 
                            id="login-button"
                            class="w-full bg-mcc-red text-white py-2 px-4 rounded hover:bg-red-600 transition-all font-semibold"
                            <?php echo ($_SESSION['lockout_time'] > time()) ? 'disabled' : ''; ?>
                        >
                            Sign in
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let loginAttempts = <?php echo $_SESSION['login_attempts']; ?>;
        const maxAttempts = 3;
        const lockoutDuration = 180; // 3 minutes in seconds
        let lockoutTime = <?php echo ($_SESSION['lockout_time'] > time()) ? $_SESSION['lockout_time'] : 0; ?>;
        
        function updateAttemptsDisplay() {
            const attemptsLeft = maxAttempts - loginAttempts;
            document.getElementById('attempts-left').textContent = `Attempts remaining: ${attemptsLeft}`;
        }

        function startLockoutTimer() {
            const loginButton = document.getElementById('login-button');
            const timerDisplay = document.getElementById('lockout-timer');
            loginButton.disabled = true;
            loginButton.classList.add('disabled-button');
            
            const interval = setInterval(() => {
                const now = Math.floor(Date.now() / 1000);
                const timeLeft = lockoutTime - now;
                
                if (timeLeft <= 0) {
                    clearInterval(interval);
                    loginButton.disabled = false;
                    loginButton.classList.remove('disabled-button');
                    timerDisplay.classList.add('hidden');
                    loginAttempts = 0;
                    updateAttemptsDisplay();
                    fetch('reset_attempts.php');
                } else {
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;
                    timerDisplay.textContent = `Account locked. Try again in ${minutes}:${seconds.toString().padStart(2, '0')}`;
                    timerDisplay.classList.remove('hidden');
                }
            }, 1000);
        }

        // Check if currently in lockout
        if (lockoutTime > Math.floor(Date.now() / 1000)) {
            startLockoutTimer();
        }

        document.getElementById("login-button").addEventListener("click", async function(e) {
            e.preventDefault();
            
            if (loginAttempts >= maxAttempts) {
                return;
            }

            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;

            // Basic validation
            if (!username || !password) {
                Swal.fire({
                    title: "Error!",
                    text: "Please enter both username and password",
                    icon: "error",
                    confirmButtonText: "Ok",
                    confirmButtonColor: '#DC3545'
                });
                return;
            }
            
            const formData = new FormData();
            formData.append('username', username);
            formData.append('password', password);

            try {
                const response = await fetch('login.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();
                
                if (data.success) {
                    // Reset attempts on successful login
                    loginAttempts = 0;
                    updateAttemptsDisplay();
                    
                    Swal.fire({
                        title: "Success!",
                        text: "You are successfully logged in!",
                        icon: "success",
                        confirmButtonText: "Ok",
                        confirmButtonColor: '#DC3545'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = data.redirect;
                        }
                    });
                } else {
                    loginAttempts++;
                    updateAttemptsDisplay();
                    
                    if (loginAttempts >= maxAttempts) {
                        lockoutTime = Math.floor(Date.now() / 1000) + lockoutDuration;
                        
                        Swal.fire({
                            title: "Account Locked!",
                            text: "Too many failed attempts. Please try again in 3 minutes.",
                            icon: "error",
                            confirmButtonText: "Ok",
                            confirmButtonColor: '#DC3545'
                        });
                        
                        startLockoutTimer();
                        
                        fetch('update_lockout.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                attempts: loginAttempts,
                                lockoutTime: lockoutTime
                            })
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: "Invalid Username or Password",
                            icon: "error",
                            confirmButtonText: "Ok",
                            confirmButtonColor: '#DC3545'
                        });
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    title: "Error!",
                    text: "An error occurred during login",
                    icon: "error",
                    confirmButtonText: "Ok",
                    confirmButtonColor: '#DC3545'
                });
            }
        });

        // Prevent right-click
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });

        // Prevent developer tools shortcuts
        document.onkeydown = function (e) {
            if (
                e.key === 'F12' ||
                (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J')) ||
                (e.ctrlKey && e.key === 'U')
            ) {
                e.preventDefault();
            }
        };

        // Allow Enter key to trigger login
        document.getElementById('password').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('login-button').click();
            }
        });
    </script>
</body>
</html>