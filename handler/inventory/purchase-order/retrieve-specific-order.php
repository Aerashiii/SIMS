<?php
header('Content-Type: application/json; charset=utf-8');
error_reporting(0); // Hide warnings from breaking JSON

$host = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

$order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($order_id <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid order ID']);
    exit;
}

// Fetch main transaction
$sql = "SELECT 
            p.id,
            p.date,
            p.total_product,
            p.total_cost,
            CASE 
                WHEN p.status = 0 THEN 'Pending'
                WHEN p.status = 1 THEN 'Received'
                ELSE 'Unknown'
            END AS status,
            u.name AS processed_by,
            s.supplier_name
        FROM purchase_order_transaction AS p
        LEFT JOIN user AS u ON p.user_id = u.id
        LEFT JOIN supplier AS s ON p.supplier_id = s.supplier_id
        WHERE p.id = ? AND p.deleted = 'no'";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();
$transaction = $result->fetch_assoc();

if (!$transaction) {
    echo json_encode(['success' => false, 'message' => 'Purchase order not found']);
    exit;
}

// Fetch product details
$sql_products = "SELECT 
                    pr.product_name,
                    op.quantity,
                    pr.original_price AS price,
                    (op.quantity * pr.original_price) AS total
                 FROM ordered_products AS op
                 LEFT JOIN products AS pr ON op.product_id = pr.id
                 WHERE op.order_id = ?";
$stmt = $conn->prepare($sql_products);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result_products = $stmt->get_result();

$products = [];
while ($row = $result_products->fetch_assoc()) {
    $products[] = $row;
}

// Final output
echo json_encode([
    'success' => true,
    'transaction' => $transaction,
    'products' => $products
]);

$conn->close();

?>
