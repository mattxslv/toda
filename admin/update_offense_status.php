<?php
session_start(); // Start the session

$connection = mysqli_connect("localhost", "root", "", "adminpanel");

if (isset($_POST['offense_id'])) {
    $offense_id = $_POST['offense_id'];

    if (isset($_POST['status'])) {
        $status = $_POST['status'];
        $query = "UPDATE drivers_offenses SET status='$status' WHERE id='$offense_id'";
    } elseif (isset($_POST['offense_type'])) {
        $offense_type = $_POST['offense_type'];
        $query = "UPDATE drivers_offenses SET offense_type='$offense_type' WHERE id='$offense_id'";
    }

    if (isset($query)) {
        $query_run = mysqli_query($connection, $query);

        if ($query_run) {
            $_SESSION['success'] = "Update successful";
        } else {
            $_SESSION['status'] = "Update failed";
        }
    }

    header("Location: " . $_SERVER['HTTP_REFERER']); // Redirect back to the same page
    exit(); // Ensure no further code is executed after the redirect
}

?>