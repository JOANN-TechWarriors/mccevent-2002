<?php
header('Content-Type: application/json');

// Database connection
$db = new mysqli('127.0.0.1', 'u510162695_judging_root', '1Judging_root', 'u510162695_judging');
if ($db->connect_error) {
    http_response_code(500);
    die(json_encode(['error' => "Connection failed: " . $db->connect_error]));
}

try {
    $stmt = $db->prepare("SELECT id, status FROM streams WHERE status = 'live'");
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $db->error);
    }

    if (!$stmt->execute()) {
        throw new Exception("Execute failed: " . $stmt->error);
    }

    $result = $stmt->get_result();
    $streams = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($streams);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    $db->close();
}
?>