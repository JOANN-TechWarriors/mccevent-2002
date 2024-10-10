<?php
include('dbcon.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $start = $_POST['start'];
    $end = $_POST['end'];

    // Check for conflicts, excluding the current event
    $sql = "SELECT COUNT(*) as count FROM events 
            WHERE id != ? AND 
            ((start BETWEEN ? AND ?) OR 
             (end BETWEEN ? AND ?) OR 
             (start <= ? AND end >= ?))";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $id, $start, $end, $start, $end, $start, $end);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $conflict = $row['count'] > 0;

    echo json_encode(['conflict' => $conflict]);

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['conflict' => true, 'message' => 'Invalid request method']);
}