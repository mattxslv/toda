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
    .btn-add-incentive {
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

    <!-- Add Incentive Modal -->
    <div class="modal fade" id="addIncentiveModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Incentive</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="incentive_code.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Incentive Type</label>
                            <input type="text" name="incentive_type" class="form-control" placeholder="Enter Incentive Type">
                        </div>
                        <div class="form-group">
                            <label>Criteria</label>
                            <input type="text" name="criteria" class="form-control" placeholder="Enter Criteria">
                        </div>
                        <div class="form-group">
                            <label>Reward</label>
                            <input type="text" name="reward" class="form-control" placeholder="Enter Reward">
                        </div>
                        <div class="form-group">
                            <label>Deadline</label>
                            <input type="date" name="deadline" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Enter Description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="add_incentive_btn" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Incentives Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h6>Incentives</h6>
                <button type="button" class="custom-btn btn-add-incentive" data-toggle="modal" data-target="#addIncentiveModal">
                    Add Incentive
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

                $query = "SELECT * FROM incentives";
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
                            <th>Incentive Type</th>
                            <th>Criteria</th>
                            <th>Reward</th>
                            <th>Deadline</th>
                            <th>Description</th>
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
                                    <td><?php echo $row["incentive_type"]; ?></td>
                                    <td><?php echo $row["criteria"]; ?></td>
                                    <td><?php echo $row["reward"]; ?></td>
                                    <td><?php echo $row["deadline"]; ?></td>
                                    <td><?php echo $row["description"]; ?></td>
                                    <td class="action-btns">
                                        <form method="POST" action="incentive_code.php">
                                            <input type="hidden" name="delete_id" value="<?php echo $row["id"]; ?>">
                                            <button type="submit" name="delete_btn" class="custom-btn delete-btn">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='7' class='no-record'>No Record Found</td></tr>"; // Adjust colspan to match the new column count
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