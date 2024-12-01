<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <title>Event Judging System</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php
include('dbcon.php');
require '../vendor/autoload.php'; // Include PHPMailer's autoloader
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to log failed login attempts
function logFailedAttempt($conn, $username, $ip, $latitude, $longitude) {
    $type = 'organizer_login_attempt';
    $currentTimestamp = date('Y-m-d H:i:s');
    $stmt = $conn->prepare("INSERT INTO logs (id, ip, username, timestamp, latitude, longitude, type) VALUES (UUID(), :ip, :username, :timestamp, :latitude, :longitude, :type)");
    $stmt->bindParam(':ip', $ip);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':timestamp', $currentTimestamp);
    $stmt->bindParam(':latitude', $latitude);
    $stmt->bindParam(':longitude', $longitude);
    $stmt->bindParam(':type', $type);
    $stmt->execute();
}

// Helper function to get the user's IP address
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        return $_SERVER['REMOTE_ADDR'];
    }
}

// Function to send email notification
function sendEmailNotification($adminEmail, $logs) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'joannrebamonte80@gmail.com';
        $mail->Password = 'dkyd tsnv hzyh amjy'; // Use an app-specific password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('joannrebamonte80@gmail.com', 'Security Orgnizer Attempt Alert');
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
        $mail->Body = "<html><body style='font-family: Arial, sans-serif;'><h2 style='color: #ff0000;'>Security Warning</h2><p>Multiple failed login attempts have been detected for your system.</p>{$logDetails}<p style='margin-top: 20px; color: #666;'>Please review these attempts and take necessary security actions.</p></body></html>";
        $mail->send();
    } catch (Exception $e) {
        error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
    }
}

// Example latitude and longitude (you may need a service to get real data)
$latitude = '0.0';
$longitude = '0.0';

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare query to fetch user data
    $query = $conn->prepare("SELECT * FROM organizer WHERE username = :username");
    $query->bindParam(':username', $username);
    $query->execute();
    $row = $query->fetch();
    $num_row = $query->rowCount();

    if ($num_row > 0) {
        // Verify the password hash
        if (password_verify($password, $row['password'])) {
            if ($row['request_status'] == '') {
                ?>
                <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Sorry, Your account is not yet approved by the admin',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = 'index2.php';
                    }
                });
                </script>
                <?php
            } elseif ($row['access'] == "Organizer") {
                $_SESSION['useraccess'] = "Organizer";
                $_SESSION['id'] = $row['organizer_id'];
                ?>
                <script>
                window.location = 'dashboard.php';
                </script>
                <?php
            }
        } else {
            // Invalid password
            logFailedAttempt($conn, $username, getUserIP(), $latitude, $longitude);
            $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;

            if ($_SESSION['login_attempts'] >= 3) {
                // Fetch admin email
                $query = $conn->prepare("SELECT email FROM admin WHERE id = 1"); // Assuming admin ID is 1
                $query->execute();
                $admin = $query->fetch();
                if ($admin) {
                    $adminEmail = $admin['email'];
                    // Fetch log details
                    $logQuery = $conn->prepare("SELECT * FROM logs WHERE type = 'organizer_login_attempt' ORDER BY timestamp DESC LIMIT 5");
                    $logQuery->execute();
                    $logs = $logQuery->fetchAll();
                    // Send email notification
                    sendEmailNotification($adminEmail, $logs);
                }
                $_SESSION['lockout_time'] = time() + 180; // Lockout for 3 minutes
            }
            ?>
            <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Invalid Username or Password',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = 'index2.php';
                }
            });
            </script>
            <?php
        }
    } else {
        // User not found
        logFailedAttempt($conn, $username, getUserIP(), $latitude, $longitude);
        $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;

        if ($_SESSION['login_attempts'] >= 3) {
            // Fetch admin email
            $query = $conn->prepare("SELECT email FROM admin WHERE id = 1"); // Assuming admin ID is 1
            $query->execute();
            $admin = $query->fetch();
            if ($admin) {
                $adminEmail = $admin['email'];
                // Fetch log details
                $logQuery = $conn->prepare("SELECT * FROM logs WHERE type = 'organizer_login_attempt' ORDER BY timestamp DESC LIMIT 5");
                $logQuery->execute();
                $logs = $logQuery->fetchAll();
                // Send email notification
                sendEmailNotification($adminEmail, $logs);
            }
            $_SESSION['lockout_time'] = time() + 180; // Lockout for 3 minutes
        }
        ?>
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Invalid Username or Password',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location = 'index2.php';
            }
        });
        </script>
        <?php
    }
} else {
    ?>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'Please provide both username and password',
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location = 'index2.php';
        }
    });
    </script>
    <?php
}
?>
</body>
</html>