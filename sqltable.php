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

// Select all data from main_event table
$sql = "SELECT * FROM main_event";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Start the table
    echo "<table border='1' cellpadding='10' cellspacing='0'>";
    
    // Get field information for headers
    $fields = $result->fetch_fields();
    echo "<tr>";
    foreach ($fields as $field) {
        echo "<th style='background-color: #f2f2f2;'>" . $field->name . "</th>";
    }
    echo "</tr>";
    
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . ($value ?? "NULL") . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results found in main_event table";
}

$conn->close();
?>