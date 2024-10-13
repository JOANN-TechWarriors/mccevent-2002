<?php
// Database connection (replace with your actual database credentials)
$db = new mysqli('127.0.0.1', 'u510162695_judging_root', '1Judging_root', 'u510162695_judging');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

$result = $db->query("SELECT * FROM streams WHERE status = 'live'");
$streams = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $streams[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($streams);
?>