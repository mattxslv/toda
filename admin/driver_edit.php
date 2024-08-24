<?php
include('includes/header.php'); 
include('includes/navbar.php'); 
?>

<div class="container-fluid">

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Edit Driver</h6>
  </div>
  <div class="card-body">
<?php

$connection = mysqli_connect("localhost", "root", "", "adminpanel");

if (isset($_POST['edit_btn'])) {
    $id = $_POST['edit_id'];

    // Fetch current driver details
    $query = "SELECT * FROM drivers WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        foreach ($query_run as $row) {
            ?>
            <form action="driver_code.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">

                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" name="edit_full_name" id="full_name" value="<?php echo isset($row["full_name"]) ? $row["full_name"] : ''; ?>" class="form-control" placeholder="Enter Full Name" required>
                </div>
                <div class="form-group">
                    <label for="license_number">Driver’s License Number</label>
                    <input type="text" name="edit_license_number" id="license_number" value="<?php echo isset($row["license_number"]) ? $row["license_number"] : ''; ?>" class="form-control" placeholder="Enter Driver’s License Number" required>
                </div>
                <div class="form-group">
                    <label for="date_of_birth">Date of Birth</label>
                    <input type="date" name="edit_date_of_birth" id="date_of_birth" value="<?php echo isset($row["date_of_birth"]) ? $row["date_of_birth"] : ''; ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="edit_address" id="address" value="<?php echo isset($row["address"]) ? $row["address"] : ''; ?>" class="form-control" placeholder="Enter Address" required>
                </div>
                <div class="form-group">
                    <label for="tricycle_id">Tricycle ID/Registration Number</label>
                    <input type="text" name="edit_tricycle_id" id="tricycle_id" value="<?php echo isset($row["tricycle_id"]) ? $row["tricycle_id"] : ''; ?>" class="form-control" placeholder="Enter Tricycle ID/Registration Number" required>
                </div>
                <div class="form-group">
                    <label for="make_and_model">Make and Model</label>
                    <input type="text" name="edit_make_and_model" id="make_and_model" value="<?php echo isset($row["make_and_model"]) ? $row["make_and_model"] : ''; ?>" class="form-control" placeholder="Enter Make and Model" required>
                </div>
                <div class="form-group">
                    <label for="year_of_manufacture">Year of Manufacture</label>
                    <input type="number" name="edit_year_of_manufacture" id="year_of_manufacture" value="<?php echo isset($row["year_of_manufacture"]) ? $row["year_of_manufacture"] : ''; ?>" class="form-control" placeholder="Enter Year of Manufacture" required>
                </div>
                <div class="form-group">
                    <label for="color">Color</label>
                    <input type="text" name="edit_color" id="color" value="<?php echo isset($row["color"]) ? $row["color"] : ''; ?>" class="form-control" placeholder="Enter Color" required>
                </div>
                <div class="form-group">
                    <label for="ownership_status">Ownership Status</label>
                    <select name="edit_ownership_status" id="ownership_status" class="form-control" required>
                        <option value="Owned" <?php echo isset($row["ownership_status"]) && $row["ownership_status"] == 'Owned' ? 'selected' : ''; ?>>Owned</option>
                        <option value="Operator" <?php echo isset($row["ownership_status"]) && $row["ownership_status"] == 'Operator' ? 'selected' : ''; ?>>Operator</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="license_copy">Driver’s License Copy</label>
                    <input type="file" name="edit_license_copy" id="license_copy" class="form-control-file">
                </div>
                <div class="form-group">
                    <label for="registration_documents">Tricycle Registration Documents</label>
                    <input type="file" name="edit_registration_documents" id="registration_documents" class="form-control-file">
                </div>
                <div class="form-group">
                    <label for="insurance_documents">Insurance Documents</label>
                    <input type="file" name="edit_insurance_documents" id="insurance_documents" class="form-control-file">
                </div>

                <button type="submit" name="update_driver_btn" class="btn btn-primary">Update</button>
                <a href="drivers.php" class="btn btn-danger">Cancel</a>
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
