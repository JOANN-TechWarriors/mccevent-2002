<?php
include('header2.php');

isset($_POST['title']) && isset($_POST['start']) && isset($_POST['end']){
    $id = $_POST['id'];
        $title = $_POST['title'];
        $start = $_POST['start'];
        $end = $_POST['end'];
        $query = "UPDATE upcoming_events SET title = '$title', start_date = '$start', end_date = '$end' WHERE id = $id";
        mysqli_query($conn, $query);
        mysqli_close($conn);
header('Location: index.php');
}
?>