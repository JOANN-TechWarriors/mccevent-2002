<?php
// Disable error reporting to prevent unwanted output
error_reporting(0);
ini_set('display_errors', 0);

session_start();
include('dbcon.php'); // Include your PDO database connection file

// Set proper JSON header at the very beginning
header('Content-Type: application/json');

// Ensure no output before JSON
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate event_id
        if (!isset($_POST['event_id']) || empty($_POST['event_id'])) {
            throw new Exception('Event ID is required');
        }

        $event_id = $_POST['event_id'];

        // Start transaction
        $conn->beginTransaction();

        // Delete related records in sub_event table
        $stmt = $conn->prepare("DELETE FROM sub_event WHERE mainevent_id = :event_id");
        $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->execute();

        // Delete the event from main_event table
        $stmt = $conn->prepare("DELETE FROM main_event WHERE mainevent_id = :event_id");
        $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->execute();

        // Commit transaction
        $conn->commit();

        // Output JSON response
        echo json_encode([
            'success' => true, 
            'message' => 'Event deleted successfully'
        ]);
        exit;

    } else {
        // Invalid request method
        throw new Exception('Invalid request method');
    }
} catch (Exception $e) {
    // Rollback transaction if it's still active
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    // Output error as JSON
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
    exit;
}
?>