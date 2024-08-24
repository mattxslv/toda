<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "adminpanel");

// Handle delete report
if (isset($_POST['delete_btn'])) {
    $id = $_POST['delete_id'];

    $query = "DELETE FROM customer_reports WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['success'] = "Report Deleted Successfully";
        header("Location: customer_reports.php");
    } else {
        $_SESSION['status'] = "Report Deletion Failed";
        header("Location: customer_reports.php");
    }
}

// Handle add offense
if (isset($_POST['add_offense_btn'])) {
    $driver_name = $_POST['driver_name'];
    $offense_type = $_POST['offense_type'];
    $details = $_POST['details'];
    $fine = $_POST['fine'];

    $query = "INSERT INTO drivers_offenses (driver_name, offense_type, details, fine) VALUES ('$driver_name', '$offense_type', '$details', '$fine')";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['success'] = "Offense Added Successfully";
        header('Location: customer_reports.php');
    } else {
        $_SESSION['status'] = "Offense Not Added";
        header('Location: customer_reports.php');
    }
}
?>