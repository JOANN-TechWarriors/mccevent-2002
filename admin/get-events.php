<?php
// Start the session (if not already started)
session_start();

// Connect to the database
$host = '127.0.0.1';
$username = 'u510162695_judging_root';
$password = '1Judging_root'; // Replace with the actual password
$dbname = 'u510162695_judging';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the current date
$current_date = date('Y-m-d');

// Prepare the SQL query to transfer events
$sql = "INSERT INTO main_event (event_name, status, organizer_id, sy, date_start, date_end, place, banner)
        SELECT title, 'active', organizer_id, '2023-2024', start_date, end_date, 'default place', 'default_banner.jpg'
        FROM upcoming_events
        WHERE DATE(start_date) = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

// Bind the current date to the query
$stmt->bind_param("s", $current_date);

// Execute the query
if ($stmt->execute()) {
    echo "Events transferred successfully.";
} else {
    echo "Error transferring events: " . $stmt->error;
}

// Close statement and connection
$stmt->close();
$conn->close();
?>