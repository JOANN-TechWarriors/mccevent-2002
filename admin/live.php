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
                echo json_encode(['status' => 'success', 'stream_id' => $stream_id]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error starting stream: ' . $stmt->error]);
            }
            exit;
        } elseif ($_POST['action'] === 'stop') {
            $stmt = $db->prepare("UPDATE streams SET status = 'ended' WHERE id = ? AND status = 'live' AND organizer_id = ?");
            $stmt->bind_param("ii", $_POST['stream_id'], $organizer_id);
            if ($stmt->execute()) {
                echo json_encode(['status' => 'success', 'message' => 'Stream ended']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error ending stream: ' . $stmt->error]);
            }
            exit;
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
    <button id="startStreamBtn">Start New Stream</button>
    <h2>Active Streams</h2>
    <div id="activeStreams"></div>
    <div id="videoContainer">
        <video id="video" width="1240" height="680" autoplay></video>
        <canvas id="canvas" width="1540" height="480" style="display:none;"></canvas>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"></script>
    <script>
        let video = document.getElementById('video');
let canvas = document.getElementById('canvas');
let stream;
let socket = io('https://mcceventsjudging.com:3306');
let currentStreamId = null;

document.getElementById('startStreamBtn').addEventListener('click', startNewStream);

async function startNewStream() {
    try {
        const response = await fetch('', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=start'
        });
        const data = await response.json();
        if (data.status === 'success') {
            currentStreamId = data.stream_id;
            await startWebcam(currentStreamId);
            updateActiveStreams();
        } else {
            console.error("Error starting stream:", data.message);
        }
    } catch (err) {
        console.error("Error starting stream:", err);
    }
}

async function startWebcam(streamId) {
    try {
        stream = await navigator.mediaDevices.getUserMedia({ video: true });
        video.srcObject = stream;
        video.onloadedmetadata = () => {
            video.play();
            broadcastStream(streamId);
        };
    } catch (err) {
        console.error("Error accessing the webcam", err);
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
    fetch('', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=capture&stream_id=${streamId}&image=${encodeURIComponent(imageData)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            console.log("Image captured successfully");
        } else {
            console.error("Error capturing image:", data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function stopStream(streamId) {
    fetch('', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `action=stop&stream_id=${streamId}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            console.log("Stream stopped successfully");
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
            video.srcObject = null;
            currentStreamId = null;
            updateActiveStreams();
        } else {
            console.error("Error stopping stream:", data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}

function updateActiveStreams() {
    fetch(`/active-streams?organizer_id=${<?php echo $organizer_id; ?>}`)
    .then(response => response.json())
    .then(streams => {
        const activeStreamsDiv = document.getElementById('activeStreams');
        activeStreamsDiv.innerHTML = '';
        streams.forEach(stream => {
            const streamDiv = document.createElement('div');
            streamDiv.className = 'stream-item';
            streamDiv.innerHTML = `
                <button onclick="stopStream(${stream.id})">Stop</button>
                <button onclick="captureImage(${stream.id})">Capture Image</button>
            `;
            activeStreamsDiv.appendChild(streamDiv);
        });
    })
    .catch(error => console.error('Error:', error));
}

// Initial update of active streams
updateActiveStreams();
    </script>
</body>
</html>