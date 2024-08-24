<?php
include('dbconfig.php');

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_POST['update_btn'])) {
    $id = mysqli_real_escape_string($connection, $_POST['edit_id']);
    $pickup_location = mysqli_real_escape_string($connection, $_POST['pickup_location']);
    $dropoff_location = mysqli_real_escape_string($connection, $_POST['dropoff_location']);
    $trip_date = mysqli_real_escape_string($connection, $_POST['trip_date']);
    $fare = mysqli_real_escape_string($connection, $_POST['fare']);
    $status = mysqli_real_escape_string($connection, $_POST['status']);

    $query = "UPDATE trips SET pickup_location='$pickup_location', dropoff_location='$dropoff_location', trip_date='$trip_date', fare='$fare', status='$status' WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['success'] = "Trip updated successfully";
    } else {
        $_SESSION['status'] = "Trip update failed: " . mysqli_error($connection);
    }

    header("Location: manage_trips.php");
    exit();
}
?>

<?php
include('includes/header.php');
include('includes/navbar.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Trips</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
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
            font-size: 1.5rem;
            margin-bottom: 1rem;
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
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h1 class="card-title">Manage Trips</h1>
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
                    $query = "SELECT trips.*, drivers.full_name FROM trips 
                              INNER JOIN drivers ON trips.driver_id = drivers.id";
                    $query_run = mysqli_query($connection, $query);
                    ?>
                    <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Driver</th>
                                <th>Pickup Location</th>
                                <th>Dropoff Location</th>
                                <th>Trip Date</th>
                                <th>Fare</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($query_run) > 0) {
                                while ($row = mysqli_fetch_assoc($query_run)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['full_name']; ?></td>
                                        <td><?php echo $row['pickup_location']; ?></td>
                                        <td><?php echo $row['dropoff_location']; ?></td>
                                        <td><?php echo date('d-m-Y H:i:s', strtotime($row['trip_date'])); ?></td>
                                        <td><?php echo $row['fare']; ?></td>
                                        <td><?php echo $row['status']; ?></td>
                                        <td>
                                            <form action="edit_trip.php" method="POST" style="display:inline;">
                                                <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="edit_btn" class="custom-btn edit-btn btn-sm">Edit</button>
                                            </form>
                                            <form action="delete_trip.php" method="POST" style="display:inline;">
                                                <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                                <button type="submit" name="delete_btn" class="custom-btn delete-btn btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='8' class='no-record'>No Record Found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php
    include('includes/scripts.php');
    include('includes/footer.php');
    ?>

    <!-- JavaScript to populate modal with existing data -->
    <script>
        $(document).ready(function() {
            $('.edit-btn').on('click', function() {
                $('#editModal').modal('show');

                var tr = $(this).closest('tr');
                var data = tr.children("td").map(function() {
                    return $(this).text();
                }).get();

                $('#edit_id').val(data[0]);
                $('#pickup_location').val(data[2]);
                $('#dropoff_location').val(data[3]);
                $('#trip_date').val(data[4]);
                $('#fare').val(data[5]);
                $('#status').val(data[6]);
            });
        });
    </script>
</body>
</html>