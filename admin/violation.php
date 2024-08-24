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
    .btn-add-violation {
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
        font-size: 1.5rem;
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

    .custom-btn.edit-btn {
        background-color: #1cc88a;
    }

    .custom-btn.edit-btn:hover {
        background-color: #17a673;
    }

    .custom-btn.delete-btn {
        background-color: #e74a3b;
    }

    .custom-btn.delete-btn:hover {
        background-color: #c82333;
    }

    .action-btns {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }
</style>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Add Violation Modal -->
    <div class="modal fade" id="addViolationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Violation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="violation_code.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Driver ID</label>
                            <input type="text" name="driver_id" class="form-control" placeholder="Enter Driver ID">
                        </div>
                        <div class="form-group">
                            <label>Driver Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Driver Name">
                        </div>
                        <div class="form-group">
                            <label>Violation Type</label>
                            <input type="text" name="violation_type" class="form-control" placeholder="Enter Violation Type">
                        </div>
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" name="violation_date" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="number" name="amount" class="form-control" placeholder="Enter Amount" step="0.01">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Enter Description"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Fee Status</label>
                            <select name="fee_status" class="form-control">
                                <option value="Paid">Paid</option>
                                <option value="Unpaid">Unpaid</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="add_violation_btn" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Violations Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6>Violations</h6>
                <button type="button" class="custom-btn btn-add-violation" data-toggle="modal" data-target="#addViolationModal">
                    Add Violation
                </button>
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

                $query = "SELECT * FROM violations";
                $query_run = mysqli_query($connection, $query);
                ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Driver ID</th>
                            <th>Driver Name</th>
                            <th>Violation Type</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Fee Status</th>
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
                                    <td><?php echo $row["violation_type"]; ?></td>
                                    <td><?php echo $row["violation_date"]; ?></td>
                                    <td><?php echo $row["amount"]; ?></td>
                                    <td><?php echo $row["description"]; ?></td>
                                    <td>
                                        <form method="POST" action="violation_code.php">
                                            <input type="hidden" name="violation_id" value="<?php echo $row["id"]; ?>">
                                            <select name="fee_status" class="form-control" onchange="this.form.submit()">
                                                <option value="Paid" <?php echo ($row["fee_status"] == 'Paid') ? 'selected' : ''; ?>>Paid</option>
                                                <option value="Unpaid" <?php echo ($row["fee_status"] == 'Unpaid') ? 'selected' : ''; ?>>Unpaid</option>
                                            </select>
                                        </form>
                                    </td>
                                    <td class="action-btns">
                                        <form method="POST" action="violation_code.php">
                                            <input type="hidden" name="delete_id" value="<?php echo $row["id"]; ?>">
                                            <button type="submit" name="delete_btn" class="custom-btn delete-btn">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='9' class='no-record'>No Record Found</td></tr>"; // Adjust colspan to match the new column count
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