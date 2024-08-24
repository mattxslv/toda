<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<style>
    .table th, .table td { text-align: center; }
    .table thead th { background-color: #4e73df; color: white; }
    .table tbody tr:nth-child(even) { background-color: #f8f9fc; }
    .table tbody tr:hover { background-color: #e2e6ea; }
    .no-record { text-align: center; font-size: 1.2rem; color: #6c757d; }
    .card-header { background-color: #4e73df; color: white; position: relative; }
    .card-header h6 { font-weight: bold; margin: 0; color: white; }
    .btn-add-offense { position: absolute; right: 20px; top: 50%; transform: translateY(-50%); font-size: 0.9rem; }
    .card-body { padding: 2rem; }
    .card-title { font-size: 1.5rem; margin-bottom: 1rem; text-align: center; }
    .modal-header { background-color: #4e73df; color: white; }
    .custom-btn { background-color: #4e73df; color: white; border: none; border-radius: 0.25rem; padding: 0.375rem 0.75rem; font-size: 0.875rem; cursor: pointer; transition: all 0.2s ease-in-out; }
    .custom-btn:hover { background-color: #2e59d9; color: white; box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075); }
    .custom-btn:focus { outline: none; box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25); }
    .custom-btn.edit-btn { background-color: #1cc88a; }
    .custom-btn.edit-btn:hover { background-color: #17a673; }
    .custom-btn.delete-btn { background-color: #e74a3b; }
    .custom-btn.delete-btn:hover { background-color: #c82333; }
    .action-btns { display: flex; justify-content: center; gap: 0.5rem; }
    .infraction-table th, .infraction-table td { text-align: left; }
    .infraction-table .fine { text-align: center; }
</style>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Infraction Categories and Fines -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="">Infraction Categories and Fines</h6>
        </div>
        <div class="card-body">
            <table class="infraction-table" width="100%">
                <thead>
                    <tr>
                        <th>Infraction Category</th>
                        <th class="fine">Fine</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Minor Infractions (e.g., late arrival, unclean vehicle)</td>
                        <td class="fine">PHP 200 - 500</td>
                    </tr>
                    <tr>
                        <td>Moderate Infractions (e.g., rude behavior, refusal to follow route)</td>
                        <td class="fine">PHP 500 - 1,000</td>
                    </tr>
                    <tr>
                        <td>Major Infractions (e.g., unsafe driving, serious customer complaints)</td>
                        <td class="fine">PHP 1,000 - 2,500</td>
                    </tr>
                    <tr>
                        <td>Severe Infractions (e.g., endangering passengers, discrimination, driving under the influence)</td>
                        <td class="fine">PHP 2,500 - 5,000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Customer Reports Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="">Customer Reports</h6>
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

                $query = "SELECT * FROM customer_reports";
                $query_run = mysqli_query($connection, $query);
                ?>
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer Name</th>
                            <th>Report Date</th>
                            <th>Report Type</th>
                            <th>Details</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($query_run) > 0) {
                            while ($row = mysqli_fetch_assoc($query_run)) {
                        ?>
                                <tr>
                                    <td><?php echo $row["id"]; ?></td>
                                    <td><?php echo $row["customer_name"]; ?></td>
                                    <td><?php echo $row["report_date"]; ?></td>
                                    <td><?php echo $row["report_type"]; ?></td>
                                    <td><?php echo $row["details"]; ?></td>
                                    <td>
                                        <form action="customer_reports_code.php" method="POST">
                                            <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                            <button type="submit" name="delete_btn" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='6'>No Record Found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Drivers Offenses Table -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="">Drivers Offenses</h6>
        <button type="button" class="custom-btn btn-add-offense" data-toggle="modal" data-target="#addOffenseModal">
            Add Offense
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
            $query = "SELECT * FROM drivers_offenses";
            $query_run = mysqli_query($connection, $query);
            ?>
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Driver Name</th>
                        <th>Offense Type</th>
                        <th>Details</th>
                        <th>Fine</th>
                        <th>Offense Count</th> <!-- New column for offense count -->
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($query_run) > 0) {
                        while ($row = mysqli_fetch_assoc($query_run)) {
                    ?>
                            <tr>
                                <td><?php echo $row["driver_name"]; ?></td>
                                <td>
                                    <form action="update_offense_status.php" method="POST">
                                        <input type="hidden" name="offense_id" value="<?php echo $row['id']; ?>">
                                        <select name="offense_type" class="form-control" onchange="this.form.submit()">
                                            <option value="Minor" <?php if ($row['offense_type'] == 'Minor') echo 'selected'; ?>>Minor</option>
                                            <option value="Moderate" <?php if ($row['offense_type'] == 'Moderate') echo 'selected'; ?>>Moderate</option>
                                            <option value="Major" <?php if ($row['offense_type'] == 'Major') echo 'selected'; ?>>Major</option>
                                            <option value="Severe" <?php if ($row['offense_type'] == 'Severe') echo 'selected'; ?>>Severe</option>
                                        </select>
                                    </form>
                                </td>
                                <td><?php echo $row["details"]; ?></td>
                                <td><?php echo $row["fine"]; ?></td>
                                <td>
                                <form action="update_offense_status.php" method="POST">
                                        <input type="hidden" name="offense_id" value="<?php echo $row['id']; ?>">
                                        <select name="offense_count" class="form-control" onchange="this.form.submit()">
                                            <option value="1" <?php if ($row['offense_count'] == '1') echo 'selected'; ?>>1st Offense</option>
                                            <option value="2" <?php if ($row['offense_count'] == '2') echo 'selected'; ?>>2nd Offense</option>
                                            <option value="3" <?php if ($row['offense_count'] == '3') echo 'selected'; ?>>3rd Offense</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <form action="update_offense_status.php" method="POST">
                                        <input type="hidden" name="offense_id" value="<?php echo $row['id']; ?>">
                                        <select name="status" class="form-control" onchange="this.form.submit()">
                                            <option value="Unpaid" <?php if ($row['status'] == 'Unpaid') echo 'selected'; ?>>Unpaid</option>
                                            <option value="Paid" <?php if ($row['status'] == 'Paid') echo 'selected'; ?>>Paid</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <form action="delete_offense.php" method="POST">
                                        <input type="hidden" name="delete_id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" name="delete_btn" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
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
    <!-- Add Offense Modal -->
    <div class="modal fade" id="addOffenseModal" tabindex="-1" role="dialog" aria-labelledby="addOffenseModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addOffenseModalLabel">Add Offense</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="add_offense.php" method="POST">
    <div class="modal-body">
        <div class="form-group">
            <label for="driver_name">Driver Name</label>
            <input type="text" class="form-control" id="driver_name" name="driver_name" placeholder="Enter Driver Name" required>
        </div>
        <div class="form-group">
            <label for="offense_type">Offense Type</label>
            <select class="form-control" id="offense_type" name="offense_type" required>
                <option value="Minor">Minor</option>
                <option value="Moderate">Moderate</option>
                <option value="Major">Major</option>
                <option value="Severe">Severe</option>
            </select>
        </div>
        <div class="form-group">
            <label for="details">Details</label>
            <textarea class="form-control" id="details" name="details" rows="3" placeholder="Enter Details" required></textarea>
        </div>
        <div class="form-group">
            <label for="fine">Fine</label>
            <input type="number" class="form-control" id="fine" name="fine" placeholder="Enter Fine Amount" step="0.01" required>
        </div>
        <div class="form-group">
            <label for="offense_count">Offense Count</label>
            <select class="form-control" id="offense_count" name="offense_count" required>
                <option value="1st">1st Offense</option>
                <option value="2nd">2nd Offense</option>
                <option value="3rd">3rd Offense</option>
            </select>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" name="add_offense_btn" class="btn btn-primary">Save</button>
    </div>
</form>

</div>
<!-- End of Main Content -->

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>

<!-- Include the script to maintain sidebar state -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const body = document.body;
    const sidebarToggle = document.querySelector('#sidebarToggle');

    // Check the local storage for the sidebar state
    if (localStorage.getItem('sidebar-collapsed') === 'true') {
        body.classList.add('sidebar-toggled');
        document.querySelector('.sidebar').classList.add('toggled');
    }

    // Add event listener to the sidebar toggle button
    sidebarToggle.addEventListener('click', function() {
        body.classList.toggle('sidebar-toggled');
        document.querySelector('.sidebar').classList.toggle('toggled');

        // Save the state in local storage
        if (body.classList.contains('sidebar-toggled')) {
            localStorage.setItem('sidebar-collapsed', 'true');
        } else {
            localStorage.setItem('sidebar-collapsed', 'false');
        }
    });
});
</script>