<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
?>
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
        position: relative;
    }
    .card-header h6 {
        font-weight: bold;
        margin: 0;
        color: white;
    }
    .card-body {
        padding: 2rem;
    }
    .card-title {
        font-size: 1.5rem;
        margin-bottom: 1rem;
        text-align: center;
    }
</style>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- App Revenue Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6>App Revenue</h6>
            </div>
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
                $connection = mysqli_connect("localhost", "root", "", "adminpanel");

                $query = "SELECT * FROM app_revenue";
                $query_run = mysqli_query($connection, $query);

                if ($query_run === false) {
                    // Log or display the error message
                    echo "Error: " . mysqli_error($connection);
                } else {
                ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Date</th>
                            <th>Revenue</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($query_run) > 0) {
                            while ($row = mysqli_fetch_assoc($query_run)) {
                        ?>
                                <tr>
                                    <td><?php echo $row["id"]; ?></td>
                                    <td><?php echo $row["date"]; ?></td>
                                    <td><?php echo $row["revenue"]; ?></td>
                                    <td><?php echo $row["description"]; ?></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='4' class='no-record'>No Record Found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

</div>
<!-- End of Main Content -->

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>