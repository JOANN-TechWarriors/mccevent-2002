<?php
include 'dbcon.php';
include('session.php');

$organizer_id = $_SESSION['id']; // Get the organizer's ID from the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventTitle = $_POST['eventtitle'];
    $eventStart = $_POST['eventstart'];
    $eventEnd = $_POST['event_end'];

    // Check for date and time conflicts for this organizer
    $checkSQL = "SELECT * FROM upcoming_events WHERE 
                organizer_id = :organizer_id AND
                (:start_date BETWEEN start_date AND end_date 
                OR :end_date BETWEEN start_date AND end_date 
                OR (start_date BETWEEN :start_date AND :end_date) 
                OR (end_date BETWEEN :start_date AND :end_date))";
    $checkStmt = $conn->prepare($checkSQL);
    $checkStmt->bindParam(':organizer_id', $organizer_id);
    $checkStmt->bindParam(':start_date', $eventStart);
    $checkStmt->bindParam(':end_date', $eventEnd);
    $checkStmt->execute();
    $conflict = $checkStmt->fetch();

    if ($conflict) {
        $error = "An event with the same date and time already exists.";
    } else {
        // Handle file upload
        $targetDir = "../uploads/";
        $targetFile = $targetDir . basename($_FILES["banner"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["banner"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $error = "File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["banner"]["size"] > 500000) {
            $error = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // If everything is ok, try to upload file
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["banner"]["tmp_name"], $targetFile)) {
                $bannerPath = $targetFile;

                // Generate a random 10-digit number for the id
                $id = random_int(1000000000, 9999999999);

                // Insert data into the database
                $sql = "INSERT INTO upcoming_events (id, title, banner, start_date, end_date, organizer_id) VALUES (:id, :title, :banner, :start_date, :end_date, :organizer_id)";
                $stmt = $conn->prepare($sql);

                $stmt->bindParam(':id', $id);
                $stmt->bindParam(':title', $eventTitle);
                $stmt->bindParam(':banner', $bannerPath);
                $stmt->bindParam(':start_date', $eventStart);
                $stmt->bindParam(':end_date', $eventEnd);
                $stmt->bindParam(':organizer_id', $organizer_id);

                if ($stmt->execute()) {
                    $success = "New event added successfully";
                } else {
                    $error = "Error: " . $stmt->errorInfo()[2];
                }
            } else {
                $error = "Sorry, there was an error uploading your file.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
    <?php
    if (isset($success)) {
        echo "Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '$success',
            confirmButtonText: 'OK'
        }).then((result) => {
            window.location.href = 'upcoming_events';
        });";
    } elseif (isset($error)) {
        echo "Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '$error',
            confirmButtonText: 'OK'
        }).then((result) => {
            window.location.href = 'upcoming_events';
        });";
    }
    ?>
    </script>
</body>
</html>