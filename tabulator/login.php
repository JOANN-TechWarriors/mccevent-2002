<?php
require '../vendor/autoload.php'; // Include PHPMailer's autoloader
include('../admin/dbcon.php');
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

$response = ['success' => false, 'message' => '', 'redirect' => ''];

// Function to log failed login attempts
function logFailedAttempt($conn, $username, $ip, $latitude, $longitude) {
    $type = 'tabulator_login_attempt';
    $stmt = $conn->prepare("INSERT INTO logs (id, ip, username, timestamp, latitude, longitude, type) VALUES (UUID(), :ip, :username, NOW(), :latitude, :longitude, :type)");
    $stmt->bindParam(':ip', $ip);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':latitude', $latitude);
    $stmt->bindParam(':longitude', $longitude);
    $stmt->bindParam(':type', $type);
    $stmt->execute();
}

// Function to send email notification
function sendEmailNotification($adminEmail, $logs) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'joannrebamonte80@gmail.com'; // SMTP username
        $mail->Password = 'dkyd tsnv hzyh amjy'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('joannrebamonte80@gmail.com', 'Security Tabulator Attempt Alert ');
        $mail->addAddress($adminEmail);

        // Generate detailed HTML log details
        $logDetails = '<table border="1" cellpadding="10" style="width:100%; border-collapse: collapse;">';
        $logDetails .= '<thead><tr style="background-color: #f2f2f2;"> <th>IP Address</th> <th>Username</th> <th>Timestamp</th> <th>Location</th> </tr></thead><tbody>';
        foreach ($logs as $log) {
            $googleMapsLink = "https://www.google.com/maps?q={$log['latitude']},{$log['longitude']}";
            $logDetails .= "<tr> <td>{$log['ip']}</td> <td>{$log['username']}</td> <td>{$log['timestamp']}</td> <td> <a href='{$googleMapsLink}' target='_blank' style='color: blue; text-decoration: none;'> Lat: {$log['latitude']}, Lon: {$log['longitude']} </a> </td> </tr>";
        }
        $logDetails .= '</tbody></table>';

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Security Alert: Multiple Failed Login Attempts';
        $mail->Body = "
            <html>
            <body style='font-family: Arial, sans-serif;'>
                <h2 style='color: #ff0000;'>⚠️ Security Warning</h2>
                <p>Multiple failed login attempts have been detected for your system.</p>
                {$logDetails}
                <p style='margin-top: 20px; color: #666;'> Please review these attempts and take necessary security actions. </p>
            </body>
            </html>
        ";
        $mail->send();
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}

// Fetch admin email
$query = $conn->prepare("SELECT email FROM admin WHERE id = 1"); // Assuming admin ID is 1
$query->execute();
$admin = $query->fetch();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $latitude = $_POST['latitude'] ?? 0;
    $longitude = $_POST['longitude'] ?? 0;

    $query = $conn->prepare("SELECT * FROM organizer WHERE username = :username AND password = :password");
    $query->bindParam(':username', $username);
    $query->bindParam(':password', $password);
    $query->execute();
    $row = $query->fetch();
    $num_row = $query->rowCount();

    if ($num_row > 0) {
        if ($row['access'] == "Tabulator") {
            $_SESSION['useraccess'] = "Tabulator";
            $_SESSION['id'] = $row['org_id'];
            $_SESSION['userid'] = $row['organizer_id'];
            $_SESSION['login_success'] = true;
            $response['success'] = true;
            $response['message'] = 'Login successful';
            $response['redirect'] = 'score_sheets';
        }
    } else {
        $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;
        if ($_SESSION['login_attempts'] >= 3) {
            $ip = $_SERVER['REMOTE_ADDR'];
            logFailedAttempt($conn, $username, $ip, $latitude, $longitude);

            if ($admin) {
                $adminEmail = $admin['email'];
                // Fetch log details
                $logQuery = $conn->prepare("SELECT * FROM logs WHERE type = 'tabulator_login_attempt' ORDER BY timestamp DESC LIMIT 5");
                $logQuery->execute();
                $logs = $logQuery->fetchAll();
                // Send email notification
                sendEmailNotification($adminEmail, $logs);
            }
            $_SESSION['lockout_time'] = time() + 180; // Lockout for 3 minutes
        }
        $response['success'] = false;
        $response['message'] = 'Invalid Username or Password';
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Missing credentials';
}

echo json_encode($response);
?>