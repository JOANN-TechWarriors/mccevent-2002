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

// SQL to describe table structure
$sql = "DESCRIBE logs";
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Field</th>
                <th>Type</th>
                <th>Null</th>
                <th>Key</th>
                <th>Default</th>
                <th>Extra</th>
            </tr>";
    
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["Field"]) . "</td>
                <td>" . htmlspecialchars($row["Type"]) . "</td>
                <td>" . htmlspecialchars($row["Null"]) . "</td>
                <td>" . htmlspecialchars($row["Key"]) . "</td>
                <td>" . htmlspecialchars($row["Default"]) . "</td>
                <td>" . htmlspecialchars($row["Extra"]) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>