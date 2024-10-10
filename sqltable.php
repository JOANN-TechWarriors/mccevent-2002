<?php
try {
    // Establish database connection
    $conn = new PDO('mysql:host=127.0.0.1;port=3306;dbname=u510162695_judging', 'u510162695_judging_root', '1Judging_root');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Handle deletion if 'id' is passed in the URL
    if (isset($_GET['delete_id'])) {
        $id = $_GET['delete_id'];

        // Prepare and execute the delete statement
        $stmt = $conn->prepare("DELETE FROM upcoming_events WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo "Event with ID $id deleted successfully.<br>";
        } else {
            echo "Failed to delete event with ID $id.<br>";
        }

        // Redirect to the same page to avoid re-deleting on refresh
        header("Location: sqltable.php");
        exit();
    }

    // Query to retrieve relevant columns from the upcoming_events table
    $query = $conn->query("SELECT id, title, start_date, end_date, banner, organizer_id FROM upcoming_events");

    // Check if there are any records in the table
    if ($query->rowCount() > 0) {
        // Start HTML table
        echo "<table border='1' cellpadding='10'>";
        echo "<tr>
                <th>ID</th>
                <th>Title</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Banner</th>
                <th>Organizer ID</th>
                <th>Action</th>
              </tr>";

        // Fetch and display each row
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['title']) . "</td>";
            echo "<td>" . htmlspecialchars($row['start_date']) . "</td>";
            echo "<td>" . htmlspecialchars($row['end_date']) . "</td>";
            echo "<td>" . htmlspecialchars($row['banner']) . "</td>";
            echo "<td>" . htmlspecialchars($row['organizer_id']) . "</td>";
            // Add a delete button that links back to the same file with the event ID
            echo "<td><a href='sqltable.php?delete_id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this event?\")'>Delete</a></td>";
            echo "</tr>";
        }

        // End HTML table
        echo "</table>";
    } else {
        echo "No upcoming events found.";
    }
    
} catch (PDOException $e) {
    // Display error if the connection fails
    echo "Connection failed: " . $e->getMessage();
}
?>