<?php
$request = $_SERVER['REQUEST_URI'];
if (substr($request, -4) == '.php') {
    $new_url = substr($request, 0, -4);
    header("Location: $new_url", true, 301);
    exit();
}
?>
<?php
// Include necessary files and start the session
include('header2.php');
include('session.php');
include('dbcon.php'); // Include your PDO database connection file



// Handle form submission to create a new event

if (isset($_POST['create'])) {
    // Generate a random 5-digit number for mainevent_id
    $mainevent_id = rand(10000, 99999);

    $event_name = $_POST['main_event'];
    $description = $_POST['description'];
    $event_start_date = $_POST['date_start'];
    $event_end_date = $_POST['date_end'];
    $event_venue = $_POST['place'];
    $banner = $_FILES['banner']['name'];
    $target = "../img/" . basename($banner);

    try {
        // Insert event details into the database using PDO
        $sql = "INSERT INTO main_event (mainevent_id, event_name, description, status, organizer_id, date_start, date_end, place, banner) 
                VALUES (:mainevent_id, :event_name, :description, 'activated', :organizer_id, :date_start, :date_end, :place, :banner)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':mainevent_id', $mainevent_id);
        $stmt->bindParam(':event_name', $event_name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':organizer_id', $session_id); // Assuming $session_id is defined elsewhere
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
    } catch (PDOException $e) {
        $_SESSION['message'] = 'Database error: ' . $e->getMessage();
        $_SESSION['message_type'] = 'error';
    }

    header("Location: home.php"); // Redirect to the same page or another page
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

/*     .sidebar.collapsed ul li a i {
        margin-right: 0;
    }
 */
/*     .sidebar ul li a span {
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

    .tile {
    position: relative;
    /* ... other existing styles ... */
    }

    .dropdown {
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        background-color: #f9f9f9;
        min-width: 120px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {background-color: #f1f1f1}

    .dropdown:hover .dropdown-content {
        display: block;
    }

    .dropdown:hover .dropbtn {
        background-color: #f1f1f1;
    }
    .tile-container {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    padding: 20px;
}

.tile {
    background: #FEFFA7;
    border-radius: 8px;
    padding: 20px;
    position: relative;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    border: 1px solid #eee;
}

/* Dropdown Styling */
.dropdown {
    position: absolute;
    top: 10px;
    right: 10px;
}

.dropbtn {
    background: transparent;
    border: none;
    font-size: 20px;
    color: #000;
    cursor: pointer;
    padding: 5px 10px;
    border-radius: 4px;
    transition: background-color 0.2s;
}

.dropbtn:hover {
    background-color: #f5f5f5;
}

.dropdown-content {
    display: none;
    position: absolute;
    right: 0;
    background-color: transparent;
    min-width: 160px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    border-radius: 6px;
    z-index: 1;
    padding: 8px;
}

.dropdown:hover .dropdown-content {
    display: block;
}

/* Button Styling */
.dropdown-content a {
    display: flex;
    align-items: center;
    padding: 8px 12px;
    text-decoration: none;
    color: #333;
    border-radius: 4px;
    margin-bottom: 4px;
    transition: background-color 0.2s;
}

.dropdown-content a:last-child {
    margin-bottom: 0;
}

.dropdown-content a.btn-success {
    color: #28a745;
}

.dropdown-content a.btn-danger {
    color: #dc3545;
}

.dropdown-content a:hover {
    background-color: #f8f9fa;
}

/* Icon Styling */
.dropdown-content a i {
    margin-right: 8px;
    font-size: 14px;
}

/* Event Content Styling */
.tile h3 {
    margin: 0 0 15px 0;
    color: #000;
    font-size: 18px;
    padding-right: 30px; /* Make room for dropdown */
}

.tile p {
    margin: 8px 0;
    color: #666;
    font-size: 14px;
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
    <!-- Header -->
    <div class="header">
    <div>
        <button class="toggle-btn" id="toggle-btn-mobile"><i class="fas fa-bars"></i></button>
    </div>
    <div class="profile-dropdown">
        <div style="font-size:small;"> <?php echo $name; ?></div>
        <div class="dropdown-menu">
            <a href="edit_organizer.php"> Account Settings</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span>Sign Out</span></a>
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
                        <small class="form-text text-muted">File size:1200x400 pixels.Maximum 2MB.</small>
                    </div>

                    <div class="form-group">
                        <label for="edit_main_event">Event Name:</label>
                        <input type="text" class="form-control btn-block" style="text-indent: 7px !important; height: 30px !important;" id="edit_main_event" name="edit_main_event" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_date_start">Start Date:</label>
                        <input type="date" class="form-control btn-block" style="height: 30px !important;" id="edit_date_start" name="edit_date_start" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_date_end">End Date:</label>
                        <input type="date" class="form-control btn-block" style="height: 30px !important;" id="edit_date_end" name="edit_date_end" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="edit_event_description">Description:</label>
                        <textarea class="form-control btn-block" style="text-indent: 7px !important; height: 100px !important;" id="edit_event_description" name="edit_event_description" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="edit_place">Venue:</label>
                        <input type="text" class="form-control btn-block" style="height: 30px !important;" id="edit_place" name="edit_place" required>
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
            window.location.href = 'sub_event?id=' + eventId;
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
            data: { event_id: eventId },
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
            
            // Wait for 2 seconds before showing the SweetAlert
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
                // Re-enable the save button
                $('#saveChanges').prop('disabled', false);
            }, 1000);
        },
        error: function() {
            // Wait for 2 seconds before showing the error SweetAlert
            setTimeout(() => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update event'
                });
                // Re-enable the save button
                $('#saveChanges').prop('disabled', false);
            }, 1000);
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
                        data: { event_id: eventId },
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
