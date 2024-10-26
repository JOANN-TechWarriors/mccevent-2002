<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCC Event Judging System - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-custom {
            background: url(../img/Community-College-Madridejos.jpeg) center/cover no-repeat;
        }
    </style>
</head>
<body class="bg-custom">
    <div class="min-h-screen flex items-center justify-center bg-black bg-opacity-50"> <!-- Added overlay -->
        <div class="bg-white rounded-xl shadow-lg flex flex-col md:flex-row w-full max-w-4xl m-4">
            <!-- Left Side - Logo and Title -->
            <div class="w-full md:w-1/2 p-8 bg-gradient-to-br from-teal-50 to-white flex flex-col items-center justify-center rounded-l-xl">
                <img src="../img/logo.png" alt="MCC Logo" class="w-64 h-auto mb-8">
                <div class="text-center space-y-2">
                    <h3 class="text-xl text-gray-600">WELCOME TO:</h3>
                    <h2 class="text-3xl font-bold text-gray-800">MCC Event Judging System</h2>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full md:w-1/2 p-8 bg-white rounded-r-xl">
                <div class="max-w-md mx-auto">
                    <h2 class="text-2xl font-bold mb-8 text-gray-800">Judge Log In</h2>
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
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Enter Judge's Code"
                                    >
                                </div>
                            </div>

                            <!-- Show Password Checkbox -->
                            <div class="flex items-center">
                                <input 
                                    type="checkbox" 
                                    id="showPassword" 
                                    onclick="myFunctionJC()"
                                    class="h-4 w-4 text-blue-600 rounded border-gray-300"
                                >
                                <label for="showPassword" class="ml-2 text-sm text-gray-600">
                                    Show Code
                                </label>
                            </div>

                            <!-- Login Button -->
                            <button 
                                type="submit" 
                                class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200"
                            >
                                LOGIN
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