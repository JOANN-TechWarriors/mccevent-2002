<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

session_start();

// Function to generate OTP
function generateOTP($length = 6) {
    return substr(str_shuffle("0123456789"), 0, $length);
}

// Function to send OTP via Gmail
function sendOTP($email, $otp, $fname) {
    $mail = new PHPMailer(true);
    
    try {
        // Gmail SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'your-gmail@gmail.com'; // Replace with your Gmail
        $mail->Password = 'your-app-specific-password'; // Replace with your Gmail app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email settings
        $mail->setFrom('your-gmail@gmail.com', 'MCC Event Judging System');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP for MCC Event Judging System Registration';
        
        // Email body
        $mail->Body = "
            <html>
            <body>
                <h2>Welcome to MCC Event Judging System</h2>
                <p>Dear " . htmlspecialchars($fname) . ",</p>
                <p>Your OTP for registration is: <strong>$otp</strong></p>
                <p>This OTP will expire in 10 minutes.</p>
                <p>If you didn't request this OTP, please ignore this email.</p>
                <br>
                <p>Best regards,<br>MCC Event Judging System Team</p>
            </body>
            </html>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>    
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <style>
        body { font-family: Arial, sans-serif; }
        .modal { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); }
        .modal-content { background: white; margin: 5% auto; padding: 20px; width: 50%; }
        .close { cursor: pointer; float: right; }
        .error-message { color: red; font-size: 14px; margin-top: 5px; }
        .success-message { color: green; font-size: 14px; margin-top: 5px; }
        #otpVerificationForm { display: none; }
        .otp-input { 
            letter-spacing: 15px;
            font-size: 20px;
            padding: 10px;
            text-align: center;
            width: 200px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <br><br><br><br>
            <!-- Registration Form -->
            <div class="panel panel-primary" id="registrationPanel">
                <div class="panel-heading">
                    <h3 class="panel-title">Event Organizer Registration Form</h3>
                </div>
                <div class="panel-body">
                    <form method="POST" id="registrationForm">
                        <!-- Your existing form fields -->
                        <table align="center">
                            <!-- Basic Information -->
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
                            
                            <!-- Email -->
                            <tr><td colspan="5">&nbsp;</td></tr>
                            <tr><td colspan="5"><strong>Contact Information</strong><hr /></td></tr>
                            <tr>
                                <td colspan="5">
                                    Email Address:
                                    <input type="email" name="email" class="form-control" placeholder="Enter your Gmail address" required>
                                    <div id="emailError" class="error-message"></div>
                                </td>
                            </tr>
                            
                            <!-- Account Security -->
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
                        <!-- Terms and Conditions -->
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

            <!-- OTP Verification Form -->
            <div class="panel panel-primary" id="otpVerificationForm">
                <div class="panel-heading">
                    <h3 class="panel-title">Email Verification</h3>
                </div>
                <div class="panel-body">
                    <form method="POST" id="otpForm">
                        <div class="text-center">
                            <p>Please enter the OTP sent to your email address:</p>
                            <input type="text" name="otp" class="form-control otp-input" maxlength="6" required>
                            <div id="otpError" class="error-message"></div>
                            <br>
                            <button type="submit" name="verify_otp" class="btn btn-primary">Verify OTP</button>
                            <button type="button" id="resendOTP" class="btn btn-link">Resend OTP</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3"></div>
    </div>

    <!-- Terms and Conditions Modal -->
    <!-- Your existing modal code -->

    <!-- Scripts -->
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
    <script src="javascript/jquery1102.min.js"></script>
    
    <script>
        // Password matching validation
        $('#password, #confirm_password').on('keyup', function () {
            if ($('#password').val() == $('#confirm_password').val()) {
                $('#message').html('Matching').css('color', 'green');
            } else {
                $('#message').html('Not Matching').css('color', 'red');
            }
        });

        // OTP input validation
        $('.otp-input').on('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // Resend OTP
        $('#resendOTP').on('click', function() {
            $.post('resend_otp.php', function(response) {
                alert('New OTP has been sent to your email.');
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

        // Validate Gmail address
        if (!preg_match('/@gmail\.com$/i', $email)) {
            echo "<script>
                document.getElementById('emailError').innerHTML = 'Please use a Gmail address.';
            </script>";
            exit();
        }

        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM organizer WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            echo "<script>
                document.getElementById('emailError').innerHTML = 'This email is already registered.';
            </script>";
            $stmt->close();
            exit();
        }
        $stmt->close();

        // Generate and store OTP
        $otp = generateOTP();
        $_SESSION['registration_otp'] = $otp;
        $_SESSION['registration_data'] = [
            'fname' => $fname,
            'mname' => $mname,
            'lname' => $lname,
            'email' => $email,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];
        $_SESSION['otp_time'] = time();

        // Send OTP
        if (sendOTP($email, $otp, $fname)) {
            echo "<script>
                document.getElementById('registrationPanel').style.display = 'none';
                document.getElementById('otpVerificationForm').style.display = 'block';
            </script>";
        } else {
            echo "<script>
                alert('Failed to send OTP. Please try again.');
            </script>";
        }
    }

    if (isset($_POST['verify_otp'])) {
        $entered_otp = $_POST['otp'];
        
        // Verify OTP
        if (
            isset($_SESSION['registration_otp']) && 
            isset($_SESSION['otp_time']) && 
            $_SESSION['registration_otp'] === $entered_otp && 
            (time() - $_SESSION['otp_time']) <= 600 // 10 minutes
        ) {
            $data = $_SESSION['registration_data'];
            
            // Insert verified user
            $stmt = $conn->prepare("INSERT INTO organizer (fname, mname, lname, email, username, password, verified, access, status) VALUES (?, ?, ?, ?, ?, ?, 1, 'Organizer', 'offline')");
            $stmt->bind_param("ssssss", 
                $data['fname'], 
                $data['mname'], 
                $data['lname'], 
                $data['email'], 
                $data['username'], 
                $data['password']
            );
            
            if ($stmt->execute()) {
                // Clear session data
                unset($_SESSION['registration_otp']);
                unset($_SESSION['registration_data']);
                unset($_SESSION['otp_time']);
                
                echo "<script>
                    alert('Registration successful! You can now login.');
                    window.location = 'index.php';
                </script>";
            } else {
                echo "<script>
                    alert('Registration failed. Please try again.');
                </script>";
            }
            $stmt->close();
        } else {
            echo "<script>
                document.getElementById('otpError').innerHTML = 'Invalid or expired OTP. Please try again.';
            </script>";
        }
    }
    ?>
</body>
</html>