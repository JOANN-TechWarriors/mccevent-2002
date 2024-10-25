<!DOCTYPE html>
<html>
<head>
<style>
/* Table Container */
.table-responsive {
    overflow-x: auto;
    margin: 20px 0;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    background: white;
}

/* Table Styles */
.custom-table {
    width: 100%;
    border-collapse: collapse;
    background-color: white;
    font-size: 14px;
}

.custom-table thead {
    background-color: #f8f9fa;
}

.custom-table th {
    padding: 15px;
    text-align: left;
    font-weight: 600;
    color: #2c3e50;
    border-bottom: 2px solid #e9ecef;
    white-space: nowrap;
}

.custom-table td {
    padding: 12px 15px;
    vertical-align: middle;
    border-bottom: 1px solid #e9ecef;
}

.custom-table tbody tr:hover {
    background-color: #f8f9fa;
    transition: background-color 0.2s ease;
}

/* Image in table */
.custom-table img {
    max-width: 100px;
    height: auto;
    border-radius: 4px;
    object-fit: cover;
}

/* Status styles */
.status-badge {
    padding: 6px 12px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 500;
    text-transform: capitalize;
    display: inline-block;
}

.status-scheduled {
    background-color: #e3f2fd;
    color: #1976d2;
}

.status-live {
    background-color: #e8f5e9;
    color: #2e7d32;
}

/* Button styles */
.btn-group {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.table-btn {
    padding: 6px 12px;
    border-radius: 4px;
    font-size: 13px;
    font-weight: 500;
    text-decoration: none;
    cursor: pointer;
    border: none;
    transition: all 0.2s ease;
}

.btn-view {
    background-color: #3498db;
    color: white;
}

.btn-view:hover {
    background-color: #2980b9;
}

.btn-delete {
    background-color: #e74c3c;
    color: white;
}

.btn-delete:hover {
    background-color: #c0392b;
}

/* Responsive Design */
@media screen and (max-width: 768px) {
    .custom-table {
        display: block;
    }
    
    .custom-table thead {
        display: none;
    }
    
    .custom-table tbody {
        display: block;
    }
    
    .custom-table tr {
        display: block;
        margin-bottom: 15px;
        border: 1px solid #e9ecef;
        border-radius: 4px;
    }
    
    .custom-table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 15px;
        text-align: right;
        border-bottom: 1px solid #e9ecef;
    }
    
    .custom-table td::before {
        content: attr(data-label);
        font-weight: 600;
        margin-right: 15px;
        text-align: left;
        min-width: 120px;
    }
    
    .custom-table td:last-child {
        border-bottom: none;
    }
    
    .btn-group {
        justify-content: flex-end;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .custom-table {
        background-color: #1a1a1a;
        color: #e0e0e0;
    }
    
    .custom-table thead {
        background-color: #2d2d2d;
    }
    
    .custom-table th {
        color: #ffffff;
        border-bottom-color: #3d3d3d;
    }
    
    .custom-table td {
        border-bottom-color: #3d3d3d;
    }
    
    .custom-table tbody tr:hover {
        background-color: #2d2d2d;
    }
}
</style>
</head>
<body>
<!-- Replace your existing table with this structure -->
<div class="table-responsive">
    <table class="custom-table">
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
                <td data-label="Stream Title"><?php echo htmlspecialchars($stream['stream_title']); ?></td>
                <td data-label="Channel Name"><?php echo htmlspecialchars($stream['channel_name']); ?></td>
                <td data-label="Stream Status">
                    <span class="status-badge status-<?php echo strtolower($stream['stream_status']); ?>">
                        <?php echo ucfirst($stream['stream_status']); ?>
                    </span>
                </td>
                <td data-label="Start Time"><?php echo date('m-d-Y H:i:s', strtotime($stream['start_time'])); ?></td>
                <td data-label="Banner">
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
                <td data-label="Actions">
                    <div class="btn-group">
                        <a href="stream/host.php?id=<?php echo $stream['stream_id']; ?>&token=<?php echo $stream['token']; ?>" 
                           class="table-btn btn-view">View</a>
                        <button class="table-btn btn-delete delete-stream" 
                                data-id="<?php echo $stream['stream_id']; ?>">Delete</button>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>