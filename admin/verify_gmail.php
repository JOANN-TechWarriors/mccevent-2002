<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';
require 'dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        
        // Verify if email exists in admin table
        $stmt = $conn->prepare("SELECT id FROM admin WHERE email = ?");
        $stmt->execute([$email]);
        
        if ($stmt->rowCount() > 0) {
            // Generate 6-digit verification code
            $verification_code = sprintf("%06d", mt_rand(0, 999999));
            
            // Update admin table with new verification code
            $update_stmt = $conn->prepare("UPDATE admin SET verification_code = ?, code_timestamp = NOW() WHERE email = ?");
            
            if ($update_stmt->execute([$verification_code, $email])) {
                $mail = new PHPMailer(true);
                
                try {
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'joannrebamonte80@gmail.com'; // Your Gmail
                    $mail->Password = 'dkyd tsnv hzyh amjy'; // Your Gmail App Password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;
                    
                    // Recipients
                    $mail->setFrom('joannrebamonte80@gmail.com', 'Event Judging System');
                    $mail->addAddress($email);
                    
                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Email Verification Code';
                    $mail->Body = '
                        <html>
                        <body style="font-family: Arial, sans-serif; padding: 20px;">
                            <div style="max-width: 600px; margin: 0 auto; background-color: #f9f9f9; padding: 20px; border-radius: 10px;">
                                <h2 style="color: #333;">Email Verification</h2>
                                <p>Your verification code is:</p>
                                <h1 style="color: #4CAF50; font-size: 32px; letter-spacing: 5px; margin: 20px 0;">' . $verification_code . '</h1>
                                <p>Please enter this code to verify your email address.</p>
                                <p style="color: #666; font-size: 14px;">This code will expire in 2 minutes.</p>
                                <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">
                                <p style="color: #999; font-size: 12px;">If you did not request this code, please ignore this email.</p>
                            </div>
                        </body>
                        </html>';
                    
                    $mail->send();
                    echo json_encode(['success' => true, 'message' => 'Verification code sent']);
                    
                } catch (Exception $e) {
                    echo json_encode(['success' => false, 'message' => "Mail could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
                }
            } else {
              // Continuation of verify_gmail.php
              echo json_encode(['success' => false, 'message' => 'Failed to update verification code']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Email not found in admin records']);
        }
        
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
}
