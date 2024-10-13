<?php
// Database connection (replace with your actual database credentials)
$db = new mysqli('127.0.0.1', 'u510162695_judging_root', '1Judging_root', 'u510162695_judging');
if ($db->connect_error) {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'Database connection failed: ' . $db->connect_error]);
    exit;
}

$result = $db->query("SELECT id, status, organizer_id FROM streams WHERE status = 'live'");
$streams = [];

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $streams[] = $row;
    }
    $result->free();
} else {
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'Query failed: ' . $db->error]);
    exit;
}

$db->close();

header('Content-Type: application/json');
echo json_encode($streams);
?>