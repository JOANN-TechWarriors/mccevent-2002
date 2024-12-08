<?php
$response = ['status' => 'error', 'message' => 'An error occurred.'];

// Connect to database
$host = '127.0.0.1';
$username = 'u510162695_judging_root';
$password = '1Judging_root';  // Replace with the actual password
$dbname = 'u510162695_judging';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    $response['message'] = "Connection failed: " . $conn->connect_error;
    echo json_encode($response);
    exit();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['studentid'];
    $fname = $_POST['firstname'];
    $mname = $_POST['middlename'];
    $lname = $_POST['lastname'];
    $course = $_POST['course']; // Assuming you have a course field

    // Check for duplicate
    $checkStmt = $conn->prepare("SELECT COUNT(*) FROM student WHERE student_id = ?");
    $checkStmt->bind_param("s", $student_id);
    $checkStmt->execute();
    $checkStmt->bind_result($count);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($count == 0) {
        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO student (student_id, fname, mname, lname, course, request_status) VALUES (?, ?, ?, ?, ?, 'Pending')");
        $stmt->bind_param("sssss", $student_id, $fname, $mname, $lname, $course);

        // Execute the statement
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = "New student added successfully.";
        } else {
            $response['message'] = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['message'] = "Duplicate entry: Student ID already exists.";
    }

    $conn->close();
}

echo json_encode($response);
?>