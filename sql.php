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

    // SQL to select all data from the sub_event table
    $select_sql = "SELECT * FROM `sub_event`";
    $stmt = $conn->query($select_sql);

    // Display data in an HTML table
    echo "<table border='1'>";
    echo "<tr> 
            <th>Subevent ID</th> 
            <th>Main Event ID</th> 
            <th>Organizer ID</th> 
            <th>Event Name</th> 
            <th>Status</th> 
            <th>Event Date</th> 
            <th>Event Time</th> 
            <th>Place</th> 
            <th>Txtpoll Status</th> 
            <th>View</th> 
            <th>Txtpoll View</th> 
            <th>Banner</th> 
          </tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['subevent_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['mainevent_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['organizer_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['event_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['status']) . "</td>";
        echo "<td>" . htmlspecialchars($row['eventdate']) . "</td>";
        echo "<td>" . htmlspecialchars($row['eventtime']) . "</td>";
        echo "<td>" . htmlspecialchars($row['place']) . "</td>";
        echo "<td>" . htmlspecialchars($row['txtpoll_status']) . "</td>";
        echo "<td>" . htmlspecialchars($row['view']) . "</td>";
        echo "<td>" . htmlspecialchars($row['txtpollview']) . "</td>";
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