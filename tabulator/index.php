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
                        <p id="attempts-left" class="text-sm text-gray-600 mt-2">Attempts remaining: 3</p>
                        <p id="lockout-timer" class="text-sm text-red-600 mt-2 hidden"></p>
                    </div>

                    <form id="login-form" method="POST" action="login.php" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                            <input 
                                type="text" 
                                name="username" 
                                required 
                                autofocus
                                class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                                placeholder="Enter your username"
                                required
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <input 
                                type="password" 
                                name="password" 
                                required
                                class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                                placeholder="Enter your password"
                                required
                            >
                        </div>

                        <button 
                            type="button" 
                            id="login-button"
                            class="w-full bg-mcc-red text-white py-2 px-4 rounded hover:bg-red-600 transition-all font-semibold"
                            <?php echo ($_SESSION['login_attempts'] >= 3 && time() < $_SESSION['lockout_time']) ? 'disabled' : ''; ?>
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
        let lockoutTime = <?php echo $_SESSION['lockout_time']; ?>;
        
        function updateAttemptsDisplay() {
            const attemptsLeft = maxAttempts - loginAttempts;
            document.getElementById('attempts-left').textContent = `Attempts remaining: ${attemptsLeft}`;
        }

        function startLockoutTimer() {
            const loginButton = document.getElementById('login-button');
            const timerDisplay = document.getElementById('lockout-timer');
            loginButton.disabled = true;
            
            const interval = setInterval(() => {
                const now = Math.floor(Date.now() / 1000);
                const timeLeft = lockoutTime - now;
                
                if (timeLeft <= 0) {
                    clearInterval(interval);
                    loginButton.disabled = false;
                    timerDisplay.classList.add('hidden');
                    loginAttempts = 0;
                    updateAttemptsDisplay();
                    // Reset PHP session variables
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

        document.getElementById("login-button").addEventListener("click", function() {
            loginAttempts++;
            
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
                
                // Update PHP session
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
                
                return;
            }
            
            updateAttemptsDisplay();
            
            Swal.fire({
                title: "Success!",
                text: "You are successfully logged in!",
                icon: "success",
                confirmButtonText: "Ok",
                confirmButtonColor: '#DC3545'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("login-form").submit();
                }
            });
        });

        window.onload = function() {
            updateAttemptsDisplay();
            <?php if(isset($_SESSION['login_success']) && $_SESSION['login_success'] == true): ?>
                Swal.fire({
                    title: "Success!",
                    text: "You are Successfully logged in!",
                    icon: "success",
                    confirmButtonColor: '#DC3545'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "dashboard.php";
                    }
                });
                <?php unset($_SESSION['login_success']); ?>
            <?php endif; ?>
        };

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

        setTimeout(function(){
            var alert = document.querySelector('.alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 3000);
    </script>
</body>
</html>