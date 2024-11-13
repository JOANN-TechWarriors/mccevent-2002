<?php
// Database connection
$servername = "127.0.0.1"; // Change if needed
$username = "u510162695_judging"; // Replace with your DB username
$password = ""; // Replace with your DB password
$dbname = "u510162695_judging"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to generate a 6-digit verification code
function generateVerificationCode() {
    return str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
}

// Handling the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Check if the email is in the database
    $stmt = $conn->prepare("SELECT id FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email exists, generate a verification code
        $verificationCode = generateVerificationCode();

        // Update the verification code in the database
        $updateStmt = $conn->prepare("UPDATE admin SET code = ?, token_expiration = DATE_ADD(NOW(), INTERVAL 15 MINUTE) WHERE email = ?");
        $updateStmt->bind_param("ss", $verificationCode, $email);
        $updateStmt->execute();

        // Send the code to the user's email
        $subject = "Your Verification Code";
        $message = "Your verification code is: " . $verificationCode;
        $headers = "From: no-reply@example.com"; // Replace with your domain's email

        if (mail($email, $subject, $message, $headers)) {
            echo "Verification code sent to your email.";
        } else {
            echo "Failed to send email. Please try again.";
        }

        $updateStmt->close();
    } else {
        echo "Email not found.";
    }

    $stmt->close();
}

$conn->close();
?>
