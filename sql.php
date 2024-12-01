<?php
// Database connection details
$host = '127.0.0.1';
$username = 'u510162595_judging_root';
$password = '1Judging_root';
$dbname = 'u510162595_judging';

/**
 * Generate and download a SQL dump of the entire database
 * @throws Exception If database connection or dump fails
 */
function downloadDatabaseBackup() {
    global $host, $username, $password, $dbname;
    
    try {
        // Create connection
        $conn = new mysqli($host, $username, $password, $dbname);
        
        // Check connection
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        
        // Disable output buffering to prevent memory issues with large databases
        @ob_end_clean();
        
        // Set headers for file download
        header('Content-Type: application/sql');
        header('Content-Disposition: attachment; filename="' . $dbname . '_backup_' . date('Y-m-d_H-i-s') . '.sql"');
        header('Pragma: no-cache');
        header('Expires: 0');
        
        // Get all table names in the database
        $tables = [];
        $result = $conn->query("SHOW TABLES");
        while ($row = $result->fetch_row()) {
            $tables[] = $row[0];
        }
        
        // Start SQL dump
        $output = "-- Database: $dbname\n";
        $output .= "-- Backup created on: " . date('Y-m-d H:i:s') . "\n\n";
        $output .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
        $output .= "START TRANSACTION;\n";
        $output .= "SET time_zone = \"+00:00\";\n\n";
        
        // Dump each table
        foreach ($tables as $table) {
            // Table structure
            $output .= "-- Table structure for table `$table`\n";
            $output .= "DROP TABLE IF EXISTS `$table`;\n";
            $createTable = $conn->query("SHOW CREATE TABLE `$table`");
            $row = $createTable->fetch_row();
            $output .= $row[1] . ";\n\n";
            
            // Table data
            $output .= "-- Dumping data for table `$table`\n";
            $select = $conn->query("SELECT * FROM `$table`");
            while ($row = $select->fetch_row()) {
                $row_output = "INSERT INTO `$table` VALUES (";
                foreach ($row as $value) {
                    // Escape and quote the value
                    $value = $conn->real_escape_string($value);
                    $row_output .= ($value !== null) ? "'$value'" : "NULL";
                    $row_output .= ", ";
                }
                $row_output = rtrim($row_output, ", ") . ");\n";
                $output .= $row_output;
            }
            $output .= "\n";
        }
        
        $output .= "COMMIT;\n";
        
        // Output the SQL dump
        echo $output;
        
        // Close connection
        $conn->close();
        
        // Stop further script execution
        exit();
        
    } catch (Exception $e) {
        // Handle any errors
        die("Database Backup Error: " . $e->getMessage());
    }
}

// Call the function immediately when the script is loaded
downloadDatabaseBackup();
?>