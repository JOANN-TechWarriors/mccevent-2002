<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MCC Event Judging System - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white rounded-xl shadow-lg flex flex-col md:flex-row w-full max-w-4xl m-4">
            <!-- Left Side - Logo and Title -->
            <div class="w-full md:w-1/2 p-8 bg-gradient-to-br from-teal-50 to-white flex flex-col items-center justify-center">
                <img src="../img/logo.png" alt="MCC Logo" class="w-64 h-auto mb-8">
                <div class="text-center space-y-2">
                    <h3 class="text-xl text-gray-600">WELCOME TO:</h3>
                    <h2 class="text-3xl font-bold text-gray-800">MCC Event Judging System</h2>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="w-full md:w-1/2 p-8">
                <div class="max-w-md mx-auto">
                    <h2 class="text-2xl font-bold mb-8 text-gray-800">Log In</h2>
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

                    <!-- Social Login -->
                    <div class="mt-8">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white text-gray-500">Or login with</span>
                            </div>
                        </div>

                        <div class="mt-6 grid grid-cols-3 gap-3">
                            <button class="flex justify-center items-center py-2 px-4 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <svg class="h-5 w-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </button>
                            <button class="flex justify-center items-center py-2 px-4 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </button>
                            <button class="flex justify-center items-center py-2 px-4 border border-gray-300 rounded-lg hover:bg-gray-50">
                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
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
    </script>
</body>
</html>