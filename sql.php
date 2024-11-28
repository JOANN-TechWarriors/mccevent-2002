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

// SQL to alter the mainevent_id column
$sql = "ALTER TABLE main_event MODIFY COLUMN mainevent_id VARCHAR(100) NOT NULL";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "Table main_event altered successfully.";
} else {
    echo "Error altering table: " . $conn->error;
}

// Close connection
$conn->close();
?>