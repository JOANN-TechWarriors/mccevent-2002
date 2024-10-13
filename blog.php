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
        .stream-container {
            margin-bottom: 10px;
        }
        .stream-video {
            width: 1320px;
            height: 580px;
            background-color: #000;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
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
                // echo "<h2>Stream ID: " . $row['id'] . "</h2>";
                // echo "<p>Status: " . $row['status'] . "</p>";
                echo "<div class='stream-video'>";
                echo "<img id='video-" . $row['id'] . "' src='' alt='Live Stream'>";
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
        const socket = io('http://localhost:3000');  // Replace with your WebSocket server address

        socket.on('stream', (data) => {
            const img = document.getElementById(`video-${data.streamId}`);
            if (img) {
                img.src = data.imageData;
            }
        });

        function updateStreams() {
            fetch('get_streams.php')
                .then(response => response.json())
                .then(streams => {
                    const container = document.getElementById('streams-container');
                    container.innerHTML = '';
                    streams.forEach(stream => {
                        const streamDiv = document.createElement('div');
                        streamDiv.className = 'stream-container';
                        streamDiv.id = `stream-${stream.id}`;
                        streamDiv.innerHTML = `
                            <h2>Stream ID: ${stream.id}</h2>
                            <p>Status: ${stream.status}</p>
                            <div class='stream-video'>
                                <img id='video-${stream.id}' src='' alt='Live Stream'>
                            </div>
                        `;
                        container.appendChild(streamDiv);
                    });
                });
        }

        setInterval(updateStreams, 30000);  // Update stream list every 30 seconds
    </script>
</body>
</html>