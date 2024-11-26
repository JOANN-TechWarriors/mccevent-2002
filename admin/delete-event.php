<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include('dbcon.php'); // Include your PDO database connection file

// Set proper JSON header
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Validate event_id
        if (!isset($_POST['event_id']) || empty($_POST['event_id'])) {
            throw new Exception('Event ID is required');
        }

        $event_id = $_POST['event_id'];
        
        // Log the received event ID
        error_log("Received event_id for deletion: " . $event_id);

        // Start transaction
        $conn->beginTransaction();

        // Delete related records in sub_event table
        $stmt = $conn->prepare("DELETE FROM sub_event WHERE mainevent_id = :event_id");
        $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $subEventResult = $stmt->execute();
        
        // Log sub_event deletion result
        error_log("Sub-event deletion result: " . ($subEventResult ? "Success" : "Failure"));

        // Delete the event from main_event table
        $stmt = $conn->prepare("DELETE FROM main_event WHERE mainevent_id = :event_id");
        $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);
        $mainEventResult = $stmt->execute();
        
        // Log main_event deletion result
        error_log("Main event deletion result: " . ($mainEventResult ? "Success" : "Failure"));

        // Check if any rows were actually deleted
        $totalDeletedRows = $stmt->rowCount();
        
        // Log total deleted rows
        error_log("Total rows deleted: " . $totalDeletedRows);

        // Commit transaction
        $conn->commit();

        // Ensure at least one row was deleted
        if ($totalDeletedRows > 0) {
            // Output JSON response
            echo json_encode([
                'success' => true, 
                'message' => 'Event deleted successfully',
                'deletedRows' => $totalDeletedRows
            ]);
            exit;
        } else {
            throw new Exception('No event found with the given ID');
        }

    } else {
        // Invalid request method
        throw new Exception('Invalid request method');
    }
} catch (Exception $e) {
    // Rollback transaction if it's still active
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }

    // Log the error
    error_log("Deletion Error: " . $e->getMessage());

    // Output error as JSON
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
    exit;
}
?>