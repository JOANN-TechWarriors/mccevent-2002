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
    
        // SQL to select all data from the organizer table
        $select_sql = "SELECT * FROM `organizer`";
        $stmt = $conn->query($select_sql);
    
        // Display data in an HTML table
        echo "<table border='1'>";
        echo "<tr>
                <th>Organizer ID</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Company Name</th>
                <th>Company Email</th>
                <th>Request Date</th>
                <th>Request Status</th>
              </tr>";
    
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['organizer_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['fname']) . "</td>";
            echo "<td>" . htmlspecialchars($row['mname']) . "</td>";
            echo "<td>" . htmlspecialchars($row['lname']) . "</td>";
            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['pnum']) . "</td>";
            echo "<td>" . htmlspecialchars($row['company_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['company_email']) . "</td>";
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