<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Violation</h6>
  </div>
  <div class="card-body">
<?php

$connection = mysqli_connect("localhost", "root", "", "adminpanel");

if (isset($_POST['edit_btn'])) {
    $id = $_POST['edit_id'];

    // Fetch current violation details
    $query = "SELECT * FROM violations WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        foreach ($query_run as $row) {
            ?>
            <form action="violation_code.php" method="POST">
                <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">

                <div class="form-group">
                    <label for="driver_id">Driver ID</label>
                    <input type="text" name="edit_driver_id" id="driver_id" value="<?php echo isset($row["driver_id"]) ? $row["driver_id"] : ''; ?>" class="form-control" placeholder="Enter Driver ID" required>
                </div>
                <div class="form-group">
                    <label for="name">Driver Name</label>
                    <input type="text" name="edit_name" id="name" value="<?php echo isset($row["name"]) ? $row["name"] : ''; ?>" class="form-control" placeholder="Enter Driver Name" required>
                </div>
                <div class="form-group">
                    <label for="violation_type">Violation Type</label>
                    <input type="text" name="edit_violation_type" id="violation_type" value="<?php echo isset($row["violation_type"]) ? $row["violation_type"] : ''; ?>" class="form-control" placeholder="Enter Violation Type" required>
                </div>
                <div class="form-group">
                    <label for="violation_date">Violation Date</label>
                    <input type="date" name="edit_violation_date" id="violation_date" value="<?php echo isset($row["violation_date"]) ? $row["violation_date"] : ''; ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" name="edit_amount" id="amount" value="<?php echo isset($row["amount"]) ? $row["amount"] : ''; ?>" class="form-control" placeholder="Enter Amount" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="edit_description" id="description" class="form-control" placeholder="Enter Description" required><?php echo isset($row["description"]) ? $row["description"] : ''; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="fee_status">Fee Status</label>
                    <select name="edit_fee_status" id="fee_status" class="form-control" required>
                        <option value="Paid" <?php echo isset($row["fee_status"]) && $row["fee_status"] == 'Paid' ? 'selected' : ''; ?>>Paid</option>
                        <option value="Unpaid" <?php echo isset($row["fee_status"]) && $row["fee_status"] == 'Unpaid' ? 'selected' : ''; ?>>Unpaid</option>
                    </select>
                </div>

                <button type="submit" name="update_violation_btn" class="btn btn-primary">Update</button>
                <a href="violation.php" class="btn btn-danger">Cancel</a>
            </form>
            <?php
        }
    } else {
        echo "Error fetching data.";
    }
}
?>
  </div>
</div>

</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
