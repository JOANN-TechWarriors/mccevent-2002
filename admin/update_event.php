<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = '127.0.0.1';
$username = 'u510162695_judging_root';
$password = '1Judging_root';
$dbname = 'u510162695_judging';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$event_id = $_POST['edit_event_id'];
$event_name = $_POST['edit_main_event'];
$date_start = $_POST['edit_date_start'];
$date_end = $_POST['edit_date_end'];
$place = $_POST['edit_place'];
$organizer_id = $_SESSION['id'];

if (isset($_FILES['edit_banner']) && $_FILES['edit_banner']['size'] > 0) {
    $banner = time() . '_' . $_FILES['edit_banner']['name'];
    $target = "../uploads/" . $banner;

    if (move_uploaded_file($_FILES['edit_banner']['tmp_name'], $target)) {
        $sql = "UPDATE upcoming_events SET title=?, start_date=?, end_date=?, banner=?, organizer_id=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $event_name, $date_start, $date_end, $banner, $organizer_id, $event_id);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to upload banner']);
        exit;
    }
} else {
    $sql = "UPDATE upcoming_events SET title=?, start_date=?, end_date=?, organizer_id=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $event_name, $date_start, $date_end, $organizer_id, $event_id);
}

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Event updated successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Error updating event: ' . $stmt->error]);
}

$stmt->close();
$conn->close();

?>