<?php
include('header2.php');

$events = array();
$query = "SELECT id, title, start_date, end_date FROM upcoming_events";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['id'];
    $title = $row['title'];
    $start = $row['start_date'];
    $end = $row['end_date'];
    $events[] = array(
        'id' => $id,
        'title' => $title,
        'start' => $start,
        'end' => $end
    );
}
echo json_encode($events);
mysqli_close($conn);
?>