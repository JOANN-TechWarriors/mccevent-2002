<?php
  include('header2.php');

if (isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end'])) {
    $title = $_POST['title'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $query = "INSERT INTO upcoming_events (title, start_date, end_date) VALUES ('$title', '$start', '$end')";
    mysqli_query($conn, $query);
    mysqli_close($conn);
    header('Location: index.php');
}
?>