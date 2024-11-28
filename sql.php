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
        
        // Step 1: Drop the foreign key constraint from the streams table
        $drop_fk_sql = "ALTER TABLE `streams` DROP FOREIGN KEY `streams_ibfk_1`;";
        $conn->exec($drop_fk_sql);
        echo "Foreign key constraint dropped successfully.<br>";

        // Step 2: Modify the organizer_id column in the organizer table
        $alter_sql = "ALTER TABLE `organizer` MODIFY `organizer_id` BIGINT(10) NOT NULL;";
        $conn->exec($alter_sql);
        echo "Table 'organizer' modified successfully.<br>";

        // Step 3: Reapply the foreign key constraint to the streams table
        $add_fk_sql = "
            ALTER TABLE `streams` 
            ADD CONSTRAINT `streams_ibfk_1` 
            FOREIGN KEY (`organizer_id`) 
            REFERENCES `organizer`(`organizer_id`);
        ";
        $conn->exec($add_fk_sql);
        echo "Foreign key constraint reapplied successfully.<br>";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    
    // Close connection
    $conn = null;
?>