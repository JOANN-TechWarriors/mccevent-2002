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
        $imageUrl = null;
        if (isset($_FILES['stream_banner']) && $_FILES['stream_banner']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            
            // Create directory if it doesn't exist
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            // Get file information
            $fileName = $_FILES['stream_banner']['name'];
            $fileType = $_FILES['stream_banner']['type'];
            $fileTmpName = $_FILES['stream_banner']['tmp_name'];
            $fileSize = $_FILES['stream_banner']['size'];
            
            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!in_array($fileType, $allowedTypes)) {
                throw new Exception('Invalid file type. Only JPG, PNG and GIF files are allowed.');
            }
            
            // Validate file size (2MB max)
            if ($fileSize > 2 * 1024 * 1024) {
                throw new Exception('File size is too large. Maximum size is 2MB.');
            }
            
            // Generate unique filename
            $newFileName = uniqid() . '_' . $fileName;
            $uploadPath = $uploadDir . $newFileName;
            
            // Move uploaded file
            if (!move_uploaded_file($fileTmpName, $uploadPath)) {
                throw new Exception('Failed to upload file.');
            }
            
            $imageUrl = $uploadPath;
        }

        $query = "INSERT INTO live_streams (
            organizer_id, 
            stream_title, 
            channel_name, 
            start_time, 
            end_time, 
            stream_status,
            app_id,
            image_url,
            token
        ) VALUES (
            :organizer_id,
            :stream_title,
            :channel_name,
            :start_time,
            :end_time,
            'scheduled',
            :app_id,
            :image_url,
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
        $stmt->bindParam(':image_url', $imageUrl);
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
?>