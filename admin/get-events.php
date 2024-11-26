<?php
// Start the session (if not already started)
session_start();

// Connect to database
$host = '127.0.0.1';
$username = 'u510162695_judging_root';
$password = '1Judging_root';  // Replace with the actual password
$dbname = 'u510162695_judging';


$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in and has an organizer ID
if (!isset($_SESSION['id'])) {
    die("User not logged in");
}

$organizer_id = $_SESSION['id'];

// Prepare and execute the query to retrieve events for the specific organizer
$sql = "SELECT * FROM upcoming_events WHERE organizer_id = ?";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    die("Error preparing statement: " . mysqli_error($conn));
}

mysqli_stmt_bind_param($stmt, "i", $organizer_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    die("Error retrieving events: " . mysqli_error($conn));
}

// Format events for FullCalendar
$events = array();
while ($row = mysqli_fetch_assoc($result)) {
    $event = array(
        'id' => $row['id'],
        'title' => $row['title'],
        'start' => $row['start_date'],
        'end' => $row['end_date']
    );
    $events[] = $event;
}

// Return events as JSON
echo json_encode($events);

// Close statement and connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>