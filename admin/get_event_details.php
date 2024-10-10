<?php
// get_event_details.php
session_start();
include('dbcon.php');

if (isset($_POST['event_id'])) {
    $event_id = $_POST['event_id'];
    $organizer_id = $_SESSION['id'];

    $stmt = $conn->prepare("SELECT * FROM main_event WHERE mainevent_id = :event_id AND organizer_id = :organizer_id");
    $stmt->bindParam(':event_id', $event_id);
    $stmt->bindParam(':organizer_id', $organizer_id);
    $stmt->execute();

    $event = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($event) {
        echo json_encode($event);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Event not found']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'No event ID provided']);
}
?>