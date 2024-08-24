<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "adminpanel");

// Add Violation
if (isset($_POST['add_violation_btn'])) {
    $driver_id = $_POST['driver_id'];
    $name = $_POST['name'];
    $violation_type = $_POST['violation_type'];
    $violation_date = $_POST['violation_date'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $fee_status = $_POST['fee_status'];

    // Ensure amount is treated as a decimal
    $amount = number_format((float)$amount, 2, '.', '');

    $query = "INSERT INTO violations (driver_id, name, violation_type, violation_date, amount, description, fee_status) 
              VALUES ('$driver_id', '$name', '$violation_type', '$violation_date', '$amount', '$description', '$fee_status')";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['success'] = "Violation Added Successfully";
        header('Location: violation.php');
    } else {
        $_SESSION['status'] = "Violation Not Added";
        header('Location: violation.php');
    }
}

// Update Violation
if (isset($_POST['update_violation_btn'])) {
    $id = $_POST['edit_id'];
    $driver_id = $_POST['edit_driver_id'];
    $name = $_POST['edit_name'];
    $violation_type = $_POST['edit_violation_type'];
    $violation_date = $_POST['edit_violation_date'];
    $description = $_POST['edit_description'];
    $fee_status = $_POST['edit_fee_status'];
    $amount = $_POST['edit_amount'];

    // Ensure amount is treated as a decimal
    $amount = number_format((float)$amount, 2, '.', '');

    $query = "UPDATE violations 
              SET driver_id='$driver_id', name='$name', violation_type='$violation_type', violation_date='$violation_date', amount='$amount', description='$description', fee_status='$fee_status' 
              WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['success'] = "Violation Updated Successfully";
        header('Location: violation.php');
    } else {
        $_SESSION['status'] = "Violation Not Updated";
        header('Location: violation.php');
    }
}

// Delete Violation
if (isset($_POST['delete_btn'])) {
    $id = $_POST['delete_id'];

    $query = "DELETE FROM violations WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['success'] = "Violation Deleted Successfully";
        header('Location: violation.php');
    } else {
        $_SESSION['status'] = "Violation Not Deleted";
        header('Location: violation.php');
    }
}

// Update Fee Status
if (isset($_POST['fee_status'])) {
    $id = $_POST['violation_id'];
    $fee_status = $_POST['fee_status'];

    $query = "UPDATE violations SET fee_status='$fee_status' WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['success'] = "Fee Status Updated Successfully";
        header('Location: violation.php');
    } else {
        $_SESSION['status'] = "Fee Status Not Updated";
        header('Location: violation.php');
    }
}
?>