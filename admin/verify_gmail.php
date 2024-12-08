<?php
// admin/verify_gmail.php
require 'dbcon.php';
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function generateVerificationCode() {
    return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
}

function sendVerificationEmail($email, $code) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'joannrebamonte80@gmail.com'; // Your Gmail address
        $mail->Password = 'dkyd tsnv hzyh amjy'; // Your Gmail App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('no-reply@yourdomain.com', 'Your Company');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your Verification Code';
        $mail->Body    = "Your verification code is: <b>$code</b>";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    try {
        $stmt = $conn->prepare("SELECT email FROM admin WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $verificationCode = generateVerificationCode();

            if (sendVerificationEmail($email, $verificationCode)) {
                $updateStmt = $conn->prepare("UPDATE admin SET code = :code WHERE email = :email");
                $updateStmt->bindParam(':code', $verificationCode);
                $updateStmt->bindParam(':email', $email);
                $updateStmt->execute();

                echo json_encode(['status' => 'success', 'message' => 'Verification code sent successfully!']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to send verification email.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Email not found in the database.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $e->getMessage()]);
    }
}
?>