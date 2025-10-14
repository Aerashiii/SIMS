<?php
session_start();
$conn = new mysqli("localhost", "root", "", "simsdb");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (isset($_POST['save_business_details'])) {
    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $contact = trim($_POST['contact_number']);
    $email = trim($_POST['email']);
    $daily = $_POST['daily_rate'] ?? 0;
    $weekly = $_POST['weekly_rate'] ?? 0;
    $monthly = $_POST['monthly_rate'] ?? 0;
    $low = isset($_POST['low_stock_alert']) ? 1 : 0;
    $overdue = isset($_POST['overdue_rental_alert']) ? 1 : 0;

    if (empty($name)) {
        $_SESSION['error_message'] = 'Business name cannot be empty.';
    } else {
        $stmt = $conn->prepare("UPDATE business_details SET name=?, address=?, contact_number=?, email=?, daily_rate=?, weekly_rate=?, monthly_rate=?, low_stock_alert=?, overdue_rental_alert=? LIMIT 1");
        $stmt->bind_param("sssssssss", $name, $address, $contact, $email, $daily, $weekly, $monthly, $low, $overdue);
        $stmt->execute();
        $_SESSION['success_message'] = 'Business details saved successfully!';
    }
}

$conn->close();
header("Location: business-settings.php");
exit;
?>
