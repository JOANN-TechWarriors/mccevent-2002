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