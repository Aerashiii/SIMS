<?php
require '../assets/config/dbconfig.php';

// Create default admin account
$adminUsername = "Admin";
$adminPassword = password_hash("admin", PASSWORD_DEFAULT); // Encrypt the password

$sql = "INSERT INTO user (username, password) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $adminUsername, $adminPassword);

if ($stmt->execute()) {
    echo "Admin account created successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();