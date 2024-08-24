<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];

    if ($password !== $repeat_password) {
        $_SESSION['status'] = "Passwords do not match";
        header("Location: register.php?error=password_mismatch");
        exit();
    }

    // Replace with your actual database connection details
    $conn = new mysqli('localhost', 'root', '', 'adminpanel');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the email already exists
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement (SELECT): " . $conn->error);
    }
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: register.php?error=email_exists");
        exit();
    } else {
        // Insert the new user into the database without hashing the password
        $sql = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Error preparing statement (INSERT): " . $conn->error);
        }
        $stmt->bind_param('ssss', $first_name, $last_name, $email, $password);
        if ($stmt->execute() === TRUE) {
            $_SESSION['status'] = "Registration successful. Please login.";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['status'] = "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>