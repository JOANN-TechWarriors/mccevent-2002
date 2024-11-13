<?php
// register_account.php

include('../admin/dbcon.php'); // Assuming this has your database connection

// reCAPTCHA configuration
$recaptcha_secret = "6LcsOX0qAAAAAN5WeH70ZBF3BM5Fd1_zeuOOA-aL";
$recaptcha_response = $_POST['g-recaptcha-response'];

function verifyRecaptcha($secret, $response) {
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = [
        'secret' => $secret,
        'response' => $response,
        'remoteip' => $_SERVER['REMOTE_ADDR']
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];

    $context = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captcha_success = json_decode($verify);

    return $captcha_success->success;
}

if(isset($_POST['register'])) {
    // Verify reCAPTCHA first
    if(!verifyRecaptcha($recaptcha_secret, $recaptcha_response)) {
        $_SESSION['error'] = "Please verify that you are not a robot.";
        header("Location: registration.php");
        exit();
    }

    // Sanitize and validate input
    $fname = mysqli_real_escape_string($connection, $_POST['fname']);
    $mname = mysqli_real_escape_string($connection, $_POST['mname']);
    $lname = mysqli_real_escape_string($connection, $_POST['lname']);
    $course = mysqli_real_escape_string($connection, $_POST['course']);
    $student_id = mysqli_real_escape_string($connection, $_POST['student_id']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Check if student ID already exists
    $check_query = "SELECT * FROM students WHERE student_id = '$student_id'";
    $check_result = mysqli_query($connection, $check_query);
    
    if(mysqli_num_rows($check_result) > 0) {
        $_SESSION['error'] = "Student ID already exists!";
        header("Location: registration.php");
        exit();
    }
    
    // Insert new student
    $query = "INSERT INTO students (firstname, middlename, lastname, course, student_id, password, date_registered) 
              VALUES ('$fname', '$mname', '$lname', '$course', '$student_id', '$password', NOW())";
    
    if(mysqli_query($connection, $query)) {
        $_SESSION['success'] = "Registration successful! Please login.";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Error in registration: " . mysqli_error($connection);
        header("Location: registration.php");
        exit();
    }
}
?>

<?php
// registration.php
session_start();
include('../admin/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- Bootstrap CSS (assuming it's included in header.php) -->
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .error-message {
            color: #dc3545;
            margin-bottom: 10px;
        }
        .success-message {
            color: #28a745;
            margin-bottom: 10px;
        }
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }
        .modal-content {
            background: white;
            margin: 5% auto;
            padding: 20px;
            width: 50%;
            max-height: 500px;
            overflow: auto;
        }
        .close {
            cursor: pointer;
            float: right;
        }
        .required {
            color: red;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .g-recaptcha {
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <br><br>
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title"><strong>STUDENT REGISTRATION FORM</strong></h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        if(isset($_SESSION['error'])) {
                            echo '<div class="error-message">' . $_SESSION['error'] . '</div>';
                            unset($_SESSION['error']);
                        }
                        if(isset($_SESSION['success'])) {
                            echo '<div class="success-message">' . $_SESSION['success'] . '</div>';
                            unset($_SESSION['success']);
                        }
                        ?>
                        <form method="POST" action="register_account.php" onsubmit="return validateForm()">
                            <table align="center" class="w-100">
                                <tr>
                                    <td colspan="5">
                                        <strong>Basic Information</strong>
                                        <hr />
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong>Firstname:</strong><span class="required">*</span>
                                        <input type="text" name="fname" class="form-control" placeholder="Firstname" required autofocus>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <strong>Middlename:</strong><span class="required">*</span>
                                        <input type="text" name="mname" class="form-control" placeholder="Middlename" required>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <strong>Lastname:</strong><span class="required">*</span>
                                        <input type="text" name="lname" class="form-control" placeholder="Lastname" required>
                                    </td>
                                </tr>
                                <tr><td colspan="5">&nbsp;</td></tr>
                                <tr>
                                    <td>
                                        <strong>Course:</strong><span class="required">*</span>
                                        <input type="text" name="course" class="form-control" placeholder="Course" required>
                                    </td>
                                    <td>&nbsp;</td>
                                    <td colspan="3">
                                        <strong>Student ID #:</strong><span class="required">*</span>
                                        <input type="text" name="student_id" class="form-control" placeholder="ID #" required>
                                    </td>
                                </tr>
                                <tr><td colspan="5">&nbsp;</td></tr>
                                <tr>
                                    <td colspan="5">
                                        <strong>Password:</strong><span class="required">*</span>
                                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <div class="g-recaptcha" data-sitekey="6LcsOX0qAAAAAMHHt5C_j6v9iH2hM6RUduOCmxqe"></div>
                                    </td>
                                </tr>
                            </table>
                            
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="flexCheckDefault" required>
                                <label class="form-check-label" for="flexCheckDefault">
                                    I agree to the <a href="#" id="openModal">Terms and Conditions</a>
                                </label>
                            </div>
                            
                            <div class="btn-group pull-right">
                                <button name="register" type="submit" class="btn btn-primary">Register</button>
                                <a href="index.php" type="button" class="btn btn-default">Cancel</a>
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
                <b>Welcome to MCC Event Judging. By using our website and services, you agree to the following terms and conditions.</b>
                <br><br>
                1. Account Creation:<br>
                - Only enrolled students can create accounts<br>
                - Accurate information required<br>
                - Users responsible for account security<br>
                - One account per student<br>
                <br>
                2. Voting Rules:<br>
                - Only registered users can vote<br>
                - Voting within specified periods<br>
                - Fair and unbiased voting required<br>
                - One vote per category per event<br>
                - Votes cannot be changed after submission<br>
                <br>
                3. Code of Conduct:<br>
                - Respectful behavior mandatory<br>
                - Manipulation of voting system prohibited<br>
                - Appropriate content only<br>
                <br>
                4. Data Privacy:<br>
                - Personal information collected and stored<br>
                - Data used for event management and system improvement<br>
                - Institution commits to data protection<br>
                <br>
                5. System Integrity:<br>
                - Administrators can monitor activities<br>
                - Accounts may be suspended for violations<br>
                - Results can be audited and votes disqualified if terms are violated<br>
                <br>
                6. Modifications:<br>
                - Terms and system may be updated<br>
                - Users will be notified of significant changes<br>
                <br>
                7. Liability:<br>
                - No guarantee of continuous system availability<br>
                - Institution not liable for result errors<br>
                <br>
                8. Agreement:<br>
                - Using the system implies acceptance of these terms<br>
                <br>
                By creating an account, you agree to these terms and conditions.
            </p>
        </div>
    </div>

    <script>
        // Modal functionality
        const modal = document.getElementById("myModal");
        const btn = document.getElementById("openModal");
        const span = document.getElementsByClassName("close")[0];

        btn.onclick = () => modal.style.display = "block";
        span.onclick = () => modal.style.display = "none";
        window.onclick = (event) => {
            if (event.target === modal) {
                modal.style.display = "none";
            }
        };

        // Form validation
        function validateForm() {
            // Verify reCAPTCHA
            const response = grecaptcha.getResponse();
            if (response.length === 0) {
                alert('Please verify that you are not a robot.');
                return false;
            }

            // Terms and conditions checkbox
            const termsCheckbox = document.getElementById('flexCheckDefault');
            if (!termsCheckbox.checked) {
                alert('Please accept the Terms and Conditions.');
                return false;
            }

            return true;
        }
    </script>

    <!-- Bootstrap and other scripts -->
    <script src="javascript/jquery1102.min.js"></script>
    <script src="../assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>