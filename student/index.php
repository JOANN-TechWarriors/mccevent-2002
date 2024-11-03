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
    <title>Organizer Login - MCC Event Judging System</title>
    
    <?php include_once('../admin/header2.php'); ?>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            animation: slideIn 0.5s ease-out;
        }
        
        @keyframes slideIn {
            from { transform: translateX(100%); }
            to { transform: translateX(0); }
        }
        
        .no-select {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        
        .bg-overlay {
            background: url(../img/Community-College-Madridejos.jpeg);
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .bg-overlay::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
        }

        .bg-mcc-red {
            background-color: #DC3545;
        }
    </style>
</head>

<body class="bg-overlay no-select">
    <?php if (isset($_SESSION['login_error'])): ?>
        <div class="alert bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
            <p><?php echo $_SESSION['login_error']; ?></p>
        </div>
        <?php unset($_SESSION['login_error']); ?>
    <?php endif; ?>

    <div class="min-h-screen flex items-center justify-center p-4 relative">
        <div class="w-full max-w-3xl bg-white rounded-lg shadow-2xl overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <!-- Left Side - Logo and Title -->
                <div class="bg-mcc-red p-8 flex flex-col items-center justify-center text-white">
                    <img src="../img/logo.png" alt="MCC Logo" class="w-32 h-auto mb-6">
                    <div class="text-center">
                        <h3 class="text-xl mb-2">WELCOME TO:</h3>
                        <h2 class="text-2xl font-bold">MCC Event Judging System</h2>
                    </div>
                </div>

                <!-- Right Side - Login Form -->
                <div class="bg-white p-8">
                    <div class="max-w-sm mx-auto">
                        <h2 class="text-2xl font-bold text-gray-800 mb-8">STUDENT LOGIN</h2>
                        <form method="POST" action="" class="space-y-6">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">
                                    <i class="icon-user"></i> STUDENT ID
                                </label>
                                <input
                                    type="text" 
                                    name="student_id" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                    placeholder="Enter Student ID #" 
                                    required 
                                    autofocus
                                >
                            </div>

                            <button 
                                type="submit" 
                                class="w-full bg-mcc-red hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200"
                            >
                                <i class="icon-ok"></i> LOGIN
                            </button>

                            <div class="text-center mt-4">
                                <p class="text-gray-600">
                                    Don't have an account? 
                                    <a href="student_register.php" class="text-red-500 hover:text-red-600 font-medium">
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

    <!-- Scripts section remains the same -->
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

    <script>
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