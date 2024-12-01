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
session_start();

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