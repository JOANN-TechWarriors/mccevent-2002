<?php 
session_start();
include('../admin/dbcon.php');
date_default_timezone_set('Asia/Manila'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCC Event Judging System - Login</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
    <style>
        /* Custom styles */
        .bg-custom {
            background: url(../img/Community-College-Madridejos.jpeg) center/cover no-repeat;
        }
        
        /* Disable text selection */
        .no-select {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        
        /* Custom animation for fade-in */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>

<body class="bg-custom no-select">
    <div class="min-h-screen flex items-center justify-center p-6 bg-black/50">
        <div class="w-full max-w-6xl bg-white rounded-xl shadow-2xl overflow-hidden flex flex-col md:flex-row fade-in">
            <!-- Left Side - Logo and Title -->
            <div class="w-full md:w-1/2 p-8 bg-gradient-to-br from-teal-50 to-white flex flex-col items-center justify-center">
                <img src="../img/logo.png" alt="MCC Logo" class="w-64 h-auto mb-8">
                <div class="text-center space-y-2">
                    <h3 class="text-xl text-gray-600">WELCOME TO:</h3>
                    <h2 class="text-3xl font-bold text-gray-800">MCC Event Judging System</h2>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full md:w-1/2 p-8 bg-white">
                <div class="w-full max-w-md mx-auto">
                    <div class="bg-aquamarine rounded-lg p-4 mb-6">
                        <h4 class="text-xl font-bold text-gray-800">TABULATOR LOGIN</h4>
                    </div>

                    <form id="login-form" method="POST" action="login.php" class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="icon-user"></i> USERNAME
                            </label>
                            <input 
                                type="text" 
                                name="username" 
                                required 
                                autofocus
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all text-lg"
                                placeholder="Enter your username"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class="icon-lock"></i> PASSWORD
                            </label>
                            <input 
                                type="password" 
                                name="password" 
                                required
                                class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all text-lg"
                                placeholder="Enter your password"
                            >
                        </div>

                        <button 
                            type="button" 
                            id="login-button"
                            class="w-full bg-teal-500 text-white py-3 px-6 rounded-lg hover:bg-teal-600 transition-all font-semibold text-lg flex items-center justify-center gap-2"
                        >
                            <i class="icon-ok"></i>
                            <span>LOGIN</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Login button click handler
        document.getElementById("login-button").addEventListener("click", function() {
            Swal.fire({
                title: "Success!",
                text: "You are successfully logged in!",
                icon: "success",
                confirmButtonText: "Ok",
                confirmButtonColor: '#14b8a6'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById("login-form").submit();
                }
            });
        });

        // Show success message on successful login
        window.onload = function() {
            <?php if(isset($_SESSION['login_success']) && $_SESSION['login_success'] == true): ?>
                Swal.fire({
                    title: "Success!",
                    text: "You are Successfully logged in!",
                    icon: "success",
                    confirmButtonColor: '#14b8a6'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "dashboard.php";
                    }
                });
                <?php unset($_SESSION['login_success']); ?>
            <?php endif; ?>
        };

        // Security measures
    // Disable right-click
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });

        // Disable F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U
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