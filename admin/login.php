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
                            window.location = 'index2';
                        }
                    });
                </script>
                <?php
            } elseif ($row['access'] == "Organizer") {
                $_SESSION['useraccess'] = "Organizer";
                $_SESSION['id'] = $row['organizer_id'];
                ?>
                <script>
                    window.location = 'dashboard';
                </script>
                <?php
            }
        } else {
            // Invalid password
            ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Invalid Username or Password',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location = 'index2';
                    }
                });
            </script>
            <?php
        }
    } else {
        // User not found
        ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Invalid Username or Password',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = 'index2';
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
                window.location = 'index2';
            }
        });
    </script>
    <?php
}
?>
</body>
</html>