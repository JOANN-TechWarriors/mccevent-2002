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

// SQL to create logs table
$sql = "CREATE TABLE IF NOT EXISTS `logs` (
    `id` varchar(45) NOT NULL,
    `ip` varchar(45) NOT NULL,
    `username` varchar(100) NOT NULL,
    `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
    `latitude` int(11) NOT NULL,
    `longitude` int(11) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

// Execute query
if ($conn->query($sql) === TRUE) {
    echo "Table 'logs' created successfully or already exists.";
} else {
    echo "Error creating table: " . $conn->error;
}

// Close connection
$conn->close();
?>