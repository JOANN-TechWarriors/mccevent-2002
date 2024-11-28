<?php
// Start the session to get organizer_id
session_start();

// Connect to the database
$host = '127.0.0.1';
$username = 'u510162695_judging_root';
$password = '1Judging_root'; // Replace with the actual password
$dbname = 'u510162695_judging';
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$event_id = $_POST['edit_event_id'];
$event_name = $_POST['edit_main_event'];
$date_start = $_POST['edit_date_start'];
$date_end = $_POST['edit_date_end'];
$organizer_id = $_SESSION['id'];

// Handle file upload if a new banner is provided
if (isset($_FILES['edit_banner']) && $_FILES['edit_banner']['size'] > 0) {
    $banner = time() . '_' . $_FILES['edit_banner']['name'];
    $target = "../img/" . $banner;
    if (move_uploaded_file($_FILES['edit_banner']['tmp_name'], $target)) {
        // Update query with new banner
        $sql = "UPDATE upcoming_events SET title=?, start_date=?, end_date=?, banner=? WHERE id=? AND organizer_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssii', $event_name, $date_start, $date_end, $banner, $event_id, $organizer_id);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to upload banner']);
        exit;
    }
} else {
    // Update query without banner
    $sql = "UPDATE upcoming_events SET title=?, start_date=?, end_date=? WHERE id=? AND organizer_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssii', $event_name, $date_start, $date_end, $event_id, $organizer_id);
}

// Execute update query
if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Event updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error updating event: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>