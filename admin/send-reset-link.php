<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require 'includes/dbconfig.php'; // Include your database connection
require 'vendor/autoload.php'; // Include Composer autoload file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$email = $_POST['email'];

// Check if the email exists in the database
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Generate a unique token
    $token = bin2hex(random_bytes(50));
    
    // Calculate the expiry time (30 minutes from now)
    $expires = new DateTime();
    $expires->add(new DateInterval('PT30M')); // Add 30 minutes
    $expiresFormatted = $expires->format('Y-m-d H:i:s'); // Format as 'Y-m-d H:i:s'
    
    // Insert token into the database
    $stmt = $conn->prepare("INSERT INTO password_resets (email, token, expires) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $token, $expiresFormatted);
    $stmt->execute();
    
    // Send reset link to the user's email using PHPMailer
    $resetLink = "http://localhost/toda_admin/admin/reset-password.php?token=" . $token;
    $subject = "Password Reset Request";
    $message = "Click the following link to reset your password: " . $resetLink;
    
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true;
        $mail->Username = 'matsura01032@gmail.com'; // SMTP username
        $mail->Password = 'deoxamxlqjecuqpu'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('no-reply@yourdomain.com', 'Mailer');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        $_SESSION['status'] = "A password reset link has been sent to your email.";
    } catch (Exception $e) {
        $_SESSION['status'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    $_SESSION['status'] = "No account found with that email address.";
}

// Redirect back to forgot-password.php
header("Location: forgot-password.php");
exit();
?>