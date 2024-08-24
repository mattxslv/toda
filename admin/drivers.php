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
    <title>Driver Management</title>
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
            font-size: 5.0rem;
            margin-bottom: 0.5rem;
            text-align: center; /* Center the heading text */
        }
        .modal-header {
            background-color: #4e73df;
            color: white;
        }
        .custom-btn {
            background-color: #4e73df; /* Primary color */
            color: white;
            border: none;
            border-radius: 0.25rem; /* Rounded corners */
            padding: 0.375rem 0.75rem; /* Padding for a nicer look */
            font-size: 0.875rem; /* Slightly smaller font size */
            cursor: pointer;
            transition: all 0.2s ease-in-out; /* Smooth transition for hover effects */
        }

        .custom-btn:hover {
            background-color: #2e59d9; /* Darker shade for hover effect */
            color: white;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); /* Subtle shadow */
        }

        .custom-btn:focus {
            outline: none;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25); /* Focus shadow */
        }

        .custom-btn.edit-btn {
            background-color: #1cc88a; /* Green color for Edit */
        }

        .custom-btn.edit-btn:hover {
            background-color: #17a673; /* Darker green for hover */
        }

        .custom-btn.delete-btn {
            background-color: #e74a3b; /* Red color for Delete */
        }

        .custom-btn.delete-btn:hover {
            background-color: #c82333; /* Darker red for hover */
        }
        .btn-group {
            display: flex;
            gap: 0.5rem; /* Space between buttons */
        }
    </style>
</head>

<body>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6><strong>Driver Management</strong></h6>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDriverModal">
                    Add Driver
                </button>
            </div>

            <div class="card-body">
                <?php
                if (isset($_SESSION['success']) && $_SESSION['success'] != '') {
                    echo '<div class="alert alert-success">' . $_SESSION['success'] . '</div>';
                    unset($_SESSION['success']);
                }

                if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
                    echo '<div class="alert alert-danger"> ' . $_SESSION['status'] . ' </div>';
                    unset($_SESSION['status']);
                }
                ?>

                <div class="table-responsive">
                    <?php
                    $query = "SELECT * FROM drivers";
                    $query_run = mysqli_query($connection, $query);
                    ?>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Full Name</th>
                                <th>License Number</th>
                                <th>Date of Birth</th>
                                <th>Address</th>
                                <th>Tricycle ID</th>
                                <th>Make and Model</th>
                                <th>Year of Manufacture</th>
                                <th>Color of Vehicle</th>
                                <th>Ownership Status</th>
                                <th>License Copy</th>
                                <th>Registration Documents</th>
                                <th>Insurance Documents</th>
                                <th>Actions</th> <!-- Single column for actions -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($query_run) > 0) {
                                while ($row = mysqli_fetch_assoc($query_run)) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row["full_name"]); ?></td>
                                        <td><?php echo htmlspecialchars($row["license_number"]); ?></td>
                                        <td><?php echo htmlspecialchars($row["date_of_birth"]); ?></td>
                                        <td><?php echo htmlspecialchars($row["address"]); ?></td>
                                        <td><?php echo htmlspecialchars($row["tricycle_id"]); ?></td>
                                        <td><?php echo htmlspecialchars($row["make_and_model"]); ?></td>
                                        <td><?php echo htmlspecialchars($row["year_of_manufacture"]); ?></td>
                                        <td><?php echo htmlspecialchars($row["color_of_vehicle"]); ?></td>
                                        <td><?php echo htmlspecialchars($row["ownership_status"]); ?></td>
                                        <td>
                                            <?php if (!empty($row["license_copy"])): ?>
                                                <a href="uploads/<?php echo htmlspecialchars($row["license_copy"]); ?>" target="_blank">View License Copy</a>
                                            <?php else: ?>
                                                Not Available
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($row["registration_documents"])): ?>
                                                <a href="uploads/<?php echo htmlspecialchars($row["registration_documents"]); ?>" target="_blank">View Registration Documents</a>
                                            <?php else: ?>
                                                Not Available
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($row["insurance_documents"])): ?>
                                                <a href="uploads/<?php echo htmlspecialchars($row["insurance_documents"]); ?>" target="_blank">View Insurance Documents</a>
                                            <?php else: ?>
                                                Not Available
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <form action="driver_edit.php" method="post">
                                                    <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($row["id"]); ?>">
                                                    <button type="submit" name="edit_btn" class="custom-btn edit-btn btn-sm">Edit</button>
                                                </form>
                                                <form action="driver_code.php" method="post">
                                                    <input type="hidden" name="delete_id" value="<?php echo htmlspecialchars($row["id"]); ?>">
                                                    <button type="submit" name="delete_btn" class="custom-btn delete-btn btn-sm">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='13' class='no-record'>No Record Found</td></tr>"; // Adjust colspan to match number of columns
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Driver Modal -->
        <div class="modal fade" id="addDriverModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Driver</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="driver_code.php" method="POST" enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" name="full_name" class="form-control" placeholder="Enter Full Name" required>
                            </div>
                            <div class="form-group">
                                <label>Driver’s License Number</label>
                                <input type="text" name="license_number" class="form-control" placeholder="Enter License Number" required>
                            </div>
                            <div class="form-group">
                                <label>Date of Birth</label>
                                <input type="date" name="date_of_birth" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control" placeholder="Enter Address" required>
                            </div>
                            <div class="form-group">
                                <label>Tricycle ID/Registration Number</label>
                                <input type="text" name="tricycle_id" class="form-control" placeholder="Enter Tricycle ID/Registration Number" required>
                            </div>
                            <div class="form-group">
                                <label>Make and Model</label>
                                <input type="text" name="make_and_model" class="form-control" placeholder="Enter Make and Model" required>
                            </div>
                            <div class="form-group">
                                <label>Year of Manufacture</label>
                                <input type="number" name="year_of_manufacture" class="form-control" placeholder="Enter Year of Manufacture" required>
                            </div>
                            <div class="form-group">
                                <label>Color of Vehicle</label>
                                <input type="text" name="color_of_vehicle" class="form-control" placeholder="Enter Color of Vehicle" required>
                            </div>
                            <div class="form-group">
                                <label>Ownership Status</label>
                                <select name="ownership_status" class="form-control" required>
                                    <option value="Owned">Owned</option>
                                    <option value="Operator">Operator</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Driver’s License Copy</label>
                                <input type="file" name="license_copy" class="form-control-file">
                            </div>
                            <div class="form-group">
                                <label>Tricycle Registration Documents</label>
                                <input type="file" name="registration_documents" class="form-control-file">
                            </div>
                            <div class="form-group">
                                <label>Insurance Documents</label>
                                <input type="file" name="insurance_documents" class="form-control-file">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="add_driver_btn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- End of Main Content -->

    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/demo/datatables-demo.js"></script>
</body>

</html>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>