<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session to get organizer_id
session_start();

// Include database connection
include('dbcon.php');

// Initialize response array
$response = ['success' => false, 'message' => ''];

// Check if the request is a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $event_id = isset($_POST['edit_event_id']) ? intval($_POST['edit_event_id']) : null;
    $event_name = isset($_POST['edit_main_event']) ? trim($_POST['edit_main_event']) : '';
    $date_start = isset($_POST['edit_date_start']) ? trim($_POST['edit_date_start']) : '';
    $date_end = isset($_POST['edit_date_end']) ? trim($_POST['edit_date_end']) : '';
    $organizer_id = isset($_SESSION['id']) ? intval($_SESSION['id']) : null;

    // Validate required fields
    if ($event_id && $event_name && $date_start && $date_end && $organizer_id) {
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
                $response['message'] = 'Failed to upload banner';
                echo json_encode($response);
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
            $response['success'] = true;
            $response['message'] = 'Event updated successfully';
        } else {
            $response['message'] = 'Error updating event: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['message'] = 'All fields are required.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

// Output JSON response
echo json_encode($response);

$conn->close();
?>