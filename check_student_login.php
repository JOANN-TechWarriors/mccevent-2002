<?php
session_start();

// Check if the student is logged in
if (!isset($_SESSION['student_id'])) {
    // Student is not logged in, store the intended destination and redirect to login page
    $_SESSION['redirect_after_login'] = 'poll/index.php?event=' . $_GET['event'];
    header("Location: student/index.php");
    exit();
} else {
    // Student is logged in, redirect to the poll
    header("Location: poll/index.php?event=" . $_GET['event']);
    exit();
}
?>