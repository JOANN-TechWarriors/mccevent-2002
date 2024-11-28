<?php
include('../admin/dbcon.php');
session_start();

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

// Function to get location from IP
function getLocationFromIP($ip) {
    $url = "http://ip-api.com/json/$ip";
    $response = file_get_contents($url);
    $data = json_decode($response, true);

    return [
        'latitude' => $data['lat'] ?? 0,
        'longitude' => $data['lon'] ?? 0
    ];
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

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
            $location = getLocationFromIP($ip);
            $latitude = $location['latitude'];
            $longitude = $location['longitude'];

            logFailedAttempt($conn, $username, $ip, $latitude, $longitude);

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