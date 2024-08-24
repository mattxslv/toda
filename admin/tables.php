<?php

include('includes/header.php'); 
include('includes/navbar.php'); 
include('dbconfig.php'); // Ensure this file contains $connection setup

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Registered Drivers</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        .table th, .table td {
            text-align: center;
        }
        .table thead th {
            background-color: #4e73df;
            color: white;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f8f9fc;
        }
        .table tbody tr:hover {
            background-color: #e2e6ea;
        }
        .no-record {
            text-align: center;
            font-size: 1.2rem;
            color: #6c757d;
        }
        .card-header {
            background-color: #4e73df;
            color: white;
        }
        .card-body {
            padding: 2rem;
        }
        .card-title {
            font-size: 1.0rem;
            margin-bottom: 1rem;
            text-align: left; /* Left-align the heading text */
            font-weight: bold; /* Make the text bold */
        }
    </style>
</head>

<body>

    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h1 class="card-title">Registered Drivers</h1>
            </div>
            <div class="card-body">
                <?php
                if (isset($_SESSION['success']) && $_SESSION['success'] != '') {
                    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                    unset($_SESSION['success']);
                }

                if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
                    echo '<div class="alert alert-danger">' . $_SESSION['status'] . '</div>';
                    unset($_SESSION['status']);
                }
                ?>

                <div class="table-responsive">
                    <?php
                    $query = "SELECT * FROM drivers";
                    $query_run = mysqli_query($connection, $query);
                    ?>
                    <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>License Number</th>
                                <th>Date of Birth</th>
                                <th>Address</th>
                                <th>Tricycle ID</th>
                                <th>Ownership Status</th>
                                <th>License Copy</th>
                                <th>Registration Documents</th>
                                <th>Insurance Documents</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($query_run) > 0) {
                                while ($row = mysqli_fetch_assoc($query_run)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row["full_name"]; ?></td>
                                        <td><?php echo $row["license_number"]; ?></td>
                                        <td><?php echo $row["date_of_birth"]; ?></td>
                                        <td><?php echo $row["address"]; ?></td>
                                        <td><?php echo $row["tricycle_id"]; ?></td>
                                        <td><?php echo $row["ownership_status"]; ?></td>
                                        <td>
                                            <?php if (!empty($row["license_copy"])): ?>
                                                <a href="uploads/<?php echo $row["license_copy"]; ?>" target="_blank">View License Copy</a>
                                            <?php else: ?>
                                                Not Available
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($row["registration_documents"])): ?>
                                                <a href="uploads/<?php echo $row["registration_documents"]; ?>" target="_blank">View Registration Documents</a>
                                            <?php else: ?>
                                                Not Available
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($row["insurance_documents"])): ?>
                                                <a href="uploads/<?php echo $row["insurance_documents"]; ?>" target="_blank">View Insurance Documents</a>
                                            <?php else: ?>
                                                Not Available
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='9' class='no-record'>No Record Found</td></tr>"; // Adjust colspan to match number of columns
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- End of Main Content -->

    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>

</body>

</html>
