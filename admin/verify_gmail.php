<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Include Composer's autoloader

$servername = "127.0.0.1"; // Change if needed
$username = "u510162695_judging_root"; // Replace with your DB username
$password = "1Judging_root"; // Replace with your DB password
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

        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth = true;
            $mail->Username = 'joannrebamonte80@gmail.com'; // Your Gmail address
            $mail->Password = 'dkyd tsnv hzyh amjy'; // Your Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('joannrebamonte80@gmail.com', 'Judging Code');
            $mail->addAddress($email); // Add the recipient's email

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Your Verification Code';
            $mail->Body = 'Your verification code is: <strong>' . $verificationCode . '</strong>';
            $mail->AltBody = 'Your verification code is: ' . $verificationCode;

            $mail->send();
            echo 'Verification code sent to your email.';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        $updateStmt->close();
    } else {
        echo "Email not found.";
    }

    $stmt->close();
}

$conn->close();
?>
