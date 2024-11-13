<?php
// Connect to database
$host = '127.0.0.1';
$username = 'u510162695_judging_root';
$password = '1Judging_root';  // Replace with the actual password
$dbname = 'u510162695_judging';

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Array of SQL statements to add multiple columns
$sqlStatements = [
    "ALTER TABLE admin ADD COLUMN code VARCHAR(6)",  // For verification codes
    "ALTER TABLE admin ADD COLUMN token VARCHAR(255)",  // For authentication/reset tokens
    "ALTER TABLE admin ADD COLUMN token_expiration DATETIME",  // For token expiration timestamp
    "ALTER TABLE admin ADD COLUMN phone VARCHAR(20)"  // For phone numbers
];

// Execute each statement
$success = true;
foreach ($sqlStatements as $sql) {
    if ($conn->query($sql) !== TRUE) {
        echo "Error executing query: " . $sql . "\n";
        echo "Error message: " . $conn->error . "\n";
        $success = false;
    }
}

if ($success) {
    echo "All columns added successfully to admin table.";
}

$conn->close();
?>