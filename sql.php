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
    
        // Fetch data from the admin table
        $select_sql = "SELECT id, username, password, email, token FROM admin";
        $stmt = $conn->query($select_sql);
        
        // Display data in an HTML table
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Username</th><th>Password</th><th>Email</th><th>Token</th></tr>";
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['username']) . "</td>";
            echo "<td>" . htmlspecialchars($row['password']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['token']) . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    
    // Close connection
    $conn = null;
?>