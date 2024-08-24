<?php
session_start();
$connection = mysqli_connect("localhost", "root", "", "adminpanel");

// Add Incentive
if (isset($_POST['add_incentive_btn'])) {
    $incentive_type = $_POST['incentive_type'];
    $criteria = $_POST['criteria'];
    $reward = $_POST['reward'];
    $deadline = $_POST['deadline'];
    $description = $_POST['description'];

    $query = "INSERT INTO incentives (incentive_type, criteria, reward, deadline, description) VALUES ('$incentive_type', '$criteria', '$reward', '$deadline', '$description')";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['success'] = "Incentive Added Successfully";
        header('Location: incentives_dashboard.php');
    } else {
        $_SESSION['status'] = "Incentive Not Added";
        header('Location: incentives_dashboard.php');
    }
}

// Delete Incentive
if (isset($_POST['delete_btn'])) {
    $id = $_POST['delete_id'];

    $query = "DELETE FROM incentives WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

    if ($query_run) {
        $_SESSION['success'] = "Incentive Deleted Successfully";
        header('Location: incentives_dashboard.php');
    } else {
        $_SESSION['status'] = "Incentive Not Deleted";
        header('Location: incentives_dashboard.php');
    }
}
?>