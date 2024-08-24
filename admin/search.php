<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="container-fluid">
    <h2 class="mt-4">Search Results</h2>

    <style>
    body {
        font-family: Arial, sans-serif;
    }

    .container-fluid {
        margin-top: 20px;
    }

    /* Table styles */
    .table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        font-size: 0.9em;
        color: #333;
    }

    .table thead {
        background-color: #4e73df; /* Blue background for header */
        color: #fff; /* White text color */
    }

    .table th, .table td {
        padding: 10px 15px;
        text-align: center; /* Center text */
        border: 1px solid #ddd;
    }

    .table tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .table tbody tr:hover {
        background-color: #e0e0e0;
    }

    /* Alert styles */
    .alert {
        padding: 15px;
        border-radius: 4px;
        margin-top: 20px;
        text-align: center;
    }

    .alert-info {
        background-color: #d9edf7; /* Light blue */
        color: #31708f; /* Darker blue */
    }

    .alert-danger {
        background-color: #f2dede; /* Light red */
        color: #a94442; /* Darker red */
    }
    </style>

    <?php
    $connection = mysqli_connect("localhost", "root", "", "adminpanel");

    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $search_term = isset($_POST['search_term']) ? mysqli_real_escape_string($connection, $_POST['search_term']) : '';
    $date_search_term = date('Y-m-d', strtotime($search_term)); // Convert to date format if needed

    // Query for drivers
    $query_drivers = "
        SELECT 'Driver' AS source, 
               id, 
               full_name AS name, 
               license_number, 
               address, 
               date_of_birth, 
               year_of_manufacture, 
               ownership_status,
               make_and_model,
               color_of_vehicle,
               NULL AS violation_type, 
               NULL AS violation_date, 
               NULL AS description, 
               NULL AS amount, 
               NULL AS month, 
               NULL AS status
        FROM drivers
        WHERE (id LIKE '%$search_term%' 
           OR full_name LIKE '%$search_term%' 
           OR license_number LIKE '%$search_term%' 
           OR address LIKE '%$search_term%' 
           OR date_of_birth LIKE '%$date_search_term%' 
           OR year_of_manufacture LIKE '%$search_term%'
           OR ownership_status LIKE '%$search_term%'
           OR make_and_model LIKE '%$search_term%'
           OR color_of_vehicle LIKE '%$search_term%')";

    // Query for violations
    $query_violations = "
        SELECT 'Violation' AS source, 
               v.id, 
               d.full_name AS name, 
               NULL AS license_number, 
               NULL AS address, 
               NULL AS date_of_birth, 
               NULL AS year_of_manufacture, 
               NULL AS ownership_status, 
               NULL AS make_and_model,
               NULL AS color_of_vehicle,
               v.violation_type, 
               v.violation_date, 
               v.description, 
               v.amount, 
               NULL AS month, 
               v.fee_status AS status
        FROM violations v
        JOIN drivers d ON v.driver_id = d.id
        WHERE (v.driver_id LIKE '%$search_term%' 
           OR v.violation_type LIKE '%$search_term%' 
           OR v.description LIKE '%$search_term%'
           OR v.violation_date LIKE '%$date_search_term%' 
           OR v.amount LIKE '%$search_term%')";

    // Query for monthly dues
    $query_dues = "
        SELECT 'Monthly Dues' AS source, 
               id, 
               name, 
               NULL AS license_number, 
               NULL AS address, 
               NULL AS date_of_birth, 
               NULL AS year_of_manufacture, 
               NULL AS ownership_status, 
               NULL AS make_and_model,
               NULL AS color_of_vehicle,
               NULL AS violation_type, 
               NULL AS violation_date, 
               NULL AS description, 
               amount, 
               month, 
               status
        FROM monthly_dues
        WHERE (id LIKE '%$search_term%'
           OR name LIKE '%$search_term%' 
           OR month LIKE '%$search_term%' 
           OR status LIKE '%$search_term%')";

    $combined_query = $query_drivers . " UNION ALL " . $query_violations . " UNION ALL " . $query_dues;

    $result = mysqli_query($connection, $combined_query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo '<div class="table-responsive mt-3">';
            echo '<table class="table table-bordered">';
            echo '<thead><tr><th>Source</th><th>ID</th><th>Driver ID</th><th>Name</th><th>License Number</th><th>Address</th><th>Date of Birth</th><th>Year of Manufacture</th><th>Ownership Status</th><th>Make and Model</th><th>Color of Vehicle</th><th>Violation Type</th><th>Violation Date</th><th>Description</th><th>Amount</th><th>Month</th><th>Status</th></tr></thead>';
            echo '<tbody>';
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['source']) . '</td>';
                echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                echo '<td>' . (isset($row['driver_id']) ? htmlspecialchars($row['driver_id']) : '') . '</td>';
                echo '<td>' . (isset($row['name']) ? htmlspecialchars($row['name']) : '') . '</td>';
                echo '<td>' . (isset($row['license_number']) ? htmlspecialchars($row['license_number']) : '') . '</td>';
                echo '<td>' . (isset($row['address']) ? htmlspecialchars($row['address']) : '') . '</td>';
                echo '<td>' . (isset($row['date_of_birth']) ? htmlspecialchars($row['date_of_birth']) : '') . '</td>';
                echo '<td>' . (isset($row['year_of_manufacture']) ? htmlspecialchars($row['year_of_manufacture']) : '') . '</td>';
                echo '<td>' . (isset($row['ownership_status']) ? htmlspecialchars($row['ownership_status']) : '') . '</td>';
                echo '<td>' . (isset($row['make_and_model']) ? htmlspecialchars($row['make_and_model']) : '') . '</td>';
                echo '<td>' . (isset($row['color_of_vehicle']) ? htmlspecialchars($row['color_of_vehicle']) : '') . '</td>';
                echo '<td>' . (isset($row['violation_type']) ? htmlspecialchars($row['violation_type']) : '') . '</td>';
                echo '<td>' . (isset($row['violation_date']) ? htmlspecialchars($row['violation_date']) : '') . '</td>';
                echo '<td>' . (isset($row['description']) ? htmlspecialchars($row['description']) : '') . '</td>';
                echo '<td>' . (isset($row['amount']) ? htmlspecialchars($row['amount']) : '') . '</td>';
                echo '<td>' . (isset($row['month']) ? htmlspecialchars($row['month']) : '') . '</td>';
                echo '<td>' . (isset($row['status']) ? htmlspecialchars($row['status']) : '') . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        } else {
            echo '<div class="alert alert-info mt-3">No relevant records found.</div>';
        }
    } else {
        echo '<div class="alert alert-danger mt-3">Error: ' . mysqli_error($connection) . '</div>';
    }

    mysqli_close($connection);
    ?>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
