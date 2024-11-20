<?php
session_start();
$_SESSION['login_attempts'] = 0;
$_SESSION['lockout_time'] = 0;
echo json_encode(['success' => true]);
?>