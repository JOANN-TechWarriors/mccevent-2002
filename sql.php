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

    // SQL to drop the main_event table if it exists
    $drop_table_sql = "DROP TABLE IF EXISTS main_event";
    $conn->exec($drop_table_sql);
    echo "Table main_event dropped successfully.<br>";

    // SQL to create the main_event table
    $create_table_sql = "
    CREATE TABLE main_event (
        mainevent_id INT(11) NOT NULL AUTO_INCREMENT,
        event_name TEXT NOT NULL,
        status TEXT NOT NULL,
        organizer_id INT(11) NOT NULL,
        sy VARCHAR(9) NOT NULL,
        date_start TEXT NOT NULL,
        date_end TEXT NOT NULL,
        place TEXT NOT NULL,
        banner VARCHAR(150) NOT NULL,
        PRIMARY KEY (mainevent_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;
    ";
    $conn->exec($create_table_sql);
    echo "Table main_event created successfully.<br>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close connection
$conn = null;
?>