<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "adminpanel");

// Add Monthly Dues
if (isset($_POST['add_dues_btn'])) {
    $driver_id = $_POST['driver_id'];
    $name = $_POST['name'];
    $month = $_POST['month'];
    $amount = $_POST['amount'];
    $status = $_POST['status'];

    // Ensure amount is treated as a decimal
    $amount = number_format((float)$amount, 2, '.', '');

    $query = "INSERT INTO monthly_dues (driver_id, name, month, amount, status) 
              VALUES ('$driver_id', '$name', '$month', '$amount', '$status')";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['success'] = "Monthly Dues Added Successfully";
        header('Location: monthly_dues.php');
    } else {
        $_SESSION['status'] = "Monthly Dues Not Added";
        header('Location: monthly_dues.php');
    }
}

// Update Monthly Dues Status
if (isset($_POST['status'])) {
    $id = $_POST['dues_id'];
    $status = $_POST['status'];

    $query = "UPDATE monthly_dues SET status='$status' WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['success'] = "Status Updated Successfully";
        header('Location: monthly_dues.php');
    } else {
        $_SESSION['status'] = "Status Not Updated";
        header('Location: monthly_dues.php');
    }
}

// Delete Monthly Dues
if (isset($_POST['delete_btn'])) {
    $id = $_POST['delete_id'];

    $query = "DELETE FROM monthly_dues WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['success'] = "Monthly Dues Deleted Successfully";
        header('Location: monthly_dues.php');
    } else {
        $_SESSION['status'] = "Monthly Dues Not Deleted";
        header('Location: monthly_dues.php');
    }
}
?>