<?php
header('Content-Type: application/json');

$server = "localhost";
$username = "root";
$password = "";
$dbname = "simsdb";

$conn = new mysqli($server, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'DB connection failed: ' . $conn->connect_error]);
    exit;
}

$response = [
    'success' => true,
    'data' => [
        'total_sales' => 0,
        'total_products' => 0,
        'low_stock_items' => 0,
        'rented_quantity' => 0,
        'total_expenses' => 0,
        'total_value' => 0,
        'total_pending_orders' => 0,
        'total_rental_boxes' => 0
    ]
];

// 🟢 SAFE HELPER
function queryValue($conn, $sql, $field) {
    $result = $conn->query($sql);
    if ($result && $row = $result->fetch_assoc()) {
        return $row[$field] ?? 0;
    }
    return 0;
}

// Queries (Make sure table names match your DB)
$response['data']['total_sales'] = number_format(queryValue($conn, "SELECT SUM(total_payment) AS total_sales FROM sales_transaction WHERE deleted='no'", 'total_sales'), 2);
$response['data']['total_value'] = number_format(queryValue($conn, "SELECT SUM(quantity * original_price) AS total_value FROM products WHERE status='active' AND deleted='no'", 'total_value'), 2);
$response['data']['total_products'] = queryValue($conn, "SELECT SUM(quantity) AS total_products FROM products WHERE status='active' AND deleted='no'", 'total_products');
$response['data']['total_rental_boxes'] = queryValue($conn, "SELECT COUNT(*) AS total_rental_boxes FROM rentalbox WHERE status='active' AND deleted='no'", 'total_rental_boxes');
$response['data']['low_stock_items'] = queryValue($conn, "SELECT COUNT(*) AS low_stock_items FROM products WHERE quantity <= reorder_point AND status='active' AND deleted='no'", 'low_stock_items');
$response['data']['total_expenses'] = number_format(queryValue($conn, "SELECT SUM(original_price * quantity) AS total_expenses FROM products WHERE status='active' AND deleted='no'", 'total_expenses'), 2);
$response['data']['total_pending_orders'] = queryValue($conn, "SELECT SUM(quantity) AS total_pending_orders FROM purchase_order WHERE status='pending' AND deleted='no'", 'total_pending_orders');
$response['data']['rented_quantity'] = queryValue($conn, "SELECT SUM(rented_quantity) AS rented_quantity FROM rental_transaction WHERE status='active'", 'rented_quantity');

$conn->close();
echo json_encode($response);
