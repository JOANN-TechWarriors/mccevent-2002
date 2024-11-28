<?php
function modifyMaineventIdColumn($host, $username, $password, $dbname) {
    try {
        // Create a new PDO connection
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // SQL to modify the mainevent_id column
        $alter_sql = "ALTER TABLE main_event MODIFY COLUMN mainevent_id BIGINT NOT NULL";

        // Execute the SQL command
        $conn->exec($alter_sql);
        echo "Column mainevent_id modified successfully.";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Close connection
        $conn = null;
    }
}

// Usage
$host = '127.0.0.1';
$username = 'u510162695_judging_root';
$password = '1Judging_root';
$dbname = 'u510162695_judging';

modifyMaineventIdColumn($host, $username, $password, $dbname);
?>