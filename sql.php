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

// SQL to alter the mainevent_id column
$alter_sql = "ALTER TABLE main_event MODIFY COLUMN mainevent_id VARCHAR(100) NOT NULL";

// Execute the alter query
if ($conn->query($alter_sql) === TRUE) {
    echo "Table main_event altered successfully.<br>";
} else {
    echo "Error altering table: " . $conn->error . "<br>";
}

// SQL to select all data from main_event
$select_sql = "SELECT * FROM main_event";
$result = $conn->query($select_sql);

// Check if there are any results
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Main Event ID</th>
                <th>Event Name</th>
                <th>Status</th>
                <th>Organizer ID</th>
                <th>SY</th>
                <th>Date Start</th>
                <th>Date End</th>
                <th>Place</th>
                <th>Banner</th>
            </tr>";
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["mainevent_id"]) . "</td>
                <td>" . htmlspecialchars($row["event_name"]) . "</td>
                <td>" . htmlspecialchars($row["status"]) . "</td>
                <td>" . htmlspecialchars($row["organizer_id"]) . "</td>
                <td>" . htmlspecialchars($row["sy"]) . "</td>
                <td>" . htmlspecialchars($row["date_start"]) . "</td>
                <td>" . htmlspecialchars($row["date_end"]) . "</td>
                <td>" . htmlspecialchars($row["place"]) . "</td>
                <td>" . htmlspecialchars($row["banner"]) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>