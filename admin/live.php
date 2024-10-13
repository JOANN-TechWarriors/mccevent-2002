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
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <title>Live Stream Control Panel</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1, h2 { color: #333; }
        form { margin-bottom: 20px; }
        button { padding: 10px 20px; font-size: 16px; cursor: pointer; }
        .stream-item { margin-bottom: 10px; }
        #videoContainer { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Live Stream Control Panel</h1>
    <form method="post">
        <button type="submit" name="action" value="start">Start New Stream</button>
    </form>
    <h2>Active Streams</h2>
    <?php
    $result = $db->query("SELECT * FROM streams WHERE status = 'live' AND organizer_id = $organizer_id");
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='stream-item'>";
            echo "<form method='post' style='display:inline; margin-left: 10px;'>";
            echo "<input type='hidden' name='stream_id' value='" . $row['id'] . "'>";
            echo "<button type='submit' name='action' value='stop'>Stop</button>";
            echo "</form>";
            echo "<button onclick='startWebcam(" . $row['id'] . ")'>Start</button>";
            echo "<button onclick='captureImage(" . $row['id'] . ")'>Capture Image</button>";
            echo "</div>";
        }
    } else {
        echo "<p>No active streams at the moment.</p>";
    }
    ?>
    <div id="videoContainer">
        <video id="video" width="1240" height="580" autoplay></video>
        <canvas id="canvas" width="1340" height="480" style="display:none;"></canvas>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"></script>
    <script>
        let video = document.getElementById('video');
        let canvas = document.getElementById('canvas');
        let stream;
        let socket = io('https://mcceventsjudging.com:3306');  // Replace with your WebSocket server address

        document.addEventListener('DOMContentLoaded', function() {
            // Find all start buttons
            document.querySelectorAll('button[onclick^="startWebcam"]').forEach(button => {
                button.addEventListener('click', function() {
                    const streamId = this.getAttribute('onclick').match(/\d+/)[0];
                    startWebcam(streamId);
                });
            });

            // Find all stop buttons
            document.querySelectorAll('button[name="action"][value="stop"]').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const streamId = this.closest('form').querySelector('input[name="stream_id"]').value;
                    stopStream(streamId);
                });
            });
        });

        async function startWebcam(streamId) {
            try {
                stream = await navigator.mediaDevices.getUserMedia({ video: true });
                video.srcObject = stream;
                broadcastStream(streamId);
            } catch (err) {
                console.error("Error accessing the webcam", err);
            }
        }

        async function stopStream(streamId) {
            const formData = new FormData();
            formData.append('action', 'stop');
            formData.append('stream_id', streamId);

            try {
                const response = await fetch(window.location.href, {
                    method: 'POST',
                    body: formData
                });
                const result = await response.text();
                console.log(result);
                // Optionally, you can reload the page or update the UI here
                window.location.reload();
            } catch (error) {
                console.error('Error stopping stream:', error);
            }
        }

        function broadcastStream(streamId) {
            setInterval(() => {
                canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                let imageData = canvas.toDataURL('image/jpeg', 0.5);
                socket.emit('stream', { streamId: streamId, imageData: imageData });
            }, 100);  // Adjust interval as needed
        }

        function captureImage(streamId) {
            canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
            let imageData = canvas.toDataURL('image/png');
            
            fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=capture&stream_id=${streamId}&image=${encodeURIComponent(imageData)}`
            })
            .then(response => response.json())
            .then(data => {
                console.log(data.message);
            })
            .catch((error) => {
                console.error('Error:', error);
            });
        }
    </script>
</body>
</html>