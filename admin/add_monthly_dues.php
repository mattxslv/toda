<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="container-fluid">

<!-- Add Monthly Dues Form -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Add Monthly Dues</h6>
  </div>
  <div class="card-body">
    <form action="monthly_dues_code.php" method="POST">
        <div class="form-group">
            <label for="driver_id">Driver ID</label>
            <input type="text" name="driver_id" id="driver_id" class="form-control" placeholder="Enter Driver ID" required>
        </div>
        <div class="form-group">
            <label for="month">Month</label>
            <input type="text" name="month" id="month" class="form-control" placeholder="Enter Month" required>
        </div>
        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" name="amount" id="amount" class="form-control" placeholder="Enter Amount" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" placeholder="Enter Description" required></textarea>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="Paid">Paid</option>
                <option value="Unpaid">Unpaid</option>
            </select>
        </div>

        <button type="submit" name="add_dues_btn" class="btn btn-primary">Add Dues</button>
        <a href="monthly_dues.php" class="btn btn-danger">Cancel</a>
    </form>
  </div>
</div>

</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
