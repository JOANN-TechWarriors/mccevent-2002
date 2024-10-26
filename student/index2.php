<?php 
session_start();
include('../admin/dbcon.php');
date_default_timezone_set('Asia/Manila'); 

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_id = $_POST['student_id'];

    try {
        // Prepare and execute the query
        $stmt = $conn->prepare("SELECT * FROM student WHERE student_id = :student_id");
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch();
        
        if ($stmt->rowCount() > 0) {
            if ($row['request_status'] == '') {
                $_SESSION['login_error'] = "Sorry, Your account is not yet approve by the admin";
            } elseif($row['request_status'] == 'Approved'){
                 // Student exists, start session
                $_SESSION['student_id'] = $student_id;
                $_SESSION['login_success'] = true;
                // Redirect to the login page to trigger JavaScript
                header("Location: index.php");
                exit();
            }
        } else {
            $_SESSION['login_error'] = "Invalid Student ID";
        }
    } catch(PDOException $e) {
        $_SESSION['login_error'] = "Database error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Login - MCC Event Judging System</title>
    
    <!-- Include your existing header -->
    <?php include_once('../admin/header2.php'); ?>
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        /* Custom styles */
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            animation: slideIn 0.5s ease-out;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(0);
            }
        }
        
        /* Prevent text selection */
        .no-select {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        
        /* Background image overlay */
        .bg-overlay {
            background: linear-gradient(rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.9)), 
                        url(../img/Community-College-Madridejos.jpeg);
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="bg-overlay no-select">
    <!-- Alert Messages -->
    <?php if (isset($_SESSION['login_error'])): ?>
        <div class="alert bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
            <p><?php echo $_SESSION['login_error']; ?></p>
        </div>
        <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?>

    <!-- Main Container -->
    <div class="min-h-screen flex items-center justify-center p-4">
        <!-- Login Card -->
        <div class="w-full max-w-6xl bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="flex flex-col md:flex-row">
                <!-- Left Side - Logo and Title -->
                <div class="w-full md:w-1/2 p-8 flex flex-col items-center justify-center bg-gradient-to-br from-blue-50 to-white">
                    <img src="../img/logo.png" alt="MCC Logo" class="w-64 h-auto mb-8">
                    <div class="text-center space-y-2">
                        <h3 class="text-xl text-gray-600">WELCOME TO:</h3>
                        <h2 class="text-3xl font-bold text-gray-800">MCC Event Judging Systems</h2>
                    </div>
                </div>

                <!-- Right Side - Login Form -->
                <div class="w-full md:w-1/2 p-8 bg-white">
                    <div class="max-w-md mx-auto">
                        <div class="bg-aquamarine p-4 rounded-lg mb-6">
                            <h2 class="text-2xl font-bold text-gray-800">Student Login</h2>
                        </div>
                        
                        <form method="POST" action="" class="space-y-6">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">
                                    <i class="icon-user"></i> STUDENT ID
                                </label>
                                <input 
                                    type="text" 
                                    name="student_id" 
                                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg"
                                    placeholder="Enter Student ID #" 
                                    required 
                                    autofocus
                                >
                            </div>

                            <div class="flex items-center justify-between">
                                <button 
                                    type="submit" 
                                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-6 rounded-lg transition duration-200"
                                >
                                    <i class="icon-ok"></i> LOGIN
                                </button>
                            </div>

                            <div class="text-center mt-4">
                                <p class="text-gray-600">
                                    Don't have an account? 
                                    <a href="student_register.php" class="text-blue-500 hover:text-blue-600 font-medium">
                                        Sign Up
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Your existing scripts -->
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap-transition.js"></script>
    <script src="../assets/js/bootstrap-alert.js"></script>
    <script src="../assets/js/bootstrap-modal.js"></script>
    <script src="../assets/js/bootstrap-dropdown.js"></script>
    <script src="../assets/js/bootstrap-scrollspy.js"></script>
    <script src="../assets/js/bootstrap-tab.js"></script>
    <script src="../assets/js/bootstrap-tooltip.js"></script>
    <script src="../assets/js/bootstrap-popover.js"></script>
    <script src="../assets/js/bootstrap-button.js"></script>
    <script src="../assets/js/bootstrap-collapse.js"></script>
    <script src="../assets/js/bootstrap-carousel.js"></script>
    <script src="../assets/js/bootstrap-typeahead.js"></script>
    <script src="../assets/js/bootstrap-affix.js"></script>
    <script src="../assets/js/holder/holder.js"></script>
    <script src="../assets/js/google-code-prettify/prettify.js"></script>
    <script src="../assets/js/application.js"></script>

    <!-- Security Scripts -->


    <!-- Success Alert Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (isset($_SESSION['login_success']) && $_SESSION['login_success'] === true): ?>
                Swal.fire({
                    title: "Success!",
                    text: "You are successfully logged in!",
                    icon: "success",
                    confirmButtonText: "Ok",
                }).then(() => {
                    window.location.href = '../index.php';
                });
                <?php unset($_SESSION['login_success']); ?>
            <?php endif; ?>
        });
    </script>
</body>
</html>