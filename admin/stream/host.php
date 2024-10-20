<?php
// Database connection details
include('../session.php');
include "db.php";

// Check if stream_id is provided in the URL
if(isset($_GET['id'])) {
    $stream_id = $_GET['id'];
} else {
    die("Error: No stream ID provided");
}

// Prepare the SQL statement
$stmt = $conn->prepare("SELECT channel_name FROM live_streams WHERE stream_id = ?");
$stmt->bind_param("i", $stream_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0) {
    $channelName = $result->fetch_assoc()['channel_name'];
} else {
    die("Error: Stream not found");
}

// Close the statement and connection
$stmt->close();
$conn->close();
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
    <link rel="stylesheet" href="assets/css/m2m-live.css">
    <link rel="icon" href="assets/img/favicon.png" type="image/png">
    <link rel="apple-touch-icon" href="assets/img/apple-touch-icon.png" type="image/png">
    <style>
        .banner { padding: 10px; background-color: #2F3FB0; color: white; }
        .banner-text { padding: 8px 20px; margin: 0; }
        #join-form { margin-top: 10px; }
        .tips { font-size: 12px; margin-bottom: 2px; color: gray; }
        .join-info-text { margin-bottom: 2px; }
        input { width: 100%; margin-bottom: 2px; }
        .player { width: 480px; height: 320px; }
        .player-name { margin: 8px 0; }
        @media (max-width: 640px) { .player { width: 320px; height: 240px; } }
        .btn-live { background-color: #2F3FB0; color: white; border: 1px solid #2F3FB0; }
        .btn-live:hover { color: #2F3FB0; background-color: white; border: 1px solid #2F3FB0; }
        #channel { display: none; } /* Hide the input field */
    </style>
</head>
<body>
    <!-- Title -->
    <div class="container-fluid banner">
        <p class="banner-text">Live Broadcast - Host</p>
    </div>
    <div class="container">
        <form id="join-form" name="join-form" class="mt-4">
            <!-- Hidden Input Field -->
            <div class="row join-info-group">
                <div class="col-sm">
                    <p class="join-info-text">Channel</p>
                    <input id="channel" type="text" placeholder="Enter Channel Name" required class="form-control">
                </div>
            </div>
            <!-- UI Controls -->
            <div class="button-group mt-3">
                <button id="host-join" type="submit" class="btn btn-live btn-sm">Join as Host</button>
                <button id="mic-btn" type="button" class="btn btn-live btn-sm">
                    <i id="mic-icon" class="fas fa-microphone"></i>
                </button>
                <button id="video-btn" type="button" class="btn btn-live btn-sm">
                    <i id="video-icon" class="fas fa-video"></i>
                </button>
                <button id="leave" type="button" class="btn btn-live btn-sm" disabled>Leave</button>
            </div>
        </form>
        <!-- Streams -->
        <div class="row video-group">
            <div class="col">
                <p id="local-player-name" class="player-name"></p>
                <div id="local-player" class="player"></div>
            </div>
            <div class="w-100"></div>
            <div class="col">
                <div id="remote-playerlist"></div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="https://download.agora.io/sdk/release/AgoraRTC_N.js"></script>
    <script src="assets/js/o2o-voice.js"></script>
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