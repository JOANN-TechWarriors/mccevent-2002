<?php
session_start();
include('dbcon.php'); // Include your PDO database connection file

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $event_id = isset($_POST['event_id']) ? intval($_POST['event_id']) : null;

    if ($event_id === null || $event_id <= 0) {
        echo json_encode([
            'success' => false, 
            'message' => 'Invalid event ID',
            'post_data' => $_POST // Log the received POST data
        ]);
        exit;
    }

    try {
        // Start transaction
        $conn->beginTransaction();

        // First, check if the event exists
        $check_stmt = $conn->prepare("SELECT COUNT(*) FROM main_event WHERE mainevent_id = :event_id");
        $check_stmt->bindParam(':event_id', $event_id);
        $check_stmt->execute();
        $event_exists = $check_stmt->fetchColumn();

        if (!$event_exists) {
            echo json_encode([
                'success' => false, 
                'message' => 'Event not found',
                'event_id' => $event_id
            ]);
            exit;
        }

        // Delete related records in sub_event table
        $stmt = $conn->prepare("DELETE FROM sub_event WHERE mainevent_id = :event_id");
        $stmt->bindParam(':event_id', $event_id);
        $sub_event_result = $stmt->execute();

        // Delete the event from main_event table
        $stmt = $conn->prepare("DELETE FROM main_event WHERE mainevent_id = :event_id");
        $stmt->bindParam(':event_id', $event_id);
        $main_event_result = $stmt->execute();

        // Commit transaction
        $conn->commit();

        echo json_encode([
            'success' => true, 
            'message' => 'Event deleted successfully',
            'sub_event_deleted' => $sub_event_result,
            'main_event_deleted' => $main_event_result
        ]);
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