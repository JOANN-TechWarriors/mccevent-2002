<?php
$request = $_SERVER['REQUEST_URI'];
if (substr($request, -4) == '.php') {
    $new_url = substr($request, 0, -4);
    header("Location: $new_url", true, 301);
    exit();
}
?>

<?php
    include "db.php";
    // Connect to the database
    
    // Get stream_id from URL parameter
    $stream_id = isset($_GET['stream_id']) ? intval($_GET['stream_id']) : 0;
    
    // Fetch the channel name and stream title for the given stream_id
    $stmt = $conn->prepare("SELECT channel_name, stream_title FROM live_streams WHERE stream_id = ?");
    $stmt->bind_param("i", $stream_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $stream = $result->fetch_assoc();
    
    // Close the connection
    $conn->close();

    // If stream not found, set default values
    if (!$stream) {
        $stream = [
            'channel_name' => 'Unknown Channel',
            'stream_title' => 'Stream Not Found'
        ];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Live video streaming for <?php echo htmlspecialchars($stream['stream_title']); ?>">
    <link rel="shortcut icon" href="../../images/logo copy.png" />
    <title><?php echo htmlspecialchars($stream['stream_title']); ?> - Live Stream</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --header-height: 50px;
            --controls-height: 50px;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #000;
        }

        body { 
            display: flex;
            flex-direction: column;
            position: fixed;
            width: 100%;
            height: 100%;
        }

        .stream-container { 
            flex: 1;
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
            position: relative;
            transition: transform 0.3s ease-in-out;
        }

        .stream-title { 
            background-color: rgba(47, 63, 176, 0.9);
            color: white; 
            padding: 10px 15px;
            height: var(--header-height);
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 10;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stream-title h1 {
            font-size: 1rem;
            margin: 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            flex: 1;
            padding-right: 10px;
        }

        .player-wrapper { 
            flex: 1;
            position: relative;
            width: 100%;
            height: calc(100% - var(--header-height) - var(--controls-height));
            margin-top: var(--header-height);
            background-color: #000;
        }

        #remote-playerlist {
            width: 100%;
            height: 100%;
            position: relative;
            background-color: #000;
        }

        .player { 
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .controls { 
            background-color: rgba(233, 236, 239, 0.9);
            height: var(--controls-height);
            padding: 0 15px;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
        }

        .btn-live { 
            background-color: #2F3FB0; 
            color: white; 
            border: 1px solid #2F3FB0;
            padding: 5px 15px;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .btn-live:hover:not(:disabled) { 
            color: #2F3FB0; 
            background-color: white; 
        }

        .btn-live:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .rotate-button {
            background: none;
            border: none;
            color: white;
            padding: 5px 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 20;
        }

        .rotate-button:hover {
            transform: scale(1.1);
        }

        .rotate-button i {
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }

        .controls-left, .controls-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .viewer-count-container {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #2F3FB0;
            font-weight: 500;
        }

        /* Rotation styles */
        .stream-container.landscape {
            transform: rotate(90deg);
            transform-origin: center center;
            width: 100vh;
            height: 100vw;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(90deg);
        }

        .stream-container.portrait {
            transform: rotate(0deg);
            transform-origin: center center;
            width: 100%;
            height: 100%;
            position: relative;
            top: 0;
            left: 0;
        }

        /* Fullscreen styles */
        .fullscreen {
            width: 100% !important;
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
        }

        /* Small screen adjustments */
        @media screen and (max-width: 576px) {
            :root {
                --header-height: 40px;
                --controls-height: 40px;
            }

            .stream-title h1 {
                font-size: 0.875rem;
            }

            .controls {
                padding: 0 10px;
            }

            .btn-live {
                padding: 4px 12px;
                font-size: 0.875rem;
            }

            .rotate-button i {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="stream-container portrait">
        <div class="stream-title">
            <h2><?php echo htmlspecialchars($stream['stream_title']); ?></h2>
            <button id="rotate-screen" class="rotate-button" aria-label="Rotate Screen">
                <i class="fas fa-rotate"></i>
            </button>
        </div>
        <div class="player-wrapper">
            <div id="remote-playerlist" class="player"></div>
        </div>
        <div class="controls">
            <div class="controls-left">
                <button id="leave" type="button" class="btn btn-live" disabled>Leave Stream</button>
            </div>
            <div class="controls-right">
                <div class="viewer-count-container">
                    <!-- <i class="fas fa-eye"></i> -->
                    <!-- <span id="viewer-count">0</span> -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>
    <script>
        // Agora client setup
        var client = AgoraRTC.createClient({ mode: "live", codec: "vp8" });
        var remoteUsers = {};

        // Agora client options
        var options = {
            appid: "639e26f0457a4e85b9e24844db6078cd",
            channel: "<?php echo $stream['channel_name']; ?>",
            uid: null,
            token: null,
            role: "audience"
        };

        // Stream container and rotation elements
        const streamContainer = document.querySelector('.stream-container');
        const rotateButton = document.getElementById('rotate-screen');
        const rotateIcon = rotateButton.querySelector('i');
        let isLandscape = false;
        let isFullscreen = false;

        // Fullscreen handling
        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => {
                    console.log('Error attempting to enable fullscreen:', err);
                });
                isFullscreen = true;
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
                isFullscreen = false;
            }
        }

        // Screen rotation
        async function toggleRotation() {
            isLandscape = !isLandscape;
            
            streamContainer.classList.toggle('landscape');
            streamContainer.classList.toggle('portrait');
            
            rotateIcon.style.transform = isLandscape ? 'rotate(90deg)' : 'rotate(0deg)';
            
            if (isLandscape && !isFullscreen) {
                await toggleFullscreen();
            }
            
            adjustPlayerSize();
            
            // Force video resize after rotation
            setTimeout(adjustPlayerSize, 300);
        }

        // Screen rotation handler
        async function handleRotation() {
            try {
                if (screen.orientation && screen.orientation.lock) {
                    const currentOrientation = screen.orientation.type;
                    if (currentOrientation.includes('portrait')) {
                        await screen.orientation.lock('landscape');
                    } else {
                        await screen.orientation.lock('portrait');
                    }
                } else {
                    await toggleRotation();
                }
            } catch (error) {
                console.log('Using CSS rotation fallback');
                await toggleRotation();
            }
        }

        // Event listeners
        rotateButton.addEventListener('click', async (e) => {
            e.preventDefault();
            await handleRotation();
        });

        document.addEventListener('fullscreenchange', () => {
            isFullscreen = !!document.fullscreenElement;
            adjustPlayerSize();
        });

        window.addEventListener('resize', () => {
            adjustPlayerSize();
        });

        // Player size adjustment
        function adjustPlayerSize() {
            const playerWrapper = document.querySelector('.player-wrapper');
            
            if (isLandscape) {
                const screenWidth = window.innerWidth;
                const screenHeight = window.innerHeight;
                
                playerWrapper.style.width = `${screenHeight}px`;
                playerWrapper.style.height = `${screenWidth}px`;
            } else {
                const containerWidth = streamContainer.clientWidth;
                playerWrapper.style.width = '100%';
                playerWrapper.style.height = `${containerWidth * 9 / 16}px`;
            }

            // Update video elements
            const videos = document.querySelectorAll('.player');
            videos.forEach(video => {
                if (video.style) {
                    video.style.width = '100%';
                    video.style.height = '100%';
                }
            });
        }

        // Agora client functions
        async function join() {
            client.setClientRole(options.role);

            client.on("user-published", handleUserPublished);
            client.on("user-unpublished", handleUserUnpublished);
            client.on("user-joined", handleUserJoined);
            client.on("user-left", handleUserLeft);

            options.uid = await client.join(options.appid, options.channel, options.token || null);
        }

        async function leave() {
            remoteUsers = {};
            $("#remote-playerlist").html("");
            await client.leave();
            $("#leave").attr("disabled", true);
            console.log("Client left channel");
        }

        async function subscribe(user, mediaType) {
            const uid = user.uid;
            await client.subscribe(user, mediaType);
            console.log("Subscribed to", uid);
            if (mediaType === 'video') {
                const player = $(`<div id="player-${uid}" class="player"></div>`);
                $("#remote-playerlist").html(player);
                user.videoTrack.play(`player-${uid}`);
            }
            if (mediaType === 'audio') {
                user.audioTrack.play();
            }
        }

        function handleUserPublished(user, mediaType) {
            const id = user.uid;
            remoteUsers[id] = user;
            subscribe(user, mediaType);
        }

        function handleUserUnpublished(user, mediaType) {
            if (mediaType === 'video') {
                const id = user.uid;
                delete remoteUsers[id];
                $(`#player-${id}`).remove();
            }
        }

        function handleUserJoined(user) {
            console.log("User", user.uid, "joined");
            updateViewerCount();
        }

        function handleUserLeft(user) {
            console.log("User", user.left, "left");
            updateViewerCount();
        }

        function updateViewerCount() {
            const count = Object.keys(remoteUsers).length;
            $("#viewer-count").text(count);
        }

        // Initialize
        document.addEventListener("DOMContentLoaded", async function() {
            try {
                adjustPlayerSize();
                await join();
                $("#leave").attr("disabled", false);
            } catch (error) {
                console.error("Error during initialization:", error);
            }
        });

        // Handle visibility change
        document.addEventListener("visibilitychange", function() {
            if (document.hidden) {
                // Page is hidden
                if (isLandscape) {
                    streamContainer.classList.remove('landscape');
                    streamContainer.classList.add('portrait');
                    isLandscape = false;
                    rotateIcon.style.transform = 'rotate(0deg)';
                }
            }
            adjustPlayerSize();
        });
    </script>
</body>
</html>