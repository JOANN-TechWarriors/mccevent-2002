<?php
// Start the session and include necessary files
session_start();
include('header2.php');
include('session.php');
include('dbcon.php'); // Include your PDO database connection file

// Handle form submission to create a new event
if (isset($_POST['create'])) {
    $mainevent_id = uniqid('', true); // Generate a unique ID
    $event_name = $_POST['main_event'];
    $description = $_POST['description'];
    $event_start_date = $_POST['date_start'];
    $event_end_date = $_POST['date_end'];
    $event_venue = $_POST['place'];
    $banner = $_FILES['banner']['name'];
    $target = "../img/" . basename($banner);

    // Insert event details into the database using PDO
    $sql = "INSERT INTO main_event (mainevent_id, event_name, description, status, organizer_id, date_start, date_end, place, banner) 
            VALUES (:mainevent_id, :event_name, :description, 'activated', :organizer_id, :date_start, :date_end, :place, :banner)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':mainevent_id', $mainevent_id);
    $stmt->bindParam(':event_name', $event_name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':organizer_id', $session_id);
    $stmt->bindParam(':date_start', $event_start_date);
    $stmt->bindParam(':date_end', $event_end_date);
    $stmt->bindParam(':place', $event_venue);
    $stmt->bindParam(':banner', $banner);

    if ($stmt->execute()) {
        if (move_uploaded_file($_FILES['banner']['tmp_name'], $target)) {
            $_SESSION['message'] = 'Event created successfully!';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Event created, but failed to upload banner.';
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = 'Failed to create event.';
        $_SESSION['message_type'] = 'error';
    }

    header("Location: home.php");
    exit();
}

// Fetch events from the database using PDO
$query = "SELECT * FROM main_event WHERE organizer_id = :organizer_id";
$stmt = $conn->prepare($query);
$stmt->bindParam(':organizer_id', $session_id);
$stmt->execute();
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="shortcut icon" href="../images/logo copy.png"/>
    <style>
        /* Add your CSS styles here */
        /* ... */
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
            <li><a href="dashboard"><i class="fas fa-tachometer-alt"></i> <span>DASHBOARD</span></a></li>
            <li><a href="home"><i class="fas fa-calendar-check"></i> <span>ONGOING EVENTS</span></a></li>
            <li><a href="upcoming_events"><i class="fas fa-calendar-alt"></i> <span>UPCOMING EVENTS</span></a></li>
            <li><a href="live_stream"><i class="fas fa-camera"></i> <span>LIVE STREAM</span></a></li>
        </ul>
    </div>
    <!-- Header -->
    <div class="header">
        <div>
            <button class="toggle-btn" id="toggle-btn-mobile"><i class="fas fa-bars"></i></button>
        </div>
        <div class="profile-dropdown">
            <div style="font-size:small;"> <?php echo $name; ?></div>
            <div class="dropdown-menu">
                <a href="edit_organizer"> Account Settings</a>
                <a href="logout"><i class="fas fa-sign-out-alt"></i> <span>Sign Out</span></a>
            </div>
        </div>
    </div> 

    <!-- Main content -->
    <div class="main" id="main-content">
        <div class="container">
            <h1 style="font-size: 35px;">Ongoing Events</h1>
        </div>

        <section id="download-bootstrap">
            <div class="page-header">
                <a data-toggle="modal" class="btn btn-info pull-right" href="#addMEcollapse"
                    title="Click to add Main Event"><i class="icon icon-plus"></i> <strong>EVENT</strong></a>

                <!-- Modal for adding an event -->
                <div id="addMEcollapse" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="addMEcollapseLabel" aria-hidden="true">                    
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title"><strong>ADD EVENT</strong><button type="button" class="close"
                                        data-dismiss="modal">&times;</button></h4>
                            </div>
                            <div class="modal-body">
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <strong>Upload Banner:</strong><br />
                                        <input type="file" name="banner" accept="image/*">
                                        <small class="form-text text-muted">File size:1200x400 pixels.Maximum 2MB.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="main_event"><strong>Event Name:</strong></label>
                                        <input type="text" name="main_event" class="form-control btn-block"
                                            style="text-indent: 5px !important; height: 30px !important;"
                                            placeholder="Event Name" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="date_start"><strong>Start Date:</strong></label>
                                        <input type="date" id="date_start" name="date_start" class="form-control btn-block"
                                            style="text-indent: 5px !important; height: 30px !important;" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="date_end"><strong>End Date:</strong></label>
                                        <input type="date" id="date_end" name="date_end" class="form-control btn-block"
                                            style="text-indent: 5px !important; height: 30px !important;" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="description"><strong>Description:</strong></label>
                                        <textarea name="description" class="form-control btn-block"
                                            style="text-indent: 5px !important; height: 100px !important;"
                                            placeholder="Description" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="place"><strong>Venue:</strong></label>
                                        <input type="text" name="place" class="form-control btn-block"
                                            style="text-indent: 5px !important; height: 30px !important;"
                                            placeholder="Venue" required />
                                    </div>
                                    <div class="modal-footer">
                                        <button name="create" class="btn btn-success"><i class="icon-save"></i>
                                            <strong>SAVE</strong></button>
                                        <button type="reset" class="btn btn-default"><i class="icon-ban-circle"></i>
                                            <strong>RESET</strong></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <br> <br><br>
                <!-- Display events -->
                <div class="tile-container">
                    <?php foreach ($events as $event) { ?>
                    <div class="tile" data-id="<?php echo htmlspecialchars($event['mainevent_id']); ?>">
                        <div class="dropdown">
                            <button class="dropbtn">⋮</button>
                            <div class="dropdown-content">
                                <a href="#editEvent" style="color: black;" class="btn-success edit-event" data-id="<?php echo htmlspecialchars($event['mainevent_id']); ?>">
                                    <i class="icon-pencil"></i> Edit
                                </a>
                                <a href="#" style="color: black;" class="btn-danger delete-event" data-id="<?php echo htmlspecialchars($event['mainevent_id']); ?>">
                                    <i class="icon-remove"></i> Delete
                                </a>
                            </div>
                        </div>
                        <h3><b><?php echo htmlspecialchars($event['event_name']); ?></b></h3>
                        <p><?php echo date('m-d-Y', strtotime($event['date_start'])); ?> to
                        <?php echo date('m-d-Y', strtotime($event['date_end'])); ?></p>
                        <p><?php echo htmlspecialchars($event['place']); ?></p>
                    </div>
                    <?php } ?>
                </div>

                <!-- Edit Event Modal -->
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
                                        <label for="edit_main_event">Event Name:</label>
                                        <input type="text" class="form-control btn-block" id="edit_main_event" name="edit_main_event" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="edit_date_start">Start Date:</label>
                                        <input type="date" class="form-control btn-block" id="edit_date_start" name="edit_date_start" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="edit_date_end">End Date:</label>
                                        <input type="date" class="form-control btn-block" id="edit_date_end" name="edit_date_end" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="edit_event_description">Description:</label>
                                        <textarea class="form-control btn-block" id="edit_event_description" name="edit_event_description" required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="edit_place">Venue:</label>
                                        <input type="text" class="form-control btn-block" id="edit_place" name="edit_place" required>
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
            </div>
        </section>
    </div>

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

        $('#toggle-btn').on('click', function() {
            $('#sidebar').toggleClass('collapsed');
            $('#main-content').toggleClass('collapsed');
            $(this).toggleClass('collapsed');
        });
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
                    data: { event_id: eventId },
                    success: function(response) {
                        Swal.close();
                        
                        if (typeof response === 'string') {
                            response = JSON.parse(response);
                        }
                        
                        if (!response.error) {
                            // Populate form fields
                            $('#edit_event_id').val(response.mainevent_id);
                            $('#edit_main_event').val(response.event_name);
                            $('#edit_date_start').val(response.date_start);
                            $('#edit_date_end').val(response.date_end);
                            $('#edit_event_description').val(response.description);
                            $('#edit_place').val(response.place);

                            // Show the modal
                            $('#editEventModal').modal('show');
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.error
                            });
                        }
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

                // Disable the save button to prevent multiple clicks
                $('#saveChanges').prop('disabled', true);

                $.ajax({
                    url: 'update_event.php',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (typeof response === 'string') {
                            response = JSON.parse(response);
                        }

                        setTimeout(() => {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message
                                }).then(function() {
                                    $('#editEventModal').modal('hide');
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: response.message || 'Failed to update event'
                                });
                            }
                            $('#saveChanges').prop('disabled', false);
                        }, 1000);
                    },
                    error: function() {
                        setTimeout(() => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to update event'
                            });
                            $('#saveChanges').prop('disabled', false);
                        }, 1000);
                    }
                });
            });

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
                            data: { event_id: eventId },
                            success: function(response) {
                                Swal.close();
                                
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
                                        text: response.message || 'Failed to delete event'
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
</body>
</html>