<?php
// Database connection parameters
$host = '127.0.0.1';
$username = 'u510162695_judging_root';
$password = '1Judging_root';
$dbname = 'u510162695_judging';

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to truncate main_event table
$truncate_main_event_sql = "TRUNCATE TABLE main_event";
if ($conn->query($truncate_main_event_sql) === TRUE) {
    echo "All data deleted from main_event table and auto-increment reset.<br>";
} else {
    echo "Error truncating main_event table: " . $conn->error . "<br>";
}

// SQL to truncate sub_event table
$truncate_sub_event_sql = "TRUNCATE TABLE sub_event";
if ($conn->query($truncate_sub_event_sql) === TRUE) {
    echo "All data deleted from sub_event table and auto-increment reset.<br>";
} else {
    echo "Error truncating sub_event table: " . $conn->error . "<br>";
}

// Close connection
$conn->close();
?>