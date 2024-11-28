<?php
include('dbcon.php'); // Include your PDO database connection file

$response = ['success' => false, 'message' => ''];

if (isset($_POST['edit_event_id'])) {
    $mainevent_id = $_POST['edit_event_id'];
    $event_name = $_POST['edit_main_event'];
    $date_start = $_POST['edit_date_start'];
    $date_end = $_POST['edit_date_end'];
    $description = $_POST['edit_event_description'];
    $place = $_POST['edit_place'];

    $query = "UPDATE main_event SET event_name = :event_name, date_start = :date_start, date_end = :date_end, description = :description, place = :place WHERE mainevent_id = :mainevent_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':event_name', $event_name);
    $stmt->bindParam(':date_start', $date_start);
    $stmt->bindParam(':date_end', $date_end);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':place', $place);
    $stmt->bindParam(':mainevent_id', $mainevent_id);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Event updated successfully!';
    } else {
        $response['message'] = 'Failed to update event.';
    }
}

echo json_encode($response);
?>