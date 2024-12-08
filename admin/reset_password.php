<?php
$request = $_SERVER['REQUEST_URI'];
if (substr($request, -4) == '.php') {
    $new_url = substr($request, 0, -4);
    header("Location: $new_url", true, 301);
    exit();
}
?>
<?php
// Load database connection
include('dbcon.php');
include('header2.php');

// Check if required URL parameters are present
if(!isset($_GET['email']) || !isset($_GET['token'])) {
    // Redirect to error 404 page
    header('HTTP/1.0 404 Not Found');
    include('error_404.php');
    exit();
}

// Get email address and token from URL parameters
$email = $_GET['email'];
$token = $_GET['token'];

// Verify password reset token
$query = $conn->prepare("SELECT * FROM organizer WHERE email=:email AND reset_token=:token AND reset_expires > NOW()");
$query->execute(array(':email' => $email, ':token' => $token));
$user = $query->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $errorMessage = "The reset token has expired. Please request a new password reset.";
    exit();
}

// Process password reset form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $errorMessage = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Update user's password in the database
        $query = $conn->prepare("UPDATE organizer SET password=:password, reset_token=NULL, reset_expires=NULL WHERE email=:email");
        $query->execute(array(':password' => $hashed_password, ':email' => $email));

        if ($query->rowCount() > 0) {
            // Password updated successfully
            $successMessage = "Password reset successfully.";
            header('Location: index2');
            exit();
        } else {
            // Password update failed
            $errorMessage = "Password reset failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .navbar {
            background-color: #333;
            color: #fff;
            padding: 10px;
        }

        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .panel {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 20px;
        }

        .panel-title {
            margin-top: 0;
        }

        .btn-group {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-default {
            background-color: #f1f1f1;
            color: #333;
            margin-right: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="jumbotron subhead" id="overview">
        <div class="container">
            <h1>Account Reset Password</h1>
            <p class="lead">Event Judging System</p>
        </div>
    </header>

    <!-- Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6 col-lg-4">
                <div class="panel">
                    <h3 class="panel-title">Reset Password</h3>
                    <?php if (isset($errorMessage)): ?>
                        <div class="alert alert-danger" role="alert"><?php echo $errorMessage; ?></div>
                    <?php elseif (isset($successMessage)): ?>
                        <div class="alert alert-success" role="alert"><?php echo $successMessage; ?></div>
                    <?php endif; ?>
                    <form action="<?php echo $_SERVER['PHP_SELF'] . '?email=' . $email . '&token=' . $token; ?>" method="POST">
                        <div class="form-group">
                            <label for="password">New Password:</label>
                            <input id="password" type="password" name="password" class="form-control" placeholder="New Password" aria-describedby="basic-addon1" required="true" autofocus="true" />
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password:</label>
                            <input id="confirm_password" type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" aria-describedby="basic-addon1" required="true" autofocus="true" />
                        </div>
                        <div class="btn-group">
                            <a href="index2" type="button" class="btn btn-default">Cancel</a>
                            <button name="register" type="submit" class="btn btn-primary">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <font size="2" class="pull-left"><strong>Event Judging System &middot; 2022 &COPY;</strong></font> <br />
        </div>
    </footer>

    <!-- Scripts -->
    <script src="javascript/jquery1102.min.js"></script>
    <script>
        const toast = document.querySelector('.toast');

        function updateToast(title, body, type) {
            const toastTitle = toast.querySelector('.toast-title');
            const toastBody = toast.querySelector('.toast-body');
            const toastHeader = toast.querySelector('.toast-header');

            toastTitle.innerText = title;
            toastBody.innerText = body;

            if (type === 'success') {
                toastHeader.style.backgroundColor = '#28a745';
            } else if (type === 'warning') {
                toastHeader.style.backgroundColor = '#ffc107';
            } else if (type === 'error') {
                toastHeader.style.backgroundColor = '#dc3545';
            }
        }
    </script>
</body>
</html>