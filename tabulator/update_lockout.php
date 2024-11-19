<?php
session_start();
$data = json_decode(file_get_contents('php://input'), true);
$_SESSION['login_attempts'] = $data['attempts'];
$_SESSION['lockout_time'] = $data['lockoutTime'];
?>