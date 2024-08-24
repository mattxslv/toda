<?php
include('includes/dbconfig.php');

// Fetch counts for summary cards
$driver_count_query = "SELECT COUNT(*) AS total FROM drivers";
$driver_count_result = mysqli_query($connection, $driver_count_query);
$driver_count = mysqli_fetch_assoc($driver_count_result)['total'];

$trip_count_query = "SELECT COUNT(*) AS total FROM trips";
$trip_count_result = mysqli_query($connection, $trip_count_query);
$trip_count = mysqli_fetch_assoc($trip_count_result)['total'];

$violation_count_query = "SELECT COUNT(*) AS total FROM violations";
$violation_count_result = mysqli_query($connection, $violation_count_query);
$violation_count = mysqli_fetch_assoc($violation_count_result)['total'];

$unpaid_dues_query = "SELECT SUM(amount) AS total FROM monthly_dues WHERE status = 'Unpaid'";
$unpaid_dues_result = mysqli_query($connection, $unpaid_dues_query);
$unpaid_dues = mysqli_fetch_assoc($unpaid_dues_result)['total'];

// Fetch data for charts
$drivers_by_status_query = "SELECT ownership_status, COUNT(*) AS count FROM drivers GROUP BY ownership_status";
$drivers_by_status_result = mysqli_query($connection, $drivers_by_status_query);
$drivers_by_status = [];
while ($row = mysqli_fetch_assoc($drivers_by_status_result)) {
    $drivers_by_status[$row['ownership_status']] = $row['count'];
}

$trips_by_month_query = "SELECT MONTH(trip_date) AS month, COUNT(*) AS count FROM trips GROUP BY MONTH(trip_date)";
$trips_by_month_result = mysqli_query($connection, $trips_by_month_query);
$trips_by_month = array_fill(0, 12, 0);
while ($row = mysqli_fetch_assoc($trips_by_month_result)) {
    $trips_by_month[$row['month'] - 1] = $row['count'];
}

$violations_by_type_query = "SELECT violation_type, COUNT(*) AS count FROM violations GROUP BY violation_type";
$violations_by_type_result = mysqli_query($connection, $violations_by_type_query);
$violations_by_type = [];
while ($row = mysqli_fetch_assoc($violations_by_type_result)) {
    $violations_by_type[$row['violation_type']] = $row['count'];
}
?>