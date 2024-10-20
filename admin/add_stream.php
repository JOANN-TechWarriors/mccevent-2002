<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('session.php');
include('dbcon.php');

header('Content-Type: application/json');

function sendResponse($success, $message) {
    echo json_encode(['success' => $success, 'message' => $message]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Validate required fields
        $required_fields = ['organizer_id', 'stream_title', 'channel_name', 'start_time', 'end_time'];
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                sendResponse(false, "Missing required field: $field");
            }
        }

        // Handle file upload
        $upload_dir = '../uploads/';
        $image_url = '';
        
        if (isset($_FILES['stream_banner']) && $_FILES['stream_banner']['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $max_size = 2 * 1024 * 1024; // 2MB
            
            if (!in_array($_FILES['stream_banner']['type'], $allowed_types)) {
                sendResponse(false, 'Invalid file type. Only JPG, PNG, and GIF are allowed.');
            }
            
            if ($_FILES['stream_banner']['size'] > $max_size) {
                sendResponse(false, 'File size exceeds the maximum limit of 2MB.');
            }
            
            $file_name = uniqid() . '_' . $_FILES['stream_banner']['name'];
            $upload_path = $upload_dir . $file_name;
            
            if (!move_uploaded_file($_FILES['stream_banner']['tmp_name'], $upload_path)) {
                sendResponse(false, 'Failed to upload the banner image.');
            }
            
            $image_url = $upload_path;
        }

        $query = "INSERT INTO live_streams (
            organizer_id, stream_title, channel_name, start_time, end_time, 
            stream_status, token, image_url
        ) VALUES (
            :organizer_id, :stream_title, :channel_name, :start_time, :end_time,
            'scheduled', :token, :image_url
        )";

        $token = bin2hex(random_bytes(16));
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':organizer_id', $_POST['organizer_id']);
        $stmt->bindParam(':stream_title', $_POST['stream_title']);
        $stmt->bindParam(':channel_name', $_POST['channel_name']);
        $stmt->bindParam(':start_time', $_POST['start_time']);
        $stmt->bindParam(':end_time', $_POST['end_time']);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':image_url', $image_url);
        
        if ($stmt->execute()) {
            sendResponse(true, 'Stream added successfully');
        } else {
            sendResponse(false, 'Failed to insert data into database');
        }

    } catch(Exception $e) {
        sendResponse(false, 'Failed to add stream: ' . $e->getMessage());
    }
} else {
    sendResponse(false, 'Invalid request method');
}