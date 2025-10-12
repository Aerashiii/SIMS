<?php
header('Content-Type: application/json; charset=utf-8');

$host = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
    exit;
}

$orderId = isset($_POST['order_id']) ? intval($_POST['order_id']) : 0;
if ($orderId <= 0) {
    echo json_encode(["success" => false, "message" => "Invalid order ID"]);
    exit;
}

// ✅ Start transaction
$conn->begin_transaction();

try {
    // 1️⃣ Update purchase order transaction to completed
    $updateOrder = $conn->prepare("UPDATE purchase_order_transaction SET status = 'completed' WHERE id = ?");
    $updateOrder->bind_param("i", $orderId);
    $updateOrder->execute();

    // 2️⃣ Get all product IDs linked to this order
    $getProducts = $conn->prepare("SELECT product_id FROM ordered_products WHERE order_id = ?");
    $getProducts->bind_param("i", $orderId);
    $getProducts->execute();
    $result = $getProducts->get_result();

    // 3️⃣ Update each product status to active
    while ($row = $result->fetch_assoc()) {
        $pid = $row['product_id'];
        $updateProd = $conn->prepare("UPDATE products SET status = 'active' WHERE id = ?");
        $updateProd->bind_param("i", $pid);
        $updateProd->execute();
    }

    // ✅ Commit all updates
    $conn->commit();

    echo json_encode(["success" => true, "message" => "Purchase order marked as completed."]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(["success" => false, "message" => "Error updating records: " . $e->getMessage()]);
}
