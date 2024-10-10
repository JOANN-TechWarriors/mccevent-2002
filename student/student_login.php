<?php
session_start();
include('../admin/dbcon.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];

    // Replace this with your actual authentication logic
    $query = "SELECT * FROM student WHERE student_id = :student_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $_SESSION['login_success'] = true;
        // Assuming you have the sub_event_id somewhere
        // Retrieve the sub_event_id from the database or set it accordingly
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['sub_event_id'] = $row['sub_event_id'];  // Adjust based on your table structure
        header('Location: ../index.php');
        exit();
    } else {
        $_SESSION['login_error'] = 'Invalid Student ID';
        header('Location: index.php');
        exit();
    }
}
?>
