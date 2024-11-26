<?php
session_start();
include('dbcon.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the event_id is properly filtered and converted to an integer
    $event_id = filter_input(INPUT_POST, 'event_id', FILTER_VALIDATE_INT);

    if ($event_id === false || $event_id === null) {
        echo json_encode([
            'success' => false, 
            'message' => 'Invalid event ID',
            'post_data' => $_POST
        ]);
        exit;
    }

    try {
        // Start transaction
        $conn->beginTransaction();

        // Delete related records in sub_event table
        $stmt = $conn->prepare("DELETE FROM sub_event WHERE mainevent_id = :event_id");
        $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->execute();

        // Delete the event from main_event table
        $stmt = $conn->prepare("DELETE FROM main_event WHERE mainevent_id = :event_id");
        $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $result = $stmt->execute();

        // Commit transaction
        $conn->commit();

        // Check if any rows were actually deleted
        if ($result && $stmt->rowCount() > 0) {
            echo json_encode([
                'success' => true, 
                'message' => 'Event deleted successfully',
                'deleted_rows' => $stmt->rowCount()
            ]);
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'No event found with the given ID',
                'event_id' => $event_id
            ]);
        }
    } catch (PDOException $e) {
        // Rollback transaction on error
        $conn->rollBack();
        echo json_encode([
            'success' => false, 
            'message' => 'Failed to delete event: ' . $e->getMessage(),
            'event_id' => $event_id
        ]);
    }
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Invalid request method'
    ]);
}
?>