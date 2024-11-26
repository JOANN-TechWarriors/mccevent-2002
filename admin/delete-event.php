<?php
session_start();
include('dbcon.php'); // Include your PDO database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'];

    if (empty($event_id)) {
        echo json_encode(['success' => false, 'message' => 'Event ID is required']);
        exit;
    }

    try {
        // Start transaction
        $conn->beginTransaction();

        // Delete related records in sub_event table
        $stmt = $conn->prepare("DELETE FROM sub_event WHERE mainevent_id = :event_id");
        $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->execute();

        // Check if any rows were affected
        if ($stmt->rowCount() > 0) {
            // Delete the event from main_event table
            $stmt = $conn->prepare("DELETE FROM main_event WHERE mainevent_id = :event_id");
            $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
            $stmt->execute();

            // Commit transaction
            $conn->commit();

            echo json_encode(['success' => true, 'message' => 'Event deleted successfully']);
        } else {
            // Rollback transaction if no rows were affected
            $conn->rollBack();
            echo json_encode(['success' => false, 'message' => 'No event found with the given ID']);
        }
    } catch (PDOException $e) {
        // Rollback transaction on error
        $conn->rollBack();
        error_log('Failed to delete event: ' . $e->getMessage()); // Log the error
        echo json_encode(['success' => false, 'message' => 'Failed to delete event']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}