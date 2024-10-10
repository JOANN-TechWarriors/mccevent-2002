<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Streaming with Webcam</title>
</head>
<body>
    <h1>Live Streaming with Webcam</h1>
    <video id="video" width="1000" height="1000" autoplay></video>
    <button id="startButton">Start Streaming</button>
    <button id="stopButton">Stop Streaming</button>

    <script>
        const video = document.getElementById('video');
        const startButton = document.getElementById('startButton');
        const stopButton = document.getElementById('stopButton');
        let stream;

        startButton.addEventListener('click', async () => {
            stream = await navigator.mediaDevices.getUserMedia({ video: true });
            video.srcObject = stream;
        });

        stopButton.addEventListener('click', () => {
            stream.getTracks().forEach(track => track.stop());
        });
    </script>
</body>
</html>
