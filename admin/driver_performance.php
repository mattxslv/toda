<?php
include('includes/header.php');
include('includes/navbar.php');
include 'dbconfig.php';

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$query = "SELECT drivers.id, drivers.full_name, AVG(driver_ratings.rating) as average_rating, COUNT(driver_ratings.rating) as total_reviews 
          FROM drivers 
          LEFT JOIN driver_ratings ON drivers.id = driver_ratings.driver_id 
          GROUP BY drivers.id";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Performance and Ratings</title>
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
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h1 class="card-title">Driver Performance and Ratings</h1>
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
                    <table class="table table-striped table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Driver Name</th>
                                <th>Average Rating</th>
                                <th>Total Reviews</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                        <td><?php echo number_format($row['average_rating'], 2); ?></td>
                                        <td><?php echo htmlspecialchars($row['total_reviews']); ?></td>
                                        <td><a href="view_reviews.php?driver_id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-info btn-sm">View Reviews</a></td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='4' class='no-record'>No Record Found</td></tr>";
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
</body>
</html>
