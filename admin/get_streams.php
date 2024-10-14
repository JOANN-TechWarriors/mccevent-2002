<?php
// Database connection (use the same credentials as in the main file)
$db = new mysqli('127.0.0.1', 'u510162695_judging_root', '1Judging_root', 'u510162695_judging');
if ($db->connect_error) {
    die(json_encode(['error' => "Connection failed: " . $db->connect_error]));
}

$stmt = $db->prepare("SELECT id, status FROM streams WHERE status = 'live'");
$stmt->execute();
$result = $stmt->get_result();

$streams = [];
while ($row = $result->fetch_assoc()) {
    $streams[] = $row;
}

header('Content-Type: application/json');
echo json_encode($streams);
?>