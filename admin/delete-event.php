<?php
session_start();
include('dbcon.php'); // Include your PDO database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'];

    try {
        // Start transaction
        $conn->beginTransaction();

        // Delete related records in sub_event table
        $stmt = $conn->prepare("DELETE FROM sub_event WHERE mainevent_id = :event_id");
        $stmt->bindParam(':event_id', $event_id);
        $stmt->execute();

        // Delete the event from main_event table
        $stmt = $conn->prepare("DELETE FROM main_event WHERE mainevent_id = :event_id");
        $stmt->bindParam(':event_id', $event_id);
        $stmt->execute();

        // Commit transaction
        $conn->commit();

        echo json_encode(['success' => true, 'message' => 'Event deleted successfully']);
    } catch (PDOException $e) {
        // Rollback transaction on error
        $conn->rollBack();
        echo json_encode(['success' => false, 'message' => 'Failed to delete event: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>