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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['purchase_transaction_id'])) {
    $purchaseTransactionId = intval($_POST['purchase_transaction_id']);

    $updateSql = "UPDATE `purchase-order` SET `deleted` = 'yes' WHERE `order_id` = ?";
    $stmt = $conn->prepare($updateSql);

    if ($stmt) {
        $stmt->bind_param("i", $purchaseTransactionId);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Purchase Order status Deleted successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to execute update query."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Failed to prepare update query: " . $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request. Purchase Order ID missing."]);
}

$conn->close();
?>
