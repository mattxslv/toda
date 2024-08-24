<?php
session_start();
require 'config.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $newPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Check if the token is valid and not expired
    $stmt = $conn->prepare("SELECT * FROM password_resets WHERE token = ? AND expires > ?");
    $stmt->bind_param("ss", $token, date("U"));
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];
        
        // Update the user's password
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $newPassword, $email);
        $stmt->execute();
        
        // Delete the token from the database
        $stmt = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        
        echo "Your password has been reset successfully.";
    } else {
        echo "Invalid or expired token.";
    }
}
?>