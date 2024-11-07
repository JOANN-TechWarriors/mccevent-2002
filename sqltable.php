<?php
// Connect to database
$host = '127.0.0.1';
$username = 'u510162695_judging_root';
$password = '1Judging_root';  // Replace with the actual password
$dbname = 'u510162695_judging';

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add password column
$sql = "ALTER TABLE student ADD COLUMN password VARCHAR(100)";

if ($conn->query($sql) === TRUE) {
    echo "Password column added successfully.";
} else {
    echo "Error adding password column: " . $conn->error;
}

$conn->close();
?>