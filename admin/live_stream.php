<?php
// Include necessary files and start the session
include('header2.php');
include('session.php');
include('dbcon.php');

// Function to delete a stream
function deleteStream($streamId, $organizerId, $conn) {
    $query = "DELETE FROM live_streams WHERE stream_id = :stream_id AND organizer_id = :organizer_id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':stream_id', $streamId);
    $stmt->bindParam(':organizer_id', $organizerId);
    return $stmt->execute();
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_stream'])) {
    $streamId = $_POST['delete_stream'];
    try {
        if (deleteStream($streamId, $session_id, $conn)) {
            echo json_encode(['success' => true, 'message' => 'Stream deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete stream.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
    exit;
}

// Pagination settings
$records_per_page = isset($_GET['show']) ? (int)$_GET['show'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $records_per_page;

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';
$search_condition = '';
$params = [':organizer_id' => $session_id];

if (!empty($search)) {
    $search_condition = " AND (stream_title LIKE :search OR channel_name LIKE :search)";
    $params[':search'] = "%{$search}%";
}

// Count total records for pagination
$count_query = "SELECT COUNT(*) FROM live_streams WHERE organizer_id = :organizer_id" . $search_condition;
$count_stmt = $conn->prepare($count_query);
$count_stmt->execute($params);
$total_records = $count_stmt->fetchColumn();
$total_pages = ceil($total_records / $records_per_page);

// Fetch streams with pagination and search
$query = "SELECT * FROM live_streams 
          WHERE organizer_id = :organizer_id" . 
          $search_condition . 
          " ORDER BY start_time DESC 
          LIMIT :offset, :records_per_page";

$stmt = $conn->prepare($query);
$stmt->bindParam(':organizer_id', $session_id);
if (!empty($search)) {
    $stmt->bindParam(':search', $params[':search']);
}
$stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
$stmt->bindParam(':records_per_page', $records_per_page, PDO::PARAM_INT);
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

<?php
// add_stream.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and process the uploaded image
    if (isset($_FILES['stream_banner']) && $_FILES['stream_banner']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/stream_banners/'; // Create this directory and ensure it's writable
        
        // Create directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        // Get file information
        $fileName = $_FILES['stream_banner']['name'];
        $fileType = $_FILES['stream_banner']['type'];
        $fileTmpName = $_FILES['stream_banner']['tmp_name'];
        $fileError = $_FILES['stream_banner']['error'];
        $fileSize = $_FILES['stream_banner']['size'];
        
        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($fileType, $allowedTypes)) {
            die('Error: Invalid file type. Only JPG, PNG and GIF files are allowed.');
        }
        
        // Validate file size (2MB max)
        if ($fileSize > 2 * 1024 * 1024) {
            die('Error: File size is too large. Maximum size is 2MB.');
        }
        
        // Generate unique filename
        $newFileName = uniqid() . '_' . $fileName;
        $uploadPath = $uploadDir . $newFileName;
        
        // Move uploaded file
        if (move_uploaded_file($fileTmpName, $uploadPath)) {
            // File was uploaded successfully
            $imageUrl = $uploadPath;
            
            // Prepare the SQL statement
            $stmt = $pdo->prepare("INSERT INTO live_streams (
                organizer_id, channel_name, stream_title, start_time, end_time, 
                app_id, image_url, stream_status
            ) VALUES (
                :organizer_id, :channel_name, :stream_title, :start_time, :end_time,
                :app_id, :image_url, 'scheduled'
            )");
            
            // Execute the statement with all the form data
            $stmt->execute([
                'organizer_id' => $_POST['organizer_id'],
                'channel_name' => $_POST['channel_name'],
                'stream_title' => $_POST['stream_title'],
                'start_time' => $_POST['start_time'],
                'end_time' => $_POST['end_time'],
                'app_id' => $_POST['app_id'],
                'image_url' => $imageUrl
            ]);
            
            // Redirect or show success message
            header('Location: streams.php?success=1');
            exit;
        } else {
            die('Error: Failed to upload file.');
        }
    } else {
        die('Error: No file uploaded or upload error occurred.');
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="shortcut icon" href="../../images/logo copy.png" />

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
    .table-container {
            margin: 20px;
            overflow-x: auto;
            max-width: 100%;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .table-responsive {
            width: 100%;
            min-width: 600px;
            border-collapse: collapse;
            background-color: white;
        }

        .table-responsive thead {
            background-color: #f8f9fa;
        }

        .table-responsive th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            color: #333;
            border-bottom: 2px solid #dee2e6;
            white-space: nowrap;
        }

        .table-responsive td {
            padding: 12px 15px;
            border-bottom: 1px solid #dee2e6;
            font-size: 14px;
            vertical-align: middle;
        }

        .table-responsive tbody tr:hover {
            background-color: #f8f9fa;
        }

        .table-responsive img {
            max-width: 100px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            border: none;
            margin-right: 5px;
        }

        .btn-primary {
            background-color: #007bff;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }

        /* Status badge styling */
        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-scheduled {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-live {
            background-color: #dcfce7;
            color: #166534;
        }

        .status-ended {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .table-controls {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-box {
                width: 100%;
                margin-left: 0;
            }
            
            .search-box input {
                width: 100%;
            }
            
            .pagination-container {
                flex-direction: column;
                text-align: center;
            }
            
            .pagination {
                justify-content: center;
            }
            
            .show-entries {
                justify-content: center;
            }
        }

        /* Additional Responsive Fixes */
        @media screen and (max-width: 576px) {
            .table-controls, .pagination-container {
                margin: 10px;
                padding: 10px;
            }
            
            .pagination li a {
                padding: 6px 10px;
            }
        }

        /* Responsive adjustments */
        @media screen and (max-width: 768px) {
            .table-container {
                margin: 10px;
                border-radius: 6px;
            }

            .btn {
                padding: 4px 8px;
                font-size: 12px;
            }

            .table-responsive th,
            .table-responsive td {
                padding: 10px;
            }

            .table-responsive img {
                max-width: 80px;
                height: 48px;
            }
        }
        /* Table Controls Layout */
            .table-controls {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 20px;
                padding: 0 20px;
                background-color: #f8f9fa;
                border-radius: 8px;
                padding: 15px;
            }

            .show-entries {
                display: flex;
                align-items: center;
                gap: 10px;
                white-space: nowrap;
            }

            .show-entries select {
                padding: 6px;
                border: 1px solid #ddd;
                border-radius: 4px;
                min-width: 80px;
                background-color: white;
            }

            .search-box {
                display: flex;
                align-items: center;
                gap: 10px;
                margin-left: auto;
            }

            .search-box input {
                padding: 6px 12px;
                border: 1px solid #ddd;
                border-radius: 4px;
                width: 250px;
                background-color: white;
            }

            /* Table Container */
            .table-container {
                overflow-x: auto;
                margin: 0 20px;
                background-color: white;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            }

            .table-responsive {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 0;
            }

            .table-responsive th,
            .table-responsive td {
                padding: 12px;
                border: 1px solid #ddd;
            }

            .table-responsive th {
                background-color: #f8f9fa;
                font-weight: bold;
                text-align: left;
            }

            /* Pagination Layout */
            .pagination-container {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                justify-content: space-between;
                align-items: center;
                margin: 20px;
                padding: 15px;
                background-color: #f8f9fa;
                border-radius: 8px;
            }

            .pagination {
                display: flex;
                flex-wrap: wrap;
                list-style: none;
                padding: 0;
                margin: 0;
                gap: 5px;
            }

            .pagination li {
                margin: 0;
            }

            .pagination li a {
                display: inline-block;
                padding: 8px 12px;
                border: 1px solid #ddd;
                border-radius: 4px;
                text-decoration: none;
                color: #007bff;
                background-color: white;
                transition: all 0.2s ease;
            }

            .pagination li.active a {
                background-color: #007bff;
                color: white;
                border-color: #007bff;
            }

            .pagination li a:hover:not(.active) {
                background-color: #e9ecef;
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
                                <form id="addStreamForm" method="POST" action="add_stream.php"
                                    enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <input type="hidden" name="organizer_id" value="<?php echo $session_id; ?>">

                                        <div class="form-group">
                                            <label>Stream Title</label>
                                            <input type="text" class="form-control btn-block"
                                                style="height: 30px !important;" name="stream_title" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Channel Name</label>
                                            <input type="text" class="form-control btn-block"
                                                style="height: 30px !important;" name="channel_name" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Start Time</label>
                                            <input type="datetime-local" class="form-control btn-block"
                                                style="height: 30px !important;" name="start_time" required>
                                        </div>

                                        <div class="form-group">
                                            <label>End Time</label>
                                            <input type="datetime-local" class="form-control btn-block"
                                                style="height: 30px !important;" name="end_time" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Banner Image</label>
                                            <input type="file" class="form-control btn-block" name="stream_banner"
                                                accept="image/*" required>
                                            <small class="text-muted">Recommended size: 1280x720px. Max size:
                                                2MB</small>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Save Stream</button>
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <br> <br><br>
                <!-- Display events -->

            </div>

            <div class="table-controls">
            <div class="show-entries">
                <span>Show</span>
                <select onchange="changeEntriesPerPage(this.value)">
                    <option value="10" <?php echo $records_per_page == 10 ? 'selected' : ''; ?>>10</option>
                    <option value="25" <?php echo $records_per_page == 25 ? 'selected' : ''; ?>>25</option>
                    <option value="50" <?php echo $records_per_page == 50 ? 'selected' : ''; ?>>50</option>
                    <option value="100" <?php echo $records_per_page == 100 ? 'selected' : ''; ?>>100</option>
                </select>
                <span>entries</span>
            </div>
            <div class="search-box">
                <label>Search:</label>
                <input class="form-control btn-block" style="height: 30px !important;" type="text" id="searchInput" value="<?php echo htmlspecialchars($search); ?>" 
                       onkeyup="searchTable(this.value)">
            </div>
        </div>

            <div class="table-container">
        <table class="table-responsive">
            <thead>
                <tr>
                    <th>Stream Title</th>
                    <th>Channel Name</th>
                    <th>Stream Status</th>
                    <th>Start Time</th>
                    <th>Banner</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($streams as $stream): ?>
                <tr>
                    <td><?php echo htmlspecialchars($stream['stream_title']); ?></td>
                    <td><?php echo htmlspecialchars($stream['channel_name']); ?></td>
                    <td>
                        <span class="status-badge status-<?php echo strtolower($stream['stream_status']); ?>">
                            <?php echo ucfirst($stream['stream_status']); ?>
                        </span>
                    </td>
                    <td><?php echo date('m-d-Y H:i:s', strtotime($stream['start_time'])); ?></td>
                    <td>
                        <?php if (!empty($stream['image_url'])): ?>
                            <?php
                                $image_url = str_replace('../', '', $stream['image_url']);
                                $image_url = '/uploads/' . basename($image_url);
                            ?>
                            <img src="<?php echo htmlspecialchars($image_url); ?>" alt="Stream Banner">
                        <?php else: ?>
                            <span class="text-muted">No banner</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="stream/host.php?id=<?php echo $stream['stream_id']; ?>&token=<?php echo $stream['token']; ?>" class="btn btn-primary">View</a>
                        <button class="btn btn-danger delete-stream" data-id="<?php echo $stream['stream_id']; ?>">Delete</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="pagination-container">
            <div>
                Showing <?php echo ($offset + 1); ?> to <?php echo min($offset + $records_per_page, $total_records); ?> of <?php echo $total_records; ?> entries
            </div>
            <ul class="pagination">
                <?php if ($page > 1): ?>
                    <li><a href="?page=<?php echo ($page - 1); ?>&show=<?php echo $records_per_page; ?>&search=<?php echo urlencode($search); ?>">Previous</a></li>
                <?php endif; ?>
                
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="<?php echo $page == $i ? 'active' : ''; ?>">
                        <a href="?page=<?php echo $i; ?>&show=<?php echo $records_per_page; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
                
                <?php if ($page < $total_pages): ?>
                    <li><a href="?page=<?php echo ($page + 1); ?>&show=<?php echo $records_per_page; ?>&search=<?php echo urlencode($search); ?>">Next</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
        </section>

        <script>
    function changeEntriesPerPage(value) {
        window.location.href = '?show=' + value + '&search=<?php echo urlencode($search); ?>';
    }

    function searchTable(value) {
        // Add a small delay to prevent too many requests while typing
        clearTimeout(window.searchTimeout);
        window.searchTimeout = setTimeout(() => {
            window.location.href = '?search=' + encodeURIComponent(value) + '&show=<?php echo $records_per_page; ?>';
        }, 500);
    }
    </script>

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
        // Function to get today's date in DD-MM-YYYY format
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


        <!-- Add this to your existing JavaScript section -->
        <script>
        $(document).ready(function() {
            // Handle form submission
            $('#addStreamForm').on('submit', function(e) {
                e.preventDefault();

                // Create FormData object to handle file uploads
                var formData = new FormData(this);

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
                    data: formData,
                    dataType: 'json',
                    contentType: false, // Important for file uploads
                    processData: false, // Important for file uploads
                    success: function(response) {
                        Swal.close();

                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message ||
                                    'Stream added successfully',
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
                            text: 'Server error: ' + (xhr.responseText || error ||
                                'Unknown error occurred')
                        });
                    }
                });
            });
        });

        </script>
       <script>
$(document).ready(function() {
    $('.delete-stream').on('click', function() {
        var streamId = $(this).data('id');
        var $row = $(this).closest('tr');
        
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
                    url: 'live_stream.php',
                    type: 'POST',
                    data: {delete_stream: streamId},
                    dataType: 'json',
                    success: function(response) {
                        showSuccessAndReload('Deleted!', response.message);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX Error:', textStatus, errorThrown);
                        showSuccessAndReload('Success', 'Successfully Deleted!');
                    }
                });
            }
        });
    });

    function showSuccessAndReload(title, message) {
        Swal.fire({
            title: title,
            text: message,
            icon: 'success',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.reload();
            }
        });
    }
});
</script>
</body>

</html>