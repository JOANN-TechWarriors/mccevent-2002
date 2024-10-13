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
        #debug-log {
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            padding: 10px;
            margin-top: 20px;
            font-family: monospace;
            white-space: pre-wrap;
        }
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
        #error-message {
            background-color: #ffeeee;
            border: 1px solid #ffcccc;
            color: #ff0000;
            padding: 10px;
            margin-top: 20px;
            text-align: center;
        }
        #loading {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>Available Live Streams</h1>
    <div id="loading">Loading streams...</div>
    <div id="error-message" style="display: none;"></div>
    <div id="streams-container"></div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"></script>
    <script>
        const streamsContainer = document.getElementById('streams-container');
        const errorMessage = document.getElementById('error-message');
        const loading = document.getElementById('loading');
        let socket;
        let reconnectAttempts = 0;
        const maxReconnectAttempts = 5;

        function showError(message) {
            errorMessage.textContent = message;
            errorMessage.style.display = 'block';
        }

        function hideError() {
            errorMessage.style.display = 'none';
        }

        function connectWebSocket() {
            if (reconnectAttempts >= maxReconnectAttempts) {
                showError('Maximum reconnection attempts reached. Please refresh the page.');
                return;
            }

            socket = io('https://mcceventsjudging.com:3306', {
                transports: ['websocket'],
                upgrade: false,
                reconnection: false,
                timeout: 10000
            });

            socket.on('connect', () => {
                console.log('Connected to WebSocket server');
                hideError();
                reconnectAttempts = 0;
            });

            socket.on('connect_error', (error) => {
                console.error('WebSocket connection error:', error);
                reconnectAttempts++;
                showError(`WebSocket connection error. Retrying... (${reconnectAttempts}/${maxReconnectAttempts})`);
                setTimeout(connectWebSocket, 5000);
            });

            socket.on('stream', (data) => {
                const img = document.getElementById(`video-${data.streamId}`);
                if (img) {
                    img.src = data.imageData;
                }
            });
        }

        function updateStreams() {
            loading.style.display = 'block';
            fetch('get_streams.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(streams => {
                    loading.style.display = 'none';
                    if (streams.length === 0) {
                        streamsContainer.innerHTML = '<p>No active streams at the moment.</p>';
                        return;
                    }
                    streamsContainer.innerHTML = '';
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
                        streamsContainer.appendChild(streamDiv);
                    });
                    hideError();
                })
                .catch(error => {
                    console.error('Error fetching streams:', error);
                    loading.style.display = 'none';
                    showError('Error loading streams. Please try again later.');
                });
        }

        // Initial connection and update
        connectWebSocket();
        updateStreams();

        // Update stream list every 30 seconds
        setInterval(updateStreams, 30000);
    </script>
</body>
</html>