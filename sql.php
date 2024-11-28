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
    $alter_sql_subevent = "ALTER TABLE `sub_event` MODIFY COLUMN `subevent_id` BIGINT NOT NULL";
    $alter_sql_mainevent = "ALTER TABLE `sub_event` MODIFY COLUMN `mainevent_id` BIGINT NOT NULL";

    // Execute the SQL statements
    $conn->exec($alter_sql_subevent);
    $conn->exec($alter_sql_mainevent);

    echo "Columns `subevent_id` and `mainevent_id` modified successfully to BIGINT.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close connection
$conn = null;
?>