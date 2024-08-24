<?php
session_start();
include('dbconfig.php');

if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Add Driver
if (isset($_POST['add_driver_btn'])) {
    $full_name = mysqli_real_escape_string($connection, $_POST['full_name']);
    $license_number = mysqli_real_escape_string($connection, $_POST['license_number']);
    $date_of_birth = mysqli_real_escape_string($connection, $_POST['date_of_birth']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $tricycle_id = mysqli_real_escape_string($connection, $_POST['tricycle_id']);
    $make_and_model = mysqli_real_escape_string($connection, $_POST['make_and_model']);
    $year_of_manufacture = mysqli_real_escape_string($connection, $_POST['year_of_manufacture']);
    $color = mysqli_real_escape_string($connection, $_POST['color']);
    $ownership_status = mysqli_real_escape_string($connection, $_POST['ownership_status']);

    // File uploads
    $license_copy = $_FILES['license_copy']['name'];
    $registration_documents = $_FILES['registration_documents']['name'];
    $insurance_documents = $_FILES['insurance_documents']['name'];

    // Check if files are uploaded
    if ($license_copy) {
        $license_copy_tmp = $_FILES['license_copy']['tmp_name'];
        move_uploaded_file($license_copy_tmp, "uploads/$license_copy");
    } else {
        $license_copy = ''; // If no new file, set to empty string
    }

    if ($registration_documents) {
        $registration_documents_tmp = $_FILES['registration_documents']['tmp_name'];
        move_uploaded_file($registration_documents_tmp, "uploads/$registration_documents");
    } else {
        $registration_documents = ''; // If no new file, set to empty string
    }

    if ($insurance_documents) {
        $insurance_documents_tmp = $_FILES['insurance_documents']['tmp_name'];
        move_uploaded_file($insurance_documents_tmp, "uploads/$insurance_documents");
    } else {
        $insurance_documents = ''; // If no new file, set to empty string
    }

    // Insert data into database
    $query = "INSERT INTO drivers (full_name, license_number, date_of_birth, address, tricycle_id, make_and_model, year_of_manufacture, color_of_vehicle, ownership_status, license_copy, registration_documents, insurance_documents) VALUES ('$full_name', '$license_number', '$date_of_birth', '$address', '$tricycle_id', '$make_and_model', '$year_of_manufacture', '$color', '$ownership_status', '$license_copy', '$registration_documents', '$insurance_documents')";
    $query_run = mysqli_query($connection, $query);

    

    header("Location: drivers.php");
}

// Edit Driver
if (isset($_POST['update_driver_btn'])) {
    $id = mysqli_real_escape_string($connection, $_POST['edit_id']);
    $full_name = mysqli_real_escape_string($connection, $_POST['edit_full_name']);
    $license_number = mysqli_real_escape_string($connection, $_POST['edit_license_number']);
    $date_of_birth = mysqli_real_escape_string($connection, $_POST['edit_date_of_birth']);
    $address = mysqli_real_escape_string($connection, $_POST['edit_address']);
    $tricycle_id = mysqli_real_escape_string($connection, $_POST['edit_tricycle_id']);
    $make_and_model = mysqli_real_escape_string($connection, $_POST['edit_make_and_model']);
    $year_of_manufacture = mysqli_real_escape_string($connection, $_POST['edit_year_of_manufacture']);
    $color = mysqli_real_escape_string($connection, $_POST['edit_color']);
    $ownership_status = mysqli_real_escape_string($connection, $_POST['edit_ownership_status']);

    // Initialize file variables
    $license_copy = '';
    $registration_documents = '';
    $insurance_documents = '';

    // Handle file uploads
    if (!empty($_FILES['edit_license_copy']['name'])) {
        $license_copy = $_FILES['edit_license_copy']['name'];
        $license_copy_tmp = $_FILES['edit_license_copy']['tmp_name'];
        move_uploaded_file($license_copy_tmp, "uploads/$license_copy");
        $license_copy_query = "license_copy='$license_copy',";
    } else {
        $license_copy_query = "";
    }

    if (!empty($_FILES['edit_registration_documents']['name'])) {
        $registration_documents = $_FILES['edit_registration_documents']['name'];
        $registration_documents_tmp = $_FILES['edit_registration_documents']['tmp_name'];
        move_uploaded_file($registration_documents_tmp, "uploads/$registration_documents");
        $registration_documents_query = "registration_documents='$registration_documents',";
    } else {
        $registration_documents_query = "";
    }

    if (!empty($_FILES['edit_insurance_documents']['name'])) {
        $insurance_documents = $_FILES['edit_insurance_documents']['name'];
        $insurance_documents_tmp = $_FILES['edit_insurance_documents']['tmp_name'];
        move_uploaded_file($insurance_documents_tmp, "uploads/$insurance_documents");
        $insurance_documents_query = "insurance_documents='$insurance_documents',";
    } else {
        $insurance_documents_query = "";
    }

    // Remove trailing comma from file update queries
    $file_queries = $license_copy_query . $registration_documents_query . $insurance_documents_query;
    $file_queries = rtrim($file_queries, ',');

    // Update data in database
    $query = "UPDATE drivers SET 
        full_name='$full_name',
        license_number='$license_number',
        date_of_birth='$date_of_birth',
        address='$address',
        tricycle_id='$tricycle_id',
        make_and_model='$make_and_model',
        year_of_manufacture='$year_of_manufacture',
        color_of_vehicle='$color',
        ownership_status='$ownership_status'
        $file_queries
        WHERE id='$id'";

    $query_run = mysqli_query($connection, $query);

    

    header("Location: drivers.php");
}

// Delete Driver
if (isset($_POST['delete_btn'])) {
    $id = mysqli_real_escape_string($connection, $_POST['delete_id']);
    $query = "DELETE FROM drivers WHERE id='$id'";
    $query_run = mysqli_query($connection, $query);

   

    header("Location: drivers.php");
}
?>
