<?php
// Include your PDO database connection file
include('dbcon.php');

// Initialize response array
$response = ['success' => false, 'message' => ''];

// Check if the required POST data is set
if (isset($_POST['edit_event_id'])) {
    // Retrieve and sanitize input data
    $event_id = $_POST['edit_event_id'];
    $event_name = $_POST['edit_main_event'];
    $date_start = $_POST['edit_date_start'];
    $date_end = $_POST['edit_date_end'];
    $organizer_id = $_SESSION['id']; // Assuming organizer_id is stored in session

    // Handle file upload if a new banner is provided
    $banner = null;
    if (isset($_FILES['edit_banner']) && $_FILES['edit_banner']['size'] > 0) {
        $banner = time() . '_' . $_FILES['edit_banner']['name'];
        $target = "../img/" . $banner;
        if (!move_uploaded_file($_FILES['edit_banner']['tmp_name'], $target)) {
            $response['message'] = 'Failed to upload banner.';
            echo json_encode($response);
            exit;
        }
    }

    // Prepare SQL query
    $query = "UPDATE upcoming_events SET title = :event_name, start_date = :date_start, end_date = :date_end";
    if ($banner) {
        $query .= ", banner = :banner";
    }
    $query .= " WHERE id = :event_id AND organizer_id = :organizer_id";

    // Prepare and execute statement
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':event_name', $event_name);
    $stmt->bindParam(':date_start', $date_start);
    $stmt->bindParam(':date_end', $date_end);
    if ($banner) {
        $stmt->bindParam(':banner', $banner);
    }
    $stmt->bindParam(':event_id', $event_id);
    $stmt->bindParam(':organizer_id', $organizer_id);

    // Execute the query and set response
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Event updated successfully!';
    } else {
        $response['message'] = 'Failed to update event.';
    }
}

// Output JSON response
echo json_encode($response);
?>