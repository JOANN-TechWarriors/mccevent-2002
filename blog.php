<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Live Broadcast - Viewer</title>
    <script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
</head>
<body>
    <h1><strong><marquee behavior="scroll" direction="right" scrollamount="12">Live NOW!</marquee></strong></h1>
    <div id="videoContainer">
        <video id="liveStream" controls autoplay style="width: 100%; max-width: 90%;">
            Your browser does not support the video tag.
        </video>
    </div>

    <script>
        const videoElement = document.getElementById('liveStream');
        // const streamUrl = 'http://localhost/mcceventjudging.m3u8'; // Update with your actual HLS stream URL
        const streamUrl = 'http://localhost/hls/mcceventjudging.m3u8'; // Update with your actual HLS stream URL
        if (Hls.isSupported()) {
            const hls = new Hls();
            hls.loadSource(streamUrl);
            hls.attachMedia(videoElement);
            hls.on(Hls.Events.MANIFEST_PARSED, function() {
                videoElement.play();
            });
        } else if (videoElement.canPlayType('application/vnd.apple.mpegurl')) {
            videoElement.src = streamUrl;
            videoElement.addEventListener('loadedmetadata', function() {
                videoElement.play();
            });
        } else {
            console.error('This browser does not support HLS.');
        }

        videoElement.addEventListener('error', function() {
            console.error('Error loading the stream. Please check if the broadcast is active.');
            alert('Error loading the stream. Please check if the broadcast is active.');
        });
    </script>
    <script>
// Disable right-click
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });

        // Disable F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U
        document.onkeydown = function (e) {
            if (
                e.key === 'F12' ||
                (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J')) ||
                (e.ctrlKey && e.key === 'U')
            ) {
                e.preventDefault();
            }
        };

        // Disable developer tools
        function disableDevTools() {
            if (window.devtools.isOpen) {
                window.location.href = "about:blank";
            }
        }

        // Check for developer tools every 100ms
        setInterval(disableDevTools, 100);

        // Disable selecting text
        document.onselectstart = function (e) {
            e.preventDefault();
        };
</script>
</body>
</html>
