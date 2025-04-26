<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rental_transaction_id'])) {
    $rentalTransactionId = intval($_POST['rental_transaction_id']);

    $updateSql = "UPDATE `rental-transaction` SET `status` = 'completed' WHERE `id` = ?";
    $stmt = $conn->prepare($updateSql);

    if ($stmt) {
        $stmt->bind_param("i", $rentalTransactionId);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Rental transaction status updated successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to execute update query."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Failed to prepare update query: " . $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request. Rental transaction ID missing."]);
}

$conn->close();
?>
