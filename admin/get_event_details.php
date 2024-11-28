<?php
include('dbcon.php'); // Include your PDO database connection file

if (isset($_POST['event_id'])) {
    $mainevent_id = $_POST['event_id'];

    $query = "SELECT * FROM main_event WHERE mainevent_id = :mainevent_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':mainevent_id', $mainevent_id);
    $stmt->execute();

    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($event) {
        echo json_encode($event);
    } else {
        echo json_encode(['error' => 'Event not found']);
    }
}
?>