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

    // SQL to modify the judges table
    $alter_judges_sql = "
        ALTER TABLE `judges`
        MODIFY `judge_id` BIGINT NOT NULL,
        MODIFY `subevent_id` BIGINT NOT NULL;
    ";

    // SQL to modify the criteria table
    $alter_criteria_sql = "
        ALTER TABLE `criteria`
        MODIFY `criteria_id` BIGINT NOT NULL,
        MODIFY `subevent_id` BIGINT NOT NULL;
    ";

    // Execute the SQL statements
    $conn->exec($alter_judges_sql);
    $conn->exec($alter_criteria_sql);

    echo "Tables modified successfully.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close connection
$conn = null;
?>