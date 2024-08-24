<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
include('fetch_data.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="dashboard.js"></script>
</head>
<body>
    <div class="container-fluid">
        <!-- Dashboard Cards -->
        <div class="row">
            <!-- Total Drivers Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Drivers</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $driver_count; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Trips Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Trips</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $trip_count; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-car fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Violations Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Violations</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $violation_count; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Unpaid Dues Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Unpaid Monthly Dues</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">₱<?php echo number_format($unpaid_dues, 2); ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphs -->
        <div class="row">
            <!-- Drivers by Status Chart -->
            <div class="col-xl-6 col-lg-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-white">Drivers by Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="driversByStatusChart"></canvas>
                            <div id="driversByStatusLabels" style="display: none;"><?php echo json_encode(array_keys($drivers_by_status)); ?></div>
                            <div id="driversByStatusData" style="display: none;"><?php echo json_encode(array_values($drivers_by_status)); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trips by Month Chart -->
            <div class="col-xl-6 col-lg-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-white">Trips by Month</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="tripsByMonthChart"></canvas>
                            <div id="tripsByMonthData" style="display: none;"><?php echo json_encode($trips_by_month); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Violations Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-white">Violations List</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Driver</th>
                                <th>Violation Type</th>
                                <th>Date</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $violations_query = "SELECT * FROM violations";
                            $violations_result = mysqli_query($connection, $violations_query);
                            while ($row = mysqli_fetch_assoc($violations_result)) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['driver_id'] . "</td>";
                                echo "<td>" . $row['violation_type'] . "</td>";
                                echo "<td>" . $row['violation_date'] . "</td>";
                                echo "<td>₱" . number_format($row['amount'], 2) . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>