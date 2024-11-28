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

// SQL to alter the subevent_id column in sub_event
$alter_sub_event_sql = "ALTER TABLE sub_event MODIFY COLUMN subevent_id VARCHAR(100) NOT NULL";
if ($conn->query($alter_sub_event_sql) === TRUE) {
    echo "Table sub_event altered successfully.<br>";
} else {
    echo "Error altering sub_event table: " . $conn->error . "<br>";
}

// SQL to select all data from main_event
$select_main_event_sql = "SELECT * FROM main_event";
$main_event_result = $conn->query($select_main_event_sql);

// SQL to select all data from sub_event
$select_sub_event_sql = "SELECT * FROM sub_event";
$sub_event_result = $conn->query($select_sub_event_sql);

// Display main_event table
if ($main_event_result->num_rows > 0) {
    echo "<h2>Main Event Table</h2>";
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
    while ($row = $main_event_result->fetch_assoc()) {
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
    echo "0 results in main_event table";
}

// Display sub_event table
if ($sub_event_result->num_rows > 0) {
    echo "<h2>Sub Event Table</h2>";
    echo "<table border='1'>
            <tr>
                <th>Sub Event ID</th>
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
    while ($row = $sub_event_result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["subevent_id"]) . "</td>
                <td>" . htmlspecialchars($row["mainevent_id"]) . "</td>
                <td>" . htmlspecialchars($row["organizer_id"]) . "</td>
                <td>" . htmlspecialchars($row["event_name"]) . "</td>
                <td>" . htmlspecialchars($row["status"]) . "</td>
                <td>" . htmlspecialchars($row["eventdate"]) . "</td>
                <td>" . htmlspecialchars($row["eventtime"]) . "</td>
                <td>" . htmlspecialchars($row["place"]) . "</td>
                <td>" . htmlspecialchars($row["txtpoll_status"]) . "</td>
                <td>" . htmlspecialchars($row["view"]) . "</td>
                <td>" . htmlspecialchars($row["txtpollview"]) . "</td>
                <td>" . htmlspecialchars($row["banner"]) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 results in sub_event table";
}

// Close connection
$conn->close();
?>