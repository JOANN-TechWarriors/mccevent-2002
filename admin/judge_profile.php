<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include session file
include('session.php');

// Ensure this script only runs on POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judge_code = $_POST['judge_code'] ?? '';

    try {
        $query = $conn->prepare("SELECT * FROM judges WHERE code = ?");
        $query->execute([$judge_code]);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $num_row = $query->rowCount();

        if ($num_row > 0) {
            $judge_ctr = $row['judge_ctr'];
            $subevent_id = $row['subevent_id'];
            $success = true;
        } else {
            $success = false;
        }
    } catch (PDOException $e) {
        // Log the error and set success to false
        error_log("Database error: " . $e->getMessage());
        $success = false;
    }
} else {
    // If not a POST request, redirect to welcome page
    header("Location: welcome.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Judge Verification</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if ($success): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Correct code. Redirecting...',
            timer: 2000,
            showConfirmButton: false
        }).then(() => {
            window.location.href = "judge_panel.php?judge_ctr=<?php echo $judge_ctr; ?>&subevent_id=<?php echo $subevent_id; ?>";
        });
        <?php else: ?>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Wrong code or an error occurred. Please try again.',
        }).then(() => {
            window.location.href = 'welcome.php';
        });
        <?php endif; ?>
    });
    </script>
</body>
</html>