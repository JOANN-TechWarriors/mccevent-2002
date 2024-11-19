<?php
session_start();
include('../admin/dbcon.php');
date_default_timezone_set('Asia/Manila');

// Handle login POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    
    // Add your authentication logic here
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($con, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $_SESSION['login_success'] = true;
        $_SESSION['username'] = $username;
        echo "success";
        exit;
    } else {
        echo "error";
        exit;
    }
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

        /* Prevent text selection */
        * {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Allow text selection in input fields */
        input {
            -webkit-user-select: text;
            -moz-user-select: text;
            -ms-user-select: text;
            user-select: text;
        }
    </style>
</head>

<body class="bg-custom">
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
                    </div>

                    <form id="login-form" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                            <input 
                                type="text" 
                                name="username" 
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
                                required
                                class="w-full px-4 py-2 rounded border border-gray-300 focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                                placeholder="Enter your password"
                            >
                        </div>

                        <button 
                            type="button" 
                            id="login-button"
                            class="w-full bg-mcc-red text-white py-2 px-4 rounded hover:bg-red-600 transition-all font-semibold"
                        >
                            Sign in
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Login button click handler
        document.getElementById("login-button").addEventListener("click", function() {
            handleLogin();
        });

        // Form submission on Enter key
        document.getElementById("login-form").addEventListener("keypress", function(event) {
            if (event.key === "Enter") {
                event.preventDefault();
                handleLogin();
            }
        });

        function handleLogin() {
            // Get form inputs
            const username = document.querySelector('input[name="username"]').value.trim();
            const password = document.querySelector('input[name="password"]').value.trim();
            
            // Validate inputs
            if (!username || !password) {
                Swal.fire({
                    title: "Error!",
                    text: "Please fill in all fields",
                    icon: "error",
                    confirmButtonText: "Ok",
                    confirmButtonColor: '#DC3545'
                });
                return;
            }
            
            // Create FormData object
            const formData = new FormData();
            formData.append('username', username);
            formData.append('password', password);
            
            // Show loading state
            const loginButton = document.getElementById("login-button");
            loginButton.disabled = true;
            loginButton.textContent = "Signing in...";
            
            // Send POST request
            fetch(window.location.href, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.includes('success')) {
                    Swal.fire({
                        title: "Success!",
                        text: "You are successfully logged in!",
                        icon: "success",
                        confirmButtonText: "Ok",
                        confirmButtonColor: '#DC3545'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "score_sheets.php";
                        }
                    });
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: "Invalid username or password",
                        icon: "error",
                        confirmButtonText: "Ok",
                        confirmButtonColor: '#DC3545'
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: "Error!",
                    text: "An error occurred. Please try again.",
                    icon: "error",
                    confirmButtonText: "Ok",
                    confirmButtonColor: '#DC3545'
                });
            })
            .finally(() => {
                // Reset button state
                loginButton.disabled = false;
                loginButton.textContent = "Sign in";
            });
        }

        // Prevent right-click context menu
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

        // Clear alerts after 3 seconds
        setTimeout(function(){
            var alert = document.querySelector('.alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 3000);
    </script>
</body>
</html>