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

    // SQL to modify the columns
    $alter_sql = "
        ALTER TABLE `contestants`
        MODIFY `contestant_id` BIGINT NOT NULL,
        MODIFY `subevent_id` BIGINT NOT NULL;
    ";

    // Execute the SQL statement
    $conn->exec($alter_sql);

    echo "Columns modified successfully.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close connection
$conn = null;
?>