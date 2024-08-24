<?php
session_start();
include('database/dbconfig.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $password = mysqli_real_escape_string($connection, $_POST['password']);

    $query = "SELECT * FROM users WHERE email='$email'";
    $query_run = mysqli_query($connection, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $row = mysqli_fetch_assoc($query_run);
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['full_name'] = $row['first_name'] . ' ' . $row['last_name']; // Store full name in session
            header("Location: dashboard.php");
        } else {
            $_SESSION['status'] = "Invalid Password";
            header("Location: login.php");
        }
    } else {
        $_SESSION['status'] = "Invalid Email";
        header("Location: login.php");
    }
} else {
    header("Location: login.php");
}
?>