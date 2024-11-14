<!DOCTYPE html>
<html lang="en">
    <?php 
    include('header.php');
    include('dbcon.php'); 
    ?>
    <head>    
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Event Organizer Registration</title>
      <link rel="shortcut icon" href="../images/logo copy.png"/>
      <!-- Bootstrap CSS -->
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
            z-index: 1000;
        }
        .modal-content { 
            background: white; 
            margin: 5% auto; 
            padding: 20px; 
            width: 50%; 
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .close { 
            cursor: pointer; 
            float: right; 
            font-size: 24px;
        }
        .close:hover {
            color: #555;
        }
        .password-requirements {
            font-size: 0.85em;
            color: #666;
            margin-top: 5px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 4px;
        }
        .password-requirements ul {
            list-style-type: none;
            padding-left: 0;
            margin-bottom: 0;
        }
        .password-requirements li {
            margin: 5px 0;
            padding-left: 20px;
            position: relative;
        }
        .password-requirements li:before {
            content: '•';
            position: absolute;
            left: 0;
        }
        .invalid {
            color: #dc3545;
        }
        .valid {
            color: #198754;
        }
        .panel {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #f8f9fa;
            padding: 10px 0;
            text-align: center;
        }
        .form-control:focus {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
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
                            <form method="POST" id="registrationForm" onsubmit="return validateForm()">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Basic Information</h4>
                                        <hr />
                                    </div>
                                </div>

                                <div class="row mb-3">
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

                                <div class="row">
                                    <div class="col-md-12">
                                        <h4>Account Security</h4>
                                        <hr />
                                    </div>
                                </div>

                                <div class="row mb-3">
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
                                            <div class="password-requirements">
                                                Password must contain:
                                                <ul>
                                                    <li id="length">8-10 characters</li>
                                                    <li id="uppercase">Exactly 1 uppercase letter</li>
                                                    <li id="lowercase">At least 1 lowercase letter</li>
                                                    <li id="number">At least 1 number</li>
                                                    <li id="symbol">At least 1 special character (!@#$%^&*)</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Re-type Password:</label>
                                            <input id="confirm_password" type="password" name="password2" class="form-control" placeholder="Re-type Password" required>
                                            <div id="password-match" class="mt-2"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="termsCheck" required>
                                            <label class="form-check-label" for="termsCheck">
                                                I agree to the <a href="#" id="openModal">Terms and Conditions</a>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="btn-group pull-right">
                                            <a href="index2.php" class="btn btn-default">Cancel</a>
                                            <button name="register" type="submit" class="btn btn-primary">Register</button>
                                        </div>
                                    </div>
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
                <p><strong>Welcome to MCC Event Judging.</strong></p>
                <p>By using our website and services, you agree to the following terms and conditions:</p>
                <ol>
                    <li>Account Creation: Provide accurate information and maintain account security.</li>
                    <li>System Usage: Use only for MCC event judging; no unlawful or harmful activities.</li>
                    <li>Data Management: Obtain necessary consents, comply with data protection laws, and maintain confidentiality.</li>
                    <li>Event Management: Ensure fair event setups and provide clear guidelines to judges.</li>
                    <li>Intellectual Property: Respect MCC's ownership of system content and materials.</li>
                    <li>Updates: System may be modified; users must use the latest version.</li>
                    <li>Termination: MCC can terminate accounts for violations or at their discretion.</li>
                    <li>Liability: System provided "as is" with no warranties; MCC not liable for certain damages.</li>
                    <li>Changes to Terms: Terms may be modified; continued use implies acceptance.</li>
                    <li>Governing Law: Terms governed by laws of the specified jurisdiction.</li>
                </ol>
                <p>By creating an account, you acknowledge that you have read, understood, and agree to be bound by these terms and conditions.</p>
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <strong>Event Judging System &middot; 2024 &COPY;</strong>
            </div>
        </footer>

        <!-- Scripts -->
        <script src="../assets/js/jquery.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script>
            // Modal handling
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

            // Password validation
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            const passwordMatch = document.getElementById('password-match');
            const form = document.getElementById('registrationForm');

            // Real-time password requirements check
            password.addEventListener('input', function() {
                const pass = password.value;
                
                // Length check (8-10 characters)
                document.getElementById('length').className = 
                    pass.length >= 8 && pass.length <= 10 ? 'valid' : 'invalid';
                
                // Uppercase check (exactly one)
                const uppercaseCount = (pass.match(/[A-Z]/g) || []).length;
                document.getElementById('uppercase').className = 
                    uppercaseCount === 1 ? 'valid' : 'invalid';
                
                // Lowercase check (at least one)
                document.getElementById('lowercase').className = 
                    /[a-z]/.test(pass) ? 'valid' : 'invalid';
                
                // Number check (at least one)
                document.getElementById('number').className = 
                    /[0-9]/.test(pass) ? 'valid' : 'invalid';
                
                // Symbol check (at least one)
                document.getElementById('symbol').className = 
                    /[!@#$%^&*]/.test(pass) ? 'valid' : 'invalid';
            });

            // Password match check
            confirmPassword.addEventListener('input', function() {
                if (password.value === confirmPassword.value) {
                    passwordMatch.innerHTML = 'Passwords match';
                    passwordMatch.className = 'valid';
                } else {
                    passwordMatch.innerHTML = 'Passwords do not match';
                    passwordMatch.className = 'invalid';
                }
            });

            // Form validation
            function validateForm() {
                const pass = password.value;
                
                // Password requirements check
                const isLengthValid = pass.length >= 8 && pass.length <= 10;
                const hasExactlyOneUpper = (pass.match(/[A-Z]/g) || []).length === 1;
                const hasLower = /[a-z]/.test(pass);
                const hasNumber = /[0-9]/.test(pass);
                const hasSymbol = /[!@#$%^&*]/.test(pass);
                
                if (!(isLengthValid && hasExactlyOneUpper && hasLower && hasNumber && hasSymbol)) {
                    alert('Please ensure your password meets all requirements.');
                    return false;
                }
                
                if (password.value !== confirmPassword.value) {
                    alert('Passwords do not match.');
                    return false;
                }
                
                return true;
            }
        </script>

        <?php 
        if (isset($_POST['register'])) {
            $fname = htmlspecialchars($_POST['fname']);
            $mname = htmlspecialchars($_POST['mname']);  
            $lname = htmlspecialchars($_POST['lname']);  
            $username = htmlspecialchars($_POST['username']);  
            $password = htmlspecialchars($_POST['password']);  
            $password2 = htmlspecialchars($_POST['password2']);  
            
            // Server-side password validation
            $passwordRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,10}$/";
            $uppercaseCount = preg_match_all("/[A-Z]/", $password);
            
            if (!preg_match($passwordRegex, $password) || $uppercaseCount !== 1) {
                ?>
                <script>
                    alert('Password does not meet the requirements.');
                </script>
                <?php
                return;
            }

            // Check if username already exists
            $stmt = $conn->prepare("SELECT username FROM organizer WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                ?>
                <script>
                    alert('Username already exists. Please choose a different username.');
                </script>
                <?php
                $stmt->close();
                return;
            }
            $stmt->close();
            
            // Insert new user if passwords match
            if ($password === $password2) {
                // Hash the password before storing
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                $stmt = $conn->prepare("INSERT INTO organizer (fname, mname, lname, username, password, access, status) VALUES (?, ?, ?, ?, ?, 'Organizer', 'offline')");
                $stmt->bind_param("sssss", $fname, $mname, $lname, $username, $hashedPassword);
                
                if ($stmt->execute()) {
                    ?>
                    <script>
                        alert('Organizer <?php echo $fname . " " . $mname . " " . $lname; ?> registered successfully!');
                        window.location = 'index.php';
                    </script>
                    <?php
                } else {
                    ?>
                    <script>
                        alert('Registration failed. Please try again.');
                    </script>
                    <?php
                }
                $stmt->close();
            } else {}
                ?>