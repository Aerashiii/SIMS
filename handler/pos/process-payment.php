<?php
$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($server, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

$products = $data['products'];
$total = $data['total'];
$cashReceived = $data['cashReceived'];
$change = $data['change'];
$paymentMethod = $data['paymentMethod'];

try {
    $conn->begin_transaction();

    // Insert into sales_transaction
    $stmt = $conn->prepare("INSERT INTO sales_transaction (total, cash_received, change_given, payment_method, created_at) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ddds", $total, $cashReceived, $change, $paymentMethod);
    $stmt->execute();
    $transactionId = $conn->insert_id;
    $stmt->close();

    // Insert into sales_items and update products table
    $stmtItem = $conn->prepare("INSERT INTO sales_items (transaction_id, product_name, barcode, quantity, price, total) VALUES (?, ?, ?, ?, ?, ?)");
    $updateQty = $conn->prepare("UPDATE products SET quantity = quantity - ? WHERE barcode = ?");

    foreach ($products as $item) {
        $name = $item['name'];
        $barcode = $item['barcode'];
        $quantity = $item['quantity'];
        $price = $item['price'];
        $itemTotal = $item['total'];

        $stmtItem->bind_param("issidd", $transactionId, $name, $barcode, $quantity, $price, $itemTotal);
        $stmtItem->execute();

        $updateQty->bind_param("is", $quantity, $barcode);
        $updateQty->execute();
    }

    $stmtItem->close();
    $updateQty->close();
    $conn->commit();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
