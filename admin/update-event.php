<?php
// Database connection
include 'dbcon.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['eventID'];
    $title = $_POST['eventTitle'];
    $start_date = $_POST['eventStart'];
    $end_date = $_POST['eventEnd'];

    // Check for date and time conflicts, excluding the current event
    $checkSQL = "SELECT * FROM upcoming_events WHERE id != :id AND 
                (:start_date BETWEEN start_date AND end_date 
                OR :end_date BETWEEN start_date AND end_date 
                OR (start_date BETWEEN :start_date AND :end_date) 
                OR (end_date BETWEEN :start_date AND :end_date))";
    $checkStmt = $conn->prepare($checkSQL);
    $checkStmt->bindParam(':id', $id);
    $checkStmt->bindParam(':start_date', $start_date);
    $checkStmt->bindParam(':end_date', $end_date);
    $checkStmt->execute();
    $conflict = $checkStmt->fetch();

    if ($conflict) {
        $error = "An event with the same date and time already exists.";
    } else {
        // Handle file upload
        $banner = "";
        if (isset($_FILES['eventBanner']) && $_FILES['eventBanner']['error'] == 0) {
            $target_dir = "../uploads/";
            $target_file = $target_dir . basename($_FILES["eventBanner"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is an actual image or fake image
            $check = getimagesize($_FILES["eventBanner"]["tmp_name"]);
            if ($check !== false) {
                if ($_FILES["eventBanner"]["size"] <= 500000 &&
                    ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif")) {
                    if (move_uploaded_file($_FILES["eventBanner"]["tmp_name"], $target_file)) {
                        $banner = $target_file;
                    } else {
                        $error = "Sorry, there was an error uploading your file.";
                    }
                } else {
                    $error = "Invalid file type or file is too large.";
                }
            } else {
                $error = "File is not an image.";
            }
        }

        if (!isset($error)) {
            // Prepare SQL statement
            $sql = "UPDATE upcoming_events SET title=:title, start_date=:start_date, end_date=:end_date";
            $params = [
                ':title' => $title,
                ':start_date' => $start_date,
                ':end_date' => $end_date
            ];

            if (!empty($banner)) {
                $sql .= ", banner=:banner";
                $params[':banner'] = $banner;
            }

            $sql .= " WHERE id=:id";
            $params[':id'] = $id;

            try {
                $stmt = $conn->prepare($sql);

                // Execute the statement
                if ($stmt->execute($params)) {
                    $success = "Event updated successfully";
                } else {
                    $error = "Error updating event";
                }
            } catch(PDOException $e) {
                $error = "Error updating event: " . $e->getMessage();
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
            window.location.href = 'upcoming_events.php';
        });";
    } elseif (isset($error)) {
        echo "Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '$error',
            confirmButtonText: 'OK'
        }).then((result) => {
            window.location.href = 'upcoming_events.php';
        });";
    }
    ?>
    </script>
</body>
</html>
