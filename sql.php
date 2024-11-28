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

    // SQL to select all data from the upcoming_events table
    $select_sql = "SELECT * FROM `upcoming_events`";
    $stmt = $conn->query($select_sql);

    // Display data in an HTML table
    echo "<table border='1'>";
    echo "<tr>
            <th>ID</th>
            <th>Title</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Banner</th>
            <th>Organizer ID</th>
          </tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
        echo "<td>" . htmlspecialchars($row['start_date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['end_date']) . "</td>";
        echo "<td><img src='" . htmlspecialchars($row['banner']) . "' alt='Banner' width='100'></td>";
        echo "<td>" . htmlspecialchars($row['organizer_id']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close connection
$conn = null;
?>