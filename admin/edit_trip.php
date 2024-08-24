<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Trip</h6>
  </div>
  <div class="card-body">

<?php
$connection = mysqli_connect("localhost", "root", "", "adminpanel");

// Check if edit button is clicked and ID is set
if (isset($_POST['edit_btn']) && isset($_POST['edit_id'])) {
    $id = mysqli_real_escape_string($connection, $_POST['edit_id']);

    // Fetch current trip details
    $query = "SELECT * FROM trips WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run && mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $row) {
            ?>
            <form action="manage_trips.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($row['id']); ?>">

                <div class="form-group">
                    <label for="pickup_location">Pickup Location</label>
                    <input type="text" name="pickup_location" id="pickup_location" value="<?php echo htmlspecialchars($row['pickup_location']); ?>" class="form-control" placeholder="Enter Pickup Location" required>
                </div>
                <div class="form-group">
                    <label for="dropoff_location">Dropoff Location</label>
                    <input type="text" name="dropoff_location" id="dropoff_location" value="<?php echo htmlspecialchars($row['dropoff_location']); ?>" class="form-control" placeholder="Enter Dropoff Location" required>
                </div>
                <div class="form-group">
                    <label for="trip_date">Trip Date</label>
                    <input type="datetime-local" name="trip_date" id="trip_date" value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($row['trip_date']))); ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="fare">Fare</label>
                    <input type="number" step="0.01" name="fare" id="fare" value="<?php echo htmlspecialchars($row['fare']); ?>" class="form-control" placeholder="Enter Fare" required>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="Pending" <?php if ($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                        <option value="Completed" <?php if ($row['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                        <option value="Cancelled" <?php if ($row['status'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                    </select>
                </div>
                
                <button type="submit" name="update_btn" class="btn btn-primary">Update</button>
                <a href="manage_trips.php" class="btn btn-danger">Cancel</a>
            </form>
            <?php
        }
    } else {
        echo "Error fetching data or no data found.";
    }
} else {
    echo "Edit button not clicked or ID not set.";
}
?>

  </div>
</div>

</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>