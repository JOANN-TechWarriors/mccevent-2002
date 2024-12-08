<?php
$request = $_SERVER['REQUEST_URI'];
if (substr($request, -4) == '.php') {
    $new_url = substr($request, 0, -4);
    header("Location: $new_url", true, 301);
    exit();
}
?>
<?php
session_start();
$_SESSION['login_attempts'] = 0;
$_SESSION['lockout_time'] = 0;
echo json_encode(['success' => true]);
?>