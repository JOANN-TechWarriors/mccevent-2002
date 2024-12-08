<?php

include "db.php";
// Function to view table contents
function viewTableContents($conn) {
    $sql = "SELECT * FROM live_streams";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Contents of live_streams table:</h2>";
        echo "<table border='1'>";
        echo "<tr>";
        
        // Output table headers
        $fields = $result->fetch_fields();
        foreach ($fields as $field) {
            echo "<th>" . $field->name . "</th>";
        }
        echo "</tr>";

        // Output data of each row
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>" . htmlspecialchars($value ?? 'NULL') . "</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "0 results in live_streams table";
    }
}

// View table contents
viewTableContents($conn);

$conn->close();
?>