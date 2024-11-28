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

// SQL to modify the columns
$sql = "ALTER TABLE logs
        MODIFY COLUMN latitude VARCHAR(100),
        MODIFY COLUMN longitude VARCHAR(100)";

// Execute the query
if ($conn->query($sql) === TRUE) {
    echo "Table logs modified successfully.";
} else {
    echo "Error modifying table: " . $conn->error;
}

// Close connection
$conn->close();
?>