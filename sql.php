<?php
// Database connection details
$host = '127.0.0.1';
$username = 'u510162595_judging_root';
$password = '1Judging_root';
$dbname = 'u510162595_judging';

try {
    // Create a new PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Prepare and execute the DELETE statement to remove all rows
    $stmt = $pdo->prepare("DELETE FROM main_event");
    $stmt->execute();
    
    // Optionally, reset the auto-increment if needed
    $resetStmt = $pdo->prepare("ALTER TABLE main_event AUTO_INCREMENT = 1");
    $resetStmt->execute();
    
    echo "All data has been successfully deleted from the main_event table.";
} catch(PDOException $e) {
    // Error handling
    echo "Error: " . $e->getMessage();
}
?>