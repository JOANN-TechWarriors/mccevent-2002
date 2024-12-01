<?php

// Database connection parameters
$host = '127.0.0.1';
$username = 'u510162695_judging_root';
$password = '1Judging_root';
$dbname = 'u510162695_judging';

try {
    // Create a new PDO connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL to alter the column type
    $alter_sql = "ALTER TABLE `live_streams` MODIFY COLUMN `organizer_id` BIGINT(10)";
    
    // Execute the alter table statement
    $conn->exec($alter_sql);

    echo "Successfully modified the organizer_id column to BIGINT(10)";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close connection
$conn = null;

?>