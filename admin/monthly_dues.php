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
    .btn-add-dues {
        position: absolute;
        right: 20px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.9rem;
    }
    .card-body {
        padding: 2rem;
    }
    .card-title {
        font-size: 5.0rem;
        margin-bottom: 1rem;
        text-align: center;
    }
    .modal-header {
        background-color: #4e73df;
        color: white;
    }
    .custom-btn {
        background-color: #4e73df;
        color: white;
        border: none;
        border-radius: 0.25rem;
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }

    .custom-btn:hover {
        background-color: #2e59d9;
        color: white;
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
    }

    .custom-btn:focus {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
    }

    .custom-btn.delete-btn {
        background-color: #e74a3b;
    }

    .custom-btn.delete-btn:hover {
        background-color: #c82333;
    }

    .btn-container {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }
</style>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Add Monthly Dues Modal -->
    <div class="modal fade" id="addMonthlyDuesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Monthly Dues</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="monthly_dues_code.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Driver ID</label>
                            <input type="text" name="driver_id" class="form-control" placeholder="Enter Driver ID">
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Driver Name">
                        </div>
                        <div class="form-group">
                            <label>Month</label>
                            <input type="text" name="month" class="form-control" placeholder="Enter Month">
                        </div>
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" name="amount" class="form-control" placeholder="Enter Amount" step="0.01">
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="Pending">Pending</option>
                                <option value="Paid">Paid</option>
                                <option value="Overdue">Overdue</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="add_dues_btn" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Monthly Dues Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="">Monthly Dues</h6>
            <button type="button" class="btn btn-primary btn-add-dues" data-toggle="modal" data-target="#addMonthlyDuesModal">
                Add Monthly Dues
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
                $connection = mysqli_connect("localhost", "root", "", "adminpanel");

                $query = "SELECT * FROM monthly_dues";
                $query_run = mysqli_query($connection, $query);
                ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Driver ID</th>
                            <th>Name</th>
                            <th>Month</th>
                            <th>Amount</th>
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
                                    <td><?php echo $row["id"]; ?></td>
                                    <td><?php echo $row["driver_id"]; ?></td>
                                    <td><?php echo $row["name"]; ?></td>
                                    <td><?php echo $row["month"]; ?></td>
                                    <td><?php echo $row["amount"]; ?></td>
                                    <td>
                                        <form method="POST" action="monthly_dues_code.php">
                                            <input type="hidden" name="dues_id" value="<?php echo $row["id"]; ?>">
                                            <select name="status" class="form-control" onchange="this.form.submit()">
                                                <option value="Pending" <?php echo ($row["status"] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                                <option value="Paid" <?php echo ($row["status"] == 'Paid') ? 'selected' : ''; ?>>Paid</option>
                                                <option value="Overdue" <?php echo ($row["status"] == 'Overdue') ? 'selected' : ''; ?>>Overdue</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="btn-container">
                                            <form action="monthly_dues_code.php" method="post" style="display:inline;">
                                                <input type="hidden" name="delete_id" value="<?php echo $row["id"]; ?>">
                                                <button type="submit" name="delete_btn" class="custom-btn delete-btn btn-sm">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='7'>No Record Found</td></tr>";
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