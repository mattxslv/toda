<?php
session_start();
include('dbconfig.php');

if (isset($_POST['delete_btn'])) {
    $id = mysqli_real_escape_string($connection, $_POST['delete_id']);

    $query = "DELETE FROM trips WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['success'] = "Trip deleted successfully";
    } else {
        $_SESSION['status'] = "Trip deletion failed: " . mysqli_error($connection);
    }

    header("Location: manage_trips.php");
    exit();
}
?>