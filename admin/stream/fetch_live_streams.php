<?php
header('Content-Type: application/json');

include "db.php";


// Fetch the channel name for stream_id 1
$sql = "SELECT channel_name FROM live_streams WHERE stream_id = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(["channel_name" => $row['channel_name']]);
} else {
    echo json_encode(["error" => "Stream not found"]);
}

$conn->close();
?>