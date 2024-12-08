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
    // Check session data
    if (!isset($_SESSION['id'])) {
        $response['message'] = 'Session ID is not set.';
        echo json_encode($response);
        exit;
    }

    // Get form data
    $event_id = isset($_POST['eventID']) ? intval($_POST['eventID']) : null;
    $event_name = isset($_POST['eventTitle']) ? trim($_POST['eventTitle']) : '';
    $date_start = isset($_POST['eventStart']) ? trim($_POST['eventStart']) : '';
    $date_end = isset($_POST['eventEnd']) ? trim($_POST['eventEnd']) : '';
    $organizer_id = isset($_SESSION['id']) ? intval($_SESSION['id']) : null;

    // Validate required fields
    if ($event_id && $event_name && $date_start && $date_end && $organizer_id) {
        // Handle file upload if a new banner is provided
        $banner = null;
        if (isset($_FILES['eventBanner']) && $_FILES['eventBanner']['size'] > 0) {
            $banner = time() . '_' . $_FILES['eventBanner']['name'];
            $target = "../img/" . $banner;
            if (!move_uploaded_file($_FILES['eventBanner']['tmp_name'], $target)) {
                $response['message'] = 'Failed to upload banner.';
                echo json_encode($response);
                exit;
            }
        }

        // Prepare SQL query
        $sql = "UPDATE upcoming_events SET title=?, start_date=?, end_date=?";
        if ($banner) {
            $sql .= ", banner=?";
        }
        $sql .= " WHERE id=? AND organizer_id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $event_name);
        $stmt->bindParam(2, $date_start);
        $stmt->bindParam(3, $date_end);
        $paramIndex = 4;
        if ($banner) {
            $stmt->bindParam($paramIndex++, $banner);
        }
        $stmt->bindParam($paramIndex++, $event_id);
        $stmt->bindParam($paramIndex, $organizer_id);

        // Execute update query
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Event updated successfully';
        } else {
            $response['message'] = 'Error updating event: ' . $stmt->errorInfo()[2];
        }
        $stmt->closeCursor();
    } else {
        $response['message'] = 'All fields are required.';
    }
} else {
    $response['message'] = 'Invalid request method.';
}

// Output JSON response
echo json_encode($response);

// Close the PDO connection
$conn = null;
?>