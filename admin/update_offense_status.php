<?php
session_start(); // Start the session

// Establish the database connection
$connection = mysqli_connect("localhost", "root", "", "adminpanel");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the POST request contains the 'offense_id'
if (isset($_POST['offense_id'])) {
    $offense_id = $_POST['offense_id'];
    $offense_count = $_POST['offense_count'] ?? null;
    $offense_type = $_POST['offense_type'] ?? null;
    $status = $_POST['status'] ?? null;

    // Debugging: Log received data
    error_log("Received data: offense_id=$offense_id, offense_count=$offense_count, offense_type=$offense_type, status=$status");

    // Prepare and execute the queries
    $queries = [
        'offense_count' => "UPDATE drivers_offenses SET offense_count=? WHERE id=?",
        'offense_type' => "UPDATE drivers_offenses SET offense_type=? WHERE id=?",
        'status' => "UPDATE drivers_offenses SET status=? WHERE id=?"
    ];

    foreach ($queries as $field => $query) {
        if (isset($$field)) {
            $stmt = mysqli_prepare($connection, $query);
            if ($stmt === false) {
                die("MySQL prepare statement error: " . mysqli_error($connection));
            }
            // Bind parameters as strings
            mysqli_stmt_bind_param($stmt, 'si', $$field, $offense_id);
            $query_run = mysqli_stmt_execute($stmt);

            // Debugging: Log the query and its parameters
            error_log("Executing query: $query with parameters: " . $$field . ", $offense_id");

            if ($query_run) {
                $_SESSION['success'] = ucfirst($field) . " updated successfully";
                // Debugging: Log success message
                error_log(ucfirst($field) . " updated successfully");
            } else {
                $_SESSION['status'] = "Update failed: " . mysqli_stmt_error($stmt);
                // Debugging: Log the error
                error_log("Update failed: " . mysqli_stmt_error($stmt));
            }
            mysqli_stmt_close($stmt);
        }
    }

    // Verify the update
    $verify_query = "SELECT offense_count FROM drivers_offenses WHERE id=?";
    $stmt = mysqli_prepare($connection, $verify_query);
    mysqli_stmt_bind_param($stmt, 'i', $offense_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $updated_offense_count);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Debugging: Log the updated offense count
    error_log("Updated offense count for ID $offense_id: $updated_offense_count");

    header("Location: customer_reports.php");
    exit(); // Ensure no further code is executed
}

mysqli_close($connection); // Close the database connection
?>