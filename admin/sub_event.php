<?php
include('header2.php');
include('session.php');
include('dbcon.php');

// Capture the mainevent_id from the URL
if (isset($_GET['id'])) {
    $main_event_id = $_GET['id'];

    // Fetch event details from the database
    $query = "SELECT * FROM main_event WHERE mainevent_id = :event_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':event_id', $main_event_id);
    $stmt->execute();
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$event) {
        die('Event not found.');
    }

    // Fetch sub-events related to the main event
    $subEventsQuery = "SELECT * FROM sub_event WHERE mainevent_id = :event_id";
    $subEventsStmt = $conn->prepare($subEventsQuery);
    $subEventsStmt->bindParam(':event_id', $main_event_id);
    $subEventsStmt->execute();
    $subEvents = $subEventsStmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    die('Event ID not provided.');
}

// Handle form submission
if (isset($_POST['add_event'])) {
    $banner = $_FILES['banner']['name'];
    $target = "../img/".basename($banner);
    $sub_event_name = $_POST['event_name'];  
    $event_date = $_POST['event_date']; 
    $event_time = $_POST['event_time']; 
    $event_place = $_POST['event_place']; 

    $stmt = $conn->prepare("INSERT INTO sub_event (mainevent_id, event_name, status, eventdate, eventtime, place, organizer_id, banner) 
                            VALUES (?, ?, 'activated', ?, ?, ?, ?, ?)");
    $result = $stmt->execute([$main_event_id, $sub_event_name, $event_date, $event_time, $event_place, $session_id, $banner]);

    if ($result && move_uploaded_file($_FILES['banner']['tmp_name'], $target)) {
        $_SESSION['swal_success'] = true;
        $_SESSION['swal_message'] = "Sub-Event " . htmlspecialchars($sub_event_name) . " created successfully!";
    } else {
        $_SESSION['swal_error'] = true;
        $_SESSION['swal_message'] = "There was a problem creating the sub-event or uploading the banner image.";
    }

    // Redirect to prevent form resubmission and include mainevent_id in the URL
    header("Location: sub_event.php?id=" . $main_event_id);
    exit();
}
?>
    <?php
    // At the top of your file, add these pagination variables
    $entries_per_page = isset($_GET['entries']) ? (int)$_GET['entries'] : 10; // Default to 10 entries
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $search_query = isset($_GET['search']) ? $_GET['search'] : '';

    // Modify your sub-events query to include search and pagination
    $subEventsQuery = "SELECT * FROM sub_event WHERE mainevent_id = :event_id";
    if (!empty($search_query)) {
        $subEventsQuery .= " AND (event_name LIKE :search OR place LIKE :search)";
    }
    $subEventsQuery .= " ORDER BY eventdate DESC";

    // First, get total number of records for pagination
    $countStmt = $conn->prepare($subEventsQuery);
    $countStmt->bindParam(':event_id', $main_event_id);
    if (!empty($search_query)) {
        $search_param = "%{$search_query}%";
        $countStmt->bindParam(':search', $search_param);
    }
    $countStmt->execute();
    $total_records = $countStmt->rowCount();
    $total_pages = ceil($total_records / $entries_per_page);

    // Add LIMIT clause for pagination
    $offset = ($current_page - 1) * $entries_per_page;
    $subEventsQuery .= " LIMIT :offset, :limit";

    $subEventsStmt = $conn->prepare($subEventsQuery);
    $subEventsStmt->bindParam(':event_id', $main_event_id);
    if (!empty($search_query)) {
        $subEventsStmt->bindParam(':search', $search_param);
    }
    $subEventsStmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $subEventsStmt->bindParam(':limit', $entries_per_page, PDO::PARAM_INT);
    $subEventsStmt->execute();
    $subEvents = $subEventsStmt->fetchAll(PDO::FETCH_ASSOC);
    ?>      

<?php
if (isset($_POST['activation'])) {
    $status = $_POST['status'];
    $sub_event_id = $_POST['sub_event_id'];
    $check_pass2 = $_POST['check_pass'];
    $se_name = $_POST['se_name'];

    if ($check_pass == $check_pass2) {
        if ($status == "activated") {
            $conn->query("UPDATE sub_event SET status='deactivated' WHERE subevent_id='$sub_event_id'");
            $_SESSION['swal_success'] = true;
            $_SESSION['swal_message'] = "Sub-Event " . htmlspecialchars($se_name) . " deactivated successfully!";
        } else {
            $conn->query("UPDATE sub_event SET status='activated' WHERE subevent_id='$sub_event_id'");
            $_SESSION['swal_success'] = true;
            $_SESSION['swal_message'] = "Sub-Event " . htmlspecialchars($se_name) . " activated successfully!";
        }
    } else {
        $_SESSION['swal_error'] = true;
        $_SESSION['swal_message'] = "Confirmation did not match. Try again.";
    }

    // Redirect to prevent form resubmission
    header("Location: sub_event.php?id=" . $main_event_id);
    exit();
}
?>


<?php
if (isset($_POST['deleteSubEvent'])) {
    $sub_event_id = $_POST['sub_event_id'];
    $entered_pass = $_POST['entered_pass'];
    $sub_event_name = $_POST['sub_event_name'];

    try {
        // Use password_verify for secure password comparison
        if (password_verify($entered_pass, $check_pass)) {
            // Start a transaction
            $conn->beginTransaction();

            // Prepare DELETE statements for related tables
            $delete_contestants_stmt = $conn->prepare("DELETE FROM contestants WHERE subevent_id = :subevent_id");
            $delete_criteria_stmt = $conn->prepare("DELETE FROM criteria WHERE subevent_id = :subevent_id");
            $delete_judges_stmt = $conn->prepare("DELETE FROM judges WHERE subevent_id = :subevent_id");
            $delete_results_stmt = $conn->prepare("DELETE FROM sub_results WHERE subevent_id = :subevent_id");
            $delete_subevent_stmt = $conn->prepare("DELETE FROM sub_event WHERE subevent_id = :subevent_id");

            // Bind the sub_event_id parameter
            $delete_contestants_stmt->bindParam(':subevent_id', $sub_event_id, PDO::PARAM_INT);
            $delete_criteria_stmt->bindParam(':subevent_id', $sub_event_id, PDO::PARAM_INT);
            $delete_judges_stmt->bindParam(':subevent_id', $sub_event_id, PDO::PARAM_INT);
            $delete_results_stmt->bindParam(':subevent_id', $sub_event_id, PDO::PARAM_INT);
            $delete_subevent_stmt->bindParam(':subevent_id', $sub_event_id, PDO::PARAM_INT);

            // Execute delete statements
            $delete_contestants_stmt->execute();
            $delete_criteria_stmt->execute();
            $delete_judges_stmt->execute();
            $delete_results_stmt->execute();
            $delete_subevent_stmt->execute();

            // Commit the transaction
            $conn->commit();

            // Set success session variables
            $_SESSION['swal_success'] = true;
            $_SESSION['swal_message'] = "Sub-Event: " . htmlspecialchars($sub_event_name) . " and its related data deleted successfully.";
        } else {
            // Set error session variables for invalid password
            $_SESSION['swal_error'] = true;
            $_SESSION['swal_message'] = "Confirmation did not match. Try again.";
        }
    } catch (PDOException $e) {
        // Rollback the transaction in case of error
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }

        // Log the error
        error_log('Database error during sub-event deletion: ' . $e->getMessage());

        // Set error session variables
        $_SESSION['swal_error'] = true;
        $_SESSION['swal_message'] = "An error occurred while deleting the sub-event. Please try again.";
    }

    // Redirect to prevent form resubmission
    header("Location: sub_event.php?id=" . htmlspecialchars($main_event_id));
    exit();
}
?>

<?php
if (isset($_POST['edit_se'])) {
    $sub_event_id = $_POST['sub_event_id'];
    $se_name = $_POST['se_name'];
    $se_new_name = $_POST['se_new_name'];
    $entered_pass = $_POST['entered_pass'];

    try {
        // Use password_verify for secure password comparison
        if (password_verify($entered_pass, $check_pass)) {
            // Validate input
            if (empty(trim($se_new_name))) {
                $_SESSION['swal_error'] = true;
                $_SESSION['swal_message'] = "Sub-Event name cannot be empty.";
            } else {
                // Prepare UPDATE statement
                $stmt = $conn->prepare("UPDATE sub_event SET event_name = :new_name WHERE subevent_id = :id");
                
                // Bind parameters
                $stmt->bindParam(':new_name', $se_new_name, PDO::PARAM_STR);
                $stmt->bindParam(':id', $sub_event_id, PDO::PARAM_INT);
                
                // Execute the update
                $stmt->execute();

                // Check if the update was successful
                if ($stmt->rowCount() > 0) {
                    $_SESSION['swal_success'] = true;
                    $_SESSION['swal_message'] = "Sub-Event title: " . htmlspecialchars($se_name) . " was changed to: " . htmlspecialchars($se_new_name) . " successfully!";
                } else {
                    $_SESSION['swal_error'] = true;
                    $_SESSION['swal_message'] = "No changes were made. The sub-event may not exist.";
                }
            }
        } else {
            $_SESSION['swal_error'] = true;
            $_SESSION['swal_message'] = "Confirmation did not match. Try again.";
        }
    } catch (PDOException $e) {
        // Log the error
        error_log('Database error during sub-event edit: ' . $e->getMessage());

        $_SESSION['swal_error'] = true;
        $_SESSION['swal_message'] = "An error occurred while updating the sub-event. Please try again.";
    }

    // Redirect to prevent form resubmission
    header("Location: sub_event.php?id=" . htmlspecialchars($main_event_id));
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Include other necessary styles and scripts -->

    <style>
        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            width: 100vw;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Modal Styles */
        .modal {
            display: none;
        }

        /* Sidebar Styles */
        .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 250px;
        background-color: #27293d;
        color: #fff;
        padding-top: 20px;
        transition: all 0.3s;
        overflow: hidden;
        z-index: 1000; /* Ensure the sidebar is above the main content */
    }

    .sidebar.collapsed {
        transform: translateX(-100%); /* Move sidebar off-screen when collapsed */
    }

    .sidebar .toggle-btn {
        position:absolute;
        top: 10px;
        right: 18px;
        background-color: transparent;
        color: #fff;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }

    .sidebar .toggle-btn i {
        font-size: 20px;
    }

    .sidebar-heading {
        text-align: center;
        padding: 10px 0;
        font-size: 18px;
        margin-bottom: 10px;
    }

    .sidebar-heading img {
        max-width: 100px;
        max-height: 100px;
    }

    .sidebar ul {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .sidebar ul li {
        padding: 15px 20px;
        transition: all 0.3s;
    }

    .sidebar ul li a {
        color: #fff;
        text-decoration: none;
        display: flex;
        align-items: center;
    }

    .sidebar ul li a i {
        margin-right: 10px;
    }

    .sidebar ul li a:hover {
        background-color: #1a1a2e;
    }

    .main {
        margin-left: 250px;
        padding: 20px;
        transition: all 0.3s;
    }

    .main.collapsed {
        margin-left: 80px;
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

        /* Header Styles */
        .header {
            background-color: #f8f9fa;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
        }

        .profile-dropdown {
            position: relative;
            display: inline-block;
        }

        .profile-dropdown img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            cursor: pointer;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            overflow: hidden;
            z-index: 1000;
        }

        .profile-dropdown:hover .dropdown-menu {
            display: block;
        }

        .dropdown-menu a {
            display: block;
            padding: 10px;
            color: #333;
            text-decoration: none;
        }

        .dropdown-menu a:hover {
            background-color: #f1f1f1;
        }

        /* Table Container */
        .table-responsive-container {
            width: 100%;
            max-width: 1200px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        /* Table Styles */
        .table-custom {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .table-custom thead th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: 600;
            padding: 12px 15px;
            text-align: left;
            border-bottom: 2px solid #dee2e6;
            white-space: nowrap;
        }

        .table-custom tbody tr {
            border-bottom: 1px solid #dee2e6;
        }

        .table-custom tbody tr:last-child {
            border-bottom: none;
        }

        .table-custom tbody td {
            padding: 12px 15px;
            vertical-align: middle;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.875rem;
            font-weight: 500;
            white-space: nowrap;
        }

        .status-badge.active {
            background-color: #28a745;
            color: white;
        }

        .status-badge.inactive {
            background-color: #dc3545;
            color: white;
        }

        /* Button Group */
        .btn-group-custom {
            display: flex;
            gap: 5px;
            justify-content: center;
        }

        .btn-group-custom .btn {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 0.875rem;
            cursor: pointer;
            border: none;
            color: white;
        }

        .btn-success { background-color: #28a745; }
        .btn-danger { background-color: #dc3545; }
        .btn-primary { background-color: #007bff; }
        .btn-warning { background-color: #ffc107; }

        /* Table Header and Footer */
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding: 10px 0;
        }

        .entries-selector,
        .search-box {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .entries-selector select {
            padding: 4px 8px;
            border-radius: 4px;
            border: 1px solid #dee2e6;
        }

        .search-box input {
            padding: 4px 8px;
            border-radius: 4px;
            border: 1px solid #dee2e6;
            width: 200px;
        }

        .table-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            padding: 10px 0;
        }

        .showing-entries {
            color: #666;
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: center;
        }

        .pagination {
            display: flex;
            gap: 5px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination-button {
            padding: 6px 12px;
            border: 1px solid #dee2e6;
            background-color: #fff;
            color: #333;
            text-decoration: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .pagination-button:hover:not(.disabled):not(.active) {
            background-color: #f8f9fa;
        }

        .pagination-button.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }

        .pagination-button.disabled {
            color: #6c757d;
            pointer-events: none;
        }

        /* Add Event Button */
        .add-event-btn {
            background-color: #17a2b8;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }

        /* Responsive Design */
        @media screen and (max-width: 992px) {
            .table-responsive-container {
                margin: 10px;
                padding: 15px;
            }

            .table-header {
                flex-direction: column;
                gap: 10px;
            }

            .search-box {
                width: 100%;
            }

            .search-box input {
                width: 100%;
            }
        }

        @media screen and (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.collapsed {
                transform: translateX(0);
            }

            .main {
                margin-left: 0;
            }

            .table-footer {
                flex-direction: column;
                align-items: center;
                gap: 15px;
            }

            .showing-entries {
                order: 2;
            }

            .pagination-container {
                order: 1;
                width: 100%;
            }
        }

        @media screen and (max-width: 576px) {
            .table-custom thead th,
            .table-custom tbody td {
                padding: 8px;
                font-size: 0.875rem;
            }

            .btn-group-custom .btn {
                padding: 4px 8px;
                font-size: 0.75rem;
            }

            .pagination-button {
                padding: 4px 8px;
                font-size: 0.875rem;
            }
        }
    </style>

</head>

<body>
    <div class="sidebar" id="sidebar">
    <button class="toggle-btn" id="toggle-btn"><i class="fas fa-bars"></i></button>
    <div class="sidebar-heading">
        <img src="../img/logo.png" alt="Logo">
        <div>Event Judging System</div>
    </div>
    <ul>
            <li><a href="dashboard.php"><i class="fas fa-tachometer-alt"></i> <span>DASHBOARD</span></a></li>
            <li><a href="home.php"><i class="fas fa-calendar-check"></i> <span>ONGOING EVENTS</span></a></li>
            <li><a href="upcoming_events.php"><i class="fas fa-calendar-alt"></i> <span>UPCOMING EVENTS</span></a></li>
            <li><a href="live_stream.php"><i class="fas fa-camera"></i> <span>LIVE STREAM</span></a></li>

        </ul>
</div>

<div class="header">
        <div>
        <button class="toggle-btn" id="toggle-btn-mobile"><i class="fas fa-bars"></i></button>
        </div>
        <div class="profile-dropdown">
           <div style="font-size:small;"> <?php echo $name; ?></div>
            <div class="dropdown-menu">
                <a href="edit_organizer.php"> Account Settings</a>
                <a href="#" id="logout"><i class="fas fa-sign-out-alt"></i> <span>Sign out</span></a>
            </div>
        </div>
    </div>
    
    <div class="main" id="main-content">
        <div class="container">
            <h1  style="font-size: 35px;">Ongoing Events</h1>
        </div>
        <section id="download-bootstrap">
            <a data-toggle="modal" class="btn btn-info pull-right" href="#addMEcollapse"
                title="Click to add Main Event"><i class="icon icon-plus"></i> <strong>SUB-EVENT</strong></a>
            <!-- Modal for adding an event -->
            <div id="addMEcollapse" class="modal fade" role="dialog">
                <div class="page-header">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><strong>Add Sub-Events</strong><button type="button"
                                        class="close" data-dismiss="modal">&times;</button></h4>
                            </div>
                            
                            <form method="POST" enctype="multipart/form-data">
                                <!-- ADD Sub-Events -->

                                <table align="center" class="table table-bordered" id="example">
                                    <td>

                                        <input name="main_event_id" type="hidden"
                                            value="<?php echo $main_event_id; ?>" />

                                        <strong>Banner</strong>:<br />
                                        <input name="banner" class="form-control btn-block"
                                            style="text-indent: 7px !important; height: 30px !important;" type="file"
                                            required="true" />
                                        <br />

                                        <strong>Sub-Event Title</strong>:<br />
                                        <input placeholder="Enter Sub-Event title" name="event_name"
                                            class="form-control btn-block"
                                            style="text-indent: 7px !important; height: 30px !important;" type="text"
                                            required="true" />
                                        <br />


                                        <strong>Date Start</strong>:<br />
                                        <input name="event_date" class="form-control btn-block"
                                            min="<?php echo date('Y-m-d');?>" style="height: 30px !important;"
                                            type="date" required="true" />
                                        <br />

                                        <strong>Time Start</strong>:<br />
                                        <input type="time" id="event_time" name="event_time" class="form-control btn-block"
                                               style="text-indent: 5px !important; height: 30px !important;" 
                                               step="1800" required />
                                        <br />

                                        <strong>Venue</strong>:<br />
                                        <textarea placeholder="Enter Sub-Event Venue" rows="2" name="event_place"
                                            class="form-control btn-block" style="text-indent: 7px !important;"
                                            required="true"></textarea>
                                        <br />

                                        <div class="modal-footer">
                                            <button name="add_event" class="btn btn-primary"><i class="icon-ok"></i>
                                                <strong>SAVE</strong></button>
                                            <button type="reset" class="btn btn-default"><i class="icon-ban-circle"></i>
                                                <strong>RESET</strong></button>
                                            
                                        </div>
                            </form>

                            </table>

                            <!-- End of ADD Sub-Events -->
                        </div>
                    </div>
                </div>
            </div>
            <br> <br><br>
            <div class="table-responsive-container">
            <!-- Table Header with Search and Entries Selector -->
        <div class="table-header">
            <div class="entries-selector">
                Show 
                <select id="entriesSelect" onchange="changeEntries(this.value)">
                    <option value="10" <?php echo $entries_per_page == 10 ? 'selected' : ''; ?>>10</option>
                    <option value="25" <?php echo $entries_per_page == 25 ? 'selected' : ''; ?>>25</option>
                    <option value="50" <?php echo $entries_per_page == 50 ? 'selected' : ''; ?>>50</option>
                    <option value="100" <?php echo $entries_per_page == 100 ? 'selected' : ''; ?>>100</option>
                </select>
                entries
            </div>
            <div class="search-box">
                <label for="searchInput">Search:</label>
                <input class="form-control btn-block" style="text-indent: 5px !important; height: 30px !important;" type="text" 
                    id="searchInput" 
                    value="<?php echo htmlspecialchars($search_query); ?>" 
                    onkeyup="searchTable(event)" 
                    placeholder="Search...">
            </div>
        </div>  
    <table class="table-custom">
        <thead>
            <tr>
                <th>Sub-event Title</th>
                <th>Date</th>
                <th>Time</th>
                <th>Venue</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($subEvents as $subEvent): ?>
            <tr>
                <td data-label="Sub-event Title"><?php echo htmlspecialchars($subEvent['event_name']); ?></td>
                <td data-label="Date"><?php echo date('m-d-Y', strtotime($subEvent['eventdate'])); ?></td>
                <td data-label="Time"><?php echo date('g:i A', strtotime($subEvent['eventtime'])); ?></td>
                <td data-label="Venue"><?php echo htmlspecialchars($subEvent['place']); ?></td>
                <td data-label="Status">
                    <span class="status-badge <?php echo $subEvent['status'] == 'activated' ? 'active' : 'inactive'; ?>">
                        <?php echo htmlspecialchars($subEvent['status']); ?>
                    </span>
                </td>
                <td data-label="Actions">
                    <div class="btn-group-custom">
                        <button class="btn btn-success" 
                                onclick="showEditModal(<?php echo htmlspecialchars($subEvent['subevent_id']); ?>, '<?php echo htmlspecialchars($subEvent['event_name']); ?>')" 
                                <?php echo $subEvent['status'] == 'deactivated' ? 'disabled' : ''; ?>>
                            <i class="icon-pencil"></i>
                        </button>
                        
                        <button class="btn btn-danger" 
                                onclick="showDeleteModal(<?php echo htmlspecialchars($subEvent['subevent_id']); ?>, '<?php echo htmlspecialchars($subEvent['event_name']); ?>')" 
                                <?php echo $subEvent['status'] == 'deactivated' ? 'disabled' : ''; ?>>
                            <i class="icon-trash"></i>
                        </button>
                        
                        <?php if ($subEvent['status'] != 'deactivated'): ?>
                        <a href="sub_event_details.php?sub_event_id=<?php echo htmlspecialchars($subEvent['subevent_id']); ?>&se_name=<?php echo urlencode($subEvent['event_name']); ?>" 
                           class="btn btn-primary">
                            <i class="icon icon-cog"></i>
                        </a>
                        <?php endif; ?>
                        
                        <button class="btn <?php echo $subEvent['status'] == 'activated' ? 'btn-warning' : 'btn-danger'; ?>"
                                onclick="showActivationModal(<?php echo htmlspecialchars($subEvent['subevent_id']); ?>, '<?php echo htmlspecialchars($subEvent['event_name']); ?>', '<?php echo htmlspecialchars($subEvent['status']); ?>')">
                            <i class="fa-solid <?php echo $subEvent['status'] == 'activated' ? 'fa-eye' : 'fa-eye-slash'; ?>"></i>
                        </button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- Table Footer with Pagination -->
<div class="table-footer">
    <div class="showing-entries">
        Showing <?php echo $offset + 1; ?> to <?php echo min($offset + $entries_per_page, $total_records); ?> of <?php echo $total_records; ?> entries
        <?php if (!empty($search_query)): ?>
            (filtered from <?php echo $total_records; ?> total entries)
        <?php endif; ?>
    </div>
    
    <div class="pagination-container">
        <div class="pagination">
            <?php if ($total_pages > 1): ?>
                <!-- Previous button -->
                <a href="?id=<?php echo $main_event_id; ?>&page=<?php echo max(1, $current_page - 1); ?>&entries=<?php echo $entries_per_page; ?>&search=<?php echo urlencode($search_query); ?>" 
                   class="pagination-button <?php echo $current_page == 1 ? 'disabled' : ''; ?>">
                    Previous
                </a>
                
                <!-- First page -->
                <?php if ($current_page > 3): ?>
                    <a href="?id=<?php echo $main_event_id; ?>&page=1&entries=<?php echo $entries_per_page; ?>&search=<?php echo urlencode($search_query); ?>" 
                       class="pagination-button">1</a>
                    <?php if ($current_page > 4): ?>
                        <span class="pagination-button disabled">...</span>
                    <?php endif; ?>
                <?php endif; ?>
                
                <!-- Page numbers -->
                <?php
                for ($i = max(1, $current_page - 2); $i <= min($total_pages, $current_page + 2); $i++):
                ?>
                    <a href="?id=<?php echo $main_event_id; ?>&page=<?php echo $i; ?>&entries=<?php echo $entries_per_page; ?>&search=<?php echo urlencode($search_query); ?>" 
                       class="pagination-button <?php echo $current_page == $i ? 'active' : ''; ?>">
                        <?php echo $i; ?>
                    </a>
                <?php endfor; ?>
                
                <!-- Last page -->
                <?php if ($current_page < $total_pages - 2): ?>
                    <?php if ($current_page < $total_pages - 3): ?>
                        <span class="pagination-button disabled">...</span>
                    <?php endif; ?>
                    <a href="?id=<?php echo $main_event_id; ?>&page=<?php echo $total_pages; ?>&entries=<?php echo $entries_per_page; ?>&search=<?php echo urlencode($search_query); ?>" 
                       class="pagination-button">
                        <?php echo $total_pages; ?>
                    </a>
                <?php endif; ?>
                
                <!-- Next button -->
                <a href="?id=<?php echo $main_event_id; ?>&page=<?php echo min($total_pages, $current_page + 1); ?>&entries=<?php echo $entries_per_page; ?>&search=<?php echo urlencode($search_query); ?>" 
                   class="pagination-button <?php echo $current_page == $total_pages ? 'disabled' : ''; ?>">
                    Next
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
    </div>
    <!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <p>Are you sure you want to delete this sub-event? This action cannot be undone.</p>
                    <input type="hidden" id="delete_sub_event_id" name="sub_event_id">
                    <input type="hidden" id="delete_sub_event_name" name="sub_event_name">
                    <div class="form-group">
                        <label for="entered_pass">Enter your password to confirm:</label>
                        <input type="password" class="form-control btn-block" style="text-indent: 5px !important; height: 30px !important;" id="entered_pass" name="entered_pass" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="deleteSubEvent" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Sub-Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <input type="hidden" id="edit_sub_event_id" name="sub_event_id">
                    <input type="hidden" id="edit_se_name" name="se_name">
                    <div class="form-group">
                        <label for="se_new_name">New Sub-Event Name:</label>
                        <input type="text" class="form-control btn-block" style="text-indent: 5px !important; height: 30px !important;" id="se_new_name" name="se_new_name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_entered_pass">Enter your password to confirm:</label>
                        <input type="password" class="form-control btn-block" style="text-indent: 5px !important; height: 30px !important;" id="edit_entered_pass" name="entered_pass" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="edit_se" class="btn btn-primary">Save Changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="activationModal" tabindex="-1" role="dialog" aria-labelledby="activationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="activationModalLabel">Confirm Action</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST">
                <div class="modal-body">
                    <p id="activationMessage"></p>
                    <input type="hidden" id="activation_sub_event_id" name="sub_event_id">
                    <input type="hidden" id="activation_se_name" name="se_name">
                    <input type="hidden" id="activation_status" name="status">
                    <div class="form-group">
                        <label for="activation_entered_pass">Enter your password to confirm:</label>
                        <input type="password" class="form-control btn-block" style="text-indent: 5px !important; height: 30px !important;" id="activation_entered_pass" name="check_pass" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="activation" class="btn btn-primary" id="activationButton">Confirm</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showEditModal(subEventId, subEventName) {
    document.getElementById('edit_sub_event_id').value = subEventId;
    document.getElementById('edit_se_name').value = subEventName;
    document.getElementById('se_new_name').value = subEventName;
    $('#editModal').modal('show');
}

function showDeleteModal(subEventId, subEventName) {
    document.getElementById('delete_sub_event_id').value = subEventId;
    document.getElementById('delete_sub_event_name').value = subEventName;
    $('#deleteModal').modal('show');
}



function showActivationModal(subEventId, subEventName, status) {
    document.getElementById('activation_sub_event_id').value = subEventId;
    document.getElementById('activation_se_name').value = subEventName;
    document.getElementById('activation_status').value = status;
    
    var message = status === 'activated' 
        ? 'Are you sure you want to deactivate this sub-event?' 
        : 'Are you sure you want to activate this sub-event?';
    document.getElementById('activationMessage').textContent = message;
    
    var buttonText = status === 'activated' ? 'Deactivate' : 'Activate';
    document.getElementById('activationButton').textContent = buttonText;
    
    $('#activationModal').modal('show');
}
</script>

<script>
        // Function to handle entries per page change
        function changeEntries(value) {
            window.location.href = `?id=<?php echo $main_event_id; ?>&entries=${value}&search=<?php echo urlencode($search_query); ?>`;
        }

        // Function to handle search
        function searchTable(event) {
            // If Enter key is pressed or 500ms has passed since last keypress
            if (event.key === 'Enter' || event.type === 'keyup') {
                clearTimeout(window.searchTimeout);
                window.searchTimeout = setTimeout(() => {
                    const searchValue = document.getElementById('searchInput').value;
                    window.location.href = `?id=<?php echo $main_event_id; ?>&entries=<?php echo $entries_per_page; ?>&search=${encodeURIComponent(searchValue)}`;
                }, event.key === 'Enter' ? 0 : 500);
            }
        }

        // Add event listener for search input
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.focus();
                // Place cursor at the end of the search input
                const len = searchInput.value.length;
                searchInput.setSelectionRange(len, len);
            }
        });
</script>
    </section>
    </div>

    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap-transition.js"></script>
    <script src="../assets/js/bootstrap-alert.js"></script>
    <script src="../assets/js/bootstrap-modal.js"></script>
    <script src="../assets/js/bootstrap-dropdown.js"></script>
    <script src="../assets/js/bootstrap-scrollspy.js"></script>
    <script src="../assets/js/bootstrap-tab.js"></script>
    <script src="../assets/js/bootstrap-tooltip.js"></script>
    <script src="../assets/js/bootstrap-popover.js"></script>
    <script src="../assets/js/bootstrap-button.js"></script>
    <script src="../assets/js/bootstrap-collapse.js"></script>
    <script src="../assets/js/bootstrap-carousel.js"></script>
    <script src="../assets/js/bootstrap-typeahead.js"></script>
    <script src="../assets/js/bootstrap-affix.js"></script>
    <script src="../assets/js/holder/holder.js"></script>
    <script src="../assets/js/google-code-prettify/prettify.js"></script>
    <script src="../assets/js/application.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (isset($_SESSION['message'])): ?>
        Swal.fire({
            title: '<?php echo htmlspecialchars($_SESSION['message']); ?>',
            icon: '<?php echo $_SESSION['message_type'] === 'success' ? 'success' : 'error'; ?>',
            confirmButtonText: 'OK'
        }).then(() => {
            <?php unset($_SESSION['message']); unset($_SESSION['message_type']); ?>
        });
        <?php endif; ?>

        document.getElementById('logout').addEventListener('click', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure you want to log out?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../index.php';
                }
            });
        });

    });
    </script>
<!-- SweetAlert for Success/Error Messages -->
<script>
        document.addEventListener('DOMContentLoaded', function() {
            <?php if (isset($_SESSION['swal_success'])): ?>
            Swal.fire({
                title: 'Success!',
                text: '<?php echo $_SESSION['swal_message']; ?>',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then(() => {
                <?php unset($_SESSION['swal_success']); unset($_SESSION['swal_message']); ?>
            });
            <?php elseif (isset($_SESSION['swal_error'])): ?>
            Swal.fire({
                title: 'Error!',
                text: '<?php echo $_SESSION['swal_message']; ?>',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then(() => {
                <?php unset($_SESSION['swal_error']); unset($_SESSION['swal_message']); ?>
            });
            <?php endif; ?>
        });
    </script>
    <script>
        document.getElementById('event_time').addEventListener('change', function() {
        var time = this.value;
        var [hours, minutes] = time.split(':');
        
        // Round minutes to nearest 30
        minutes = (Math.round(minutes / 30) * 30) % 60;
        
        // Adjust hours if minutes rounded up to 60
        if (minutes === 0 && parseInt(this.value.split(':')[1]) > 30) {
            hours = (parseInt(hours) + 1) % 24;
        }
        
        // Format hours and minutes to ensure two digits
        hours = hours.toString().padStart(2, '0');
        minutes = minutes.toString().padStart(2, '0');
        
        this.value = `${hours}:${minutes}`;
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const toggleButtons = document.querySelectorAll(".toggle-btn");
    const sidebar = document.getElementById("sidebar");
    const mainContent = document.querySelector(".main");

    toggleButtons.forEach(button => {
        button.addEventListener("click", function() {
            // Toggle the collapsed class on sidebar
            sidebar.classList.toggle("collapsed");
            // Toggle the collapsed class on main content
            mainContent.classList.toggle("collapsed");
        });
    });
});

</script>
</body>
</html>
