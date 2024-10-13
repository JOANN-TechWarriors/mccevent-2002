<?php
session_start();
// Database connection (replace with your actual database credentials)
$db = new mysqli('127.0.0.1', 'u510162695_judging_root', '1Judging_root', 'u510162695_judging');
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
// Get active streams
$result = $db->query("SELECT * FROM streams WHERE status = 'live'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <title>Live Stream Viewer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f0f0f0;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .stream-container {
            margin-bottom: 20px;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .stream-video {
            width: 100%;
            max-width: 1320px;
            height: 580px;
            background-color: #000;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto;
        }
        .stream-video img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .stream-info {
            padding: 10px;
            background-color: #f8f8f8;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <h1>Available Live Streams</h1>
    <div id="streams-container">
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='stream-container' id='stream-" . $row['id'] . "'>";
                echo "<div class='stream-video'>";
                echo "<img id='video-" . $row['id'] . "' src='' alt='Live Stream'>";
                echo "</div>";
                echo "<div class='stream-info'>";
                echo "<h2>Stream ID: " . $row['id'] . "</h2>";
                echo "<p>Status: " . $row['status'] . "</p>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No active streams at the moment.</p>";
        }
        ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"></script>
    <script>
        const socket = io('https://mcceventsjudging.com:3306');  // Replace with your WebSocket server address

        socket.on('stream', (data) => {
            const img = document.getElementById(`video-${data.streamId}`);
            if (img) {
                img.src = data.imageData;
            }
        });

        function updateStreams() {
            fetch('get_streams.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(streams => {
                    const container = document.getElementById('streams-container');
                    if (streams.length === 0) {
                        container.innerHTML = '<p>No active streams at the moment.</p>';
                        return;
                    }
                    container.innerHTML = '';
                    streams.forEach(stream => {
                        const streamDiv = document.createElement('div');
                        streamDiv.className = 'stream-container';
                        streamDiv.id = `stream-${stream.id}`;
                        streamDiv.innerHTML = `
                            <div class='stream-video'>
                                <img id='video-${stream.id}' src='' alt='Live Stream'>
                            </div>
                            <div class='stream-info'>
                                <h2>Stream ID: ${stream.id}</h2>
                                <p>Status: ${stream.status}</p>
                                <p>Organizer ID: ${stream.organizer_id}</p>
                            </div>
                        `;
                        container.appendChild(streamDiv);
                    });
                })
                .catch(error => {
                    console.error('Error fetching streams:', error);
                    const container = document.getElementById('streams-container');
                    container.innerHTML = '<p>Error loading streams. Please try again later.</p>';
                });
        }

        // Initial update
        updateStreams();

        // Update stream list every 30 seconds
        setInterval(updateStreams, 30000);
    </script>
</body>
</html>