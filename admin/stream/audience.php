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
    <title><?php echo htmlspecialchars($stream['stream_title']); ?> - Live Stream</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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
        }
        .stream-container { 
            flex: 1;
            display: flex;
            flex-direction: column;
            width: 100%;
            height: 100%;
        }
        .stream-title { 
            background-color: rgba(47, 63, 176, 0.8);
            color: white; 
            padding: 5px 10px;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            z-index: 10;
        }
        .player-wrapper { 
            flex: 1;
            position: relative;
            width: 100%;
            height: calc(100% - 50px); /* Adjust based on your controls height */
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
            background-color: rgba(233, 236, 239, 0.8);
            padding: 5px 10px;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-live { 
            background-color: #2F3FB0; 
            color: white; 
            border: 1px solid #2F3FB0; 
        }
        .btn-live:hover { 
            color: #2F3FB0; 
            background-color: white; 
        }
    </style>
</head>
<body>
    <div class="stream-container">
        <div class="stream-title">
            <h1 class="h5 mb-0"><?php echo htmlspecialchars($stream['stream_title']); ?></h1>
        </div>
        <div class="player-wrapper">
            <div id="remote-playerlist" class="player"></div>
        </div>
        <div class="controls">
            <button id="leave" type="button" class="btn btn-live btn-sm" disabled>Leave Stream</button>
            <span>Viewers: <span id="viewer-count">0</span></span>
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

        document.addEventListener("DOMContentLoaded", async function() {
            try {
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
                $("#remote-playerlist").append(player);
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