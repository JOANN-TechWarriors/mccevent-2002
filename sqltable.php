<?php
// Connect to database
$host = '127.0.0.1';
$username = 'u510162695_judging_root';
$password = '1Judging_root';  // Replace with the actual password
$dbname = 'u510162695_judging';

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update email and phone for admin
$email = "joannrebamonte80@gmail.com";
$phone = "09959631846";

// Using prepared statement to prevent SQL injection
$sql = "UPDATE admin SET email = ?, phone = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $email, $phone);

if ($stmt->execute()) {
    echo "Email and phone number updated successfully.";
} else {
    echo "Error updating record: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>