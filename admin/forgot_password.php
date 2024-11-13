<?php
include('dbcon.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

include('header2.php');

require '..//phpmailer/src/Exception.php';
require '..//phpmailer/src/PHPMailer.php';
require '..//phpmailer/src/SMTP.php';


$mail = new PHPMailer(true);

if(isset($_POST["send"])){
    $email = $_POST['email'];

    // Check if email address exists in database
    $query = $conn->prepare("SELECT * FROM organizer WHERE email=:email");
    $query->execute(array(':email' => $email));
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo '<div class="alert alert-danger" role="alert">Email address not found.</div>';
        include('index2.php');
        exit();
    } else {
        // Generate unique token for password reset link
        $token = bin2hex(random_bytes(32));
    
        // Update user's reset_token and reset_expires in the database
        date_default_timezone_set('Asia/Manila'); //Ph Time zone
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $query = $conn->prepare("UPDATE organizer SET reset_token=:token, reset_expires=:expires WHERE email=:email");
        $query->execute(array(':token' => $token, ':expires' => $expires, ':email' => $email));
    
        try {
            // Server settings
            $mail->SMTPDebug = 0;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                    //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'joannbilbao725@gmail.com';                     //SMTP username
            $mail->Password   = 'tfsmvgtgbgqqurdc';                               //SMTP password
            $mail->SMTPSecure = 'tls';         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
            $mail->Port       = 587;                                   //TCP port to connect to
    
            // Disable certificate verification
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
    
            $mail->setFrom('joannbilbao725@gmail.com', 'Event Judging System');
            $mail->addAddress($_POST['email']);
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Link';
            // http://localhost/judging-standard/create_account.php
            $mail->Body = 'Click on this link to reset your password: https://mcceventsjudging.com/admin/reset_password.php?email=' . $email . '&token=' . $token;
    
            $mail->send();
    
            echo '<div class="alert alert-success" role="alert">Password reset email sent to ' . $email . '.</div>';
            include('index2.php');
            exit();
        } catch (Exception $e) {
            echo '<div class="alert alert-danger" role="alert">Error sending email: ' . $mail->ErrorInfo . '</div>';
            include('index2.php');
            exit();
        }
    }
    
}
?>
<!-- <style>
    .alert-danger {
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
}

.alert-success {
    color: #155724;
    background-color: #d4edda;
    border-color: #c3e6cb;
}

</style> -->

