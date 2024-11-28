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

    // Reset auto-increment for main_event
    $reset_auto_increment_sql = "ALTER TABLE main_event AUTO_INCREMENT = 1";
    $conn->exec($reset_auto_increment_sql);
    echo "Auto-increment value reset for main_event.<br>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close connection
$conn = null;
?>