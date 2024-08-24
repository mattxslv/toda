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
        } // Add this closing brace
    
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