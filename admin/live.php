<?php
session_start();
// Database connection (replace with your actual database credentials)
$db = new mysqli('127.0.0.1', 'u510162695_judging_root', '1Judging_root', 'u510162695_judging');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

// Function to get a valid organizer_id
function getValidOrganizerId($db) {
    $result = $db->query("SELECT organizer_id FROM organizer LIMIT 1");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['organizer_id'];
    }
    return null;
}

// Get a valid organizer_id
$organizer_id = getValidOrganizerId($db);
if ($organizer_id === null) {
    die("No valid organizer found in the database.");
}

// Handle stream start/stop and image capture
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'start') {
            $stmt = $db->prepare("INSERT INTO streams (organizer_id, status) VALUES (?, 'live')");
            $stmt->bind_param("i", $organizer_id);
            if ($stmt->execute()) {
                $stream_id = $db->insert_id;
                // echo "<p>Stream started with ID: " . $stream_id . "</p>";
            } else {
                // echo "<p>Error starting stream: " . $stmt->error . "</p>";
            }
        } elseif ($_POST['action'] === 'stop') {
            $stmt = $db->prepare("UPDATE streams SET status = 'ended' WHERE id = ? AND status = 'live' AND organizer_id = ?");
            $stmt->bind_param("ii", $_POST['stream_id'], $organizer_id);
            if ($stmt->execute()) {
                // echo "<p>Stream ended</p>";
            } else {
                // echo "<p>Error ending stream: " . $stmt->error . "</p>";
            }
        } elseif ($_POST['action'] === 'capture') {
            $img = $_POST['image'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            $file = 'uploads/' . uniqid() . '.png';
            file_put_contents($file, $data);
            
            $stmt = $db->prepare("INSERT INTO captured_events (stream_id, image_path) VALUES (?, ?)");
            $stmt->bind_param("is", $_POST['stream_id'], $file);
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Image captured and saved']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error saving image: ' . $stmt->error]);
            }
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Server Admin</title>
</head>
<body>
    <h1>Server Admin</h1>
    <button id="startBtn">Start Server</button>
    <button id="stopBtn">Stop Server</button>
    <p id="status"></p>

    <script>
        const startBtn = document.getElementById('startBtn');
        const stopBtn = document.getElementById('stopBtn');
        const status = document.getElementById('status');

        startBtn.addEventListener('click', async () => {
            const response = await fetch('/start');
            const result = await response.text();
            status.textContent = result;
        });

        stopBtn.addEventListener('click', async () => {
            const response = await fetch('/stop');
            const result = await response.text();
            status.textContent = result;
        });
    </script>
</body>
</html>