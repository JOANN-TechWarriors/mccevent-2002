<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', 'error.log');

// Database configuration
$db_host = '127.0.0.1';
$db_user = 'u510162695_judging_root';
$db_pass = '1Judging_root';
$db_name = 'u510162695_judging';

// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

// Function to verify reCAPTCHA
function verifyRecaptcha($recaptchaResponse) {
    $secretKey = "YOUR_RECAPTCHA_SECRET_KEY"; // Replace with your secret key
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $data = [
        'secret' => $secretKey,
        'response' => $recaptchaResponse
    ];
    
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return json_decode($result)->success;
}

// Function to generate verification code
function generateVerificationCode() {
    return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
}

// Function to send verification email
function sendVerificationEmail($email, $code) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = 0;  // Changed from SMTP::DEBUG_SERVER to 0 to prevent debug output
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'joannrebamonte80@gmail.com';
        $mail->Password   = 'dkyd tsnv hzyh amjy';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('joannrebamonte80@gmail.com', 'Admin Verification');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your Verification Code';
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

// Handle the AJAX request
header('Content-Type: application/json');

try {
    // Create database connection
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle verification code sending
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['verify_code'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        
        // Verify reCAPTCHA first
        if (!isset($_POST['g-recaptcha-response']) || !verifyRecaptcha($_POST['g-recaptcha-response'])) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid reCAPTCHA']);
            exit;
        }
        
        // Verify email exists in database
        $stmt = $conn->prepare("SELECT id FROM admin WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            // Generate new code
            $code = generateVerificationCode();
            $token = bin2hex(random_bytes(32));
            $expiration = date('Y-m-d H:i:s', strtotime('+2 minutes'));
            
            // Update database
            $update = $conn->prepare("UPDATE admin SET code = ?, token = ?, token_expiration = ? WHERE email = ?");
            $success = $update->execute([$code, $token, $expiration, $email]);
            
            if ($success) {
                if (sendVerificationEmail($email, $code)) {
                    echo json_encode(['status' => 'success', 'message' => 'Verification code sent successfully']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to send email']);
                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update database']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Email not found']);
        }
    }
    
    // Handle code verification
    if (isset($_POST['verify_code'])) {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $submitted_code = filter_var($_POST['code'], FILTER_SANITIZE_STRING);
        
        $stmt = $conn->prepare("SELECT code, token_expiration FROM admin WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result && $result['code'] === $submitted_code) {
            if (strtotime($result['token_expiration']) >= time()) {
                // Clear verification data
                $update = $conn->prepare("UPDATE admin SET code = NULL, token = NULL, token_expiration = NULL WHERE email = ?");
                $update->execute([$email]);
                
                echo json_encode(['status' => 'success', 'message' => 'Verification successful']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Verification code has expired']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid verification code']);
        }
    }

} catch(PDOException $e) {
    error_log("Database Error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Database connection error']);
} catch(Exception $e) {
    error_log("General Error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'An error occurred']);
}
?>