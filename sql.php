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

    // Fetch data from the main_event table
    $select_sql = "SELECT mainevent_id, event_name, status, organizer_id, sy, date_start, date_end, place, banner FROM main_event";
    $stmt = $conn->query($select_sql);

    // Display data in an HTML table
    echo "<table border='1'>";
    echo "<tr>
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

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['mainevent_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['event_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
        echo "<td>" . htmlspecialchars($row['organizer_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['sy']) . "</td>";
        echo "<td>" . htmlspecialchars($row['date_start']) . "</td>";
        echo "<td>" . htmlspecialchars($row['date_end']) . "</td>";
        echo "<td>" . htmlspecialchars($row['place']) . "</td>";
        echo "<td>" . htmlspecialchars($row['banner']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close connection
$conn = null;
?>