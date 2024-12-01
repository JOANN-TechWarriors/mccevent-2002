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

    // List of tables to display
    $tables = ['main_event', 'sub_event', 'organizer'];

    // Loop through each table and display its columns and data
    foreach ($tables as $table) {
        // Get column information
        $columns_query = "SHOW COLUMNS FROM `$table`";
        $columns_stmt = $conn->query($columns_query);
        $columns = $columns_stmt->fetchAll(PDO::FETCH_COLUMN);

        // SQL to select all data from the current table
        $select_sql = "SELECT * FROM `$table`";
        $stmt = $conn->query($select_sql);

        // Display table name and header
        echo "<h2>$table Table Columns:</h2>";
        echo implode(', ', $columns) . "<br><br>";

        // Display data from the table in an HTML table
        echo "<table border='1'>";
        
        // Create table header
        echo "<tr>";
        foreach ($columns as $column) {
            echo "<th>" . htmlspecialchars($column) . "</th>";
        }
        echo "</tr>";

        // Display table rows
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            foreach ($columns as $column) {
                echo "<td>" . htmlspecialchars($row[$column]) . "</td>";
            }
            echo "</tr>";
        }
        echo "</table><br><br>";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close connection
$conn = null;

?>