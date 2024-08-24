<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Monthly Dues</h6>
  </div>
  <div class="card-body">
<?php

$connection = mysqli_connect("localhost", "root", "", "adminpanel");

if (isset($_POST['edit_btn'])) {
    $id = $_POST['edit_id'];
    
    $query = "SELECT * FROM monthly_dues WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    foreach ($query_run as $row) {
        ?>

        <form action="monthly_dues_code.php" method="POST">

            <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">

            <div class="form-group">
                <label>Driver ID</label>
                <input type="text" name="edit_driver_id" value="<?php echo $row['driver_id']; ?>" class="form-control" placeholder="Enter Driver ID">
            </div>
            <div class="form-group">
                <label>Driver Name</label>
                <input type="text" name="edit_name" value="<?php echo $row['name']; ?>" class="form-control" placeholder="Enter Driver Name">
            </div>
            <div class="form-group">
                <label>Month</label>
                <input type="text" name="edit_month" value="<?php echo $row['month']; ?>" class="form-control" placeholder="Enter Month">
            </div>
            <div class="form-group">
                <label>Amount</label>
                <input type="text" name="edit_amount" value="<?php echo $row['amount']; ?>" class="form-control" placeholder="Enter Amount">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="edit_status" class="form-control">
    <option value="Paid" <?php if($row['status'] == 'Paid') echo 'selected'; ?>>Paid</option>
    <option value="Unpaid" <?php if($row['status'] == 'Unpaid') echo 'selected'; ?>>Unpaid</option>
    <option value="Overdue" <?php if($row['status'] == 'Overdue') echo 'selected'; ?>>Overdue</option>
</select>

            </div>

            <button type="submit" name="update_dues_btn" class="btn btn-primary">Update</button>
            <a href="monthly_dues.php" class="btn btn-danger">Cancel</a>

        </form>

        <?php
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
