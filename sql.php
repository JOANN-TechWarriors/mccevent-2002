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
    
        // SQL to add the token column to the admin table
        $alter_table_sql = "ALTER TABLE admin ADD COLUMN token VARCHAR(100)";
        $conn->exec($alter_table_sql);
        echo "Column 'token' added successfully to admin table.<br>";
        
        // Generate a temporary token
        $temporary_token = bin2hex(random_bytes(50)); // Generates a 100-character hexadecimal string
        
        // SQL to update the token column with the temporary token
        $update_token_sql = "UPDATE admin SET token = :token";
        $stmt = $conn->prepare($update_token_sql);
        $stmt->bindParam(':token', $temporary_token);
        $stmt->execute();
        
        echo "Temporary token inserted successfully into the token column for all rows.<br>";
    
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    
    // Close connection
    $conn = null;
?>