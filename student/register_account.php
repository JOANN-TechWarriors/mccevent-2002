<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname = htmlspecialchars($_POST['fname']);
    $mname = htmlspecialchars($_POST['mname']);
    $lname = htmlspecialchars($_POST['lname']);
    $course = htmlspecialchars($_POST['course']);
    $student_id = htmlspecialchars($_POST['student_id']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    // Database connection
    include('../admin/dbcon.php');

    try {
        // Check if the student_id and lname match an existing record
        $sql = "SELECT request_status FROM student WHERE student_id=:student_id AND lname=:lname";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':lname', $lname);
        $stmt->execute();
        $row = $stmt->fetch();

        if ($row) {
            if ($row['request_status'] === 'Approved') {
                echo "<script>alert('This account is already registered and approved.'); window.history.back();</script>";
            } else {
                // Update request_status to 'Approved' and update fname, mname, course, and password
                $updateSql = "UPDATE student SET request_status='Approved', fname=:fname, mname=:mname, course=:course, password=:password WHERE student_id=:student_id AND lname=:lname";
                $updateStmt = $conn->prepare($updateSql);
                $updateStmt->bindParam(':student_id', $student_id);
                $updateStmt->bindParam(':lname', $lname);
                $updateStmt->bindParam(':fname', $fname);
                $updateStmt->bindParam(':mname', $mname);
                $updateStmt->bindParam(':course', $course);
                $updateStmt->bindParam(':password', $password);

                if ($updateStmt->execute()) {
                    echo "<script>alert('Student $fname $lname registration activated successfully!'); window.location = 'index.php';</script>";
                } else {
                    echo "<script>alert('Error: Could not update student information.'); window.history.back();</script>";
                }
            }
        } else {
            echo "<script>alert('Error: Student ID and Lastname do not match our records.'); window.history.back();</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Database error: " . $e->getMessage() . "'); window.history.back();</script>";
    }

    $conn = null;
}
?>