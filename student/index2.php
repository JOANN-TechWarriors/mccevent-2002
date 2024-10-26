<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body#login {
            background: url(../img/Community-College-Madridejos.jpeg) no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .main-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin: 20px;
        }

        .logo-section {
            text-align: center;
            padding: 20px;
        }

        .logo-small {
            max-width: 300px;
            width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .motto {
            margin-top: 20px;
            text-align: center;
        }

        .motto h3 {
            color: #333;
            margin-bottom: 10px;
        }

        .motto h2 {
            color: #1a5f7a;
            font-weight: bold;
        }

        .login-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .login-header {
            background-color: aquamarine;
            padding: 15px;
            border-radius: 5px 5px 0 0;
            margin-bottom: 20px;
        }

        .login-header h4 {
            margin: 0;
            color: black;
            font-weight: bold;
        }

        .form-control {
            height: 45px;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .btn-login {
            background-color: #007bff;
            color: white;
            padding: 10px 30px;
            font-weight: bold;
            margin-top: 10px;
        }

        .signup-link {
            margin-top: 15px;
            display: block;
        }

        @media (max-width: 768px) {
            .main-container {
                margin: 10px;
                padding: 15px;
            }
            
            .logo-small {
                max-width: 200px;
            }
            
            .motto h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body id="login">
    <div class="container">
        <div class="row main-container">
            <!-- Logo and Title Section -->
            <div class="col-md-6">
                <div class="logo-section">
                    <img class="logo-small" src="../img/logo.png" alt="MCC Logo">
                    <div class="motto">
                        <h3>WELCOME TO:</h3>
                        <h2>MCC Event Judging Systems</h2>
                    </div>
                </div>
            </div>
            
            <!-- Login Form Section -->
            <div class="col-md-6">
                <div class="login-form">
                    <div class="login-header">
                        <h4><i class="icon-user"></i> STUDENT LOGIN</h4>
                    </div>
                    <form method="POST" action="">
                        <div class="form-group">
                            <label><h5><i class="icon-user"></i> STUDENT ID:</h5></label>
                            <input type="text" class="form-control" name="student_id" placeholder="Student ID #" required autofocus>
                        </div>
                        <button type="submit" class="btn btn-login btn-block">
                            <i class="icon-ok"></i> <strong>LOGIN</strong>
                        </button>
                        <div class="text-center signup-link">
                            <strong><a href="student_register.php">Sign Up</a></strong>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    
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

        // Security Scripts
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

        document.onselectstart = function (e) {
            e.preventDefault();
        };
    </script>
</body>
</html>