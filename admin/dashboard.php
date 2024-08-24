<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
?>
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fc;
            color: #4e73df;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            background-color: #fff;
        }
        .card:hover {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }
        .card-header {
            background-color: #4e73df;
            color: white;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem;
        }
        .card-body {
            padding: 1.5rem;
            font-size: 1.1rem;
        }
        .card-title {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        .chart-container {
            position: relative;
            height: 40vh;
            width: 100%;
        }
        .table thead th {
            background-color: #4e73df;
            color: white;
            text-align: center;
        }
        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .btn {
            border-radius: 20px;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
        }
        .text-gray-800 {
            color: #343a40;
        }
    </style>
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
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Trips</div>
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
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Unpaid Dues</div>
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
                    <h6 class="m-0 font-weight-bold" style="color: white; font-weight: bold;">Drivers by Status</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="driversByStatusChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            

            <!-- Trips by Month Chart -->
            <div class="col-xl-6 col-lg-12 mb-4">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold" style="color: white; font-weight: bold;">Trips by Month</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="tripsByMonthChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Violations Table -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold" style="color: white; font-weight: bold;">Violations List</h6>

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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Drivers by Status Chart
        var ctx = document.getElementById('driversByStatusChart').getContext('2d');
        var driversByStatusChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_keys($drivers_by_status)); ?>,
                datasets: [{
                    label: 'Drivers by Status',
                    data: <?php echo json_encode(array_values($drivers_by_status)); ?>,
                    backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (context.parsed !== null) {
                                    label += ': ' + context.parsed + ' drivers';
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });

        // Trips by Month Chart
        var ctx2 = document.getElementById('tripsByMonthChart').getContext('2d');
        var tripsByMonthChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Trips by Month',
                    data: <?php echo json_encode($trips_by_month); ?>,
                    backgroundColor: '#4e73df',
                    borderColor: '#4e73df',
                    borderWidth: 1,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (context.parsed !== null) {
                                    label += ': ' + context.parsed + ' trips';
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#e3e6f0'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
