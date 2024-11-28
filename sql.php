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

// SQL to alter the mainevent_id column in main_event
$alter_main_event_id_sql = "ALTER TABLE main_event MODIFY COLUMN mainevent_id INT(11) NOT NULL AUTO_INCREMENT";
if ($conn->query($alter_main_event_id_sql) === TRUE) {
    echo "Table main_event altered successfully for mainevent_id.<br>";
} else {
    echo "Error altering main_event table for mainevent_id: " . $conn->error . "<br>";
}

// SQL to alter the subevent_id column in sub_event
$alter_sub_event_id_sql = "ALTER TABLE sub_event MODIFY COLUMN subevent_id INT(11) NOT NULL AUTO_INCREMENT";
if ($conn->query($alter_sub_event_id_sql) === TRUE) {
    echo "Table sub_event altered successfully for subevent_id.<br>";
} else {
    echo "Error altering sub_event table for subevent_id: " . $conn->error . "<br>";
}

// SQL to alter the mainevent_id column in sub_event
$alter_sub_event_main_event_id_sql = "ALTER TABLE sub_event MODIFY COLUMN mainevent_id INT(11) NOT NULL";
if ($conn->query($alter_sub_event_main_event_id_sql) === TRUE) {
    echo "Table sub_event altered successfully for mainevent_id.<br>";
} else {
    echo "Error altering sub_event table for mainevent_id: " . $conn->error . "<br>";
}

// Close connection
$conn->close();
?>