<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start output buffering to capture any unexpected output
ob_start();

// Database connection (replace with your actual database credentials)
$db = new mysqli('127.0.0.1', 'u510162695_judging_root', '1Judging_root', 'u510162695_judging');
if ($db->connect_error) {
    error_log("Database connection failed: " . $db->connect_error);
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'Database connection failed: ' . $db->connect_error]);
    exit;
}

error_log("Database connection successful");

$result = $db->query("SELECT id, status, organizer_id FROM streams WHERE status = 'live'");
$streams = [];

if ($result) {
    error_log("Query executed successfully");
    while ($row = $result->fetch_assoc()) {
        $streams[] = $row;
    }
    error_log("Number of streams found: " . count($streams));
    $result->free();
} else {
    error_log("Query failed: " . $db->error);
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(['error' => 'Query failed: ' . $db->error]);
    exit;
}

$db->close();

// Capture any unexpected output
$output = ob_get_clean();
if (!empty($output)) {
    error_log("Unexpected output: " . $output);
}

header('Content-Type: application/json');
echo json_encode($streams);

error_log("JSON response sent: " . json_encode($streams));
?>