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
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; }
        .stream-container {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 5px;
        }
        .stream-video {
            width: 1290px;
            height: 580px;
            background-color: #000;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .stream-video img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        #no-streams {
            font-style: italic;
            color: #666;
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
            echo "</div>";
        }
    } else {
        echo "<p id='no-streams'>No active streams at the moment.</p>";
    }
    ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"></script>
    <script>
        const socket = io('https://mcceventsjudging.com:3306');

        socket.on('streamEnded', (streamId) => {
    const streamElement = document.getElementById(`stream-${streamId}`);
    if (streamElement) {
        streamElement.remove();
    }
    });

    function updateStreams() {
    fetch('get_streams.php')
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            const streams = data.streams || [];
            const container = document.getElementById('streams-container');
            if (streams.length === 0) {
                container.innerHTML = '<p id="no-streams">No active streams at the moment.</p>';
            } else {
                streams.forEach(stream => {
                    let streamDiv = document.getElementById(`stream-${stream.id}`);
                    if (!streamDiv) {
                        streamDiv = document.createElement('div');
                        streamDiv.className = 'stream-container';
                        streamDiv.id = `stream-${stream.id}`;
                        streamDiv.innerHTML = `
                            <div class='stream-video'>
                                <img id='video-${stream.id}' src='' alt='Live Stream'>
                            </div>
                        `;
                        container.appendChild(streamDiv);
                    }
                });
                // Remove streams that are no longer active
                Array.from(container.children).forEach(child => {
                    if (child.id && child.id.startsWith('stream-')) {
                        const streamId = child.id.split('-')[1];
                        if (!streams.some(s => s.id == streamId)) {
                            container.removeChild(child);
                        }
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error fetching streams:', error);
            const container = document.getElementById('streams-container');
            container.innerHTML = `<p>Error loading streams: ${error.message}. Please try again later.</p>`;
        });
        }

        // Log WebSocket connection status
        const socket = io('https://mcceventsjudging.com:3306');
        socket.on('connect', () => {
            console.log('WebSocket connected');
        });
        socket.on('connect_error', (error) => {
            console.error('WebSocket connection error:', error);
        });

        // Initial load of streams
        updateStreams();

        // Update stream list every 30 seconds
        setInterval(updateStreams, 30000);
    </script>
</body>
</html>