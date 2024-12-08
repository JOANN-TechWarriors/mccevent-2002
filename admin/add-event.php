<?php
$host = '127.0.0.1';
$username = 'u510162695_judging_root';
$password = '1Judging_root';  // Replace with the actual password
$dbname = 'u510162695_judging';


$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";

// Handle file upload
$banner = "";
if(isset($_FILES['banner']) && $_FILES['banner']['error'] == 0) {
    $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
    $filename = $_FILES["banner"]["name"];
    $filetype = $_FILES["banner"]["type"];
    $filesize = $_FILES["banner"]["size"];

    // Verify file extension
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");

    // Verify file size - 5MB maximum
    $maxsize = 5 * 1024 * 1024;
    if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");

    // Verify MYME type of the file
    if(in_array($filetype, $allowed)) {
        // Check whether file exists before uploading it
        if(file_exists("uploads/" . $filename)) {
            echo $filename . " is already exists.";
        } else {
            if(move_uploaded_file($_FILES["banner"]["tmp_name"], "uploads/" . $filename)) {
                $banner = "uploads/" . $filename;
            } else {
                echo "File is not uploaded";
            }
        }
    } else {
        echo "Error: There was a problem uploading your file. Please try again."; 
    }
}

// Insert event into database
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];
$sql = "INSERT INTO upcoming_events (id, title, start_date, end_date, banner) VALUES (null, '$title', '$start', '$end', '$banner')";
$result = mysqli_query($conn, $sql);

if($result) {
    echo "Event added successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>