<?php
include('session.php');
include('dbcon.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Validate required fields
        if (empty($_POST['organizer_id']) || empty($_POST['stream_title']) || 
            empty($_POST['channel_name']) || empty($_POST['start_time']) || 
            empty($_POST['end_time']) || empty($_POST['app_id'])) {
            throw new Exception('All fields are required');
        }

        // Handle file upload
        $upload_dir = '../uploads/';
        $image_url = '';
        
        if (isset($_FILES['stream_banner']) && $_FILES['stream_banner']['error'] == 0) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $max_size = 2 * 1024 * 1024; // 2MB
            
            if (!in_array($_FILES['stream_banner']['type'], $allowed_types)) {
                throw new Exception('Invalid file type. Only JPG, PNG, and GIF are allowed.');
            }
            
            if ($_FILES['stream_banner']['size'] > $max_size) {
                throw new Exception('File size exceeds the maximum limit of 2MB.');
            }
            
            $file_name = uniqid() . '_' . $_FILES['stream_banner']['name'];
            $upload_path = $upload_dir . $file_name;
            
            if (move_uploaded_file($_FILES['stream_banner']['tmp_name'], $upload_path)) {
                $image_url = $upload_path;
            } else {
                throw new Exception('Failed to upload the banner image.');
            }
        }

        $query = "INSERT INTO live_streams (
            organizer_id, 
            stream_title, 
            channel_name, 
            start_time, 
            end_time, 
            stream_status,
            app_id,
            token,
            image_url
        ) VALUES (
            :organizer_id,
            :stream_title,
            :channel_name,
            :start_time,
            :end_time,
            'scheduled',
            :app_id,
            :token,
            :image_url
        )";

        $token = bin2hex(random_bytes(16));
        
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':organizer_id', $_POST['organizer_id']);
        $stmt->bindParam(':stream_title', $_POST['stream_title']);
        $stmt->bindParam(':channel_name', $_POST['channel_name']);
        $stmt->bindParam(':start_time', $_POST['start_time']);
        $stmt->bindParam(':end_time', $_POST['end_time']);
        $stmt->bindParam(':app_id', $_POST['app_id']);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':image_url', $image_url);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Stream added successfully']);
        } else {
            throw new Exception('Failed to insert data');
        }

    } catch(Exception $e) {
        echo json_encode([
            'success' => false, 
            'message' => 'Failed to add stream: ' . $e->getMessage()
        ]);
    }
    exit;
}