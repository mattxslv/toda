<?php
session_start(); // Start the session

$connection = mysqli_connect("localhost", "root", "", "adminpanel");

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_POST['add_offense_btn'])) {
    $driver_name = $_POST['driver_name'];
    $offense_type = $_POST['offense_type'];
    $details = $_POST['details'];
    $fine = $_POST['fine'];

    // Calculate the offense count for the driver
    $offense_count_query = "SELECT COUNT(*) AS offense_count FROM drivers_offenses WHERE driver_name='$driver_name'";
    $offense_count_result = mysqli_query($connection, $offense_count_query);
    $offense_count_row = mysqli_fetch_assoc($offense_count_result);
    $offense_count = $offense_count_row['offense_count'] + 1;

    $query = "INSERT INTO drivers_offenses (driver_name, offense_type, details, fine, offense_count) VALUES ('$driver_name', '$offense_type', '$details', '$fine', '$offense_count')";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['success'] = "Offense added successfully";
    } else {
        $_SESSION['status'] = "Offense addition failed: " . mysqli_error($connection);
    }

    header("Location: customer_reports.php"); // Redirect to the page where you want to display the message
    exit(); // Ensure no further code is executed after the redirect
}
?>