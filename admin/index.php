<?php 
session_start();
include('dbcon.php');
date_default_timezone_set('Asia/Manila'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCC Event Judging System</title>
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
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

        /* Prevent text selection */
        body {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Custom background with overlay */
        .bg-custom {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                        url('../img/Community-College-Madridejos.jpeg');
            background-size: cover;
            background-position: center;
        }

        /* Custom input focus effect */
        .input-focus:focus {
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        }
    </style>
</head>
<body class="bg-custom min-h-screen">
    <div class="container mx-auto px-4 h-screen flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-6xl flex flex-col md:flex-row overflow-hidden">
            <!-- Left Column -->
            <div class="w-full md:w-1/2 bg-gradient-to-br from-blue-50 to-white p-8 flex flex-col items-center justify-center">
                <img class="w-64 h-auto mb-8" src="../img/logo.png" alt="MCC Logo">
                <div class="text-center">
                    <h3 class="text-gray-600 text-xl mb-2">WELCOME TO:</h3>
                    <h2 class="text-gray-800 text-3xl font-bold">MCC Event Judging System</h2>
                </div>
            </div>

            <!-- Right Column -->
            <div class="w-full md:w-1/2 p-8">
                <div class="max-w-md mx-auto">
                    <h2 class="text-2xl font-bold text-gray-800 mb-8">ORGANIZER LOGIN</h2>
                    
                    <form id="login-form" method="POST" action="login.php">
                        <!-- Username Input -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-semibold mb-2">
                                USERNAME
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input 
                                    type="email" 
                                    name="username" 
                                    required 
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg input-focus focus:outline-none focus:border-blue-500"
                                    placeholder="Enter your username"
                                >
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-semibold mb-2">
                                PASSWORD
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-3 text-gray-400">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input 
                                    type="password" 
                                    name="password" 
                                    required 
                                    class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg input-focus focus:outline-none focus:border-blue-500"
                                    placeholder="Enter your password"
                                >
                            </div>
                        </div>

                        <!-- Forgot Password Link -->
                        <div class="flex items-center justify-between mb-6">
                            <a href="#" 
                               data-toggle="modal" 
                               data-target="#forgot-password-modal" 
                               class="text-blue-500 hover:text-blue-600 text-sm transition duration-200">
                                Forgot password?
                            </a>
                        </div>

                        <!-- Login Button -->
                        <button 
                            type="button"
                            id="login-button"
                            class="w-full bg-blue-500 text-white py-3 rounded-lg hover:bg-blue-600 transition duration-200 font-semibold"
                        >
                            <i class="fas fa-sign-in-alt mr-2"></i> Sign in
                        </button>

                        <!-- Register Link -->
                        <p class="mt-6 text-center text-gray-600 text-sm">
                            Don't have an account? 
                            <a href="create_account.php" class="text-blue-500 hover:text-blue-600 transition duration-200">
                                Register here
                            </a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Forgot Password Modal -->
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

    <!-- Scripts -->
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap-modal.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        // Login success alert
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

        // Login button click handler
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

        // Clear email in forgot password form
        function clearEmail() {
            document.getElementById("forgot-password-form").reset();
        }

        // Hide alert after 3 seconds
        setTimeout(function(){
            var alert = document.querySelector('.alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 3000);

        
    </script>
</body>
</html>