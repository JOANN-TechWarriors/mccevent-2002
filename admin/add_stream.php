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

        $query = "INSERT INTO live_streams (
            organizer_id, 
            stream_title, 
            channel_name, 
            start_time, 
            end_time, 
            stream_status,
            app_id,
            token
        ) VALUES (
            :organizer_id,
            :stream_title,
            :channel_name,
            :start_time,
            :end_time,
            'scheduled',
            :app_id,
            :token
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