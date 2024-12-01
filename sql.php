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

    // Delete all data from main_event table
    $delete_sql = "DELETE FROM `sub_event`";
    $deleted_count = $conn->exec($delete_sql);

    // Reset auto-increment to start from 1
    $reset_sql = "ALTER TABLE `sub_event` AUTO_INCREMENT = 1";
    $conn->exec($reset_sql);

    // Output confirmation message
    echo "Successfully deleted $deleted_count rows from main_event table.<br>";
    echo "Table auto-increment has been reset to 1.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close connection
$conn = null;

?>