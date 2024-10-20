<?php
// Include necessary files and start the session
include('header2.php');
include('session.php');
include('dbcon.php'); // Include your PDO database connection file




// Fetch events from the database using PDO
$query = "SELECT * FROM main_event WHERE organizer_id = :organizer_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':organizer_id', $session_id);
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

$query = "SELECT * FROM live_streams WHERE organizer_id = :organizer_id ORDER BY start_time DESC";
$stmt = $conn->prepare($query);
$stmt->bindParam(':organizer_id', $session_id);
$stmt->execute();
$streams = $stmt->fetchAll(PDO::FETCH_ASSOC);



// Add this near the top of your live_stream.php file
if(isset($_GET['error'])) {
    $error_message = '';
    switch($_GET['error']) {
        case 'missing_parameters':
            $error_message = 'Missing required parameters to access the stream.';
            break;
        case 'invalid_token':
            $error_message = 'Invalid access token provided.';
            break;
        case 'stream_not_found':
            $error_message = 'The requested stream could not be found.';
            break;
    }
    if($error_message) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Access Denied',
                text: '$error_message'
            });
        </script>";
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="shortcut icon" href="../images/logo copy.png" />

    <style>
    /* Modal Background */
    .modal {
        display: none;
        /* Hidden by default */

    }

    body {
        font-family: Arial, sans-serif;
        background-color: #fff;
        margin: 0;
        padding: 0;
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
    }

    .sidebar.collapsed {
        width: 80px;
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
        font-size: 14px;
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
        transition: margin 0.3s;
        font-size: 14px;
    }

    .sidebar.collapsed ul li a i {
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

    .tile-container {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .tile {
        background-color: #7FFFD4;
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
            width: 100%;
            height: auto;
            position: relative;
        }

        .sidebar.collapsed {
            width: 100%;
        }

        .main {
            margin-left: 0;
        }
    }

    @media (max-width: 576px) {
        .sidebar-heading {
            font-size: 18px;
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


    .tile {
        position: relative;
        /* ... other existing styles ... */
    }

    .dropdown {
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .dropbtn {
        background-color: transparent;
        color: black;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: #f9f9f9;
        min-width: 120px;
        box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {
        background-color: #f1f1f1
    }

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown:hover .dropbtn {
        background-color: #f1f1f1;
    }
    </style>
</head>

<body>
    <div class="sidebar" id="sidebar">
        <button class="toggle-btn" id="toggle-btn">☰</button>
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
    <!-- Header -->
    <div class="header">
        <div>
            <!-- Add any left-aligned content here if needed -->
        </div>
        <div class="profile-dropdown">
            <div style="font-size:small;"> <?php echo $name; ?></div>
            <div class="dropdown-menu">
                <a href="edit_organizer.php"> Account Settings</a>
                <a href="#" id="logout"><i class="fas fa-sign-out-alt"></i> <span>LOGOUT</span></a>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="main" id="main-content">
        <div class="container">
            <h1 style="font-size: 35px;">Live Stream</h1>
        </div>

        <section id="download-bootstrap">
            <div class="page-header">
                <a data-toggle="modal" class="btn btn-info pull-right" href="#addMEcollapse"
                    title="Click to add Main Event"><i class="icon icon-plus"></i> <strong>Add Live Stream</strong></a>

                <!-- Modal for adding an event -->
                <div id="addMEcollapse" class="modal fade" tabindex="-1" role="dialog"
                    aria-labelledby="addMEcollapseLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><strong>Add Live Stream</strong><button type="button"
                                        class="close" data-dismiss="modal">&times;</button></h4>
                            </div>
                            <div class="modal-body">
                                <form id="addStreamForm" method="POST" action="add_stream.php">
                                    <div class="modal-body">
                                        <input type="hidden" name="organizer_id" value="<?php echo $session_id; ?>">

                                        <div class="form-group">
                                            <label>Stream Title</label>
                                            <input type="text" class="form-control btn-block" style="height: 30px !important;" name="stream_title" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Channel Name</label>
                                            <input type="text" class="form-control btn-block" style="height: 30px !important;" name="channel_name" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Start Time</label>
                                            <input type="datetime-local" class="form-control btn-block" style="height: 30px !important;" name="start_time"
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label>End Time</label>
                                            <input type="datetime-local" class="form-control btn-block" style="height: 30px !important;" name="end_time" required>
                                        </div>

                                        <div class="form-group">
                                            <label>App ID</label>
                                            <input type="text" class="form-control btn-block" style="height: 30px !important;" name="app_id" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Save Stream</button>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <br> <br><br>
                <!-- Display events -->

            </div>

            <table class="table table-bordered">
    <thead>
        <tr>
            <th>Stream Title</th>
            <th>Channel Name</th>
            <th>Stream Status</th>
            <th>Start Time</th>
            <th>App ID</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($streams as $stream): ?>
            <tr>
                <td><?php echo htmlspecialchars($stream['stream_title']); ?></td>
                <td><?php echo htmlspecialchars($stream['channel_name']); ?></td>
                <td><?php echo ucfirst($stream['stream_status']); ?></td>
                <td><?php echo date('Y-m-d H:i:s', strtotime($stream['start_time'])); ?></td>
                <td><?php echo htmlspecialchars($stream['app_id']); ?></td>
                <td>
                    <a href="stream/host.php?id=<?php echo $stream['stream_id']; ?>&token=<?php echo $stream['token']; ?>" class="btn btn-primary btn-sm">View</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

            <!-- Update the edit event modal HTML -->
            <div id="editEventModal" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Edit Event</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="editEventForm" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="edit_event_id" id="edit_event_id">

                                <div class="form-group">
                                    <label for="edit_banner">Banner:</label>
                                    <input type="file" class="form-control" id="edit_banner" name="edit_banner">
                                </div>

                                <div class="form-group">
                                    <label for="edit_main_event">Event Name:</label>
                                    <input type="text" class="form-control btn-block"
                                        style="text-indent: 7px !important; height: 30px !important;"
                                        id="edit_main_event" name="edit_main_event" required>
                                </div>

                                <div class="form-group">
                                    <label for="edit_date_start">Start Date:</label>
                                    <input type="date" class="form-control btn-block" style="height: 30px !important;"
                                        id="edit_date_start" name="edit_date_start" required>
                                </div>

                                <div class="form-group">
                                    <label for="edit_date_end">End Date:</label>
                                    <input type="date" class="form-control btn-block" style="height: 30px !important;"
                                        id="edit_date_end" name="edit_date_end" required>
                                </div>

                                <div class="form-group">
                                    <label for="edit_event_description">Description:</label>
                                    <textarea class="form-control btn-block"
                                        style="text-indent: 7px !important; height: 100px !important;"
                                        id="edit_event_description" name="edit_event_description" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="edit_place">Venue:</label>
                                    <input type="text" class="form-control btn-block" style="height: 30px !important;"
                                        id="edit_place" name="edit_place" required>
                                </div>


                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="collapse indent" id="editEvent<?php echo $main_event_id; ?>">

                <!-- start of edit of main events -->

                <h4>Edit Event Details</h4>
                <table align="center" class="table table-bordered" id="example">
                    <tr>
                        <td>

                            <form method="POST">


                                <?php   
                                          $edit_event_query = $conn->query("select * from main_event where organizer_id='$session_id' and mainevent_id='$main_event_id'") or die(mysql_error());
                                        while ($edit_event_row = $edit_event_query->fetch()) 
                                        {
                                            $edit_mainevent_id=$edit_event_row['mainevent_id'];
                                           
                                             
                                            ?>


                                <input name="main_event_id" type="hidden" value="<?php echo $edit_mainevent_id; ?>" />

                                <strong>Event Name:</strong><br />
                                <input type="text" name="main_event" class="form-control btn-block"
                                    style="text-indent: 7px !important; height: 30px !important;"
                                    placeholder="Event Name" required="true"
                                    value="<?php echo $edit_event_row['event_name']; ?>" />
                                <br />

                                <strong>Date Start:</strong><br />
                                <input type="date" name="date_start" min="<?php echo date('Y-m-d');?>"
                                    class="form-control btn-block" style="height: 30px !important;" required="true"
                                    value="<?php echo $edit_event_row['date_start']; ?>" />
                                <br />

                                <strong>Date End:</strong><br />
                                <input type="date" name="date_end" min="<?php echo date('Y-m-d');?>"
                                    class="form-control btn-block" style="height: 30px !important;" required="true"
                                    value="<?php echo $edit_event_row['date_end']; ?>" />
                                <br />

                                <strong>Time Start</strong>:<br />
                                <input type="time" name="event_time" type="text" required="true" placeholder="hh:mm"
                                    class="form-control btn-block">
                                <br />

                                <strong>Time End</strong>:<br />
                                <input type="time" name="event_time" type="text" required="true" placeholder="hh:mm"
                                    class="form-control btn-block">
                                <br />

                                <strong>Venue:</strong><br />
                                <textarea placeholder="Enter Sub-Event Venue" rows="2" name="place"
                                    class="form-control btn-block" style="text-indent: 7px !important;"
                                    required="true"><?php echo $edit_event_row['place']; ?></textarea>



                                <?php } ?>

                                <div class="modal-footer">
                                    <button name="edit_event" class="btn btn-success"><i class="icon-ok"></i>
                                        <strong>UPDATE</strong></button>
                                </div>

                            </form>

                        </td>
                    </tr>
                </table>


                <!-- end of edit of main events -->
            </div>
    </div>
    <?php
if (isset($_POST['edit_event'])) {
    $main_event_id = $_POST['main_event_id'];
    $event_name = $_POST['main_event'];
    $date_start = $_POST['date_start'];
    $date_end = $_POST['date_end'];
    $event_place = $_POST['place'];

    $conn->query("UPDATE main_event SET event_name='$event_name', date_start='$date_start', date_end='$date_end', place='$event_place' WHERE mainevent_id='$main_event_id'");
    ?>
    <script>
    Swal.fire({
        title: 'Success!',
        text: 'Event <?php echo $event_name; ?> updated successfully!',
        icon: 'success'
    }).then(() => {
        window.location = 'home.php';
    });
    </script>
    <?php
}
?>


    </div>

    </section>
    <script src="..//assets/js/jquery.js"></script>
    <script src="..//assets/js/bootstrap-transition.js"></script>
    <script src="..//assets/js/bootstrap-alert.js"></script>
    <script src="..//assets/js/bootstrap-modal.js"></script>
    <script src="..//assets/js/bootstrap-dropdown.js"></script>
    <script src="..//assets/js/bootstrap-scrollspy.js"></script>
    <script src="..//assets/js/bootstrap-tab.js"></script>
    <script src="..//assets/js/bootstrap-tooltip.js"></script>
    <script src="..//assets/js/bootstrap-popover.js"></script>
    <script src="..//assets/js/bootstrap-button.js"></script>
    <script src="..//assets/js/bootstrap-collapse.js"></script>
    <script src="..//assets/js/bootstrap-carousel.js"></script>
    <script src="..//assets/js/bootstrap-typeahead.js"></script>
    <script src="..//assets/js/bootstrap-affix.js"></script>
    <script src="..//assets/js/holder/holder.js"></script>
    <script src="..//assets/js/google-code-prettify/prettify.js"></script>
    <script src="..//assets/js/application.js"></script>
    <!-- SweetAlert JavaScript -->
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
                    // Redirect to logout.php
                    window.location.href = '..//index.php';
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
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.tile').forEach(function(tile) {
            tile.addEventListener('click', function() {
                var eventId = this.getAttribute('data-id');
                window.location.href = 'sub_event.php?id=' + eventId;
            });
        });
    });
    </script>
    <script>
    // Function to get today's date in YYYY-MM-DD format
    function getTodayDate() {
        return new Date().toISOString().split('T')[0];
    }

    // Set min attribute for both date inputs
    document.getElementById('date_start').min = getTodayDate();
    document.getElementById('date_end').min = getTodayDate();

    // Ensure end date is not before start date
    document.getElementById('date_start').addEventListener('change', function() {
        document.getElementById('date_end').min = this.value;
    });
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
    $(document).ready(function() {
        // Handle edit button click
        $('.edit-event').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var eventId = $(this).data('id');

            // Show loading state
            Swal.fire({
                title: 'Loading...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Fetch event details
            $.ajax({
                url: 'get_event_details.php',
                type: 'POST',
                data: {
                    event_id: eventId
                },
                success: function(response) {
                    Swal.close();

                    // Parse the response if it's a string
                    if (typeof response === 'string') {
                        response = JSON.parse(response);
                    }

                    // Populate form fields
                    $('#edit_event_id').val(response.mainevent_id);
                    $('#edit_main_event').val(response.event_name);
                    $('#edit_date_start').val(response.date_start);
                    $('#edit_date_end').val(response.date_end);
                    $('#edit_place').val(response.place);

                    // Show the modal
                    $('#editEventModal').modal('show');
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch event details'
                    });
                }
            });
        });

        // Handle save changes button click
        $('#saveChanges').on('click', function() {
            var formData = new FormData($('#editEventForm')[0]);

            $.ajax({
                url: 'update_event.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    // Parse the response if it's a string
                    if (typeof response === 'string') {
                        response = JSON.parse(response);
                    }

                    if (response.success) {
                        $('#editEventModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Failed to update event'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to update event'
                    });
                }
            });
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        // Handle delete button click
        $('.delete-event').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            var eventId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading state
                    Swal.fire({
                        title: 'Deleting...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Send delete request
                    $.ajax({
                        url: 'delete-event.php',
                        type: 'POST',
                        data: {
                            event_id: eventId
                        },
                        success: function(response) {
                            Swal.close();

                            // Parse the response if it's a string
                            if (typeof response === 'string') {
                                response = JSON.parse(response);
                            }

                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message
                                }).then(function() {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message ||
                                        'Failed to delete event'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to connect to the server'
                            });
                        }
                    });
                }
            });
        });
    });
    </script>

    <!-- Add this to your existing JavaScript section -->
    <script>
    $(document).ready(function() {
        // Handle form submission
        $('#addStreamForm').on('submit', function(e) {
            e.preventDefault();

            // Show loading state
            Swal.fire({
                title: 'Adding stream...',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                type: 'POST',
                url: 'add_stream.php',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    Swal.close();

                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message || 'Stream added successfully',
                        }).then(() => {
                            $('#addMEcollapse').modal('hide');
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Failed to add stream'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.close();
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Server error: ' + (error || 'Unknown error occurred')
                    });
                }
            });
        });
    });
    </script>
</body>

</html>