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

    // SQL to select all data from the main_event table
    $select_main_sql = "SELECT * FROM `main_event`";
    $stmt_main = $conn->query($select_main_sql);

    // Display data from main_event in an HTML table
    echo "<h2>Main Event Table</h2>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Main Event ID</th>
            <th>Event Name</th>
            <th>Status</th>
            <th>Organizer ID</th>
            <th>School Year</th>
            <th>Date Start</th>
            <th>Date End</th>
            <th>Place</th>
            <th>Banner</th>
          </tr>";

    while ($row = $stmt_main->fetch(PDO::FETCH_ASSOC)) {
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

    // SQL to select all data from the sub_event table
    $select_sub_sql = "SELECT * FROM `sub_event`";
    $stmt_sub = $conn->query($select_sub_sql);

    // Display data from sub_event in an HTML table
    echo "<h2>Sub Event Table</h2>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Sub Event ID</th>
            <th>Main Event ID</th>
            <th>Organizer ID</th>
            <th>Event Name</th>
            <th>Status</th>
            <th>Event Date</th>
            <th>Event Time</th>
            <th>Place</th>
            <th>TxtPoll Status</th>
            <th>View</th>
            <th>TxtPoll View</th>
            <th>Banner</th>
          </tr>";

    while ($row = $stmt_sub->fetch(PDO::FETCH_ASSOC)) {
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

    // SQL to select all data from the organizer table
    $select_organizer_sql = "SELECT * FROM `organizer`";
    $stmt_organizer = $conn->query($select_organizer_sql);

    // Display data from organizer in an HTML table
    echo "<h2>Organizer Table</h2>";
    echo "<table border='1'>";
    echo "<tr>
            <th>Organizer ID</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Username</th>
            <th>Email</th>
            <th>Phone Number</th>
            <th>Access</th>
            <th>Company Name</th>
            <th>Company Address</th>
            <th>Company Telephone</th>
            <th>Company Email</th>
            <th>Company Website</th>
            <th>Request Date</th>
            <th>Request Status</th>
          </tr>";

    while ($row = $stmt_organizer->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['organizer_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['fname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['mname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['lname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['username']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['pnum']) . "</td>";
        echo "<td>" . htmlspecialchars($row['access']) . "</td>";
        echo "<td>" . htmlspecialchars($row['company_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['company_address']) . "</td>";
        echo "<td>" . htmlspecialchars($row['company_telephone']) . "</td>";
        echo "<td>" . htmlspecialchars($row['company_email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['company_website']) . "</td>";
        echo "<td>" . htmlspecialchars($row['request_date']) . "</td>";
        echo "<td>" . htmlspecialchars($row['request_status']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close connection
$conn = null;

?>