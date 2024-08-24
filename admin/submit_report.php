<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $issueCategory = $_POST['issueCategory'];
    $issueDescription = $_POST['issueDescription'];

    // Save the report to the database or send an email
    // Example: Save to database
    // $conn = new mysqli('hostname', 'username', 'password', 'database');
    // $stmt = $conn->prepare("INSERT INTO reports (category, description) VALUES (?, ?)");
    // $stmt->bind_param("ss", $issueCategory, $issueDescription);
    // $stmt->execute();
    // $stmt->close();
    // $conn->close();

    echo "Report submitted successfully!";
} else {
    echo "Invalid request.";
}
?>