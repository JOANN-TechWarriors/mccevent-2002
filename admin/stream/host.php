<?php
// File: host.php

// Database connection details
include('../session.php');
include "db.php";

// Initialize error message
$error_message = "";

// Check if both stream_id and token are provided in the URL
if(!isset($_GET['id']) || !isset($_GET['token'])) {
    header("Location: ../live_stream.php");
    exit();
}

$stream_id = $_GET['id'];
$provided_token = $_GET['token'];

// Prepare the SQL statement to check both stream_id and token
$stmt = $conn->prepare("SELECT channel_name, token FROM live_streams WHERE stream_id = ?");
$stmt->bind_param("i", $stream_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $channelName = $row['channel_name'];
    $stored_token = $row['token'];

    // Verify that the provided token matches the stored token
    if($provided_token !== $stored_token) {
        // Invalid token, redirect to live_stream.php
        header("Location: ../live_stream.php");
        exit();
    }
} else {
    // Stream not found, redirect to live_stream.php
    header("Location: ../live_stream.php");
    exit();
}

// Close the statement
$stmt->close();

// Here's the rest of your host.php code
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Meta Tags For SEO -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Many to many, live video streaming using the Agora Web NG SDK.">
    <title>Host - Many to Many Live Streaming || Agora Web NG SDK</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link rel="shortcut icon" href="../../images/logo copy.png" />
    <link rel="stylesheet" href="assets/css/m2m-live.css">
    <link rel="icon" href="assets/img/favicon.png" type="image/png">
    <link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png" type="image/png">
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .banner { 
            padding: 10px; 
            background-color: #2F3FB0; 
            color: white; 
            width: 100%;
            position: fixed;
            top: 0;
            z-index: 1000;
            height: 50px;
            box-sizing: border-box;
        }
        .banner-text { 
            padding: 8px 20px; 
            margin: 0; 
        }
        #join-form { 
            margin-top: 50px;
        }
        input { 
            width: 100%; 
            margin-bottom: 2px; 
        }
        /* Adjusted video container with zoom controls */
        .video-container {
            position: fixed;
            top: 50px; /* Aligned with banner height */
            left: 0;
            right: 0;
            bottom: 0;
            background: #000;
            overflow: hidden; /* Prevents scrolling */
        }
        #local-player {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: calc(100vh - 50px); /* Subtract banner height */
            object-fit: cover; /* Changed to cover for better filling */
            transform-origin: center;
            transform: scale(1); /* Initial scale - no zoom */
            background: #000;
        }
        .player-name { 
            position: absolute;
            top: 10px;
            left: 10px;
            color: white;
            z-index: 100;
            margin: 0;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
        }
        /* Control buttons */
        .button-group {
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            background: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 8px;
            display: flex;
            gap: 10px;
        }
        .btn-live { 
            background-color: #2F3FB0; 
            color: white; 
            border: 1px solid #2F3FB0; 
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
        }
        .btn-live:hover { 
            color: #2F3FB0; 
            background-color: white; 
        }
        #channel { 
            display: none; 
        }
        /* Landscape mode optimization */
        @media screen and (orientation: landscape) {
            .video-container {
                height: calc(100vh - 50px);
            }
            #local-player {
                width: 100vw;
                height: 100%;
                object-position: center;
            }
        }
        /* Portrait mode handling */
        @media screen and (orientation: portrait) {
            .video-container {
                height: calc(100vw - 50px);
            }
            #local-player {
                width: 100%;
                height: 100vw;
                object-position: center;
            }
        }
        /* Zoom controls */
        .zoom-controls {
            position: fixed;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 10px;
            background: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 8px;
        }
        .zoom-btn {
            background-color: #2F3FB0;
            color: white;
            border: 1px solid #2F3FB0;
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="banner">
        <p class="banner-text">Live Streaming</p>
    </div>
    <div class="container-fluid">
        <form id="join-form" name="join-form">
            <input id="channel" type="text" placeholder="Enter Channel Name" required>
            <div class="button-group">
                <button id="host-join" type="submit" class="btn-live">Start Live</button>
                <button id="mic-btn" type="button" class="btn-live">
                    <i id="mic-icon" class="fas fa-microphone"></i>
                </button>
                <button id="video-btn" type="button" class="btn-live">
                    <i id="video-icon" class="fas fa-video"></i>
                </button>
                <button id="leave" type="button" class="btn-live" disabled>Stop Live</button>
            </div>
        </form>
        <div class="video-container">
            <!-- <p id="local-player-name" class="player-name"></p> -->
            <div id="local-player"></div>
            <div class="zoom-controls">
                <button class="zoom-btn" onclick="zoomIn()">+</button>
                <button class="zoom-btn" onclick="zoomOut()">-</button>
                <button class="zoom-btn" onclick="resetZoom()">⟲</button>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>
    <script src="assets/js/o2o-voice.js"></script>

    <script>
        let currentZoom = 1;
        const zoomStep = 0.1;
        const maxZoom = 2;
        const minZoom = 1;
        
        function zoomIn() {
            if (currentZoom < maxZoom) {
                currentZoom += zoomStep;
                updateZoom();
            }
        }
        
        function zoomOut() {
            if (currentZoom > minZoom) {
                currentZoom -= zoomStep;
                updateZoom();
            }
        }
        
        function resetZoom() {
            currentZoom = 1;
            updateZoom();
        }
        
        function updateZoom() {
            const player = document.getElementById('local-player');
            player.style.transform = `scale(${currentZoom})`;
        }
    </script>
    
    <script>
        // Set the default channel name
        document.addEventListener("DOMContentLoaded", function() {
            var defaultChannelName = "<?php echo $channelName; ?>";
            document.getElementById("channel").value = defaultChannelName;
        });

        // Create Agora client
        var client = AgoraRTC.createClient({ mode: "live", codec: "vp8" });
        var localTracks = { videoTrack: null, audioTrack: null };
        var localTrackState = { videoTrackEnabled: true, audioTrackEnabled: true };
        var remoteUsers = {};

        // Agora client options
        var options = {
            appid: "639e26f0457a4e85b9e24844db6078cd", // Replace with your Agora App ID
            channel: null,
            uid: null,
            token: null, // Provide token if required
            role: "host" // host or audience
        };

        $("#host-join").click(function (e) {
            options.role = "host";
        });

        $("#join-form").submit(async function (e) {
            e.preventDefault();
            $("#host-join").attr("disabled", true);
            try {
                options.channel = $("#channel").val();
                await join();
            } catch (error) {
                console.error(error);
            } finally {
                $("#leave").attr("disabled", false);
            }
        });

        $("#leave").click(function (e) {
            leave();
        });

        // New function to toggle microphone
        $("#mic-btn").click(async function() {
            if (localTrackState.audioTrackEnabled) {
                await muteAudio();
            } else {
                await unmuteAudio();
            }
        });

        // New function to toggle video
        $("#video-btn").click(async function() {
            if (localTrackState.videoTrackEnabled) {
                await muteVideo();
            } else {
                await unmuteVideo();
            }
        });

        async function join() {
            try {
                console.log("Joining channel:", options.channel);
                
                // Set client role
                client.setClientRole(options.role);
                console.log("Client role set to:", options.role);
                
                // Enable UI controls
                $('#mic-btn').prop('disabled', false);
                $('#video-btn').prop('disabled', false);
                
                // Set up event listeners
                client.on("user-published", handleUserPublished);
                client.on("user-joined", handleUserJoined);
                client.on("user-left", handleUserLeft);
                console.log("Event listeners set up");

                // Join the channel
                options.uid = await client.join(options.appid, options.channel, options.token || null);
                console.log("Successfully joined channel. UID:", options.uid);

                // Get the list of video devices
                const devices = await AgoraRTC.getDevices();
                const videoDevices = devices.filter(device => device.kind === "videoinput");
                console.log("Available video devices:", videoDevices);

                // Create local audio track
                console.log("Creating microphone audio track...");
                localTracks.audioTrack = await AgoraRTC.createMicrophoneAudioTrack();
                console.log("Audio track created successfully");

                // Create local video track with the detected camera
                console.log("Creating camera video track...");
                localTracks.videoTrack = await AgoraRTC.createCameraVideoTrack({
                    deviceId: videoDevices[0].deviceId  // Use the first available camera
                });
                console.log("Video track created successfully");

                showMuteButton();

                // Play local video track
                localTracks.videoTrack.play("local-player");
                $("#local-player-name").text(`localTrack(${options.uid})`);
                console.log("Local video playing");

                // Publish local tracks to channel
                await client.publish(Object.values(localTracks));
                console.log("Local tracks published successfully");
            } catch (error) {
                console.error("Error in join function:", error);
                alert(`Failed to join: ${error.message}`);
            }
        }

        async function leave() {
            for (let trackName in localTracks) {
                var track = localTracks[trackName];
                if (track) {
                    track.stop();
                    track.close();
                    $('#mic-btn').prop('disabled', true);
                    $('#video-btn').prop('disabled', true);
                    localTracks[trackName] = undefined;
                }
            }
            // Remove remote users and player views
            remoteUsers = {};
            $("#remote-playerlist").html("");

            // Leave the channel
            await client.leave();
            $("#local-player-name").text("");
            $("#host-join").attr("disabled", false);
            $("#leave").attr("disabled", true);
            hideMuteButton();
            console.log("Client successfully left channel.");
        }

        async function subscribe(user, mediaType) {
            const uid = user.uid;
            // Subscribe to a remote user
            await client.subscribe(user, mediaType);
            console.log("Successfully subscribed.");
            if (mediaType === 'video') {
                const player = $(`
                    <div id="player-wrapper-${uid}">
                        <p class="player-name">remoteUser(${uid})</p>
                        <div id="player-${uid}" class="player"></div>
                    </div>
                `);
                $("#remote-playerlist").append(player);
                user.videoTrack.play(`player-${uid}`);
            }
            if (mediaType === 'audio') {
                user.audioTrack.play();
            }
        }

        // Handle user published
        function handleUserPublished(user, mediaType) {
            const id = user.uid;
            remoteUsers[id] = user;
            subscribe(user, mediaType);
        }

        // Handle user joined
        function handleUserJoined(user) {
            const id = user.uid;
            remoteUsers[id] = user;
        }

        // Handle user left
        function handleUserLeft(user) {
            const id = user.uid;
            delete remoteUsers[id];
            $(`#player-wrapper-${id}`).remove();
        }

        // Mute audio function
        async function muteAudio() {
            if (!localTracks.audioTrack) return;
            await localTracks.audioTrack.setEnabled(false);
            localTrackState.audioTrackEnabled = false;
            $("#mic-icon").removeClass("fa-microphone").addClass("fa-microphone-slash");
        }

        // Mute video function
        async function muteVideo() {
            if (!localTracks.videoTrack) return;
            await localTracks.videoTrack.setEnabled(false);
            localTrackState.videoTrackEnabled = false;
            $("#video-icon").removeClass("fa-video").addClass("fa-video-slash");
        }

        // Unmute audio function
        async function unmuteAudio() {
            if (!localTracks.audioTrack) return;
            await localTracks.audioTrack.setEnabled(true);
            localTrackState.audioTrackEnabled = true;
            $("#mic-icon").removeClass("fa-microphone-slash").addClass("fa-microphone");
        }

        // Unmute video function
        async function unmuteVideo() {
            if (!localTracks.videoTrack) return;
            await localTracks.videoTrack.setEnabled(true);
            localTrackState.videoTrackEnabled = true;
            $("#video-icon").removeClass("fa-video-slash").addClass("fa-video");
        }

        // Hide mute buttons
        function hideMuteButton() {
            $("#video-btn").css("display", "none");
            $("#mic-btn").css("display", "none");
        }

        // Show mute buttons
        function showMuteButton() {
            $("#video-btn").css("display", "inline-block");
            $("#mic-btn").css("display", "inline-block");
        }
    </script>
</body>
</html>