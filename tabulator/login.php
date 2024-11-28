<?php
$request = $_SERVER['REQUEST_URI'];
if (substr($request, -4) == '.php') {
    $new_url = substr($request, 0, -4);
    header("Location: $new_url", true, 301);
    exit();
}
?>
<?php
include('../admin/dbcon.php');
session_start();

header('Content-Type: application/json');
$response = ['success' => false, 'message' => '', 'redirect' => ''];

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
        $response['success'] = false;
        $response['message'] = 'Invalid Username or Password';
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Missing credentials';
}

echo json_encode($response);
?>
