<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
    include('header.php');
    include('dbcon.php');
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Organizer Registration</title>
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body { 
            font-family: Arial, sans-serif; 
            padding-top: 20px;
        }
        .modal { 
            display: none; 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%; 
            background: rgba(0,0,0,0.5); 
        }
        .modal-content { 
            background: white; 
            margin: 5% auto; 
            padding: 20px; 
            width: 50%; 
            border-radius: 5px;
        }
        .close { 
            cursor: pointer; 
            float: right; 
            font-size: 24px;
            font-weight: bold;
        }
        .close:hover {
            color: red;
        }
        .password-requirements {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f9f9f9;
        }
        .password-requirements ul {
            list-style-type: none;
            padding-left: 15px;
            margin-bottom: 0;
        }
        .requirement-met {
            color: #28a745;
        }
        .requirement-met::before {
            content: '✓ ';
        }
        .requirement-unmet {
            color: #dc3545;
        }
        .requirement-unmet::before {
            content: '✗ ';
        }
        .form-group {
            margin-bottom: 15px;
        }
        .panel {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .footer {
            margin-top: 50px;
            padding: 20px 0;
            background-color: #f5f5f5;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Event Organizer Registration Form</h3>
                    </div>
                    <div class="panel-body">
                        <form method="POST" id="registrationForm">
                            <div class="form-section">
                                <h4>Basic Information</h4>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Firstname:</label>
                                            <input type="text" name="fname" class="form-control" placeholder="Firstname" required autofocus>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Middlename:</label>
                                            <input type="text" name="mname" class="form-control" placeholder="Middlename" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Lastname:</label>
                                            <input type="text" name="lname" class="form-control" placeholder="Lastname" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4>Account Security</h4>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Username:</label>
                                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Password:</label>
                                            <input id="password" type="password" name="password" class="form-control" placeholder="Password" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Re-type Password:</label>
                                            <input id="confirm_password" type="password" name="password2" class="form-control" placeholder="Re-type Password" required>
                                            <span id='message'></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="termsCheck" required>
                                    <label class="form-check-label" for="termsCheck">
                                        I agree to the <a href="#" id="openModal">Terms and Conditions</a>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group text-right">
                                <a href="index2.php" class="btn btn-default">Cancel</a>
                                <button name="register" type="submit" class="btn btn-primary">Register</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-3"></div>
        </div>
    </div>

    <!-- Terms and Conditions Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h4>TERMS AND CONDITIONS</h4>
            <p>
                <b>Welcome to MCC Event Judging.</b><br>
                By using our website and services, you agree to the following terms and conditions:<br><br>
                
                1. Account Creation: Provide accurate information and maintain account security.<br>
                2. System Usage: Use only for MCC event judging; no unlawful or harmful activities.<br>
                3. Data Management: Obtain necessary consents, comply with data protection laws, and maintain confidentiality.<br>
                4. Event Management: Ensure fair event setups and provide clear guidelines to judges.<br>
                5. Intellectual Property: Respect MCC's ownership of system content and materials.<br>
                6. Updates: System may be modified; users must use the latest version.<br>
                7. Termination: MCC can terminate accounts for violations or at their discretion.<br>
                8. Liability: System provided "as is" with no warranties; MCC not liable for certain damages.<br>
                9. Changes to Terms: Terms may be modified; continued use implies acceptance.<br>
                10. Governing Law: Terms governed by laws of the specified jurisdiction.<br><br>

                By creating an account, you acknowledge that you have read, understood, and agree to be bound by these terms and conditions.
            </p>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <span class="text-muted">Event Judging System &middot; 2024 &COPY;</span>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
    <!-- Add SweetAlert JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.7.32/sweetalert2.min.js"></script>

    <script>
        // Modal functionality remains the same
        const modal = document.getElementById("myModal");
        const btn = document.getElementById("openModal");
        const span = document.getElementsByClassName("close")[0];

        btn.onclick = (e) => {
            e.preventDefault();
            modal.style.display = "block";
        }
        span.onclick = () => modal.style.display = "none";
        window.onclick = (event) => {
            if (event.target === modal) modal.style.display = "none";
        }

        // Password validation function remains the same
        function validatePassword(password) {
            const requirements = {
                length: password.length >= 8 && password.length <= 10,
                uppercase: /[A-Z]/.test(password),
                lowercase: /[a-z]/.test(password),
                number: /[0-9]/.test(password),
                special: /[!@#$%^&*]/.test(password)
            };

            Object.keys(requirements).forEach(requirement => {
                const element = document.getElementById(requirement);
                if (requirements[requirement]) {
                    element.classList.add('requirement-met');
                    element.classList.remove('requirement-unmet');
                } else {
                    element.classList.add('requirement-unmet');
                    element.classList.remove('requirement-met');
                }
            });

            return Object.values(requirements).every(Boolean);
        }

        // Real-time password validation
        $('#password').on('keyup', function() {
            validatePassword($(this).val());
        });

        // Password matching validation
        $('#password, #confirm_password').on('keyup', function() {
            const password = $('#password').val();
            const confirmPassword = $('#confirm_password').val();
            const isPasswordValid = validatePassword(password);

            if (!isPasswordValid) {
                $('#message').html('Password requirements not met').css('color', 'red');
                return;
            }

            if (password === confirmPassword) {
                $('#message').html('Passwords Match').css('color', 'green');
            } else {
                $('#message').html('Passwords Do Not Match').css('color', 'red');
            }
        });

        // Updated form submission validation with SweetAlert
        $('#registrationForm').on('submit', function(e) {
            e.preventDefault();
            const password = $('#password').val();
            const confirmPassword = $('#confirm_password').val();

            if (!validatePassword(password)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Password',
                    text: 'Please ensure your password meets all requirements.',
                    confirmButtonColor: '#3085d6'
                });
                return false;
            }

            if (password !== confirmPassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Password Mismatch',
                    text: 'Passwords do not match.',
                    confirmButtonColor: '#3085d6'
                });
                return false;
            }

            if (!$('#termsCheck').is(':checked')) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Terms & Conditions',
                    text: 'Please accept the Terms and Conditions.',
                    confirmButtonColor: '#3085d6'
                });
                return false;
            }

            // If all validations pass, submit the form
            this.submit();
        });
    </script>
</body>
</html>

<?php
if (isset($_POST['register'])) {
    $fname = htmlspecialchars($_POST['fname']);
    $mname = htmlspecialchars($_POST['mname']);
    $lname = htmlspecialchars($_POST['lname']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $password2 = htmlspecialchars($_POST['password2']);

    // Server-side password validation
    $password_regex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,10}$/";

    if (!preg_match($password_regex, $password)) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid Password',
                text: 'Password does not meet requirements. Please ensure it contains 8-10 characters, including uppercase, lowercase, numbers, and special characters.',
                confirmButtonColor: '#3085d6'
            });
        </script>";
        exit;
    }

    try {
        // Check if username already exists
        $check_username = $conn->prepare("SELECT username FROM organizer WHERE username = ?");
        $check_username->execute([$username]);
        
        if ($check_username->rowCount() > 0) {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Username Taken',
                    text: 'Username already exists. Please choose a different username.',
                    confirmButtonColor: '#3085d6'
                });
            </script>";
            exit;
        }

        if ($password === $password2) {
            // Hash password before storing
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new user using PDO
            $stmt = $conn->prepare("INSERT INTO organizer (fname, mname, lname, username, password, access, status) VALUES (?, ?, ?, ?, ?, 'Organizer', 'offline')");
            
            if ($stmt->execute([$fname, $mname, $lname, $username, $hashed_password])) {
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Registration Successful',
                        text: 'Organizer " . $fname . " " . $mname . " " . $lname . " registered successfully!',
                        confirmButtonColor: '#3085d6'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location = 'index2.php';
                        }
                    });
                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Registration Failed',
                        text: 'Registration failed. Please try again.',
                        confirmButtonColor: '#3085d6'
                    });
                </script>";
            }
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Password Mismatch',
                    text: 'Passwords do not match. Please try again.',
                    confirmButtonColor: '#3085d6'
                });
            </script>";
        }
    } catch (PDOException $e) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Database Error',
                text: 'An error occurred. Please try again later.',
                confirmButtonColor: '#3085d6'
            });
        </script>";
        // For debugging (remove in production):
        // error_log($e->getMessage());
    }
}
?>