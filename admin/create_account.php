<!DOCTYPE html>
<html lang="en">
<?php 
include('header.php');
include('dbcon.php');

// Function to generate verification token
function generateToken($length = 32) {
    return bin2hex(random_bytes($length));
}

// Function to send verification email
function sendVerificationEmail($email, $token, $fname) {
    $subject = "Verify Your Email - MCC Event Judging System";
    
    // Replace with your actual website URL
    $verificationLink = "http://your-website.com/verify.php?token=" . $token;
    
    $message = "Dear " . htmlspecialchars($fname) . ",\n\n";
    $message .= "Thank you for registering with MCC Event Judging System. Please click the link below to verify your email:\n\n";
    $message .= $verificationLink . "\n\n";
    $message .= "If you didn't register for an account, please ignore this email.\n\n";
    $message .= "Best regards,\nMCC Event Judging System Team";
    
    $headers = "From: noreply@your-website.com";
    
    return mail($email, $subject, $message, $headers);
}
?>

<head>    
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <style>
        body { font-family: Arial, sans-serif; }
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
        .modal-content { background: white; margin: 5% auto; padding: 20px; width: 50%; }
        .close { cursor: pointer; float: right; }
        .error-message { color: red; font-size: 14px; margin-top: 5px; }
        .success-message { color: green; font-size: 14px; margin-top: 5px; }
    </style>
</head>

<body>
    <div class="container">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <br><br><br><br>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Event Organizer Registration Form</h3>
                </div>
                <div class="panel-body">
                    <form method="POST" id="registrationForm">
                        <table align="center">
                            <tr>
                                <td colspan="5"><strong>Basic Information</strong><hr /></td>
                            </tr>
                            <tr>
                                <td>
                                    Firstname:
                                    <input type="text" name="fname" class="form-control" placeholder="Firstname" required autofocus>
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    Middlename:
                                    <input type="text" name="mname" class="form-control" placeholder="Middlename" required>
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    Lastname:
                                    <input type="text" name="lname" class="form-control" placeholder="Lastname" required>
                                </td>
                            </tr>
                            
                            <tr><td colspan="5">&nbsp;</td></tr>
                            <tr><td colspan="5"><strong>Contact Information</strong><hr /></td></tr>
                            <tr>
                                <td colspan="5">
                                    Email Address:
                                    <input type="email" name="email" class="form-control" placeholder="Enter your email address" required>
                                    <div id="emailError" class="error-message"></div>
                                </td>
                            </tr>
                            
                            <tr><td colspan="5">&nbsp;</td></tr>
                            <tr><td colspan="5"><strong>Account Security</strong><hr /></td></tr>
                            <tr>
                                <td>
                                    Username:
                                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                                    <div id="usernameError" class="error-message"></div>
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    Password:
                                    <input id="password" type="password" name="password" class="form-control" placeholder="Password" required>
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    Re-type Password:
                                    <input id="confirm_password" type="password" name="password2" class="form-control" placeholder="Re-type Password" required>
                                    <span id='message'></span>
                                </td>
                            </tr>
                        </table>
                        <br />
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                            <label class="form-check-label" for="flexCheckDefault">
                                <a href="#" id="openModal">Terms and condition</a>
                            </label>
                        </div>
                        <div class="btn-group pull-right">
                            <a href="index2.php" type="button" class="btn btn-default">Cancel</a>
                            <button name="register" type="submit" class="btn btn-primary">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3"></div>
    </div>
    
    <!-- Terms and Conditions Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>
                <b>TERMS AND CONDITIONS<br>
                Welcome to MCC Event Judging.<br>
                By using our website and services, you agree to the following terms and conditions.</b><br>
                <br>
                1. Account Creation: Provide accurate information and maintain account security.<br>
                2. System Usage: Use only for MCC event judging; no unlawful or harmful activities.<br>
                3. Data Management: Obtain necessary consents, comply with data protection laws, and maintain confidentiality.<br>
                4. Event Management: Ensure fair event setups and provide clear guidelines to judges.<br>
                5. Intellectual Property: Respect MCC's ownership of system content and materials.<br>
                6. Updates: System may be modified; users must use the latest version.<br>
                7. Termination: MCC can terminate accounts for violations or at their discretion.<br>
                8. Liability: System provided "as is" with no warranties; MCC not liable for certain damages.<br>
                9. Changes to Terms: Terms may be modified; continued use implies acceptance.<br>
                10. Governing Law: Terms governed by laws of the specified jurisdiction.<br>
                <br>
                By creating an account, you acknowledge that you have read, understood, and agree to be bound by these terms and conditions.
            </p>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <font size="2" class="pull-left"><strong>Event Judging System &middot; 2024 &COPY;</strong></font>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
    <script src="javascript/jquery1102.min.js"></script>
    
    <script>
        // Modal functionality
        const modal = document.getElementById("myModal");
        const btn = document.getElementById("openModal");
        const span = document.getElementsByClassName("close")[0];

        btn.onclick = () => modal.style.display = "block";
        span.onclick = () => modal.style.display = "none";
        window.onclick = (event) => { 
            if (event.target === modal) modal.style.display = "none"; 
        };

        // Password matching validation
        $('#password, #confirm_password').on('keyup', function () {
            if ($('#password').val() == $('#confirm_password').val()) {
                $('#message').html('Matching').css('color', 'green');
            } else {
                $('#message').html('Not Matching').css('color', 'red');
            }
        });

        // Form validation
        $(document).ready(function() {
            $('#registrationForm').on('submit', function(e) {
                if ($('#password').val() != $('#confirm_password').val()) {
                    e.preventDefault();
                    alert('Passwords do not match!');
                    return false;
                }
            });
        });
    </script>

    <?php 
    if (isset($_POST['register'])) {
        $fname = htmlspecialchars($_POST['fname']);
        $mname = htmlspecialchars($_POST['mname']);  
        $lname = htmlspecialchars($_POST['lname']);  
        $email = htmlspecialchars($_POST['email']); 
        $username = htmlspecialchars($_POST['username']);  
        $password = htmlspecialchars($_POST['password']);  
        $password2 = htmlspecialchars($_POST['password2']);
        
        // Generate verification token
        $verification_token = generateToken();
        $verified = 0; // 0 = unverified, 1 = verified
        
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM organizer WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "<script>
                document.getElementById('emailError').innerHTML = 'This email is already registered.';
            </script>";
            $stmt->close();
            exit();
        }
        $stmt->close();
        
        // Check if username already exists
        $stmt = $conn->prepare("SELECT id FROM organizer WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "<script>
                document.getElementById('usernameError').innerHTML = 'This username is already taken.';
            </script>";
            $stmt->close();
            exit();
        }
        $stmt->close();
        
        if ($password == $password2) {
            // Hash password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Insert new user
            $stmt = $conn->prepare("INSERT INTO organizer (fname, mname, lname, email, username, password, verification_token, verified, access, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Organizer', 'offline')");
            $stmt->bind_param("sssssssi", $fname, $mname, $lname, $email, $username, $hashed_password, $verification_token, $verified);
            
            if ($stmt->execute()) {
                // Send verification email
                if (sendVerificationEmail($email, $verification_token, $fname)) {
                    echo "<script>
                        alert('Registration successful! Please check your email to verify your account.');
                        window.location = 'index.php';
                    </script>";
                } else {
                    echo "<script>
                        alert('Registration successful but failed to send verification email. Please contact support.');
                    </script>";
                }
            } else {
                echo "<script>
                    alert('Registration failed. Please try again.');
                </script>";
            }
            $stmt->close();
        } else {
            echo "<script>
                alert('Registration failed. Passwords do not match.');
            </script>";
        }
    }
    ?>
</body>
</html>