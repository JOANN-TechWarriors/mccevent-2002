<?php
session_start();
include('../admin/dbcon.php');

// Check if student is logged in
if (!isset($_SESSION['student_id'])) {
    // Redirect to login page if not logged in
    $_SESSION['redirect_after_login'] = 'poll/index.php?event=' . $_GET['event'];
    header("Location: ../student/index2.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$event = isset($_GET['event']) ? $_GET['event'] : null;

// Fetch student details
$stmt = $conn->prepare("SELECT * FROM student WHERE student_id = :student_id");
$stmt->execute([':student_id' => $student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle voting
if (isset($_POST['vote'])) {
    $contestant_id = $_POST['contestant_id'];
    $contestant_name = $_POST['contestant_name'];
    
    // Check if the student has already voted in this event
    $stmt = $conn->prepare("SELECT * FROM votes WHERE student_id = :student_id AND subevent_id = :event_id");
    $stmt->execute([
        ':student_id' => $student_id,
        ':event_id' => $event
    ]);
    $existing_vote = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existing_vote) {
        // Insert the vote
        $stmt = $conn->prepare("INSERT INTO votes (student_id, subevent_id, contestant_id) VALUES (:student_id, :event_id, :contestant_id)");
        $stmt->execute([
            ':student_id' => $student_id,
            ':event_id' => $event,
            ':contestant_id' => $contestant_id
        ]);

        // Update the contestant's vote count
        $stmt = $conn->prepare("UPDATE contestants SET txtPollScore = txtPollScore + 1 WHERE contestant_id = :contestant_id");
        $stmt->execute([':contestant_id' => $contestant_id]);
        
        $success_message = "Successfully Voted for " . htmlspecialchars($contestant_name);
    } else {
        $error_message = "You have already voted in this event.";
    }
}

// Fetch event details
if ($event) {
    $stmt = $conn->prepare("SELECT * FROM sub_event WHERE subevent_id = :event");
    $stmt->execute([':event' => $event]);
    $rowinfo = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Check if the student has already voted in this event
$stmt = $conn->prepare("SELECT * FROM votes WHERE student_id = :student_id AND subevent_id = :event_id");
$stmt->execute([
    ':student_id' => $student_id,
    ':event_id' => $event
]);
$has_voted = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="../img/logo.png"/>
    <title>VOTE POLL</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style type="text/css">
        /* Your existing styles here */
        .votebtn {
            cursor: pointer;
        }
        .voted, .voted:hover {
            background-color: #28a745;
            border-color: #28a745;
        }

        .header {
            background-color: #f8f9fa;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
        }

        .header .profile-dropdown {
            position: relative;
            display: inline-block;
        }

        .header .profile-dropdown img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            cursor: pointer;
        }

        .header .profile-dropdown .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            overflow: hidden;
            z-index: 1000;
        }

        .header .profile-dropdown:hover .dropdown-menu {
            display: block;
        }

        .header .profile-dropdown .dropdown-menu a {
            display: block;
            padding: 10px;
            color: #333;
            text-decoration: none;
        }

        .header .profile-dropdown .dropdown-menu a:hover {
            background-color: #f1f1f1;
        }
        .back-btn {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div>
            <a href="../index.php" class="btn btn-secondary back-btn">Back</a>
        </div>
        <div>
            <!-- Add any left-aligned content here if needed -->
        </div>
        <div class="profile-dropdown">
           <div style="font-size:small;"> Welcome, <?php echo htmlspecialchars($student['fname'] . ' ' . $student['lname']); ?> , Course: <?php echo htmlspecialchars($student['course']); ?></div>
        </div>
    </div>

<div class="container">
    

    <?php if ($rowinfo): ?>
        <br />
        <h1 class="text-center" style="font-size: 20px;"><?php echo htmlspecialchars($rowinfo['event_name']); ?></h1>
        <h5 class="text-center text-muted">ONLINE VOTE POLL</h5>
        <br />

        <div class="row">
        <?php
        $stmt = $conn->prepare("SELECT c.*, IFNULL(v.vote_count, 0) as user_vote_count 
                                FROM contestants c 
                                LEFT JOIN (
                                    SELECT contestant_id, COUNT(*) as vote_count 
                                    FROM votes 
                                    WHERE student_id = :student_id AND subevent_id = :event
                                    GROUP BY contestant_id
                                ) v ON c.contestant_id = v.contestant_id 
                                WHERE c.subevent_id = :event");
        $stmt->execute([':student_id' => $student_id, ':event' => $event]);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>

        <div class="col-md-3 col-6">
        <div class="card">
          <img class="card-img-top pic" height="300" src="../img/<?php echo htmlspecialchars($row['Picture']); ?>" alt="Contestant Profile">
          <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($row['fullname']); ?><p class="text-muted"><?php echo htmlspecialchars($row['AddOn']); ?></p></h5>
            
            <form action="index.php?event=<?php echo htmlspecialchars($event); ?>" method="POST">
                <input type="hidden" name="contestant_id" value="<?php echo htmlspecialchars($row['contestant_id']); ?>">
                <input type="hidden" name="contestant_name" value="<?php echo htmlspecialchars($row['fullname']); ?>">
                <button type="submit" name="vote" class="btn btn-primary votebtn <?php echo $has_voted ? 'voted' : ''; ?>" 
                <?php echo $has_voted ? 'disabled' : ''; ?>>
                <i class="fa fa-heart" aria-hidden="true"></i>
                <span class="vote-count"><?php echo htmlspecialchars($row['txtPollScore']); ?></span>
                </button>
            </form>
            
          </div>
        </div>
        <br />
        </div>

        <?php } ?>
        </div>
    <?php else: ?>
        <h1 class="text-center">No event specified or event not found.</h1>
    <?php endif; ?>
</div>
<script>
<?php if (isset($success_message)): ?>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '<?php echo $success_message; ?>',
    }).then((result) => {
        if (result.isConfirmed) {
            location.reload();
        }
    });
<?php endif; ?>

<?php if (isset($error_message)): ?>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: '<?php echo $error_message; ?>',
    });
<?php endif; ?>
</script>
<script>
// Disable right-click
        document.addEventListener('contextmenu', function (e) {
            e.preventDefault();
        });

        // Disable F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U
        document.onkeydown = function (e) {
            if (
                e.key === 'F12' ||
                (e.ctrlKey && e.shiftKey && (e.key === 'I' || e.key === 'J')) ||
                (e.ctrlKey && e.key === 'U')
            ) {
                e.preventDefault();
            }
        };

        // Disable developer tools
        function disableDevTools() {
            if (window.devtools.isOpen) {
                window.location.href = "about:blank";
            }
        }

        // Check for developer tools every 100ms
        setInterval(disableDevTools, 100);

        // Disable selecting text
        document.onselectstart = function (e) {
            e.preventDefault();
        };
</script>
</body>
</html>