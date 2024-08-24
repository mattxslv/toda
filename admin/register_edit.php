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

// Check if edit button is clicked and ID is set
if (isset($_POST['edit_btn'])) {
    $id = mysqli_real_escape_string($connection, $_POST['edit_id']);

    // Fetch current driver details
    $query = "SELECT * FROM drivers WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run && mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $row) {
            ?>
            <form action="code.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($row['id']); ?>">

                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" name="edit_full_name" id="full_name" value="<?php echo htmlspecialchars($row['full_name']); ?>" class="form-control" placeholder="Enter Full Name" required>
                </div>
                <div class="form-group">
                    <label for="license_number">Driver’s License Number</label>
                    <input type="text" name="edit_license_number" id="license_number" value="<?php echo htmlspecialchars($row['license_number']); ?>" class="form-control" placeholder="Enter License Number" required>
                </div>
                <div class="form-group">
                    <label for="license_expiry">License Expiry Date</label>
                    <input type="date" name="edit_license_expiry" id="license_expiry" value="<?php echo htmlspecialchars($row['license_expiry']); ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="contact_phone">Contact Phone</label>
                    <input type="text" name="edit_contact_phone" id="contact_phone" value="<?php echo htmlspecialchars($row['contact_phone']); ?>" class="form-control" placeholder="Enter Contact Phone" required>
                </div>
                <div class="form-group">
                    <label for="contact_email">Contact Email</label>
                    <input type="email" name="edit_contact_email" id="contact_email" value="<?php echo htmlspecialchars($row['contact_email']); ?>" class="form-control" placeholder="Enter Contact Email" required>
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" name="edit_dob" id="dob" value="<?php echo htmlspecialchars($row['dob']); ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea name="edit_address" id="address" class="form-control" placeholder="Enter Address" required><?php echo htmlspecialchars($row['address']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="tricycle_id">Tricycle ID</label>
                    <input type="text" name="edit_tricycle_id" id="tricycle_id" value="<?php echo htmlspecialchars($row['tricycle_id']); ?>" class="form-control" placeholder="Enter Tricycle ID" required>
                </div>
                <div class="form-group">
                    <label for="make_model">Make and Model</label>
                    <input type="text" name="edit_make_model" id="make_model" value="<?php echo htmlspecialchars($row['make_model']); ?>" class="form-control" placeholder="Enter Make and Model" required>
                </div>
                <div class="form-group">
                    <label for="year_manufacture">Year of Manufacture</label>
                    <input type="text" name="edit_year_manufacture" id="year_manufacture" value="<?php echo htmlspecialchars($row['year_manufacture']); ?>" class="form-control" placeholder="Enter Year of Manufacture" required>
                </div>
                <div class="form-group">
                    <label for="color">Color</label>
                    <input type="text" name="edit_color" id="color" value="<?php echo htmlspecialchars($row['color']); ?>" class="form-control" placeholder="Enter Color" required>
                </div>
                <div class="form-group">
                    <label for="ownership_status">Ownership Status</label>
                    <input type="text" name="edit_ownership_status" id="ownership_status" value="<?php echo htmlspecialchars($row['ownership_status']); ?>" class="form-control" placeholder="Enter Ownership Status" required>
                </div>
                <div class="form-group">
                    <label for="insurance_provider">Insurance Provider</label>
                    <input type="text" name="edit_insurance_provider" id="insurance_provider" value="<?php echo htmlspecialchars($row['insurance_provider']); ?>" class="form-control" placeholder="Enter Insurance Provider" required>
                </div>
                <div class="form-group">
                    <label for="policy_number">Policy Number</label>
                    <input type="text" name="edit_policy_number" id="policy_number" value="<?php echo htmlspecialchars($row['policy_number']); ?>" class="form-control" placeholder="Enter Policy Number" required>
                </div>
                <div class="form-group">
                    <label for="coverage_details">Coverage Details</label>
                    <textarea name="edit_coverage_details" id="coverage_details" class="form-control" placeholder="Enter Coverage Details" required><?php echo htmlspecialchars($row['coverage_details']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="policy_expiry">Policy Expiry Date</label>
                    <input type="date" name="edit_policy_expiry" id="policy_expiry" value="<?php echo htmlspecialchars($row['policy_expiry']); ?>" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="certifications">Certifications</label>
                    <input type="text" name="edit_certifications" id="certifications" value="<?php echo htmlspecialchars($row['certifications']); ?>" class="form-control" placeholder="Enter Certifications" required>
                </div>
                <div class="form-group">
                    <label for="inspection_status">Inspection Status</label>
                    <input type="text" name="edit_inspection_status" id="inspection_status" value="<?php echo htmlspecialchars($row['inspection_status']); ?>" class="form-control" placeholder="Enter Inspection Status" required>
                </div>
                <div class="form-group">
                    <label for="violations_history">Violations History</label>
                    <textarea name="edit_violations_history" id="violations_history" class="form-control" placeholder="Enter Violations History" required><?php echo htmlspecialchars($row['violations_history']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="special_skills">Special Skills</label>
                    <input type="text" name="edit_special_skills" id="special_skills" value="<?php echo htmlspecialchars($row['special_skills']); ?>" class="form-control" placeholder="Enter Special Skills" required>
                </div>
                <div class="form-group">
                    <label for="emergency_contact">Emergency Contact</label>
                    <input type="text" name="edit_emergency_contact" id="emergency_contact" value="<?php echo htmlspecialchars($row['emergency_contact']); ?>" class="form-control" placeholder="Enter Emergency Contact" required>
                </div>
                <div class="form-group">
                    <label for="license_copy">License Copy</label>
                    <input type="file" name="edit_license_copy" id="license_copy" class="form-control">
                    <input type="hidden" name="current_license_copy" value="<?php echo htmlspecialchars($row['license_copy']); ?>">
                </div>
                <div class="form-group">
                    <label for="registration_docs">Registration Documents</label>
                    <input type="file" name="edit_registration_docs" id="registration_docs" class="form-control">
                    <input type="hidden" name="current_registration_docs" value="<?php echo htmlspecialchars($row['registration_docs']); ?>">
                </div>
                <div class="form-group">
                    <label for="insurance_docs">Insurance Documents</label>
                    <input type="file" name="edit_insurance_docs" id="insurance_docs" class="form-control">
                    <input type="hidden" name="current_insurance_docs" value="<?php echo htmlspecialchars($row['insurance_docs']); ?>">
                </div>
                
                <button type="submit" name="updatebtn" class="btn btn-primary">Update</button>
                <a href="register.php" class="btn btn-danger">Cancel</a>
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
