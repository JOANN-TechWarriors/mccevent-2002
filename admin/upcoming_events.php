<?php
$request = $_SERVER['REQUEST_URI'];
if (substr($request, -4) == '.php') {
    $new_url = substr($request, 0, -4);
    header("Location: $new_url", true, 301);
    exit();
}
?>
<?php 
  include('dbcon.php');
  date_default_timezone_set('Asia/Manila'); 
  include('session.php');
?>
<!DOCTYPE html>
<html>
<head>
<link rel="shortcut icon" href="../images/logo copy.png"/>
<title>Event Judging System</title>  
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link href="..//assets/fullcalendar/main.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="..//assets/fullcalendar/main.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.min.js"></script>
  <script src="..//assets/fullcalendar/moment.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #fff;
      margin: 0;
      padding: 0;
      overflow-x: hidden;
    }

    /* Calendar Specific Responsive Styles */
    .fc {
      max-width: 100%;
      height: auto !important;
    }

    .fc .fc-toolbar {
      flex-wrap: wrap;
      gap: 0.5rem;
    }

    .fc .fc-toolbar-title {
      font-size: 1.2em;
    }

    @media (max-width: 768px) {
      .fc .fc-toolbar {
        display: flex;
        flex-direction: column;
        align-items: stretch;
        gap: 0.5rem;
      }

      .fc .fc-toolbar-title {
        font-size: 1em;
        text-align: center;
      }

      .fc .fc-button {
        padding: 0.2rem 0.5rem;
        font-size: 0.9em;
      }

      .fc .fc-view-harness {
        height: auto !important;
        min-height: 400px;
      }
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

    .sidebar ul li a:hover {
        background-color: #1a1a2e;
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

    .main {
      margin-left: 250px;
      padding: 20px;
      transition: margin-left 0.3s ease;
    }

    .main.collapsed {
      margin-left: 0;
    }

    /* Modal Responsive Styles */
    .modal-dialog {
      max-width: 95%;
      margin: 1.75rem auto;
    }

    @media (min-width: 576px) {
      .modal-dialog {
        max-width: 500px;
      }
    }

    /* Responsive Breakpoints */
    @media (max-width: 1024px) {
      .fc .fc-toolbar-title {
        font-size: 1.1em;
      }
    }

    @media (max-width: 768px) {
      .sidebar {
        transform: translateX(-100%);
      }

      .sidebar.collapsed {
        transform: translateX(0);
      }

      .main {
        margin-left: 0;
        padding: 10px;
      }

      .header {
        padding: 5px 10px;
      }

      .fc .fc-toolbar-title {
        font-size: 1em;
      }

      .fc .fc-button {
        padding: 0.2rem 0.4rem;
        font-size: 0.8em;
      }
    }

    @media (max-width: 576px) {
      .sidebar-heading {
        font-size: 14px;
      }

      .sidebar ul li a {
        font-size: 14px;
      }

      .header .profile-dropdown img {
        width: 30px;
        height: 30px;
      }

      .fc .fc-toolbar-title {
        font-size: 0.9em;
      }

      .fc .fc-button-group {
        display: flex;
        flex-wrap: wrap;
        gap: 0.2rem;
      }

      .fc .fc-button {
        padding: 0.15rem 0.3rem;
        font-size: 0.75em;
      }
    }

    /* Calendar Container */
    #calendar {
      margin-top: 20px;
      background: white;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    /* Add Event Button */
    #addEvent {
      margin-bottom: 15px;
      width: auto;
    }

    @media (max-width: 480px) {
      #addEvent {
        width: 100%;
      }
    }
  </style>
</head>
<body >
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
                <a href="#" id="logout"><i class="fas fa-sign-out-alt"></i> <span>Sign out</span></a>
            </div>
        </div>
    </div>
    <!-- Main content -->
  <div class="main" id="main-content">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <br>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEventModal" id="addEvent">
            Add Event
          </button>
          <br><br>
          <div id="calendar"></div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addEventModalLabel">Add Event</h5>
          </div>
          <div class="modal-body">
            <form action="add_upcoming_event.php" method="POST" enctype="multipart/form-data">
              <div class="mb-3">
                <input type="hidden" class="form-control" id="eventID">
                <label for="eventTitle" class="form-label">Title</label>
                <input type="text" class="form-control" name="eventtitle" id="eventTitle" required>
              </div>
              <div class="mb-3">
                <div>Upload Banner:</div> <br>
                <input type="file" name="banner" id="banner" required>
              </div>
              <div class="mb-3">
                <label for="eventStart" class="form-label">Start</label>
                <input type="datetime-local" name="eventstart" class="form-control" id="eventStart" required>
              </div>
              <div class="mb-3">
                <label for="eventEnd" class="form-label">End</label>
                <input type="datetime-local" name="event_end" class="form-control" id="eventEnd" required>
              </div>
              <button type="submit" class="btn btn-primary">Add Event</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="updateEventModal" tabindex="-1" aria-labelledby="updateEventModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="updateEventModalLabel">Edit Event</h5>
          </div>
          <div class="modal-body">
          <form action="update-event.php" method="POST" enctype="multipart/form-data">
  <div class="mb-3">
    <input type="hidden" class="form-control" id="updateeventID" name="eventID">
    <label for="updateeventTitle" class="form-label">Title</label>
    <input type="text" class="form-control" id="updateeventTitle" name="eventTitle" required>
  </div>
  <div class="mb-3">
    <strong>Upload Banner:</strong> <br />
    <input type="file" name="eventBanner" accept="image/*">
  </div>
  <div class="mb-3">
    <label for="updateeventStart" class="form-label">Start</label>
    <input type="datetime-local" class="form-control" id="updateeventStart" name="eventStart" required>
  </div>
  <div class="mb-3">
    <label for="updateeventEnd" class="form-label">End</label>
    <input type="datetime-local" class="form-control" id="updateeventEnd" name="eventEnd" required>
  </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" id="deleteEventButton">Delete</button>
            <button type="submit" class="btn btn-success" id="updateEventButton">Update</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelEventButton">Cancel</button>
          </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
  var calendarEl = document.getElementById('calendar');
  var calendar;

  document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: window.innerWidth < 768 ? 'listMonth' : 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,listMonth'
        },
        windowResize: function(view) {
            if (window.innerWidth < 768) {
                calendar.changeView('listMonth');
            } else {
                calendar.changeView('dayGridMonth');
            }
            calendar.updateSize();
        },
        initialDate: '<?php echo date('Y-m-d') ?>',
        weekNumbers: window.innerWidth >= 768,
        navLinks: true,
        editable: true,
        selectable: true,
        selectConstraint: {
            start: new Date().toISOString().slice(0, 10),
            end: null
        },
        nowIndicator: true,
        dayMaxEvents: true,
        events: 'get-events.php',
        height: 'auto',
        contentHeight: 'auto',
        aspectRatio: 1.8,
        handleWindowResize: true,
        select: function(info) {
            var start = roundToNearestHalfHour(info.start);
            var end = moment(start).add(30, 'minutes');

            var startTime = start.format('YYYY-MM-DDTHH:mm');
            $('#eventStart').val(startTime);

            var endTime = end.format('YYYY-MM-DDTHH:mm');
            $('#eventEnd').val(endTime);
            $('#addEventModal').modal('show');
            calendar.unselect();
        },
        eventClick: function(info) {
            $('#updateEventModal').modal('show');
            $('#updateeventID').val(info.event.id);
            $('#updateeventTitle').val(info.event.title);

            var startRounded = roundToNearestHalfHour(info.event.start);
            var endRounded = roundToNearestHalfHour(info.event.end);

            $('#updateeventStart').val(startRounded.format('YYYY-MM-DDTHH:mm'));
            $('#updateeventEnd').val(endRounded.format('YYYY-MM-DDTHH:mm'));
        }
    });

    calendar.render();

    $('#deleteEventButton').off('click').on('click', function() {
  var event_id = $('#updateeventID').val();
  
  if (event_id) {
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
        $.ajax({
          url: 'delete-event.php',
          type: 'POST',
          data: { event_id: event_id },
          dataType: 'json',
          success: function(response) {
            if (response && response.success) {
              // Remove the event from the calendar
              var eventToRemove = calendar.getEventById(event_id);
              if (eventToRemove) {
                eventToRemove.remove();
              }

              // Close the modal
              $('#updateEventModal').modal('hide');

              // Clear form fields
              $('#updateeventID').val('');
              $('#updateeventTitle').val('');
              $('#updateeventStart').val('');
              $('#updateeventEnd').val('');

              // Show success message
              Swal.fire({
                icon: 'success',
                title: 'Event Deleted Successfully',
                text: response.message || 'Event has been removed',
                showConfirmButton: false,
                timer: 1500
              });

              // Refresh the calendar events
              calendar.refetchEvents();
            } else {
              // Handle failure scenario
              Swal.fire({
                icon: 'error',
                title: 'Deletion Failed',
                text: response ? response.message : 'Unable to delete the event'
              });
            }
          },
          error: function(xhr, status, error) {
            // Parse error response if possible
            let errorMessage = 'An unexpected error occurred';
            try {
              const responseText = xhr.responseText;
              const errorResponse = JSON.parse(responseText);
              errorMessage = errorResponse.message || errorMessage;
            } catch (e) {
              // If parsing fails, use the original error
              errorMessage = error || 'Unknown error occurred';
            }

            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'Failed to delete event: ' + errorMessage
            });
          }
        });
      }
    });
  } else {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: 'Event ID is required for deletion.'
    });
  }
});

    $('#cancelEventButton').off('click').on('click', function() {
      $('#updateeventID').val('');
      $('#updateeventTitle').val('');
      $('#updateeventStart').val('');
      $('#updateeventEnd').val('');
    });

    $('#updateEventButton').off('click').on('click', function() {
      var id = $('#updateeventID').val();
      var title = $('#updateeventTitle').val();
      var start = $('#updateeventStart').val();
      var end = $('#updateeventEnd').val();
      var formData = new FormData();

      formData.append('eventID', id);
      formData.append('eventTitle', title);
      formData.append('eventStart', start);
      formData.append('eventEnd', end);

      var bannerInput = $('#eventBanner')[0];
      if (bannerInput.files.length > 0) {
        formData.append('eventBanner', bannerInput.files[0]);
      }

      $.ajax({
        url: 'update-event.php',
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: response.message,
            confirmButtonText: 'OK'
          }).then((result) => {
            if (result.isConfirmed) {
              $('#updateEventModal').modal('hide');
              calendar.refetchEvents();  // Refresh the events in FullCalendar
            }
          });
        },
        error: function(jqXHR, textStatus, errorThrown) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error updating event: ' + errorThrown,
            confirmButtonText: 'OK'
          });
        }
      });
    });

    var currentDateTime = roundToNearestHalfHour(new Date()).format('YYYY-MM-DDTHH:mm');
    $('#eventStart, #eventEnd, #updateeventStart, #updateeventEnd').attr('min', currentDateTime).attr('step', '1800');
  });

  function roundToNearestHalfHour(date) {
    var m = moment(date);
    var roundedMinutes = Math.round(m.minute() / 30) * 30;
    return m.minute(roundedMinutes).second(0).millisecond(0);
  }

  function validateTimeInput(input) {
    var time = moment(input.value, 'YYYY-MM-DDTHH:mm');
    var roundedTime = roundToNearestHalfHour(time);
    input.value = roundedTime.format('YYYY-MM-DDTHH:mm');
  }

  function checkEventConflict(eventData, callback) {
    $.ajax({
      url: 'check_event_conflict.php',
      type: 'POST',
      data: eventData,
      success: function(response) {
        var result = JSON.parse(response);
        callback(result.conflict);
      },
      error: function() {
        callback(true); // Assume conflict on error
      }
    });
  }
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

  $('#eventStart, #eventEnd, #updateeventStart, #updateeventEnd').on('change', function() {
    validateTimeInput(this);
  });

   // Handle window resize
   window.addEventListener('resize', function() {
        calendar.updateSize();
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