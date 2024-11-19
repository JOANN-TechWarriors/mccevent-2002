<?php
session_start();
$_SESSION['login_attempts'] = 0;
$_SESSION['lockout_time'] = 0;
?>