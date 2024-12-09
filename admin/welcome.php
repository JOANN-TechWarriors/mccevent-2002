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
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <title>MCC Event Judging System - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-custom {
            background: url(../img/Community-College-Madridejos.jpeg) center/cover no-repeat;
        }
        .bg-mcc-red {
            background-color: #DC3545;
        }
    </style>
</head>
<body class="bg-custom">
    <div class="min-h-screen flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg flex flex-col md:flex-row w-full max-w-4xl m-4">
            <!-- Left Side - Logo and Title -->
            <div class="w-full md:w-1/2 p-8 bg-mcc-red flex flex-col items-center justify-center rounded-l-lg text-white">
                <img src="../img/logo.png" alt="MCC Logo" class="w-48 h-auto mb-6">
                <div class="text-center space-y-3">
                    <h3 class="text-xl">WELCOME TO:</h3>
                    <h2 class="text-2xl font-bold">MCC Event Judging System</h2>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full md:w-1/2 p-8 bg-white rounded-r-lg">
                <div class="max-w-md mx-auto">
                    <h2 class="text-xl font-bold mb-8 text-gray-800">JUDGE LOGIN</h2>
                    <form method="POST" action="judge_profile.php">
                        <div class="space-y-6">
                            <!-- Judge Code Input -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Judge's Code</label>
                                <div class="relative">
                                    <input 
                                        type="password" 
                                        name="judge_code" 
                                        id="myInputJC"
                                        class="w-full px-4 py-2 border border-gray-300 rounded focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                        placeholder="Enter Judge's Code"
                                        required
                                    >
                                </div>
                            </div>

                            <!-- Show Password Checkbox -->
                            <div class="flex items-center">
                                <input 
                                    type="checkbox" 
                                    id="showPassword" 
                                    onclick="myFunctionJC()"
                                    class="h-4 w-4 text-red-600 rounded border-gray-300"
                                >
                                <label for="showPassword" class="ml-2 text-sm text-gray-600">
                                    Show Code
                                </label>
                            </div>

                            <!-- Login Button -->
                            <button 
                                type="submit" 
                                class="w-full bg-mcc-red hover:bg-red-600 text-white font-semibold py-2 px-4 rounded transition duration-200"
                            >
                                Sign in
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function myFunctionJC() {
            var x = document.getElementById("myInputJC");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }

        // Security measures
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        document.onkeydown = function(e) {
            if (e.key === 'F12' || 
                (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J')) || 
                (e.ctrlKey && e.key === 'U')) {
                e.preventDefault();
            }
        };

        document.onselectstart = function(e) {
            e.preventDefault();
        };
    </script>
</body>
</html>