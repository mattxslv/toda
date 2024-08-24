<?php
ob_start(); // Start output buffering
include('includes/dbconfig.php'); // Ensure this file contains your DB connection details

// Start the session
session_start();

// Fetch driver details if ID is provided
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($connection, $_GET['id']);
    
    // Fetch existing data
    $query = "SELECT * FROM drivers WHERE id='$id'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $driver = mysqli_fetch_assoc($result);
    } else {
        $_SESSION['status'] = "No record found.";
        header("Location: register.php");
        ob_end_flush();
        exit();
    }
} else {
    $_SESSION['status'] = "No ID provided.";
    header("Location: register.php");
    ob_end_flush();
    exit();
}

// Handle form submission
if (isset($_POST['updatebtn'])) {
    $id = mysqli_real_escape_string($connection, $_POST['edit_id']);
    $full_name = mysqli_real_escape_string($connection, $_POST['edit_full_name']);
    $license_number = mysqli_real_escape_string($connection, $_POST['edit_license_number']);
    $license_expiry = mysqli_real_escape_string($connection, $_POST['edit_license_expiry']);
    $contact_phone = mysqli_real_escape_string($connection, $_POST['edit_contact_phone']);
    $contact_email = mysqli_real_escape_string($connection, $_POST['edit_contact_email']);
    $dob = mysqli_real_escape_string($connection, $_POST['edit_dob']);
    $address = mysqli_real_escape_string($connection, $_POST['edit_address']);
    $tricycle_id = mysqli_real_escape_string($connection, $_POST['edit_tricycle_id']);
    $make_model = mysqli_real_escape_string($connection, $_POST['edit_make_model']);
    $year_manufacture = mysqli_real_escape_string($connection, $_POST['edit_year_manufacture']);
    $color = mysqli_real_escape_string($connection, $_POST['edit_color']);
    $ownership_status = mysqli_real_escape_string($connection, $_POST['edit_ownership_status']);
    $insurance_provider = mysqli_real_escape_string($connection, $_POST['edit_insurance_provider']);
    $policy_number = mysqli_real_escape_string($connection, $_POST['edit_policy_number']);
    $coverage_details = mysqli_real_escape_string($connection, $_POST['edit_coverage_details']);
    $policy_expiry = mysqli_real_escape_string($connection, $_POST['edit_policy_expiry']);
    $certifications = mysqli_real_escape_string($connection, $_POST['edit_certifications']);
    $inspection_status = mysqli_real_escape_string($connection, $_POST['edit_inspection_status']);
    $violations_history = mysqli_real_escape_string($connection, $_POST['edit_violations_history']);
    $special_skills = mysqli_real_escape_string($connection, $_POST['edit_special_skills']);
    $emergency_contact = mysqli_real_escape_string($connection, $_POST['edit_emergency_contact']);

    // Handle file uploads
    $target = "uploads/";
    $license_copy = !empty($_FILES['edit_license_copy']['name']) ? $_FILES['edit_license_copy']['name'] : $_POST['current_license_copy'];
    $registration_docs = !empty($_FILES['edit_registration_docs']['name']) ? $_FILES['edit_registration_docs']['name'] : $_POST['current_registration_docs'];
    $insurance_docs = !empty($_FILES['edit_insurance_docs']['name']) ? $_FILES['edit_insurance_docs']['name'] : $_POST['current_insurance_docs'];

    if (!empty($_FILES['edit_license_copy']['name'])) {
        move_uploaded_file($_FILES['edit_license_copy']['tmp_name'], $target . basename($license_copy));
    }
    if (!empty($_FILES['edit_registration_docs']['name'])) {
        move_uploaded_file($_FILES['edit_registration_docs']['tmp_name'], $target . basename($registration_docs));
    }
    if (!empty($_FILES['edit_insurance_docs']['name'])) {
        move_uploaded_file($_FILES['edit_insurance_docs']['tmp_name'], $target . basename($insurance_docs));
    }

    // Update the driver record
    $query = "UPDATE drivers SET full_name='$full_name', license_number='$license_number', license_expiry='$license_expiry', contact_phone='$contact_phone', contact_email='$contact_email', dob='$dob', address='$address', tricycle_id='$tricycle_id', make_model='$make_model', year_manufacture='$year_manufacture', color='$color', ownership_status='$ownership_status', insurance_provider='$insurance_provider', policy_number='$policy_number', coverage_details='$coverage_details', policy_expiry='$policy_expiry', certifications='$certifications', inspection_status='$inspection_status', violations_history='$violations_history', special_skills='$special_skills', emergency_contact='$emergency_contact', license_copy='$license_copy', registration_docs='$registration_docs', insurance_docs='$insurance_docs' WHERE id='$id'";

    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['success'] = "Driver Updated Successfully";
        header("Location: register.php");
    } else {
        $_SESSION['status'] = "Driver Not Updated: " . mysqli_error($connection);
        header("Location: register.php");
    }
    ob_end_flush();
    exit();
}
?>

<?php include('includes/header.php'); ?>
<?php include('includes/navbar.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Driver</title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css">
    <script src="path/to/jquery.min.js"></script>
    <script src="path/to/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Driver Information</h2>
        <form action="register_edit.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="edit_id" value="<?php echo htmlspecialchars($driver['id']); ?>">

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="edit_full_name" class="form-control" value="<?php echo htmlspecialchars($driver['full_name']); ?>">
            </div>
            <div class="form-group">
                <label>Driver’s License Number</label>
                <input type="text" name="edit_license_number" class="form-control" value="<?php echo htmlspecialchars($driver['license_number']); ?>">
            </div>
            <div class="form-group">
                <label>License Expiry Date</label>
                <input type="date" name="edit_license_expiry" class="form-control" value="<?php echo htmlspecialchars($driver['license_expiry']); ?>">
            </div>
            <div class="form-group">
                <label>Contact Phone</label>
                <input type="text" name="edit_contact_phone" class="form-control" value="<?php echo htmlspecialchars($driver['contact_phone']); ?>">
            </div>
            <div class="form-group">
                <label>Contact Email</label>
                <input type="email" name="edit_contact_email" class="form-control" value="<?php echo htmlspecialchars($driver['contact_email']); ?>">
            </div>
            <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" name="edit_dob" class="form-control" value="<?php echo htmlspecialchars($driver['dob']); ?>">
            </div>
            <div class="form-group">
                <label>Address</label>
                <textarea name="edit_address" class="form-control"><?php echo htmlspecialchars($driver['address']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Tricycle ID</label>
                <input type="text" name="edit_tricycle_id" class="form-control" value="<?php echo htmlspecialchars($driver['tricycle_id']); ?>">
            </div>
            <div class="form-group">
                <label>Make and Model</label>
                <input type="text" name="edit_make_model" class="form-control" value="<?php echo htmlspecialchars($driver['make_model']); ?>">
            </div>
            <div class="form-group">
                <label>Year of Manufacture</label>
                <input type="text" name="edit_year_manufacture" class="form-control" value="<?php echo htmlspecialchars($driver['year_manufacture']); ?>">
            </div>
            <div class="form-group">
                <label>Color</label>
                <input type="text" name="edit_color" class="form-control" value="<?php echo htmlspecialchars($driver['color']); ?>">
            </div>
            <div class="form-group">
                <label>Ownership Status</label>
                <input type="text" name="edit_ownership_status" class="form-control" value="<?php echo htmlspecialchars($driver['ownership_status']); ?>">
            </div>
            <div class="form-group">
                <label>Insurance Provider</label>
                <input type="text" name="edit_insurance_provider" class="form-control" value="<?php echo htmlspecialchars($driver['insurance_provider']); ?>">
            </div>
            <div class="form-group">
                <label>Policy Number</label>
                <input type="text" name="edit_policy_number" class="form-control" value="<?php echo htmlspecialchars($driver['policy_number']); ?>">
            </div>
            <div class="form-group">
                <label>Coverage Details</label>
                <textarea name="edit_coverage_details" class="form-control"><?php echo htmlspecialchars($driver['coverage_details']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Policy Expiry Date</label>
                <input type="date" name="edit_policy_expiry" class="form-control" value="<?php echo htmlspecialchars($driver['policy_expiry']); ?>">
            </div>
            <div class="form-group">
                <label>Certifications</label>
                <input type="text" name="edit_certifications" class="form-control" value="<?php echo htmlspecialchars($driver['certifications']); ?>">
            </div>
            <div class="form-group">
                <label>Inspection Status</label>
                <input type="text" name="edit_inspection_status" class="form-control" value="<?php echo htmlspecialchars($driver['inspection_status']); ?>">
            </div>
            <div class="form-group">
                <label>Violations History</label>
                <textarea name="edit_violations_history" class="form-control"><?php echo htmlspecialchars($driver['violations_history']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Special Skills</label>
                <input type="text" name="edit_special_skills" class="form-control" value="<?php echo htmlspecialchars($driver['special_skills']); ?>">
            </div>
            <div class="form-group">
                <label>Emergency Contact</label>
                <input type="text" name="edit_emergency_contact" class="form-control" value="<?php echo htmlspecialchars($driver['emergency_contact']); ?>">
            </div>

            <div class="form-group">
                <label>License Copy</label>
                <input type="file" name="edit_license_copy" class="form-control">
                <?php if (!empty($driver['license_copy'])): ?>
                    <a href="uploads/<?php echo htmlspecialchars($driver['license_copy']); ?>" target="_blank">View current license copy</a>
                    <input type="hidden" name="current_license_copy" value="<?php echo htmlspecialchars($driver['license_copy']); ?>">
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label>Registration Documents</label>
                <input type="file" name="edit_registration_docs" class="form-control">
                <?php if (!empty($driver['registration_docs'])): ?>
                    <a href="uploads/<?php echo htmlspecialchars($driver['registration_docs']); ?>" target="_blank">View current registration docs</a>
                    <input type="hidden" name="current_registration_docs" value="<?php echo htmlspecialchars($driver['registration_docs']); ?>">
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label>Insurance Documents</label>
                <input type="file" name="edit_insurance_docs" class="form-control">
                <?php if (!empty($driver['insurance_docs'])): ?>
                    <a href="uploads/<?php echo htmlspecialchars($driver['insurance_docs']); ?>" target="_blank">View current insurance docs</a>
                    <input type="hidden" name="current_insurance_docs" value="<?php echo htmlspecialchars($driver['insurance_docs']); ?>">
                <?php endif; ?>
            </div>

            <button type="submit" name="updatebtn" class="btn btn-primary">Update Driver</button>
            <a href="register.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <?php include('includes/scripts.php'); ?>
    <?php include('includes/footer.php'); ?>
</body>
</html>
