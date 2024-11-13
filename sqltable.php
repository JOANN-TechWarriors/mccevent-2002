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

// Add email column to admin table
$sql = "ALTER TABLE admin ADD COLUMN email VARCHAR(100)";

if ($conn->query($sql) === TRUE) {
    echo "Email column added successfully to admin table.";
} else {
    echo "Error adding email column: " . $conn->error;
}

$conn->close();
?>