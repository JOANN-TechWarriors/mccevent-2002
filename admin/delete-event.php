<?php
include('dbcon.php');

header('Content-Type: application/json');

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        // Prepare and execute delete statement
        $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            // Check if any rows were actually deleted
            if ($stmt->affected_rows > 0) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Event deleted successfully'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No event found with the given ID'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to delete event'
            ]);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Database error: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No event ID provided'
    ]);
}

$conn->close();
?>