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
    
    .header{
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
    margin-left: 250px; /* Space for the sidebar */
    padding: 20px;
    transition: margin-left 0.3s ease; /* Smooth transition for main content */
}

.main.collapsed {
    margin-left: 0; /* No space for sidebar when collapsed */
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
}eft: 0;
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
<body >
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

    calendar = new FullCalendar.Calendar(calendarEl, {
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,listMonth'
        },
        initialDate: '<?php echo date('Y-m-d') ?>',
        weekNumbers: true,
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
      var id = $('#updateeventID').val();
      if (id) {
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
              data: { id: id },
              success: function(data) {
                calendar.refetchEvents();
                $('#updateEventModal').modal('hide');
                $('#updateeventID').val('');
                $('#updateeventTitle').val('');
                $('#updateeventStart').val('');
                $('#updateeventEnd').val('');
                Swal.fire({
                  icon: 'success',
                  title: 'Event Deleted Successfully',
                  showConfirmButton: false,
                  timer: 1500
                });
              },
              error: function(xhr, status, error) {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'An error occurred while deleting the event: ' + error
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