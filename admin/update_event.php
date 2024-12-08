<?php
// Start the session to get organizer_id
session_start();

// Connect to database
$host = '127.0.0.1';
$username = 'u510162695_judging_root';
$password = '1Judging_root';  // Replace with the actual password
$dbname = 'u510162695_judging';
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get form data
$event_id = $_POST['edit_event_id'];
$event_name = $_POST['edit_main_event'];
$date_start = $_POST['edit_date_start'];
$date_end = $_POST['edit_date_end'];
$place = $_POST['edit_place'];
$organizer_id = $_SESSION['id'];

// Handle file upload if a new banner is provided
if (isset($_FILES['edit_banner']) && $_FILES['edit_banner']['size'] > 0) {
    $banner = time() . '_' . $_FILES['edit_banner']['name'];
    $target = "../img/" . $banner;
    
    if (move_uploaded_file($_FILES['edit_banner']['tmp_name'], $target)) {
        // Update query with new banner
        $sql = "UPDATE main_event SET 
                event_name='$event_name', 
                date_start='$date_start', 
                date_end='$date_end', 
                place='$place',
                banner='$banner'
                WHERE mainevent_id=$event_id AND organizer_id=$organizer_id";
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to upload banner']);
        exit;
    }
} else {
    // Update query without banner
    $sql = "UPDATE main_event SET 
            event_name='$event_name', 
            date_start='$date_start', 
            date_end='$date_end', 
            place='$place'
            WHERE mainevent_id=$event_id AND organizer_id=$organizer_id";
}

// Execute update query
if ($conn->query($sql) === TRUE) {
    echo json_encode(['success' => true, 'message' => 'Event updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error updating event: ' . $conn->error]);
}

$conn->close();
?>