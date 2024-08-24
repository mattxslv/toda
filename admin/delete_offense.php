<?php
session_start(); // Start the session

$connection = mysqli_connect("localhost", "root", "", "adminpanel");

if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    $query = "DELETE FROM drivers_offenses WHERE id='$delete_id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['success'] = "Offense deleted successfully";
    } else {
        $_SESSION['status'] = "Offense deletion failed";
    }

    header("Location: customer_reports.php"); // Redirect to the page where you want to display the message
    exit(); // Ensure no further code is executed after the redirect
}
?>