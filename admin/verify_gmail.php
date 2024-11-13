<?php
// Database configuration
$db_host = '127.0.0.1';
$db_user = 'u510162695_judging';
$db_pass = 'u510162695_judging_root';
$db_name = '1Judging_root';

// Email configuration (using PHPMailer)
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Make sure PHPMailer is installed via composer

// Function to generate 6-digit code
function generateVerificationCode() {
    return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
}

// Function to send verification email
function sendVerificationEmail($email, $code) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Replace with your SMTP host
        $mail->SMTPAuth   = true;
        $mail->Username = 'joannrebamonte80@gmail.com'; // Your Gmail address
        $mail->Password = 'dkyd tsnv hzyh amjy'; // Your Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('joannrebamonte80@gmail.com', 'Admin Verification');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Verification Code';
        $mail->Body    = "
            <div style='font-family: Arial, sans-serif; padding: 20px; max-width: 600px; margin: 0 auto;'>
                <h2 style='color: #333;'>Verification Code</h2>
                <p>Your verification code is:</p>
                <div style='background-color: #f5f5f5; padding: 15px; border-radius: 5px; text-align: center; font-size: 24px; letter-spacing: 5px; margin: 20px 0;'>
                    <strong>{$code}</strong>
                </div>
                <p>This code will expire in 2 minutes.</p>
                <p style='color: #666; font-size: 12px;'>If you didn't request this code, please ignore this email.</p>
            </div>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}

// Handle the verification request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the email from POST request
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    
    try {
        // Create database connection
        $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if email exists in database
        $stmt = $conn->prepare("SELECT id FROM admin WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            // Generate new verification code
            $code = generateVerificationCode();
            
            // Set token expiration (2 minutes from now)
            $expiration = date('Y-m-d H:i:s', strtotime('+2 minutes'));
            
            // Generate token
            $token = bin2hex(random_bytes(32));
            
            // Update database with new code and token
            $update = $conn->prepare("UPDATE admin SET code = ?, token = ?, token_expiration = ? WHERE email = ?");
            $update->execute([$code, $token, $expiration, $email]);
            
            // Send verification email
            if (sendVerificationEmail($email, $code)) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Verification code sent successfully'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to send verification code'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Email not found in database'
            ]);
        }
        
    } catch(PDOException $e) {
        error_log("Database Error: " . $e->getMessage());
        echo json_encode([
            'status' => 'error',
            'message' => 'Database error occurred'
        ]);
    }
}
