<!-- registration_form.php -->
<!DOCTYPE html>
<html lang="en">
<?php include('../admin/header.php'); ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration Form</title>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
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
            overflow: scroll;
        }
        .close {
            cursor: pointer;
            float: right;
        }
        .error-message {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
        .success-message {
            color: green;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <br><br>
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>STUDENT REGISTRATION FORM</strong></h3>
                </div>
                <div class="panel-body">
                    <!-- Display messages if they exist -->
                    <?php
                    if (isset($_SESSION['error'])) {
                        echo '<div class="error-message">' . $_SESSION['error'] . '</div>';
                        unset($_SESSION['error']);
                    }
                    if (isset($_SESSION['success'])) {
                        echo '<div class="success-message">' . $_SESSION['success'] . '</div>';
                        unset($_SESSION['success']);
                    }
                    ?>
                    <form method="POST" action="register_account.php" id="registrationForm" onsubmit="return validateForm(event)">
                        <table align="center">
                            <tr>
                                <td colspan="5">
                                    <strong>Basic Information</strong>
                                    <hr/>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Firstname:</strong>
                                    <input type="text" name="fname" class="form-control" placeholder="Firstname" required autofocus>
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>Middlename:</strong>
                                    <input type="text" name="mname" class="form-control" placeholder="Middlename" required>
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    <strong>Lastname:</strong>
                                    <input type="text" name="lname" class="form-control" placeholder="Lastname" required>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">&nbsp;</td>
                            </tr>
                            <tr>
                                <td>
                                    <strong>Course:</strong>
                                    <input type="text" name="course" class="form-control" placeholder="Course" required>
                                </td>
                                <td>&nbsp;</td>
                                <td colspan="3">
                                    <strong>Student ID #:</strong>
                                    <input type="text" name="student_id" class="form-control" placeholder="ID #" required>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <strong>Password:</strong>
                                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                                </td>
                            </tr>
                        </table>
                        <br/>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                            <label class="form-check-label" for="flexCheckDefault">
                                <a href="#" id="openModal">Terms and conditions</a>
                            </label>
                        </div>
                        <!-- reCAPTCHA widget -->
                        <div class="g-recaptcha" data-sitekey="6LcsOX0qAAAAAMHHt5C_j6v9iH2hM6RUduOCmxqe" data-callback="enableSubmit"></div>
                        <br/>
                        <div class="btn-group pull-right">
                            <button name="register" type="submit" class="btn btn-primary" id="registerButton" disabled>Register</button>
                            <a href="index.php" type="button" class="btn btn-default">Cancel</a>
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
                <b>TERMS AND CONDITIONS <br>
                Welcome to MCC Event Judging. By using our website and services, you agree to the following terms and
                conditions.</b>
                <br><br>
                1. Account Creation:<br>
                - Only enrolled students can create accounts<br>
                - Accurate information required<br>
                - Users responsible for account security<br>
                - One account per student<br>
                2. Voting Rules:<br>
                - Only registered users can vote<br>
                - Voting within specified periods<br>
                - Fair and unbiased voting required<br>
                - One vote per category per event<br>
                - Votes cannot be changed after submission<br>
                3. Code of Conduct:<br>
                - Respectful behavior mandatory<br>
                - Manipulation of voting system prohibited<br>
                - Appropriate content only<br>
                4. Data Privacy:<br>
                - Personal information collected and stored<br>
                - Data used for event management and system improvement<br>
                - Institution commits to data protection<br>
                5. System Integrity:<br>
                - Administrators can monitor activities<br>
                - Accounts may be suspended for violations<br>
                - Results can be audited and votes disqualified if terms are violated<br>
                6. Modifications:<br>
                - Terms and system may be updated<br>
                - Users will be notified of significant changes<br>
                7. Liability:<br>
                - No guarantee of continuous system availability<br>
                - Institution not liable for result errors<br>
                8. Agreement:<br>
                - Using the system implies acceptance of these terms<br>
                By creating an account, you agreed by the terms and conditions.<br>
            </p>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
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

        // reCAPTCHA callback
        function enableSubmit(response) {
            if (response) {
                document.getElementById('registerButton').disabled = false;
            }
        }

        // Form validation
        function validateForm(event) {
            event.preventDefault();
            
            // Get reCAPTCHA response
            const recaptchaResponse = grecaptcha.getResponse();
            
            if (!recaptchaResponse) {
                alert('Please complete the reCAPTCHA verification');
                return false;
            }

            // If validation passes, submit the form
            document.getElementById('registrationForm').submit();
            return true;
        }
    </script>
</body>
</html>

<!-- register_account.php -->
<?php
session_start();
include('../admin/dbcon.php'); // Include your database connection

// Function to validate reCAPTCHA
function validateRecaptcha($recaptcha_response) {
    $secret_key = "6LcsOX0qAAAAAN5WeH70ZBF3BM5Fd1_zeuOOA-aL"; // Replace with your reCAPTCHA secret key
    
    $url = 'https://www.google.com/recaptcha/api/siteverify';
    $data = array(
        'secret' => $secret_key,
        'response' => $recaptcha_response
    );

    $options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        )
    );

    $context = stream_context_create($options);
    $verify = file_get_contents($url, false, $context);
    $captcha_success = json_decode($verify);

    return $captcha_success->success;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verify reCAPTCHA
    $recaptcha_response = $_POST['g-recaptcha-response'];
    
    if (!validateRecaptcha($recaptcha_response)) {
        $_SESSION['error'] = "reCAPTCHA verification failed. Please try again.";
        header("Location: registration_form.php");
        exit();
    }

    // Get form data
    $fname = mysqli_real_escape_string($connection, $_POST['fname']);
    $mname = mysqli_real_escape_string($connection, $_POST['mname']);
    $lname = mysqli_real_escape_string($connection, $_POST['lname']);
    $course = mysqli_real_escape_string($connection, $_POST['course']);
    $student_id = mysqli_real_escape_string($connection, $_POST['student_id']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Check if student ID already exists
    $check_query = "SELECT * FROM students WHERE student_id = '$student_id'";
    $check_result = mysqli_query($connection, $check_query);
    
    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['error'] = "Student ID already exists. Please use a different ID.";
        header("Location: registration_form.php");
        exit();
    }

    // Insert new student record
    $insert_query = "INSERT INTO students (firstname, middlename, lastname, course, student_id, password) 
                    VALUES ('$fname', '$mname', '$lname', '$course', '$student_id', '$password')";
    
    if (mysqli_query($connection, $insert_query)) {
        $_SESSION['success'] = "Registration successful! You can now login.";
        header("Location: index.php"); // Redirect to login page
        exit();
    } else {
        $_SESSION['error'] = "Registration failed. Please try again. Error: " . mysqli_error($connection);
        header("Location: registration_form.php");
        exit();
    }
} else {
    // If someone tries to access this file directly
    header("Location: registration_form.php");
    exit();
}
?>
