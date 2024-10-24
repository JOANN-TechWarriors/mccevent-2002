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

if (isset($_POST['edit_sub_event'])) {
    $sub_event_id = $_POST['sub_event_id'];
    $sub_event_name = $_POST['sub_event_name'];
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];
    $event_place = $_POST['event_place'];

    $stmt = $conn->prepare("UPDATE sub_event SET event_name = ?, eventdate = ?, eventtime = ?, place = ? WHERE subevent_id = ?");
    $result = $stmt->execute([$sub_event_name, $event_date, $event_time, $event_place, $sub_event_id]);

    if ($result) {
        $_SESSION['swal_success'] = true;
        $_SESSION['swal_message'] = "Sub-Event " . htmlspecialchars($sub_event_name) . " updated successfully!";
    } else {
        $_SESSION['swal_error'] = true;
        $_SESSION['swal_message'] = "There was a problem updating the sub-event.";
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

    if ($entered_pass == $check_pass) {
        // Delete related data
        $conn->query("DELETE FROM contestants WHERE subevent_id='$sub_event_id'");
        $conn->query("DELETE FROM criteria WHERE subevent_id='$sub_event_id'");
        $conn->query("DELETE FROM judges WHERE subevent_id='$sub_event_id'");
        $conn->query("DELETE FROM sub_results WHERE subevent_id='$sub_event_id'");
        
        // Delete the sub-event
        $conn->query("DELETE FROM sub_event WHERE subevent_id='$sub_event_id'");

        $_SESSION['swal_success'] = true;
        $_SESSION['swal_message'] = "Sub-Event: " . htmlspecialchars($sub_event_name) . " and its related data deleted successfully.";
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
if (isset($_POST['edit_se'])) {
    $sub_event_id = $_POST['sub_event_id'];
    $se_name = $_POST['se_name'];
    $se_new_name = $_POST['se_new_name'];
    $entered_pass = $_POST['entered_pass'];

    if ($entered_pass == $check_pass) {
        // Update sub_event
        $stmt = $conn->prepare("UPDATE sub_event SET event_name = :new_name WHERE subevent_id = :id");
        $stmt->execute([':new_name' => $se_new_name, ':id' => $sub_event_id]);

        $_SESSION['swal_success'] = true;
        $_SESSION['swal_message'] = "Sub-Event title: " . htmlspecialchars($se_name) . " was changed to: " . htmlspecialchars($se_new_name) . " successfully!";
    } else {
        $_SESSION['swal_error'] = true;
        $_SESSION['swal_message'] = "Confirmation did not match. Try again.";
    }

    // Redirect to prevent form resubmission
    header("Location: sub_event.php?id=" . $main_event_id);
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Include other necessary styles and scripts -->

    <style>
        /* Modal Background */
.modal {
    display: none; /* Hidden by default */
   
}

body {
    font-family: Arial, sans-serif;
    background-color: #fff;
    margin: 0;
    padding: 0;
    min-height: 100vh; /* Ensures the body takes at least the full viewport height */
    width: 100vw;      /* Ensures full width */
    overflow-y: auto;  /* Enables vertical scrolling */
    overflow-x: hidden; /* Prevents horizontal scrolling if content overflows */
}

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
        position: absolute;
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
        font-size: 16px;

    }

    .sidebar ul li a i {
    margin-right: 10px;
}
   

/*     .sidebar.collapsed ul li a i {
        margin-right: 0;
    }

    .sidebar ul li a span {
        display: inline-block;
        transition: opacity 0.3s;
    }

    .sidebar.collapsed ul li a span {
        opacity: 0;
        width: 0;
        overflow: hidden;
    } */

    .sidebar ul li a:hover {
        background-color: #1a1a2e;
    }

   .main {
    margin-left: 250px; /* Space for the sidebar */
    padding: 20px;
    transition: margin-left 0.3s ease; /* Smooth transition for main content */
}

.main.collapsed {
    margin-left: 0; /* No space for sidebar when collapsed */
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
/*     .button {
  width: 100px; /* Set appropriate width */
  height: 40px; /* Set appropriate height */
} */

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

    .tile-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .tile {
        background-color: #999999;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .tile i {
        font-size: 50px;
        margin-bottom: 10px;
    }

    .tile h3 {
        margin: 10px 0;
    }

    .tile p {
        color: #ddd;
    }

    .tile:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 1024px) {
        .tile-container {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
    .sidebar {
        position: absolute;
        width: 250px;
       
        transform: translateX(-100%); /* Hide sidebar off-screen */
        display: block; /* Show sidebar when collapsed */
    }

    .main {
        margin-left: 0; /* No space for sidebar on mobile */
        transition: margin-left 0.3s ease; /* Smooth transition for main content */
    }

    .sidebar.collapsed {
        transform: translateX(0); /* Show sidebar when expanded */
    }

    .sidebar .toggle-btn {
        display: block; /* Show toggle button on mobile */
    }
}

    @media (max-width: 576px) {
    .sidebar-heading {
        font-size: 14px;
    }

    .sidebar ul li a {
        font-size: 14px;
    }

    .header {
        padding: 5px 10px;
    }

    .header .profile-dropdown img {
        width: 30px;
        height: 30px;
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
        <li><a href="live.php"><i class="fas fa-camera"></i> <span>LIVE</span></a></li>
    </ul>
</div>

    <!-- Header -->
<div class="header">
    <div>
        <button class="toggle-btn" id="toggle-btn-mobile"><i class="fas fa-bars"></i></button>
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
            <div class="container">
    <table class="table table-bordered">
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
                <td><?php echo htmlspecialchars($subEvent['event_name']); ?></td>
                <td><?php echo date('m-d-Y', strtotime($subEvent['eventdate'])); ?></td>
                <td><?php echo date('g:i', strtotime($subEvent['eventtime'])); ?></td>
                <td><?php echo htmlspecialchars($subEvent['place']); ?></td>
                <td><?php echo htmlspecialchars($subEvent['status']); ?></td>
                <td>
                    <!-- Disable Edit and Delete buttons if status is 'deactivated' -->
                    <button class="btn btn-success" onclick="showEditModal(<?php echo htmlspecialchars($subEvent['subevent_id']); ?>, '<?php echo htmlspecialchars($subEvent['event_name']); ?>')" <?php echo $subEvent['status'] == 'deactivated' ? 'disabled' : ''; ?>><i class="icon-pencil"></i></button>
                    
                    <button class="btn btn-danger" onclick="showDeleteModal(<?php echo htmlspecialchars($subEvent['subevent_id']); ?>, '<?php echo htmlspecialchars($subEvent['event_name']); ?>')" <?php echo $subEvent['status'] == 'deactivated' ? 'disabled' : ''; ?>><i class="icon-trash"></i></button>
                    
                    <!-- Conditionally Render Settings Button -->
                    <?php if ($subEvent['status'] != 'deactivated'): ?>
                    <a href="sub_event_details.php?sub_event_id=<?php echo htmlspecialchars($subEvent['subevent_id']); ?>&se_name=<?php echo urlencode($subEvent['event_name']); ?>" 
                       class="btn btn-primary"><i class="icon icon-cog"></i></a>
                    <?php endif; ?>
                    
                    <!-- Always enable Activate/Deactivate button -->
                    <button class="btn <?php echo $subEvent['status'] == 'activated' ? 'btn-warning' : 'btn-danger'; ?>" onclick="showActivationModal(<?php echo htmlspecialchars($subEvent['subevent_id']); ?>, '<?php echo htmlspecialchars($subEvent['event_name']); ?>', '<?php echo htmlspecialchars($subEvent['status']); ?>')">
                        <i class="fa-solid <?php echo $subEvent['status'] == 'activated' ? 'fa-eye' : 'fa-eye-slash'; ?>"></i>
                        <span class="sr-only"><?php echo $subEvent['status'] == 'activated' ? 'Deactivate' : 'Activate'; ?></span>
                    </button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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

        $('#toggle-btn').on('click', function() {
            $('#sidebar').toggleClass('collapsed');
            $('#main-content').toggleClass('collapsed');
            $(this).toggleClass('collapsed');
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
