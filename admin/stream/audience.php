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
        }

        body { 
            background-color: #000; 
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
        }

        .stream-title { 
            background-color: rgba(47, 63, 176, 0.9);
            color: white; 
            padding: 10px;
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
            transition: transform 0.3s ease;
        }

        .rotate-button:hover {
            transform: scale(1.1);
        }

        .rotate-button i {
            font-size: 1.2rem;
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
        }

        /* Portrait orientation specific styles */
        @media screen and (orientation: portrait) {
            .player-wrapper {
                /* Adjust aspect ratio for portrait mode */
                height: 56.25vw; /* 16:9 aspect ratio */
                margin: var(--header-height) auto 0;
            }

            .rotate-button .fa-rotate {
                transform: rotate(90deg);
            }
        }

        /* Landscape orientation specific styles */
        @media screen and (orientation: landscape) {
            .player-wrapper {
                /* Use maximum available height in landscape */
                height: calc(100% - var(--header-height) - var(--controls-height));
            }

            .rotate-button .fa-rotate {
                transform: rotate(0deg);
            }
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
        }
    </style>
</head>
<body>
    <div class="stream-container">
        <div class="stream-title">
            <h1><?php echo htmlspecialchars($stream['stream_title']); ?></h1>
            <button id="rotate-screen" class="rotate-button" title="Rotate Screen">
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
                    <i class="fas fa-eye"></i>
                    <span id="viewer-count">0</span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>
    <script>
        // Create Agora client
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

        // Screen orientation handling
        const rotateButton = document.getElementById('rotate-screen');
        
        async function toggleOrientation() {
            try {
                const screen = window.screen;
                if (screen.orientation) {
                    if (screen.orientation.type.includes('portrait')) {
                        await screen.orientation.lock('landscape');
                    } else {
                        await screen.orientation.lock('portrait');
                    }
                } else {
                    // Fallback for browsers that don't support Screen Orientation API
                    alert('Screen rotation is not supported in your browser');
                }
            } catch (error) {
                console.error('Error rotating screen:', error);
                alert('Unable to rotate screen. Please rotate your device manually.');
            }
        }

        rotateButton.addEventListener('click', toggleOrientation);

        // Handle orientation changes
        window.addEventListener('resize', function() {
            adjustPlayerSize();
        });

        if (screen.orientation) {
            screen.orientation.addEventListener('change', function() {
                adjustPlayerSize();
            });
        }

        function adjustPlayerSize() {
            const playerWrapper = document.querySelector('.player-wrapper');
            const container = document.querySelector('.stream-container');
            const isPortrait = window.innerHeight > window.innerWidth;

            if (isPortrait) {
                // In portrait mode, maintain 16:9 aspect ratio
                const width = container.clientWidth;
                playerWrapper.style.height = (width * 9 / 16) + 'px';
            } else {
                // In landscape mode, use available height
                playerWrapper.style.height = 'calc(100% - var(--header-height) - var(--controls-height))';
            }
        }

        document.addEventListener("DOMContentLoaded", async function() {
            try {
                adjustPlayerSize();
                await join();
                $("#leave").attr("disabled", false);
            } catch (error) {
                console.error(error);
            }
        });

        $("#leave").click(function (e) {
            leave();
        });

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
            console.log("User", user.uid, "left");
            updateViewerCount();
        }

        function updateViewerCount() {
            const count = Object.keys(remoteUsers).length;
            $("#viewer-count").text(count);
        }
    </script>
</body>
</html>